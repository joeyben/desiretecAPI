<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\GroupBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereMonth;
use App\Repositories\Criteria\WhereYear;
use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Wishes\Repositories\Contracts\WishesRepository;
use Analytics;
use Spatie\Analytics\Period;

class OffersController extends Controller
{
    /**
     * @var \Modules\Wishes\Repositories\Contracts\WishesRepository
     */
    private $events;
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
     * @var \Carbon\Carbon
     */
    private $carbon;

    /**
     * WishesController constructor.
     *
     * @param \Modules\Wishes\Repositories\Contracts\WishesRepository $wishes
     * @param \Illuminate\Routing\ResponseFactory                     $response
     * @param \Illuminate\Auth\AuthManager                            $auth
     * @param \Illuminate\Translation\Translator                      $lang
     * @param \Carbon\Carbon                                          $carbon
     */
    public function __construct(WishesRepository $events, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon)
    {
        $this->events = $events;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function perMonth(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabel');

            $gaViewId = '192484069';

            if ('' !== $gaViewId) {
                $optParams = [
                ];

                $result['ga'] = \Analytics::performQuery(
                        Period::months(12),
                        'ga:totalEvents',
                        [
                        'dimensions' => 'ga:month'
                        ]
                        )->rows;

                $data = [];


                $result['data'] = $data;
            } else {
                $result['data'] = [];
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

    public function perDay(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabel');

            $gaViewId = '192484069';

            if ('' !== $gaViewId) {
                $optParams = [
                ];

                $result['ga'] = \Analytics::performQuery(
                        Period::days(30),
                        'ga:totalEvents',
                        [
                        'dimensions' => 'ga:day'
                        ]
                        )->rows;

                $data = [];

                $result['data'] = $data;
            } else {
                $result['data'] = [];
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
