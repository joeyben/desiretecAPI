<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\Where;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;
use Modules\Groups\Repositories\Contracts\GroupsRepository;

class GroupsController extends Controller
{
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

    private $dashboard;

    /**
     * GroupsController constructor.
     *
     * @param \Modules\Groups\Repositories\Contracts\GroupsRepository $groups
     * @param \Illuminate\Routing\ResponseFactory                     $response
     * @param \Illuminate\Auth\AuthManager                            $auth
     * @param \Illuminate\Translation\Translator                      $lang
     */
    public function __construct(GroupsRepository $groups, ResponseFactory $response, AuthManager $auth, Translator $lang, DashboardRepository $dashboard)
    {
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->groups = $groups;
        $this->dashboard = $dashboard;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $result['groupCount'] = $this->groups->withCriteria([
                new ByWhitelabel('groups'),
                 new Where('groups.whitelabel_id', $request->get('whitelabelId'))
            ])->all()->count();
            $result['basis'] = $this->dashboard->getFilterCategory('Basis');
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
