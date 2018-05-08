<?php

namespace App\Http\Controllers\Backend\Wishes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Wishes\ManageWishesRequest;
use App\Repositories\Backend\Wishes\WishesRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class WishesTableController.
 */
class WishesTableController extends Controller
{
    protected $wishes;

    /**
     * @param \App\Repositories\Backend\Wishes\WishesRepository $cmspages
     */
    public function __construct(WishesRepository $wishes)
    {
        $this->wishes = $wishes;
    }

    /**
     * @param \App\Http\Requests\Backend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageWishesRequest $request)
    {
        return Datatables::of($this->wishes->getForDataTable())
            ->escapeColumns(['title'])
            ->addColumn('status', function ($wishes) {
                return $wishes->status;
            })
            ->addColumn('created_by', function ($wishes) {
                return $wishes->user_name;
            })
            ->addColumn('created_at', function ($wishes) {
                return $wishes->created_at->toDateString();
            })
            ->addColumn('actions', function ($wishes) {
                return $wishes->action_buttons;
            })
            ->addColumn('offer_count', function ($wishes) {
                if($wishes->total_offers > 0){
                    return $wishes->action_wish_offers;
                }else{
                    return $wishes->total_offers;
                }
            })
            ->make(true);
    }
}
