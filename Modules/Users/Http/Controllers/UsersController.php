<?php

namespace Modules\Users\Http\Controllers;

use App\Events\Backend\Access\User\UserCreated;
use App\Events\Backend\Access\User\UserUpdated;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WhereHas;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * UsersController constructor.
     *
     * @param \Modules\Users\Repositories\Contracts\UsersRepository             $users
     * @param \Illuminate\Routing\ResponseFactory                               $response
     * @param \Illuminate\Auth\AuthManager                                      $auth
     * @param \Illuminate\Translation\Translator                                $lang
     * @param \Modules\Groups\Repositories\Contracts\GroupsRepository           $groups
     * @param \Modules\Activities\Repositories\Contracts\ActivitiesRepository   $activities
     * @param \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository $whitelabels
     * @param \Modules\Dashboard\Repositories\Contracts\DashboardRepository     $dashboards
     * @param \Modules\Roles\Repositories\Contracts\RolesRepository             $roles
     */
    public function __construct(UsersRepository $users, ResponseFactory $response, AuthManager $auth, Translator $lang, GroupsRepository $groups, ActivitiesRepository $activities, WhitelabelsRepository $whitelabels, DashboardRepository $dashboards, RolesRepository $roles)
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

    /**
     * @param \Illuminate\Http\Request $request
     *
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
     * @param \Illuminate\Http\Request $request
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
     * @param \Modules\Users\Http\Requests\StoreUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            if ($request->has('password')) {
                $extras['password'] = bcrypt($request->get('password'));
            }
            if ($request->has('last_name') && !is_null($request->get('last_name'))) {
                $extras['last_name'] = $request->get('last_name');
            }

            $extras['created_by'] = $this->auth->guard('web')->user()->id;
            $extras['updated_by'] = $this->auth->guard('web')->user()->id;
            $extras['confirmation_code'] = md5(uniqid(mt_rand(), true));


            if ($request->has('confirmation_email')) {
            }
            if ($request->get('confirmation_email')  && !$request->get('confirmed')) {
                $result['user']->notify(new UserNeedsConfirmation( $result['user']->confirmation_code));
            }

            event(new UserCreated($result['user']));

            $this->users->sync($result['user']->id, 'whitelabels', $request->get('whitelabels'));
            $this->users->sync($result['user']->id, 'dashboards', $request->get('dashboards'));
            $this->users->sync($result['user']->id, 'roles', $request->get('roles'));

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
     * @param int $id
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
     * @param \Modules\Users\Http\Requests\UpdateUserRequest $request
     * @param int                                            $id
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
