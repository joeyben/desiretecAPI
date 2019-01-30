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
use App\Repositories\Criteria\WhereHas;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Groups\Repositories\Contracts\GroupsRepository;
use Modules\Users\Http\Requests\StoreUserRequest;
use Modules\Users\Http\Requests\UpdateUserRequest;
use Modules\Users\Repositories\Contracts\UsersRepository;

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
     * SellersController constructor.
     *
     * @param \Modules\Users\Repositories\Contracts\UsersRepository   $users
     * @param \Illuminate\Routing\ResponseFactory                     $response
     * @param \Illuminate\Auth\AuthManager                            $auth
     * @param \Illuminate\Translation\Translator                      $lang
     * @param \Modules\Groups\Repositories\Contracts\GroupsRepository $groups
     */
    public function __construct(UsersRepository $users, ResponseFactory $response, AuthManager $auth, Translator $lang, GroupsRepository $groups)
    {
        $this->users = $users;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->groups = $groups;
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
            $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();
            $user = $this->users->withCriteria([
                new EagerLoad(['groups' => function ($query) {
                    $query->select('groups.id', 'groups.name');
                }]),
                new WhereHas('roles', function ($query) {
                    $query->where('roles.name', Flag::SELLER_ROLE);
                })
            ])->find($id);

            $result['user'] = [
                'id'         => $user->id,
                'first_name' => $user->first_name,
                'email'      => $user->email,
                'status'     => $user->status,
                'confirmed'  => $user->confirmed,
                'groups'     => $user->groups->pluck('id'),
                'whitelabel' => $whitelabel->name,
            ];

            $result['user']['logs'] = $this->auth->guard('web')->user()->hasPermission('logs-user') ? $this->activities->byModel($user) : [];
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
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        try {
            $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();

            $result['user'] = [
                'id'         => 0,
                'first_name' => '',
                'email'      => '',
                'status'     => true,
                'confirmed'  => true,
                'groups'     => [],
                'whitelabel' => $whitelabel->name,
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
            $user = $this->users->update($id, $request->only('first_name', 'email', 'status'));

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
