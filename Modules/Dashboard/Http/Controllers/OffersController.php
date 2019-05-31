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
use Spatie\Analytics\AnalyticsClientFactory;


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

            $whitelabelId = $request->get('whitelabelId');
            $ViewId = DB::table('whitelabels')->where('id',$whitelabelId)->value('ga_view_id');
            $gaViewId = ($ViewId == '') ? '192484069' : $ViewId;


            if ('' !== $gaViewId) {

                $filter = $this->getFilter($gaViewId);

                 $optParams = [
                    'dimensions' => 'ga:yearMonth',
                    'filters' => $filter['filterd'],
                ];

                 $result['ga'] = \Analytics::getAnalyticsService()->data_ga->get(
                    'ga:'.$gaViewId,
                    '365daysAgo',
                    'yesterday',
                    'ga:totalEvents',
                    $optParams
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
            $whitelabelId = $request->get('whitelabelId');
            $ViewId = DB::table('whitelabels')->where('id',$whitelabelId)->value('ga_view_id');

            $gaViewId = ($ViewId == '') ? '192484069' : $ViewId;

            $filter = $this->getFilter($gaViewId);


            if ('' !== $gaViewId) {
                 $optParams = [
                    'dimensions' => 'ga:date',
                    'filters' => $filter['filterd'],
                ];

                 $result['ga'] = \Analytics::getAnalyticsService()->data_ga->get(
                    'ga:'.$gaViewId,
                    '30daysAgo',
                    'yesterday',
                    'ga:totalEvents',
                    $optParams
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


    public function mobileMonth(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $ViewId = DB::table('whitelabels')->where('id',$whitelabelId)->value('ga_view_id');

            $gaViewId = ($ViewId == '') ? '192484069' : $ViewId;

            $filter = $this->getFilter($gaViewId);


            if ('' !== $gaViewId) {
                 $optParams = [
                    'dimensions' => 'ga:yearMonth',
                    'filters' => $filter['filterm'],
                ];

                 $result['ga'] = \Analytics::getAnalyticsService()->data_ga->get(
                    'ga:'.$gaViewId,
                    '365daysAgo',
                    'yesterday',
                    'ga:totalEvents',
                    $optParams
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


    public function getFilter(string $viewid)
    {
        $filterdesk = '';
        $filtermobile = '';

        switch($viewid){

            case '192484069':
            $filterdesk = 'ga:eventLabel==eil-n1;ga:eventAction==shown;ga:eventCategory==trendtours_exitwindow';
            $filtermobile = 'ga:eventLabel==eil-mobile;ga:eventAction==shown;ga:eventCategory==trendtours_exitwindow';
            break;

            case '159641355':
            $filterdesk = 'ga:eventLabel==eil-n1-3.0;ga:eventAction==shown;ga:eventCategory==tui_exitwindow_3.0';
            $filtermobile = 'ga:eventLabel==eil-auto-tablet-3.0;ga:eventAction==shown;ga:eventCategory==tui_exitwindow_3.0';
            break;

            case '162076862':
            $filterdesk = 'ga:eventLabel==eil-n1-3.0;ga:eventAction==shown;ga:eventCategory==tui_exitwindow_3.0';
            $filtermobile = 'ga:eventLabel==eil-auto-tablet-3.0;ga:eventAction==shown;ga:eventCategory==tui_exitwindow_3.0';
            break;

            case '174270531':
            $filterdesk = 'ga:eventLabel==eil-n1-3.0;ga:eventAction==shown;ga:eventCategory==tui_exitwindow_3.0';
            $filtermobile = 'ga:eventLabel==eil-auto-tablet-3.0;ga:eventAction==shown;ga:eventCategory==tui_exitwindow_3.0';
            break;

            case '185523513':
            $filterdesk = 'ga:eventLabel==eil-n1-3.0;ga:eventAction==shown;ga:eventCategory==tui_exitwindow_3.0';
            $filtermobile = 'ga:eventLabel==eil-auto-tablet-3.0;ga:eventAction==shown;ga:eventCategory==tui_exitwindow_3.0';
            break;

        }

        return array('filterd'=>$filterdesk, 'filterm'=>$filtermobile);
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
