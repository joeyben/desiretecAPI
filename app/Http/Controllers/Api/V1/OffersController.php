<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Offers\ManageOffersRequest;
use App\Http\Requests\Frontend\Offers\StoreOffersRequest;
use App\Models\Agents\Agent;
use App\Repositories\Frontend\Offers\OffersRepository;
use PHPUnit\Exception;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Frontend\Offers\OffersTableController;
use Illuminate\Http\Request;

class OffersController extends APIController

{
    protected $offer;
    protected $offersList;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(OffersRepository $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Return offers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $offers['data'] = $this->offer->getOffers();

            return $this->responseJson($offers);
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     *
     */
    public function store(StoreOffersRequest $request)
    {
        try{
            if($this->offer->create($request);){
                return $this->respondCreated(trans('alerts.frontend.offers.created'));
            }

            return $this->respondWithError('error');
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
}