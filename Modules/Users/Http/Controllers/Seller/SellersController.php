<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 29.01.19
 * Time: 15:04.
 */

namespace Modules\Users\Http\Controllers\Seller;

use App\Models\Access\Role\Role;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\HasRole;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WhereHas;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Groups\Repositories\Contracts\GroupsRepository;
use Modules\Users\Http\Requests\StoreUserRequest;
use Modules\Users\Http\Requests\UpdateUserRequest;
use Modules\Users\Repositories\Contracts\UsersRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

/**
 * Class SellersController.
 */
class SellersController
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
     * SellersController constructor.
     *
     * @param \Modules\Users\Repositories\Contracts\UsersRepository             $users
     * @param \Illuminate\Routing\ResponseFactory                               $response
     * @param \Illuminate\Auth\AuthManager                                      $auth
     * @param \Illuminate\Translation\Translator                                $lang
     * @param \Modules\Groups\Repositories\Contracts\GroupsRepository           $groups
     * @param \Modules\Activities\Repositories\Contracts\ActivitiesRepository   $activities
     * @param \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository $whitelabels
     */
    public function __construct(UsersRepository $users, ResponseFactory $response, AuthManager $auth, Translator $lang, GroupsRepository $groups, ActivitiesRepository $activities, WhitelabelsRepository $whitelabels)
    {
        $this->users = $users;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->groups = $groups;
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
        return view('users::sellers.index');
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
                    $query->select('id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'));
                }, 'roles'  => function ($query) {
                    $query->select('roles.id', 'roles.name');
                }]),
                new HasRole(Flag::SELLER_ROLE)
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
                new EagerLoad(['groups' => function ($query) {
                    $query->select('groups.id', 'groups.name');
                }, 'whitelabels']),
                new WhereHas('roles', function ($query) {
                    $query->where('roles.name', Flag::SELLER_ROLE);
                })
            ])->find($id);

            $result['user'] = [
                'id'         => $user->id,
                'first_name' => $user->first_name,
                'email'      => $user->email,
                'status'     => (boolean)$user->status,
                'confirmed'  => (boolean)$user->confirmed,
                'groups'     => $user->groups->pluck('id'),
                'whitelabel' => $user->whitelabels->first(),
                'whitelabelId' => $user->whitelabels->first()->id,
            ];

            $result['user']['logs'] = $this->auth->guard('web')->user()->hasPermission('logs-user') ? $this->activities->byModel($user) : [];
            $result['user']['groupsList'] = $this->groups->findWhere('whitelabel_id', $user->whitelabels->first()->id)->map(function ($group) {
                return [
                    'id'   => $group->id,
                    'name' => $group->name
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
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();

            if ((null === $whitelabel) && $request->has('whitelabelId')) {
                $whitelabel = $this->whitelabels->find($request->get('whitelabelId'));
            }

            $result['user'] = [
                'id'         => 0,
                'first_name' => '',
                'email'      => '',
                'status'     => true,
                'confirmed'  => true,
                'groups'     => [],
                'whitelabel' => $whitelabel,
                'whitelabelId' => $whitelabel->id
            ];

            $result['user']['logs'] = [];
            $result['user']['groupsList'] = $this->groups->findWhere('whitelabel_id', $whitelabel->id)->map(function ($group) {
                return [
                    'id'   => $group->id,
                    'name' => $group->name
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
     * @param \Modules\Users\Http\Requests\UpdateUserRequest $request
     * @param int                                            $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        try {
            $user = $this->users->withCriteria([
                new HasRole(Flag::SELLER_ROLE)
            ])->update($id, $request->only('first_name', 'email', 'status', 'confirmed'));

            $this->users->sync($user->id, 'groups', $request->get('groups'));

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
     * Store a newly created resource in storage.
     *
     * @param \Modules\Users\Http\Requests\StoreUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();
            if ((null === $whitelabel) && $request->has('whitelabelId')) {
                $whitelabel = $this->whitelabels->find($request->get('whitelabelId'));
            }

            $result['user'] = $this->users->create(
                $request->only('first_name', 'email', 'status', 'confirmed')
            );

            $this->users->sync($result['user']->id, 'groups', $request->get('groups'));
            $this->users->sync($result['user']->id, 'whitelabels', [$whitelabel->id]);
            $this->users->sync($result['user']->id, 'roles', [Role::where('name', Flag::SELLER_ROLE)->first()->id]);

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
}
