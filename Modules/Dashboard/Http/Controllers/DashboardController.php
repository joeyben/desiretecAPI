<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Repositories\Backend\Access\User\UserRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Translation\Translator;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;

class DashboardController extends Controller
{
    /**
     * @var \Modules\Dashboard\Repositories\Contracts\DashboardRepository
     */
    private $dashboard;
    /**
     * @var \Modules\Activities\Repositories\Contracts\ActivitiesRepository
     */
    private $activities;
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
     * @var \App\Repositories\Backend\Access\User\UserRepository
     */
    private $users;
    /**
     * @var \Illuminate\Support\Carbon
     */
    private $carbon;

    /**
     * DashboardController constructor.
     *
     * @param \Modules\Dashboard\Repositories\Contracts\DashboardRepository   $dashboard
     * @param \Modules\Activities\Repositories\Contracts\ActivitiesRepository $activities
     * @param \Illuminate\Routing\ResponseFactory                             $response
     * @param \Illuminate\Auth\AuthManager                                    $auth
     * @param \Illuminate\Translation\Translator                              $lang
     * @param \App\Repositories\Backend\Access\User\UserRepository            $users
     * @param \Illuminate\Support\Carbon                                      $carbon
     */
    public function __construct(DashboardRepository $dashboard, ActivitiesRepository $activities, ResponseFactory $response, AuthManager $auth, Translator $lang, UserRepository $users, Carbon $carbon)
    {
        $this->dashboard = $dashboard;
        $this->activities = $activities;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->users = $users;
        $this->carbon = $carbon;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('dashboard::index');
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
        try {
            $result['dashboards'] = $this->auth->guard('web')->user()->dashboards()->get();
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

    public function save(Request $request)
    {
        try {
            $dashboards = $this->auth->guard('web')->user()->dashboards()->get()->pluck('id')->toArray();

            foreach ($request->get('dashboards') as $dashboard) {
                if (\in_array($dashboard['id'], $dashboards, true)) {
                    $this->dashboard->update($dashboard['id'], ['x' => $dashboard['x'], 'y' => $dashboard['y']]);
                }
            }
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
