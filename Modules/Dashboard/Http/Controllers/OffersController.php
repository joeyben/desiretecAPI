<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\Where;
use App\Services\Flag\Src\Flag;
use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;
use Modules\Wishes\Repositories\Contracts\WishesRepository;
use Analytics;
use Spatie\Analytics\Period;
use Spatie\Analytics\AnalyticsClientFactory;


class OffersController extends Controller
{
    /**
     * @var \Modules\Wishes\Repositories\Contracts\WishesRepository
     */
    private $wishes;

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
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;
    /**
     * @var \Modules\Dashboard\Repositories\Contracts\DashboardRepository
     */
    private $dashboard;


    /**
     * WishesController constructor.
     *
     * @param \Modules\Wishes\Repositories\Contracts\WishesRepository           $wishes
     * @param \Illuminate\Routing\ResponseFactory                               $response
     * @param \Illuminate\Auth\AuthManager                                      $auth
     * @param \Illuminate\Translation\Translator                                $lang
     * @param \Carbon\Carbon                                                    $carbon
     * @param \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository $whitelabels
     * @param \Modules\Dashboard\Repositories\Contracts\DashboardRepository     $dashboard
     */
    public function __construct(WishesRepository $wishes, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, WhitelabelsRepository $whitelabels, DashboardRepository $dashboard)
    {
        $this->wishes = $wishes;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->whitelabels = $whitelabels;
        $this->dashboard = $dashboard;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
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

            if (is_null($whitelabelId)) {
                $whitelabel = $this->whitelabels->first();
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $ViewId = $whitelabel->value('ga_view_id');
            $gaViewId = is_null($ViewId) ? '192484069' : $ViewId;
            $filter = $this->getFilter($gaViewId);

            $optParams = [
                'dimensions' => 'ga:yearMonth',
                'filters' => $filter['filterd'],
            ];

            $result['ga'] = $this->dashboard->totalEventsMonth($gaViewId, $optParams);

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function perDay(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            
            if (is_null($whitelabelId)) {
                $whitelabel = $this->whitelabels->first();
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $ViewId = $whitelabel->value('ga_view_id');
            $gaViewId = is_null($ViewId) ? '192484069' : $ViewId;
            $filter = $this->getFilter($gaViewId);

                 $optParams = [
                    'dimensions' => 'ga:date',
                    'filters' => $filter['filterd'],
                ];

                 $result['ga'] = $this->dashboard->totalEventsDay($gaViewId, $optParams);

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }


    public function mobileMonth(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            
            if (is_null($whitelabelId)) {
                $whitelabel = $this->whitelabels->first();
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $ViewId = $whitelabel->value('ga_view_id');
            $gaViewId = is_null($ViewId) ? '192484069' : $ViewId;
            $filter = $this->getFilter($gaViewId);

                 $optParams = [
                    'dimensions' => 'ga:yearMonth',
                    'filters' => $filter['filterm'],
                ];

                 $result['ga'] = $this->dashboard->totalEventsMonth($gaViewId, $optParams);  

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }


    public function responseMonth(Request $request)
    {
        try {

            $whitelabelId = $request->get('whitelabelId');
            
            if (is_null($whitelabelId)) {
                $whitelabel = $this->whitelabels->first();
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $ViewId = $whitelabel->value('ga_view_id');
            $gaViewId = is_null($ViewId) ? '192484069' : $ViewId;

                $filter = $this->getFilter($gaViewId);

                 $optParams = [
                    'dimensions' => 'ga:yearMonth',
                    'filters' => $filter['filterd'],
                ];

                    $result['ga'] = $this->dashboard->uniqueEventsMonth($gaViewId, $optParams);

                    $result['wishCount'] = $this->wishes->withCriteria([
                    new ByWhitelabel(),
                    new Where('wishes.whitelabel_id', $request->get('whitelabelId')),
                     ])->all()->count();

                foreach ($result['ga'] as $key => $value) {
                        if($result['ga'][$key][1]!=0)
                     $result['ga'][$key][1] = intval(($result['wishCount']/$result['ga'][$key][1])*100);
                 }             

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }


    public function responsemMonth(Request $request)
    {
        try {

            $whitelabelId = $request->get('whitelabelId');
            
            if (is_null($whitelabelId)) {
                $whitelabel = $this->whitelabels->first();
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }
            
            $ViewId = $whitelabel->value('ga_view_id');
            $gaViewId = is_null($ViewId) ? '192484069' : $ViewId;

                $filter = $this->getFilter($gaViewId);

                 $optParams = [
                    'dimensions' => 'ga:yearMonth',
                    'filters' => $filter['filterm'],
                ];

                    $result['ga'] = $this->dashboard->uniqueEventsMonth($gaViewId, $optParams);

                    $result['wishCount'] = $this->wishes->withCriteria([
                    new ByWhitelabel(),
                    new Where('wishes.whitelabel_id', $request->get('whitelabelId')),
                     ])->all()->count();

                foreach ($result['ga'] as $key => $value) {
                        if($result['ga'][$key][1]!=0)
                     $result['ga'][$key][1] = intval(($result['wishCount']/$result['ga'][$key][1])*100);
                 } 

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
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
