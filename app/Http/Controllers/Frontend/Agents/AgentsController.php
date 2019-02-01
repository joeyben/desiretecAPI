<?php

namespace App\Http\Controllers\Frontend\Agents;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Agents\ManageAgentsRequest;
use App\Http\Requests\Frontend\Agents\StoreAgentsRequest;
use App\Http\Requests\Frontend\Agents\UpdateAgentsRequest;
use App\Models\Agents\Agent;
use App\Repositories\Frontend\Agents\AgentsRepository;
use Illuminate\Http\Request;

/**
 * Class AgentsController.
 */
class AgentsController extends Controller
{
    const BODY_CLASS = 'agent';
    /**
     * Agent Status.
     */
    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
        'Deleted'      => 'Deleted',
    ];

    /**
     * @var AgentsRepository
     */
    protected $agent;

    /**
     * @param \App\Repositories\Frontend\Agents\AgentsRepository $agent
     */
    public function __construct(AgentsRepository $agent)
    {
        $this->agent = $agent;
    }

    /**
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     *
     * @return mixed
     */
    public function index(ManageAgentsRequest $request)
    {
        return view('frontend.agents.index')->with([
            'status'     => $this->status,
            'body_class' => $this::BODY_CLASS,
        ]);
    }
    
    /**
     * @param \App\Models\Agents\Agent                               $agent
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     *
     * @return mixed
     */
    public function profile()
    {
        return view('frontend.agents.profile');
    }

    /**
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     * @param type                                                   $id
     *
     * @return mixed
     */
    public function create(ManageAgentsRequest $request)
    {
        return view('frontend.agents.create')->with([
            'status'         => $this->status,
            // 'user_id'        => $id,
            'body_class'     => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Agents\StoreAgentsRequest $request
     *
     * @return mixed
     */
    public function store(Request $request)
    { 
        $this->agent->create($request->except('_token'));

        return redirect()
            ->route('frontend.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.created'));
    }

    /**
     * @param \App\Models\Agents\Agent                               $agent
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     *
     * @return mixed
     */
    public function edit(Agent $agent, ManageAgentsRequest $request)
    {
        return view('frontend.agents.edit')->with([
            'agent'               => $agent,
            'status'              => $this->status,
            'body_class'          => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Models\Agents\Agent                               $agent
     * @param \App\Http\Requests\Frontend\Agents\UpdateAgentsRequest $request
     *
     * @return mixed
     */
    public function update(Agent $agent, UpdateAgentsRequest $request)
    {
        $input = $request->all();

        $this->agent->update($agent, $request->except(['_token', '_method']));

        return redirect()
            ->route('admin.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.updated'));
    }

    /**
     * @param \App\Models\Agents\Agent                               $agent
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     *
     * @return mixed
     */
    public function destroy(Agent $agent, ManageAgentsRequest $request)
    {
        $this->agent->delete($agent);

        return redirect()
            ->route('admin.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.deleted'));
    }

    public function status($id)
    {
    
        $this->agent->updateStatus($id);

        return redirect()->back();
    }
}
