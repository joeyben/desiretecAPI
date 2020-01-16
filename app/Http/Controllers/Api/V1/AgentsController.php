<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agents\Agent;
use App\Repositories\Frontend\Agents\AgentsRepository;
use Illuminate\Http\Request;
use App\Http\Resources\PagesResource;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class AgentsController extends APIController
{
    protected $agent;

    public function __construct(AgentsRepository $agent)
    {
        $this->agent = $agent;
    }

    public function getAgents(Request $request)
    {
        try {
            return Datatables::of($this->agent->getForDataTable())
                ->addColumn('avatar', function ($agent) {
                    $path = Storage::disk('s3')->url('img/agent/');
                    return '<img src="' . $path . $agent->avatar . '"/>';
                })
                ->addColumn('name', function ($agent) {
                    return $agent->name;
                })
                ->addColumn('display_name', function ($agent) {
                    return $agent->display_name;
                })
                ->addColumn('status', function ($agent) {
                    return $agent->status;
                })
                ->addColumn('actions', function ($agent) {
                    return '<a href="' . route('frontend.agents.edit', $agent->id) . '">' . trans('labels.agents.edit') . '</a> / ' . '<a href="' . route('frontend.agents.delete', $agent->id) . '">' . trans('labels.agents.delete') . '</a>';
                })
                ->addColumn('created_at', function ($agent) {
                    return $agent->created_at->toFormattedDateString() . ' ' . $agent->created_at->toTimeString();
                })
                ->rawColumns(['avatar', 'actions', 'status'])->make(true);
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }
}
