<?php

namespace App\Http\Controllers\Backend\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Groups\ManageGroupsRequest;
use App\Repositories\Backend\Groups\GroupsRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class GroupsTableController.
 */
class GroupsTableController extends Controller
{
    protected $groups;

    /**
     * @param \App\Repositories\Backend\Groups\GroupsRepository $cmspages
     */
    public function __construct(GroupsRepository $groups)
    {
        $this->groups = $groups;
    }

    /**
     * @param \App\Http\Requests\Backend\Groups\ManageGroupsRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageGroupsRequest $request)
    {
        return Datatables::of($this->groups->getForDataTable())
            ->escapeColumns(['name'])
            ->escapeColumns(['display_name'])
            ->escapeColumns(['description'])
            ->addColumn('users', function ($groups) {
                $users = "";
                foreach ($groups->users as $user){
                    $users .= "<div>".$user->first_name." ".$user->last_name."</div>";
                }
                return $users;
            })
            ->addColumn('status', function ($groups) {
                return $groups->status;
            })
            ->addColumn('created_at', function ($groups) {
                return $groups->created_at->toDateString();
            })
            ->addColumn('actions', function ($groups) {
                return $groups->action_buttons;
            })
            ->make(true);
    }
}
