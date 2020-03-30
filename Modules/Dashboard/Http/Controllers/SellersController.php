<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Models\Access\User\User;
use App\Repositories\Criteria\HasRole;
use App\Repositories\Criteria\WhereHas;
use App\Repositories\Criteria\WhereHasForDashboard;
use App\Repositories\Criteria\WhereIn;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;
use Modules\Users\Repositories\Contracts\UsersRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class SellersController extends Controller
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

    private $dashboard;
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;

    public function __construct(WhitelabelsRepository $whitelabels, UsersRepository $users, ResponseFactory $response, AuthManager $auth, Translator $lang, DashboardRepository $dashboard)
    {
        $this->users = $users;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->dashboard = $dashboard;
        $this->whitelabels = $whitelabels;
    }


    public function index(Request $request)
    {
        try {
            $usersForWhitelabels = [];

            if ($this->auth->guard('web')->user()->hasRole(Flag::EXECUTIVE_ROLE) && !$this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
                $whitelabelId = $this->auth->guard('web')->user()->whitelabels()->first()->id;

                $users = $this->whitelabels->find($whitelabelId)->users()->whereHas('roles', function ($query) {
                    $query->where('roles.name', Flag::SELLER_ROLE);
                })->get();

                foreach ($users as $user) {
                    if ($user->hasRole(Flag::SELLER_ROLE) && !$user->hasRole(Flag::ADMINISTRATOR_ROLE)) {
                        $usersForWhitelabels[] = $user->id;
                    }
                }
            } elseif ($this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
                $users = User::whereHas('roles', function ($query) {
                    $query->where('roles.name', Flag::SELLER_ROLE);
                })->get();

                foreach ($users as $user) {
                    if ($user->hasRole(Flag::SELLER_ROLE) && !$user->hasRole(Flag::ADMINISTRATOR_ROLE)) {
                        $usersForWhitelabels[] = $user->id;
                    }
                }
            }

            $sellers = $this->users->withCriteria([
                new WhereIn('users.id', $usersForWhitelabels),
            ])->all();

            $data = [];

            foreach ($sellers as $seller) {
                if ($request->has('whitelabelId')) {
                    if (null !== $seller->whitelabels->first() && $seller->whitelabels->first()->id === (int) $request->get('whitelabelId')) {
                        $data[] = $seller;
                    }
                } else {
                    $data[] = $seller;
                }
            }

            $result['sellerCount']['all'] = \count($data);
            $result['sellerCount']['active'] = 0;

            foreach ($data as $seller) {
                if ($seller->status) {
                    ++$result['sellerCount']['active'];
                }
            }
            $result['basis'] = $this->dashboard->getFilterCategory('Basis');
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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('dashboard::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('dashboard::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request)
    {
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
