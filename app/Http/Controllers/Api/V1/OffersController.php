<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Offers\ManageOffersRequest;
use App\Models\Agents\Agent;
use App\Repositories\Frontend\Offers\OffersRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Frontend\Offers\OffersTableController;

class OffersController extends Controller

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
        dd('$this->offer');
    }
}