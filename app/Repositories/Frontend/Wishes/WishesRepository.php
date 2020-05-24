<?php

namespace App\Repositories\Frontend\Wishes;

use App\Events\Frontend\Wishes\WishCreated;
use App\Events\Frontend\Wishes\WishDeleted;
use App\Events\Frontend\Wishes\WishUpdated;
use App\Exceptions\GeneralException;
use App\Http\Requests\Frontend\Wishes\ChangeWishesStatusRequest;
use App\Http\Requests\Frontend\Wishes\ManageWishesRequest;
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
use Modules\Autooffers\Repositories\AutooffersRepository;
use Modules\Autooffers\Repositories\AutooffersTTRepository;
use Modules\Autooffers\Repositories\Eloquent\EloquentAutooffersRepository;
use Modules\Rules\Repositories\Eloquent\EloquentRulesRepository;
use phpDocumentor\Reflection\Types\Integer;
use Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\EagerLoad;

require_once 'Mobile_Detect.php';
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

    /**
     * @var \Modules\Rules\Repositories\Eloquent\EloquentRulesRepository
     */
    private $rules;
    private $autooffers;
    private $autooffersTT;
    private $autoRules;
    private $layerWhitelabel;

    public function __construct(EloquentRulesRepository $rules, AutooffersRepository $autooffers, AutooffersTTRepository $autooffersTT, EloquentAutooffersRepository $autoRules, LayerWhitelabelRepository $layerWhitelabel)
    {
        $this->upload_path = 'img' . \DIRECTORY_SEPARATOR . 'wish' . \DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('s3');
        $this->rules = $rules;
        $this->autooffers = $autooffers;
        $this->autooffersTT = $autooffersTT;
        $this->autoRules = $autoRules;
        $this->layerWhitelabel = $layerWhitelabel;
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
            ->leftJoin('categories_wish', 'categories_wish.wish_id', '=', config('module.wishes.table') . '.id')
            ->leftJoin('categories', 'categories_wish.category_id', '=', 'categories.id')
            ->select([
                config('module.wishes.table') . '.id',
                config('module.wishes.table') . '.title',
                config('module.wishes.table') . '.airport',
                config('module.wishes.table') . '.destination',
                config('module.wishes.table') . '.duration',
                config('module.wishes.table') . '.adults',
                config('module.wishes.table') . '.kids',
                config('module.wishes.table') . '.pets',
                config('module.wishes.table') . '.rooms',
                config('module.wishes.table') . '.budget',
                config('module.wishes.table') . '.earliest_start',
                config('module.wishes.table') . '.latest_return',
                config('module.wishes.table') . '.status',
                config('module.wishes.table') . '.featured_image',
                config('module.wishes.table') . '.created_by',
                config('module.wishes.table') . '.created_at',
                config('module.wishes.table') . '.group_id',
                config('module.wishes.table') . '.note',
                config('module.wishes.table') . '.is_autooffer',
                config('module.wishes.table') . '.version',
                config('access.users_table') . '.first_name as first_name',
                config('access.users_table') . '.last_name as last_name',
                config('module.whitelabels.table') . '.id as whitelabel_id',
                config('module.whitelabels.table') . '.display_name as whitelabel_name',
                config('module.whitelabels.table') . '.tt',
                config('module.whitelabels.table') . '.traffics',
                config('module.whitelabels.table') . '.peakwork',
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

    public function getWishList(ManageWishesRequest $request)
    {
        $status_arr = [
            'new'               => '1',
            'offer_created'     => '2',
            'completed'         => '3',
        ];

        $status = $request->get('status') ? $status_arr[$request->get('status')] : '1';
        $id = ($request->get('filter') && null !== $request->get('filter') && is_numeric($request->get('filter'))) ? $request->get('filter') : '';
        $destination = ($request->get('filter') && null !== $request->get('filter') && !is_numeric($request->get('filter'))) ? $request->get('filter') : '';

        if (session()->has('wl-id') && !is_null(session()->get('wl-id'))) {
            $currentWhiteLabelID = session()->get('wl-id', null);
        } else {
            $currentWhiteLabelID = Auth::user()->whitelabels()->first()->id;
        }

        $rules = $this->rules->getRuleForWhitelabel((int) ($currentWhiteLabelID));

        if (Auth::user()->hasRole('User')) {
            $wish = $this->getForDataTable()
                ->when($currentWhiteLabelID, function ($wish, $currentWhiteLabelID) {
                    return $wish->where('whitelabel_id', (int) ($currentWhiteLabelID));
                })
                ->when($id, function ($wish, $id) {
                    return $wish->where(config('module.wishes.table') . '.id', 'like', '%' . $id . '%');
                })
                ->when($destination, function ($wish, $destination) {
                    return $wish->where(config('module.wishes.table') . '.destination', 'like', '%' . $destination . '%');
                })
                ->paginate(10);
        } else {
            $wish = $this->getForDataTable()
                ->when($currentWhiteLabelID, function ($wish, $currentWhiteLabelID) {
                    return $wish->where('whitelabel_id', (int) ($currentWhiteLabelID));
                })
                ->when($status, function ($wish, $status) {
                    return $wish->where(config('module.wishes.table') . '.status', $status);
                })
                ->when($id, function ($wish, $id) {
                    return $wish->where(config('module.wishes.table') . '.id', 'like', '%' . $id . '%');
                })
                ->when($destination, function ($wish, $destination) {
                    return $wish->where(config('module.wishes.table') . '.destination', 'like', '%' . $destination . '%');
                })
                ->paginate(10);
        }

        $whitelabelLayers = $this->getLayers((int)$currentWhiteLabelID);

        foreach ($wish as $singleWish) {
            $singleWish['status'] = array_search($singleWish['status'], $status_arr, true) ? array_search($singleWish['status'], $status_arr, true) : 'new';

            foreach ($whitelabelLayers as $layer) {
                if ($layer['layer']['path'] === $singleWish['version'] && sizeof($layer['attachments'])) {
                    $singleWish['layer_image'] = $layer['attachments'][0]['url'];
                }
            }

            if (Auth::user()->hasRole('Seller')) {
                if (198 === $currentWhiteLabelID) { //<<<--- ID of BILD REISEN AND the respective WLs for User's Email
                    $singleWish['senderEmail'] = ($this->users->find($singleWish['created_by'])->email && null !== $this->users->find($singleWish['created_by'])->email) ? $this->users->find($singleWish['created_by'])->email : 'No Email';
                }
                if ($singleWish->messages() && $singleWish->messages()->count() > 0) {
                    $singleWish['messageSentFlag'] = true;
                }
            }

            if (null === $rules || 'manuel' === $rules['type']) {
                $manuelFlag = true;
            } else {
                $manuelFlag = false;

                if (\is_array($rules['destination']) && null !== $rules['destination']) {
                    if (\is_array($singleWish['destination'])) {
                        foreach ($singleWish['destination'] as $destination) {
                            if (\in_array($destination, $rules['destination'], true)) {
                                $manuelFlag = true;
                            }
                        }
                    } else {
                        if (\in_array($singleWish['destination'], $rules['destination'], true)) {
                            $manuelFlag = true;
                        }
                    }
                }

                if (isset($rules['budget']) && null !== $rules['budget']) {
                    if ($singleWish['budget'] > $rules['budget']) {
                        $manuelFlag = true;
                    }
                }
            }

            $singleWish['manuelFlag'] = $manuelFlag;
            $singleWish['wlRule'] = $rules['type'];
        }

        $response = [
            'pagination' => [
                'total'        => $wish->total(),
                'per_page'     => $wish->perPage(),
                'current_page' => $wish->currentPage(),
                'last_page'    => $wish->lastPage(),
                'from'         => $wish->firstItem(),
                'to'           => $wish->lastItem()
            ],
            'data' => $wish,
            'currentWhiteLabelID' => $currentWhiteLabelID
        ];

        return $response;
    }

    /**
     * @return JSON response
     */
    public function changeWishStatus(ChangeWishesStatusRequest $request)
    {
        try {
            $status_arr = [
                'new'               => '1',
                'offer_created'     => '2',
                'completed'         => '3',
            ];

            $status = $request->get('status') ? $status_arr[$request->get('status')] : '1';

            $wish = $this->updateStatus($request->get('id'), $status);

            return json_response([]);
        } catch (Exception $e) {
            return json_response_error($e);
        }
    }

    /**
     * @return array
     */
    public function getById(int $id)
    {
        $result['wish'] = Wish::where([config('module.wishes.table') . '.id' => $id])->get()->first();

        $result['modifiedData'] = Wish::where([config('module.wishes.table') . '.id' => $id])
            ->leftjoin(config('access.users_table'), config('access.users_table') . '.id', '=', config('module.wishes.table') . '.created_by')
            ->first();

        return $result;
    }

    /**
     * @return Wish
     */
    public function getWish(int $id)
    {
        return Wish::findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function getLowestWishesGroup($whitelabel_id)
    {
        $group = Group::where('whitelabel_id', $whitelabel_id)
            ->oldest('lastwish')
            ->where('status', 1)
            ->first();

        if (!$group) {
            $group = Group::where('whitelabel_id', $whitelabel_id)
                ->orderby('id', 'ASC')
                ->where('status', 1)
                ->first();
        }

        $id = $group->toArray()['id'];
        $this->updateLastwish($id);

        return $id;
    }

    /**
     * @param int $whitelabelId
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return mixed
     */
    public function create(array $input, $whitelabelId)
    {
        $this->whitelabel_id = $whitelabelId;

        $wish = DB::transaction(function () use ($input, $whitelabelId) {
            $from = \Illuminate\Support\Carbon::createFromFormat('d.m.Y', $input['earliest_start']);
            $to = \Illuminate\Support\Carbon::createFromFormat('d.m.Y', $input['latest_return']);
            $daysDiff = $to->diffInDays($from);
            $detect = new \Mobile_Detect();

            if ('0' === $input['duration'] && $daysDiff < 7) {
                $input['duration'] = '' . $daysDiff;
            } elseif ('0' === $input['duration']) {
                $input['duration'] = '7-';
            }

            $input['featured_image'] = (isset($input['featured_image']) && !empty($input['featured_image'])) ? $input['featured_image'] : '1522558148csm_ER_Namibia_b97bcd06f0.jpg';
            $input['created_by'] = access()->user()->id;
            $input['whitelabel_id'] = $whitelabelId;
            $input['group_id'] = $this->getGroup();
            $input['title'] = '-';
            $input['budget'] = null === $input['budget'] ? 0 : $input['budget'];
            $input['category'] = null === $input['category'] ? 3 : $input['category'];
            $input['mobile'] = $detect->isMobile() || $detect->isTablet() ? 1 : 0;

            $input['earliest_start'] = $from;
            $input['latest_return'] = $input['latest_return'] ? $to : '0000-00-00';
            $input['adults'] = (int) ($input['adults']);
            $input['extra_params'] = isset($input['extra_params']) ? $input['extra_params'] : '';
            $input['duration'] = 'exact' === $input['duration'] ? '' . $daysDiff : $input['duration'];

            if ($wish = \Modules\Wishes\Entities\Wish::create($input)) {
                $this->updateGroup($input['group_id'], $input['whitelabel_id']);
                event(new WishCreated($wish));

                return $wish;
            }

            throw new GeneralException(trans('exceptions.backend.wishes.create_error'));
        });

        return $wish;
    }

    public function createFromApi(array $input, string $userId)
    {
        $this->whitelabel_id = $input['whitelabel_id'];

        $wish = DB::transaction(function () use ($input, $userId) {

            if($input['earliest_start'] !== '-' && $input['latest_return'] !== '-') {
                $from = \Illuminate\Support\Carbon::createFromFormat('d.m.Y', $input['earliest_start']);
                $to = \Illuminate\Support\Carbon::createFromFormat('d.m.Y', $input['latest_return']);
                $daysDiff = $to->diffInDays($from);
                if ('0' === $input['duration'] && $daysDiff < 7) {
                    $input['duration'] = '' . $daysDiff;
                } elseif ('0' === $input['duration']) {
                    $input['duration'] = '7-';
                }
                $input['earliest_start'] = $from;
                $input['latest_return'] = $input['latest_return'] ? $to : '0000-00-00';
                $input['duration'] = 'exact' === $input['duration'] ? '' . $daysDiff : $input['duration'];
            }

            $input['featured_image'] = (isset($input['featured_image']) && !empty($input['featured_image'])) ? $input['featured_image'] : '1522558148csm_ER_Namibia_b97bcd06f0.jpg';
            $input['created_by'] = $userId;
            $input['group_id'] = $this->getGroup();
            $input['title'] = '-';
            $input['adults'] = (int) ($input['adults']);
            $input['extra_params'] = isset($input['extra_params']) ? $input['extra_params'] : '';

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

            throw new GeneralException(trans('exceptions.backend.wishes.update_error'));
        });
    }

    /**
     * @param int $id
     * Update Wish.
     */
    public function setIsAutoofer(int $id)
    {
        $wish = Wish::find($id);
        $wish->is_autooffer = 1;

        return $wish->save();
    }

    /**
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
     * @param string $token
     */
    public function validateToken($token)
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
     * @param $category
     */
    public function storeCategoryWish($category, \Modules\Wishes\Entities\Wish $wish)
    {
        if (\is_array($category)) {
            foreach ($category as $cat) {
                $wish->attachCategory($cat);
            }
        } else {
            $wish->attachCategory($category);
        }
    }

    /**
     * Update Wish Status.
     */
    public function updateStatus(int $id, string $updatedStatus)
    {
        $input['updated_by'] = access()->user()->id;
        $input['status'] = $updatedStatus;
        $update = DB::transaction(function () use ($id, $input) {
            if (\Modules\Wishes\Entities\Wish::where('id', $id)->update($input)) {
                return true;
            }

            return false;

            throw new GeneralException(trans('exceptions.backend.wishes.update_error'));
        });
        if ($update) {
            return true;
        }

        return false;
    }

    public function updateNote(int $id, string $note)
    {
        DB::transaction(function () use ($id, $note) {
            if (Wish::where('id', $id)->update(['note' => $note])) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.wishes.update_error'));
        });
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return string
     */
    public function manageRules($wish)
    {
        $rules = $this->rules->getRuleForWhitelabel($wish->whitelabel->id);
        $offer = 0;
        switch ($rules['type']) {
            case 'mix':
                $destinations = \is_array($rules['destination']) ? $rules['destination'] : [];
                $budget_lower = $wish->budget < $rules['budget'];
                $description_notset = !$wish->description || '' === $wish->description;
                $destination_exists = empty($destinations) || \in_array($wish->destination, $destinations, true);

                if ($budget_lower && $description_notset && $destination_exists) {
                    $offer = 1;
                } else {
                    $offer = 0;
                }
                break;
            case 'auto':
                $offer = 1;
                break;
            case 'manuel':
                $offer = 0;
                break;
            default:
                $offer = 0;
        }

        return $offer;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function getRuleType(int $id)
    {
        $rules = $this->rules->getRuleForWhitelabel($id);
        switch ($rules['type']) {
            case 'mix':
                return 2;
                break;
            case 'auto':
                return 1;
                break;
            case 'manuel':
                return 0;
                break;
            default:
                return 0;
        }
    }

    public function callTT($wishID, $whitelabelId, $userId)
    {
        $wish = Wish::where('id', $wishID)->first();
        $_rules = $this->autoRules->getSettingsForWhitelabel($whitelabelId);
        $this->autooffersTT->saveWishData($wish, $whitelabelId);
        $this->autooffersTT->getToken();
        $response = $this->autooffersTT->getTTData();
        $this->autooffersTT->storeMany($response, $wish->id, $_rules, $userId);
    }

    public function callTraffics($wishID, $whitelabelId, $userId)
    {
        $wish = Wish::where('id', $wishID)->first();
        $_rules = $this->autoRules->getSettingsForWhitelabel($whitelabelId);
        //dd(getRegionCode($wish->airport, 0));
        $this->autooffers->saveWishData($wish);
        $response = $this->autooffers->getTrafficsData();
        $this->autooffers->storeMany($response, $wish->id, $_rules, $userId);
    }

    private function getLayers(int $whitelabelId)
    {
        return $this->layerWhitelabel->withCriteria([
            new OrderBy('layer_id'),
            new Where('whitelabel_id', $whitelabelId),
            new EagerLoad(['layer', 'attachments'])
        ])->all();
    }
}
