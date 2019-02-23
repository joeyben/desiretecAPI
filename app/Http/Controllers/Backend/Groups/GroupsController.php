<?php

namespace App\Http\Controllers\Backend\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Groups\ManageGroupsRequest;
use App\Http\Requests\Backend\Groups\StoreGroupsRequest;
use App\Http\Requests\Backend\Groups\UpdateGroupsRequest;
use App\Models\Groups\Group;
use App\Repositories\Backend\Groups\GroupsRepository;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;

/**
 * Class GroupsController.
 */
class GroupsController extends Controller
{
    /**
     * Group Status.
     */
    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
        'Deleted'      => 'Deleted',
    ];

    /**
     * @var GroupsRepository
     */
    protected $group;

    /**
     * @var WhitelabelsRepository
     */
    protected $whitelabels;

    /**
     * @param \App\Repositories\Backend\Groups\GroupsRepository $group
     * @param WhitelabelsRepository                             $whitelabels
     */
    public function __construct(GroupsRepository $group, WhitelabelsRepository $whitelabels)
    {
        $this->group = $group;
        $this->whitelabels = $whitelabels;
    }

    /**
     * @param \App\Http\Requests\Backend\Groups\ManageGroupsRequest $request
     *
     * @return mixed
     */
    public function index(ManageGroupsRequest $request)
    {
        return view('groups::index');
    }

    /**
     * @param \App\Http\Requests\Backend\Groups\ManageGroupsRequest $request
     *
     * @return mixed
     */
    public function create(ManageGroupsRequest $request)
    {
        return view('backend.groups.create')->with([
            'whitelabels'    => $this->whitelabels->getAll(),
            'status'         => $this->status,
        ]);
    }

    /**
     * @param \App\Http\Requests\Backend\Groups\StoreGroupsRequest $request
     *
     * @return mixed
     */
    public function store(StoreGroupsRequest $request)
    {
        $this->group->create($request->except('_token'));

        return redirect()
            ->route('admin.groups.index')
            ->with('flash_success', trans('alerts.backend.groups.created'));
    }

    /**
     * @param \App\Models\Groups\Group                              $group
     * @param \App\Http\Requests\Backend\Groups\ManageGroupsRequest $request
     *
     * @return mixed
     */
    public function edit(Group $group, ManageGroupsRequest $request)
    {
        return view('backend.groups.edit')->with([
            'group'               => $group,
            'status'              => $this->status,
            'whitelabels'         => $this->whitelabels->getAll(),
        ]);
    }

    /**
     * @param \App\Models\Groups\Group                              $group
     * @param \App\Http\Requests\Backend\Groups\UpdateGroupsRequest $request
     *
     * @return mixed
     */
    public function update(Group $group, UpdateGroupsRequest $request)
    {
        $input = $request->all();

        $this->group->update($group, $request->except(['_token', '_method']));

        return redirect()
            ->route('admin.groups.index')
            ->with('flash_success', trans('alerts.backend.groups.updated'));
    }

    /**
     * @param \App\Models\Groups\Group                              $group
     * @param \App\Http\Requests\Backend\Groups\ManageGroupsRequest $request
     *
     * @return mixed
     */
    public function destroy(Group $group, ManageGroupsRequest $request)
    {
        $this->group->delete($group);

        return redirect()
            ->route('admin.groups.index')
            ->with('flash_success', trans('alerts.backend.groups.deleted'));
    }
}
