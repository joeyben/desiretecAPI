<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\CreateUserRequest;
use App\Http\Requests\Backend\Access\User\DeleteUserRequest;
use App\Http\Requests\Backend\Access\User\EditUserRequest;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Http\Requests\Backend\Access\User\ShowUserRequest;
use App\Http\Requests\Backend\Access\User\StoreUserRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserRequest;
use App\Models\Access\Permission\Permission;
use App\Models\Access\User\User;
use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Repositories\Backend\Access\User\UserRepository;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * @var RoleRepository
     */
    protected $roles;

    /**
     * @var WhitelabelRepository
     */
    protected $whitelabels;
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private $response;

    /**
     * @param UserRepository                                              $users
     * @param RoleRepository                                              $roles
     * @param \App\Repositories\Backend\Whitelabels\WhitelabelsRepository $whitelabels
     * @param \Illuminate\Auth\AuthManager                                $auth
     * @param \Illuminate\Routing\ResponseFactory                         $response
     */
    public function __construct(UserRepository $users, RoleRepository $roles, WhitelabelsRepository $whitelabels, AuthManager $auth, ResponseFactory $response)
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->whitelabels = $whitelabels;
        $this->auth = $auth;
        $this->response = $response;
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageUserRequest $request)
    {
        return view('backend.access.users.index');
    }

    /**
     * @param CreateUserRequest $request
     *
     * @return mixed
     */
    public function create(CreateUserRequest $request)
    {
        return view('backend.access.users.create')->with([
            'roles'       => $this->roles->getAll(),
            'whitelabels' => $this->whitelabels->getAll(),
        ]);
    }

    /**
     * @param StoreUserRequest $request
     *
     * @return mixed
     */
    public function store(StoreUserRequest $request)
    {
        $this->users->create($request);

        return redirect()->route('admin.access.user.index')->withFlashSuccess(trans('alerts.backend.users.created'));
    }

    /**
     * @param User            $user
     * @param ShowUserRequest $request
     *
     * @return mixed
     */
    public function show(User $user, ShowUserRequest $request)
    {
        return view('backend.access.users.show')
            ->withUser($user)->with([
                'whitelabels' => $this->whitelabels->getAll(),
            ]);
    }

    /**
     * @param User            $user
     * @param EditUserRequest $request
     *
     * @return mixed
     */
    public function edit(User $user, EditUserRequest $request)
    {
        $permissions = Permission::getSelectData('display_name');
        $groups = DB::table('groups')->whereIn('whitelabel_id', $user->whitelabels->pluck('id')->toArray())->get()->toArray();
        $userPermissions = $user->permissions()->get()->pluck('id')->toArray();
        $userWhitelabels = $user->whitelabels()->get()->pluck('id')->toArray();
        $userGroups = $user->groups()->get()->pluck('id')->toArray();

        return view('backend.access.users.edit')->with([
            'user'            => $user,
            'userRoles'       => $user->roles->pluck('id')->all(),
            'roles'           => $this->roles->getAll(),
            'userPermissions' => $userPermissions,
            'userWhitelabels' => $userWhitelabels,
            'userGroups'      => $userGroups,
            'permissions'     => $permissions,
            'groups'          => $groups,
            'whitelabels'     => $this->whitelabels->getAll(),
        ]);
    }

    /**
     * @param User              $user
     * @param UpdateUserRequest $request
     *
     * @return mixed
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $this->users->update($user, $request);

        return redirect()->route('admin.access.user.index')->withFlashSuccess(trans('alerts.backend.users.updated'));
    }

    /**
     * @param User              $user
     * @param DeleteUserRequest $request
     *
     * @return mixed
     */
    public function destroy(User $user, DeleteUserRequest $request)
    {
        $this->users->delete($user);

        return redirect()->route('admin.access.user.deleted')->withFlashSuccess(trans('alerts.backend.users.deleted'));
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function current()
    {
        try {
            $user = $this->users->find($this->auth->guard('web')->user()->id);
            $result['user']['id'] = $user->id;
            foreach (config('wishes.permissions', []) as $permission) {
                $result['user']['permissions'][\str_slug($permission)] = $user->hasPermission(\str_slug($permission));
            }
            foreach (config('categories.permissions', []) as $permission) {
                $result['user']['permissions'][\str_slug($permission)] = $user->hasPermission(\str_slug($permission));
            }
            foreach (config('groups.permissions', []) as $permission) {
                $result['user']['permissions'][\str_slug($permission)] = $user->hasPermission(\str_slug($permission));
            }
            $result['user']['roles']['Administrator'] = $user->hasRole('Administrator');
            $result['user']['roles']['Executive'] = $user->hasRole('Executive');
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_PRESERVE_ZERO_FRACTION);
    }
}
