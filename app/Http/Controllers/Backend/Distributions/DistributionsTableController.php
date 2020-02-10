<?php

namespace App\Http\Controllers\Backend\Distributions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Distributions\ManageDistributionsRequest;
use App\Repositories\Backend\Distributions\DistributionsRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class DistributionsTableController.
 */
class DistributionsTableController extends Controller
{
    protected $distributions;

    /**
     * @param \App\Repositories\Backend\Distributions\DistributionsRepository $cmspages
     */
    public function __construct(DistributionsRepository $distributions)
    {
        $this->distributions = $distributions;
    }

    /**
     * @return mixed
     */
    public function __invoke(ManageDistributionsRequest $request)
    {
        return Datatables::of($this->distributions->getForDataTable())
            ->escapeColumns(['name'])
            ->addColumn('display_name', function ($distributions) {
                return $distributions->display_name;
            })
            ->addColumn('description', function ($distributions) {
                return $distributions->description;
            })
            ->addColumn('created_by', function ($distributions) {
                return $distributions->user_name;
            })
            ->addColumn('created_at', function ($distributions) {
                return $distributions->created_at->toDateString();
            })
            ->addColumn('actions', function ($distributions) {
                return $distributions->action_buttons;
            })
            ->make(true);
    }
}
