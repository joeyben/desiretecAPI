<?php

namespace Modules\Groups\Http\Controllers;

use App\Models\Whitelabels\Whitelabel;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereBetween;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Groups\Http\Requests\StoreGroupRequest;
use Modules\Groups\Http\Requests\UpdateGroupRequest;
use Modules\Groups\Repositories\Contracts\GroupsRepository;

class GroupsController extends Controller
{
    /**
     * @var \Modules\Groups\Repositories\Contracts\GroupsRepository
     */
    private $groups;
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private $response;
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var \Illuminate\Translation\Translator
     */
    private $lang;
    /**
     * @var \Illuminate\Support\Carbon
     */
    private $carbon;
    /**
     * @var \Modules\Activities\Repositories\Contracts\ActivitiesRepository
     */
    private $activities;
    /**
     * @var \App\Repositories\Backend\Whitelabels\WhitelabelsRepository
     */
    private $whitelabels;

    /**
     * GroupsController constructor.
     *
     * @param \Modules\Groups\Repositories\Contracts\GroupsRepository         $groups
     * @param \Illuminate\Routing\ResponseFactory                             $response
     * @param \Illuminate\Auth\AuthManager                                    $auth
     * @param \Illuminate\Translation\Translator                              $lang
     * @param \Illuminate\Support\Carbon                                      $carbon
     * @param \Modules\Activities\Repositories\Contracts\ActivitiesRepository $activities
     * @param \App\Repositories\Backend\Whitelabels\WhitelabelsRepository     $whitelabels
     */
    public function __construct(GroupsRepository $groups, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, WhitelabelsRepository $whitelabels)
    {
        $this->groups = $groups;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->activities = $activities;
        $this->whitelabels = $whitelabels;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('groups::index');
    }

    public function view(Request $request)
    {
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->groups->withCriteria([
                new OrderBy($sort[0], $sort[1]),
                new Where('groups.whitelabel_id', $request->get('whitelabel')),
                new WhereBetween('groups.created_at', $request->get('start'), $request->get('end')),
                new Filter($request->get('filter')),
                new EagerLoad(['owner' => function ($query) {
                    $select = $this->auth->guard('web')->user()->hasRole('Administrator') ? 'CONCAT(first_name, " ", last_name, " ( ", email, " ) ") AS full_name' : 'CONCAT(first_name, " ", last_name) AS full_name';
                    $query->select('users.id', DB::raw($select));
                }, 'users'  => function ($query) {
                    $query->select('users.id', DB::raw('CONCAT(first_name, " ", last_name, " ( ", email, " ) ") AS full_name'));
                }, 'whitelabel'  => function ($query) {
                    $query->select('id', 'display_name');
                }]),
                new ByWhitelabel('groups')
            ])->paginate($perPage);

            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result['data'], $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        try {
            $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();
            $result['group'] = [
                'name'                    => '',
                'description'              => '',
                'status'              => true,
                'users'                    => [],
                'owner'                    => $this->auth->guard('web')->user()->first_name . ' ' . $this->auth->guard('web')->user()->last_name,
                'logs'                    => [],
                'whitelabel' => $whitelabel,
            ];
            $users = $this->whitelabels->find($whitelabel->id)->users()->get();

            $result['group']['usersList'] = $users->map(function ($user) {
                return [
                    'id'   => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name
                ];
            });

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(StoreGroupRequest $request)
    {
        try {
            $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();
            $result['group'] = $this->groups->create(
                array_merge(
                    $request->only('name', 'description', 'status'),
                    ['whitelabel_id' => $whitelabel->id, 'created_by' => $this->auth->guard('web')->user()->id, 'updated_by' => $this->auth->guard('web')->user()->id]
                )
            );

            $this->groups->sync($result['group']->id, 'users', $request->get('users'));
            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Group']);
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('groups::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id)
    {
        try {
            $group = $this->groups->withCriteria([
                new EagerLoad(['owner' => function ($query) {
                    $query->select('users.id', DB::raw('CONCAT(users.first_name, " ", users.last_name) AS full_name'));
                }, 'users'  => function ($query) {
                    $query->select('users.id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'));
                }, 'whitelabel'  => function ($query) {
                    $query->select('id', 'display_name');
                }]),
                new ByWhitelabel('groups')
            ])->find($id);

            $result['group'] = [
                'id' => $group->id,
                'name' => $group->name,
                'owner' => $group->owner->full_name,
                'whitelabel' => $group->whitelabel,
                'users' => $group->users->pluck('id'),
                'description' => $group->description,
                'status' => $group->status
            ];
            $result['group']['logs'] = $this->auth->guard('web')->user()->hasPermission('logs-group') ? $this->activities->byModel($group) : [];
            $users = $this->whitelabels->find($group->whitelabel_id)->users()->get();

            $result['group']['usersList'] = $users->map(function ($user) {
                return [
                    'id'   => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name
                ];
            });

            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_PRESERVE_ZERO_FRACTION);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Modules\Groups\Http\Requests\UpdateGroupRequest $request
     *
     * @param int                                              $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateGroupRequest $request, int $id)
    {
        try {
            $group = $this->groups->withCriteria([
                new ByWhitelabel('groups')
            ])->update(
                $id,
                $request->only(
                    'name',
                    'description',
                    'status'
                ));

            $this->groups->sync($group->id, 'users', $request->get('users'));

            $result['group'] = $group;
            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Group']);
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $result['group'] = $this->groups->delete($id);
            $result['message'] = $this->lang->get('messages.deleted', ['attribute' => 'Group']);
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }
}
