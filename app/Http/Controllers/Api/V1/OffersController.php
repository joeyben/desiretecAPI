<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Frontend\Offers\StoreOffersRequest;
use App\Repositories\Frontend\Offers\OffersRepository;

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
            return $this->responseJsonError($e);
        }
    }

    public function store(StoreOffersRequest $request)
    {
        try {
            if ($this->offer->createOfferAPI($request)) {
                return $this->respondCreated(trans('alerts.frontend.offers.created'));
            }

            ErrorException(trans('alerts.frontend.offers.error'));
        } catch (\Exception $e) {
            return $this->responseJsonError($e);
        }
    }
}
