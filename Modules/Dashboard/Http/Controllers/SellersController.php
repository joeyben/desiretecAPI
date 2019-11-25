<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Repositories\Criteria\HasRole;
use App\Repositories\Criteria\WhereHas;
use App\Repositories\Criteria\WhereHasForDashboard;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;
use Modules\Users\Repositories\Contracts\UsersRepository;

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

    public function __construct(UsersRepository $users, ResponseFactory $response, AuthManager $auth, Translator $lang, DashboardRepository $dashboard)
    {
        $this->users = $users;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->dashboard = $dashboard;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $sellers = $this->users->withCriteria([
                new WhereHas('whitelabels', function ($query) {
                    $whitelabels = $this->auth->guard('web')->user()->whitelabels()->get()->pluck('id')->all();
                    $this->auth->guard('web')->user()->hasRole('Administrator') ? $query->newQuery() : $query->whereIn('whitelabels.id', $whitelabels);
                }),
                new WhereHasForDashboard('whitelabels', function ($query) use ($request) {
                    $query->where('whitelabels.id', $request->get('whitelabelId'));
                }),
                new HasRole(Flag::SELLER_ROLE)
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
     * @param Request $request
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
     * @param Request $request
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
