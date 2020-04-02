<?php

namespace Modules\Users\Http\Controllers;

use App\Events\Backend\Access\User\UserCreated;
use App\Events\Backend\Access\User\UserUpdated;
use App\Models\Access\User\User;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WhereHas;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;
use Modules\Groups\Repositories\Contracts\GroupsRepository;
use Modules\Roles\Repositories\Contracts\RolesRepository;
use Modules\Users\Http\Requests\StoreUserRequest;
use Modules\Users\Http\Requests\UpdateUserRequest;
use Modules\Users\Notifications\CreatedUserNotificationForExecutive;
use Modules\Users\Repositories\Contracts\UsersRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class UsersController extends Controller
{
    /**
     * @var \Modules\Users\Repositories\Contracts\UsersRepository
     */
    private $users;
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
     * @var \Modules\Groups\Repositories\Contracts\GroupsRepository
     */
    private $groups;
    /**
     * @var \Modules\Activities\Repositories\Contracts\ActivitiesRepository
     */
    private $activities;
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;
    /**
     * @var \Modules\Dashboard\Repositories\Contracts\DashboardRepository
     */
    private $dashboards;
    /**
     * @var \Modules\Roles\Repositories\Contracts\RolesRepository
     */
    private $roles;
    /**
     * @var \Illuminate\Notifications\ChannelManager
     */
    private $notification;

    /**
     * UsersController constructor.
     */
    public function __construct(UsersRepository $users, ResponseFactory $response, AuthManager $auth, Translator $lang, GroupsRepository $groups, ActivitiesRepository $activities, WhitelabelsRepository $whitelabels, DashboardRepository $dashboards, RolesRepository $roles, ChannelManager $notification)
    {
        $this->users = $users;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->groups = $groups;
        $this->activities = $activities;
        $this->whitelabels = $whitelabels;
        $this->dashboards = $dashboards;
        $this->roles = $roles;
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('users::index');
    }


    public function login(int $id)
    {
        $user = $this->users->find($id);
        $user->storeToken();

        $whitelabel = $user->whitelabels()->first();
        $url = $whitelabel->domain . '/api/token?' . http_build_query(
            array_merge(
                ['token' => $user->token->token],
                [
                    'email' => $user->email,
                    'host' => $whitelabel->domain,
                    'whitelabelId' => $whitelabel->id
                ]
            ));

        return  redirect($url);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->users->withCriteria([
                new OrderBy($sort[0], $sort[1]),
                new WhereBetween('users.created_at', $request->get('start'), $request->get('end')),
                new Filter($request->get('filter')),
                new EagerLoad(['owner' => function ($query) {
                    $select = $this->auth->guard('web')->user()->hasRole('Administrator') ? 'CONCAT(first_name, " ", last_name, " ( ", email, " ) ") AS full_name' : 'CONCAT(first_name, " ", last_name) AS full_name';
                    $query->select('id', DB::raw($select));
                }, 'roles'  => function ($query) {
                    $query->select('roles.id', 'roles.name');
                }]),
                new WhereHas('whitelabels', function ($query) {
                    $whitelabels = Auth::guard('web')->user()->whitelabels()->get()->pluck('id')->all();
                    Auth::guard('web')->user()->hasRole('Administrator') ? $query->newQuery() : $query->whereIn('whitelabels.id', $whitelabels);
                }),
                new WhereHas('roles', function ($query) {
                    Auth::guard('web')->user()->hasRole('Administrator') ? $query->newQuery() : $query->where('roles.name', Flag::SELLER_ROLE);
                })
            ])->paginate($perPage, ['id', 'first_name', 'last_name', 'email', 'status', 'confirmed', 'created_by', 'created_at', 'updated_at', 'deleted_at']);

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result['data'], $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $result['user'] = [
                'id'                   => 0,
                'first_name'           => '',
                'last_name'            => '',
                'email'                => '',
                'status'               => true,
                'confirmed'            => true,
                'groups'               => [],
                'whitelabels'          => [],
                'roles'                => [],
                'dashboards'           => [],
                'confirmation_email'   => false
            ];

            $result['user']['logs'] = [];
            $result['user']['dashboardsList'] = $this->dashboards->all(['id', 'name']);
            $result['user']['whitelabelsList'] = $this->whitelabels->all(['id', 'display_name']);
            $result['user']['rolesList'] = $this->roles->all(['id', 'name']);
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
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            if ($request->has('password')) {
                $extras['password'] = bcrypt($request->get('password'));
            }
            if ($request->has('last_name') && null !== $request->get('last_name')) {
                $extras['last_name'] = $request->get('last_name');
            }

            $extras['created_by'] = $this->auth->guard('web')->user()->id;
            $extras['updated_by'] = $this->auth->guard('web')->user()->id;
            $extras['confirmed'] = true;

            $result['user'] = $this->users->create(
                array_merge($request->only('first_name', 'email', 'status'), $extras)
            );

            event(new UserCreated($result['user']));

            $this->users->sync($result['user']->id, 'whitelabels', $request->get('whitelabels'));
            $this->users->sync($result['user']->id, 'dashboards', $request->get('dashboards'));
            $this->users->sync($result['user']->id, 'roles', $request->get('roles'));

            if ($result['user']->hasRole(Flag::EXECUTIVE_ROLE)) {
                $this->notification->send($result['user'], new CreatedUserNotificationForExecutive($result['user'], $request->get('password')));
            }

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Seller']);
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
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id)
    {
        try {
            $user = $this->users->withCriteria([
                new EagerLoad(['roles'  => function ($query) {
                    $query->select('roles.id', 'roles.name');
                }, 'whitelabels', 'roles', 'dashboards'])
            ])->find($id);

            $result['user'] = [
                'id'                   => $user->id,
                'first_name'           => $user->first_name,
                'last_name'            => $user->last_name,
                'email'                => $user->email,
                'status'               => (bool) $user->status,
                'confirmed'            => (bool) $user->confirmed,
                'groups'               => $user->groups->pluck('id'),
                'whitelabels'          => $user->whitelabels->pluck('id'),
                'roles'                => $user->roles->pluck('id'),
                'dashboards'           => $user->dashboards->pluck('id'),
                'confirmation_email'   => false
            ];

            $result['user']['logs'] = $this->auth->guard('web')->user()->hasPermission('logs-user') ? $this->activities->byModel($user) : [];
            $result['user']['dashboardsList'] = $this->dashboards->all(['id', 'name']);
            $result['user']['whitelabelsList'] = $this->whitelabels->all(['id', 'display_name']);
            $result['user']['rolesList'] = $this->roles->all(['id', 'name']);

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
     * @param Request $request
     *
     * @return Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        try {
            $extras = [];

            if ($request->has('password')) {
                $extras['password'] = bcrypt($request->get('password'));
            }

            $user = $this->users->update($id, array_merge($request->only('first_name', 'last_name', 'email', 'status', 'confirmed'), $extras));

            $this->users->sync($user->id, 'whitelabels', $request->get('whitelabels'));
            $this->users->sync($user->id, 'dashboards', $request->get('dashboards'));
            $this->users->sync($user->id, 'roles', $request->get('roles'));
            event(new UserUpdated($user));

            $result['user'] = $user;
            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'User']);
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
     * @return Response
     */
    public function destroy()
    {
    }
}
