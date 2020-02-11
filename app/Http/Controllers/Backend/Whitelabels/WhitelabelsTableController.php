<?php

namespace App\Http\Controllers\Backend\Whitelabels;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Whitelabels\ManageWhitelabelsRequest;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class WhitelabelsTableController.
 */
class WhitelabelsTableController extends Controller
{
    protected $whitelabels;

    /**
     * @param \App\Repositories\Backend\Whitelabels\WhitelabelsRepository $cmspages
     */
    public function __construct(WhitelabelsRepository $whitelabels)
    {
        $this->whitelabels = $whitelabels;
    }

    /**
     * @return mixed
     */
    public function __invoke(ManageWhitelabelsRequest $request)
    {
        return Datatables::of($this->whitelabels->getForDataTable())
            ->escapeColumns(['name'])
            ->addColumn('display_name', function ($whitelabels) {
                return $whitelabels->display_name;
            })
            ->addColumn('distribution', function ($whitelabels) {
                return $whitelabels->distribution->display_name;
            })
            ->addColumn('status', function ($whitelabels) {
                return $whitelabels->status;
            })
            ->addColumn('ga_view_id', function ($whitelabels) {
                return $whitelabels->ga_view_id;
            })
            ->addColumn('created_by', function ($whitelabels) {
                return $whitelabels->user_name;
            })
            ->addColumn('created_at', function ($whitelabels) {
                return $whitelabels->created_at->toDateString();
            })
            ->addColumn('actions', function ($whitelabels) {
                return $whitelabels->action_buttons;
            })
            ->make(true);
    }
}
