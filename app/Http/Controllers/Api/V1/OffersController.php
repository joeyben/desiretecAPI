<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Offers\ManageOffersRequest;
use App\Http\Requests\Frontend\Offers\StoreOffersRequest;
use App\Models\Agents\Agent;
use App\Repositories\Frontend\Offers\OffersRepository;
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
    public function index($id)
    {
        return response()->json($this->offer->getOffersData($id)->original);
    }

    /**
     *
     */
    public function store(Request $request)
    {
        $this->offer->create($request);

        return $this->respond([
            'message'   => 'asdasd',
        ]);
    }
}