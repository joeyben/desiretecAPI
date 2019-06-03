<?php

namespace App\Repositories\Frontend\Wishes;

use App\Events\Frontend\Wishes\WishCreated;
use App\Events\Frontend\Wishes\WishDeleted;
use App\Events\Frontend\Wishes\WishUpdated;
use App\Exceptions\GeneralException;
use App\Models\Access\User\User;
use App\Models\Access\User\UserToken;
use App\Models\Groups\Group;
use App\Models\Whitelabels\Whitelabel;
use App\Models\Wishes\Wish;
use App\Repositories\BaseRepository;
use Auth;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

/**
 * Class WishesRepository.
 */
class WishesRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Wish::class;

    const ROUND_ROBIN = 'round-robin';
    const REGIONAL = 'regional';

    protected $upload_path;

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    protected $whitelabel_id = null;

    public function __construct()
    {
        $this->upload_path = 'img' . \DIRECTORY_SEPARATOR . 'wish' . \DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('s3');
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        $whitelabels = [];
        foreach (access()->user()->whitelabels as $whitelabel) {
            array_push($whitelabels, $whitelabel->id);
        }

        $query = $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table') . '.id', '=', config('module.wishes.table') . '.created_by')
            ->leftjoin(config('module.whitelabels.table'), config('module.whitelabels.table') . '.id', '=', config('module.wishes.table') . '.whitelabel_id')
            ->leftjoin(config('module.offers.table'), config('module.offers.table') . '.wish_id', '=', config('module.wishes.table') . '.id')
            ->leftJoin('categories_wish', 'categories_wish.wish_id', '=', config('module.wishes.table') .'.id')
            ->leftJoin('categories', 'categories_wish.category_id', '=', 'categories.id')
            ->select([
                config('module.wishes.table') . '.id',
                config('module.wishes.table') . '.title',
                config('module.wishes.table') . '.airport',
                config('module.wishes.table') . '.destination',
                config('module.wishes.table') . '.duration',
                config('module.wishes.table') . '.adults',
                config('module.wishes.table') . '.budget',
                config('module.wishes.table') . '.earliest_start',
                config('module.wishes.table') . '.latest_return',
                config('module.wishes.table') . '.status',
                config('module.wishes.table') . '.featured_image',
                config('module.wishes.table') . '.created_by',
                config('module.wishes.table') . '.created_at',
                config('module.wishes.table') . '.group_id',
                config('access.users_table') . '.first_name as first_name',
                config('access.users_table') . '.last_name as last_name',
                config('module.whitelabels.table') . '.id as whitelabel_id',
                config('module.whitelabels.table') . '.display_name as whitelabel_name',
                DB::raw('count(' . config('module.offers.table') . '.id) as offers'),
                DB::raw('GROUP_CONCAT(categories.value) as categories'),
            ])
            ->whereIn('whitelabel_id', $whitelabels)
            ->groupBy(config('module.wishes.table') . '.id')->orderBy(config('module.wishes.table') . '.id', 'DESC');
        if (access()->user()->hasRole('User')) {
            $query->where(config('module.wishes.table') . '.created_by', access()->user()->id);
        } elseif (access()->user()->hasRole('Seller')) {
            $query->whereIn(config('module.wishes.table') . '.group_id', access()->user()->groups->pluck('id')->toArray());
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public function getLowestWishesGroup($whitelabel_id)
    {
        $group = Group::where('whitelabel_id', $whitelabel_id)
            ->oldest('lastwish')
            ->first();

        if (!$group) {
            $group = Group::where('whitelabel_id', $whitelabel_id)
                ->orderby('id', 'ASC')
                ->first();
        }

        $id = $group->toArray()['id'];
        $this->updateLastwish($id);

        return $id;
    }

    /**
     * @param array $input
     * @param integer $whitelabelId
     * @throws \App\Exceptions\GeneralException
     *
     * @return mixed
     */
    public function create(array $input, $whitelabelId)
    {
        $this->whitelabel_id = $whitelabelId;

        $wish = DB::transaction(function () use ($input, $whitelabelId) {
            $input['featured_image'] = (isset($input['featured_image']) && !empty($input['featured_image'])) ? $input['featured_image'] : '1522558148csm_ER_Namibia_b97bcd06f0.jpg';
            $input['created_by'] = access()->user()->id;
            $input['whitelabel_id'] = $whitelabelId;
            $input['group_id'] = $this->getGroup();
            $input['title'] = '-';
            $input['earliest_start'] = \Illuminate\Support\Carbon::createFromFormat('d.m.Y', $input['earliest_start']);
            $input['latest_return'] = \Illuminate\Support\Carbon::createFromFormat('d.m.Y', $input['latest_return']);
            $input['adults'] = intval($input['adults']);

            if ($wish = \Modules\Wishes\Entities\Wish::create($input)) {
                $this->updateGroup($input['group_id'], $input['whitelabel_id']);

                event(new WishCreated($wish));

                return $wish;
            }

            throw new GeneralException(trans('exceptions.backend.wishes.create_error'));
        });

        return $wish;
    }

    /**
     * Update Wish.
     *
     * @param \App\Models\Wishes\Wish $wish
     * @param array                   $input
     */
    public function update(Wish $wish, array $input)
    {
        $input['updated_by'] = access()->user()->id;

        // Uploading Image
        if (\array_key_exists('featured_image', $input)) {
            $this->deleteOldFile($wish);
            $this->uploadImage($input);
        }

        DB::transaction(function () use ($wish, $input) {
            if ($wish->update($input)) {
                event(new WishUpdated($wish));

                return true;
            }

            throw new GeneralException(
                trans('exceptions.backend.wishes.update_error')
            );
        });
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Wish $wish)
    {
        DB::transaction(function () use ($wish) {
            if ($wish->delete()) {
                event(new WishDeleted($wish));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.wishes.delete_error'));
        });
    }

    /**
     * Upload Image.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function uploadImage(&$input)
    {
        if (isset($input['featured_image']) && !empty($input['featured_image'])) {
            $avatar = $input['featured_image'];

            $fileName = time() . $avatar->getClientOriginalName();

            $this->storage->put($this->upload_path . $fileName, file_get_contents($avatar->getRealPath()), 'public');

            $input = array_merge($input, ['featured_image' => $fileName]);

            return true;
        }

        return false;
    }

    /**
     * Destroy Old Image.
     *
     * @param int $id
     */
    public function deleteOldFile($model)
    {
        $fileName = $model->featured_image;

        return $this->storage->delete($this->upload_path . $fileName);
    }

    public function getGroup()
    {
        if (!$this->whitelabel_id) {
            return null;
        }

        $distribution = $this->getDistribution();

        if ($distribution === $this::ROUND_ROBIN) {
            return $this->getLowestWishesGroup($this->whitelabel_id);
        } elseif ($distribution === $this::REGIONAL) {
            return $this->getLowestWishesGroup($this->whitelabel_id);
        }
    }

    public function updateGroup($group_id, $whitelabel_id)
    {
        Group::where('id', $group_id)->update(['current'=> 1]);

        $current = Group::where('id', '<', $group_id)
            ->where('whitelabel_id', $whitelabel_id)
            ->orderby('id', 'DESC')
            ->first();
        if ($current) {
            Group::where('id', $current->toArray()['id'])->update(['current'=> 0]);
        } else {
            $first = Group::where('whitelabel_id', $whitelabel_id)
                ->orderby('id', 'DESC')
                ->first();
            Group::where('id', $first->toArray()['id'])->update(['current'=> 0]);
        }
    }

    public function getDistribution()
    {
        $whitelabel = Whitelabel::find((int) $this->whitelabel_id);

        return $whitelabel->distribution->name;
    }

    /**
     * @param string $id
     * @param string $token
     */
    public function validateToken($id, $token)
    {
        try {
            $usertoken = UserToken::where('token', $token)->firstOrFail();
            $user_id = $usertoken->user_id;
            $user = User::where('id', $user_id)->firstOrFail();
            Auth::login($user);

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function updateLastwish($id)
    {
        $group = Group::find((int) $id);
        $group->lastwish = \Carbon\Carbon::now();

        return $group->save();
    }

    /**
     * Find data by multiple values in one field.
     *
     * @param       \Modules\Wishes\Entities\Wish $wish
     * @param       $category
     *
     * @return void
     */
    public function storeCategoryWish($category, \Modules\Wishes\Entities\Wish $wish)
    {
        $wish->attachCategory($category);
    }
}
