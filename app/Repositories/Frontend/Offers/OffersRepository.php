<?php

namespace App\Repositories\Frontend\Offers;

use App\Events\Frontend\Offers\OfferCreated;
use App\Events\Frontend\Offers\OfferDeleted;
use App\Events\Frontend\Offers\OfferUpdated;
use App\Exceptions\GeneralException;
use App\Http\Requests\Frontend\Offers\StoreOffersRequest;
use App\Models\Agents\Agent;
use App\Models\OfferFiles\OfferFile;
use App\Models\Offers\Offer;
use App\Repositories\BaseRepository;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class OffersRepository.
 */
class OffersRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Offer::class;

    protected $upload_path;

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img' . \DIRECTORY_SEPARATOR . 'offer' . \DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('s3');
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table') . '.id', '=', config('module.offers.table') . '.created_by')
            ->leftjoin(config('module.wishes.table'), config('module.wishes.table') . '.id', '=', config('module.offers.table') . '.wish_id')
            ->select([
                config('module.offers.table') . '.id',
                config('module.offers.table') . '.title',
                config('module.offers.table') . '.status',
                config('module.offers.table') . '.created_by',
                config('module.offers.table') . '.created_at',
                config('module.offers.table') . '.agent_id',
                config('access.users_table') . '.first_name as first_name',
                config('access.users_table') . '.last_name as last_name',
                config('module.wishes.table') . '.id as wish_id',
                config('module.wishes.table') . '.title as wish_title',
            ])->where(config('module.offers.table') . '.created_by', access()->user()->id)
            ->orderBy(config('module.offers.table') . '.id', 'DESC');
    }

    public function getOffers()
    {
        $data = $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table') . '.id', '=', config('module.offers.table') . '.created_by')
            ->leftjoin(config('module.wishes.table'), config('module.wishes.table') . '.id', '=', config('module.offers.table') . '.wish_id')
            ->select([
                config('module.offers.table') . '.id',
                config('module.offers.table') . '.title',
                config('module.offers.table') . '.status',
                config('module.offers.table') . '.created_by',
                config('module.offers.table') . '.created_at',
                config('module.offers.table') . '.agent_id',
                config('access.users_table') . '.first_name as first_name',
                config('access.users_table') . '.last_name as last_name',
                config('module.wishes.table') . '.id as wish_id',
                config('module.wishes.table') . '.title as wish_title',
            ])->where(config('module.offers.table') . '.created_by', Auth::guard('api')->user()->id)
            ->orderBy(config('module.offers.table') . '.id', 'DESC')->get()->toArray();

        foreach ($data as &$offer) {
            $offer['title'] = '<a href="/wishes/' . $offer['wish_id'] . '">' . $offer['title'] . '</a>';
            if (isset($offer['agent_id']) && null !== $offer['agent_id']) {
                $offer['created_by'] = Agent::where('id', $offer['agent_id'])->first()->name;
            } else {
                $offer['created_by'] = Auth::guard('agent')->user()->name;
            }
            $offer['created_at'] = date('d.m.Y H:i:s', strtotime($offer['created_at']));
        }

        return $data;
    }

    public function getOffersData()
    {
        return Datatables::of($this->getForDataTable())
            ->addColumn('title', function ($offers) {
                return '<a href="' . route('frontend.wishes.show', [$offers->wish_id])
                    . '">' . $offers->title . '</a>';
            })
            ->addColumn('created_by', function ($offers) {
                return Agent::where('id', $offers->agent_id)->first()->name;
            })
            ->addColumn('created_at', function ($offers) {
                return $offers->created_at->format('d.m.Y') . ' ' . $offers->created_at->toTimeString();
            })
            ->addColumn('status', function ($offers) {
                return $offers->status;
            })
            ->addColumn('actions', function ($offers) {
                return $offers->action_buttons;
            })
            ->rawColumns(['title'])
            ->make(true);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function getForDataTableForWish($id)
    {
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table') . '.id', '=', config('module.offers.table') . '.created_by')
            ->leftjoin(config('module.wishes.table'), config('module.wishes.table') . '.id', '=', config('module.offers.table') . '.wish_id')
            ->select([
                config('module.offers.table') . '.id',
                config('module.offers.table') . '.title',
                config('module.offers.table') . '.status',
                config('module.offers.table') . '.created_by',
                config('module.offers.table') . '.created_at',
                config('access.users_table') . '.first_name as first_name',
                config('access.users_table') . '.last_name as last_name',
                config('module.wishes.table') . '.id as wish_id',
                config('module.wishes.table') . '.title as wish_title',
            ])->where(config('module.offers.table') . '.wish_id', $id);
    }

    /**
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(StoreOffersRequest $request)
    {
        $files = $request->hasfile('file') ? $request->file('file') : [];
        $input = $request->except('_token', 'file');
        DB::transaction(function () use ($input, $files) {
            $id = access()->user()->id;

            $input['created_by'] = $id;
            $input['agent_id'] = Auth::guard('agent')->user()->id;

            if ($offer = Offer::create($input)) {
                $fileUploaded = $this->uploadImage($files, $offer->id);
                event(new OfferCreated($offer));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.offers.create_error'));
        });
    }

    public function createOfferAPI(Request $request)
    {
        $files = $request->hasfile('file') ? $request->file('file') : [];
        $input = $request->except('_token', 'file');

        return DB::transaction(function () use ($input, $files) {
            $id = access()->user()->id;
            $active_agent = Auth::guard('agent')->user()->id;

            $input['created_by'] = $id;
            $input['agent_id'] = $active_agent['id'];

            if ($offer = Offer::create($input)) {
                $fileUploaded = $this->uploadImage($files, $offer->id);
                event(new OfferCreated($offer));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.offers.create_error'));
        });
    }

    /**
     * Update Offer.
     */
    public function update(Offer $offer, array $input)
    {
        $input['updated_by'] = access()->user()->id;

        // Uploading Image
        if (\array_key_exists('file', $input)) {
            $this->deleteOldFile($offer);
            $fileUploaded = $this->uploadImage($input);
        }

        DB::transaction(function () use ($offer, $input) {
            if ($offer->update($input)) {
                event(new OfferUpdated($offer));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.offers.update_error'));
        });
    }

    /**
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Offer $offer)
    {
        DB::transaction(function () use ($offer) {
            if ($offer->delete()) {
                event(new OfferDeleted($offer));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.offers.delete_error'));
        });
    }

    /**
     * Upload Image.
     *
     * @param array $files
     * @param int   $id
     *
     * @return bool
     */
    public function uploadImage($files, $id)
    {
        if (isset($files) && !empty($files)) {
            foreach ($files as $file) {
                $fileName = time() . $file->getClientOriginalName();
                $this->storage->put($this->upload_path . $fileName, file_get_contents($file->getRealPath()), 'public');
                $offerFiles = new OfferFile();
                $offerFiles->offer_id = $id;
                $offerFiles->file = $fileName;
                $offerFiles->save();
            }

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
        $fileName = $model->file;

        return $this->storage->delete($this->upload_path . $fileName);
    }
}
