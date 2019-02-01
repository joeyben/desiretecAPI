<?php

namespace App\Http\Controllers\Frontend\Agents;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Agents\ManageAgentsRequest;
use App\Repositories\Frontend\Agents\AgentsRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class AgentsTableController.
 */
class AgentsTableController extends Controller
{
    protected $agents;

    /**
     * @param \App\Repositories\Frontend\Agents\AgentsRepository $cmspages
     */
    public function __construct(AgentsRepository $agents)
    {
        $this->agents = $agents;
    }

    /**
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageAgentsRequest $request)
    {
        return Datatables::of($this->agents->getForDataTable())
            ->addColumn('avatar', function ($agents) {
                return '<img src="https://desiretec.s3.eu-central-1.amazonaws.com/img/agent/' . $agents->avatar . ' "/>';
            })
            ->addColumn('name', function ($agents) {
                return $agents->name;
            })
            ->addColumn('display_name', function ($agents) {
                return $agents->display_name;
            })

            ->addColumn('status', function ($agents) {
                return $agents->status;
            })
            ->addColumn('created_at', function ($agents) {
                return $agents->created_at->toFormattedDateString() . ' ' . $agents->created_at->toTimeString();
            })
            ->rawColumns(['avatar', 'actions', 'confirmed'])->make(true);
    }
}
