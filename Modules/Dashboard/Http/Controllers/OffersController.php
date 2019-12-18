<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\GroupBy;
use App\Repositories\Criteria\Where;
use App\Services\Flag\Src\Flag;
use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;
use Modules\Wishes\Repositories\Contracts\WishesRepository;

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
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], 'mvp')) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = null === $whitelabel['ga_view_id'] ? '192484069' : $whitelabel['ga_view_id'];
            $filter = $this->getFilter();
            $optParams = [
                'dimensions' => 'ga:yearMonth',
                'filters'    => $filter['filterd'],
            ];

            $result['lidesktop'] = $this->dashboard->getFilterCategory('LI Desktop');
            $result['ga'] = $this->dashboard->uniqueEventsMonth($viewId, $optParams, $startDate, $endDate);
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
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], 'mvp')) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = null === $whitelabel['ga_view_id'] ? '192484069' : $whitelabel['ga_view_id'];
            $filter = $this->getFilter();

            $optParams = [
                'dimensions' => 'ga:date',
                'filters'    => $filter['filterd'],
            ];

            $result['lidesktop'] = $this->dashboard->getFilterCategory('LI Desktop');
            $result['ga'] = $this->dashboard->uniqueEventsDay($viewId, $optParams, $startDate, $endDate);
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
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], 'mvp')) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = null === $whitelabel['ga_view_id'] ? '192484069' : $whitelabel['ga_view_id'];
            $filter = $this->getFilter();

            $optParams = [
                'dimensions' => 'ga:yearMonth',
                'filters'    => $filter['filterm'],
            ];

            $result['limobile'] = $this->dashboard->getFilterCategory('LI Mobile');
            $result['ga'] = $this->dashboard->uniqueEventsMonth($viewId, $optParams, $startDate, $endDate);

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function mobileDay(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], 'mvp')) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = null === $whitelabel['ga_view_id'] ? '192484069' : $whitelabel['ga_view_id'];
            $filter = $this->getFilter();

            $optParams = [
                'dimensions' => 'ga:date',
                'filters'    => $filter['filterm'],
            ];

            $result['limobile'] = $this->dashboard->getFilterCategory('LI Mobile');
            $result['ga'] = $this->dashboard->uniqueEventsDay($viewId, $optParams, $startDate, $endDate);

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function browserperMonth(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], 'mvp')) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = null === $whitelabel['ga_view_id'] ? '192484069' : $whitelabel['ga_view_id'];
            $filter = $this->getFilter();

            $optParams = [
                'dimensions' => 'ga:browser',
                'filters'    => $filter['filterd'],
            ];

            $result['browser'] = $this->dashboard->getFilterCategory('Desktop Browser');
            $result['ga'] = $this->dashboard->uniqueEventsMonth($viewId, $optParams, $startDate, $endDate);
            $sum = 0;
            $browsers = ['Firefox', 'Chrome', 'Edge', 'Safari', 'Internet Explorer', 'Opera'];

            $result['ga'] = $this->dashboard->calculateBrowserData($result, $browsers, $sum);

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function shareperMonth(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], 'mvp')) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = null === $whitelabel['ga_view_id'] ? '192484069' : $whitelabel['ga_view_id'];
            $filter = $this->getFilter();

            $optParams = [
            'dimensions' => 'ga:browser',
            'filters'    => $filter['filters'],
            ];

            $result['browser'] = $this->dashboard->getFilterCategory('Desktop Browser');
            $result['ga'] = $this->dashboard->uniqueEventsMonth($viewId, $optParams, $startDate, $endDate);
            $sum = 0;
            $browsers = ['Firefox', 'Chrome', 'Edge', 'Safari', 'Internet Explorer', 'Opera'];

            $result['ga'] = $this->dashboard->calculateBrowserData($result, $browsers, $sum);

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
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], 'mvp')) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = null === $whitelabel['ga_view_id'] ? '192484069' : $whitelabel['ga_view_id'];
            $filter = $this->getFilter();

            $optParams = [
            'dimensions' => 'ga:yearMonth',
            'filters'    => $filter['filterd'],
            ];

            $result['response'] = $this->dashboard->getFilterCategory('Response Rate');
            $result['ga'] = $this->dashboard->uniqueEventsMonth($viewId, $optParams, $startDate, $endDate);

            $data = $this->wishes->withCriteria([
            new ByWhitelabel(),
            new Where('wishes.whitelabel_id', $request->get('whitelabelId')),
            new GroupBy('month')
            ])->all(['id', 'whitelabel_id', 'created_at', DB::raw('MONTH(wishes.created_at) as month'), DB::raw('count(*) as wishes_count'), DB::raw('DATE(wishes.created_at) as date')])
            ->pluck('wishes_count', 'date');
            $stack = [];

            $result['ga'] = $this->dashboard->calculateResponseData($result, $data, $stack);

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
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], 'mvp')) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = null === $whitelabel['ga_view_id'] ? '192484069' : $whitelabel['ga_view_id'];
            $filter = $this->getFilter();

            $optParams = [
            'dimensions' => 'ga:yearMonth',
            'filters'    => $filter['filterm'],
            ];

            $result['response'] = $this->dashboard->getFilterCategory('Response Rate');
            $result['ga'] = $this->dashboard->uniqueEventsMonth($viewId, $optParams, $startDate, $endDate);

            $data = $this->wishes->withCriteria([
            new ByWhitelabel(),
            new Where('wishes.whitelabel_id', $request->get('whitelabelId')),
            new GroupBy('month')
            ])->all(['id', 'whitelabel_id', 'created_at', DB::raw('MONTH(wishes.created_at) as month'), DB::raw('count(*) as wishes_count'), DB::raw('DATE(wishes.created_at) as date')])
            ->pluck('wishes_count', 'date');
            $stack = [];

            $result['ga'] = $this->dashboard->calculateResponseData($result, $data, $stack);

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function clickRate(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], 'mvp')) {
                    $whitelabelId = config($url[0] . '.id');
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $result['email'] = $this->dashboard->getFilterCategory('E-Mail');
            $result['clickrate'] = $this->dashboard->loadClickRate($whitelabelId);
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function openRate(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], 'mvp')) {
                    $whitelabelId = config($url[0] . '.id');
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $result['email'] = $this->dashboard->getFilterCategory('E-Mail');
            $result['openrate'] = $this->dashboard->loadOpenRate($whitelabelId);
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function save(Request $request)
    {
        try {
            $this->dashboard->setFilterCategory($request);
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function getFilter()
    {
        $filterdesk = 'ga:eventLabel==eil-n1;ga:eventAction==shown;ga:eventCategory==desiretec_exitwindow';
        $filtermobile = 'ga:eventLabel==eil-mobile;ga:eventAction==shown;ga:eventCategory==desiretec_exitwindow';
        $filtershare = 'ga:eventLabel==eil-n1;ga:eventAction==Submit-Button;ga:eventCategory==desiretec_exitwindow';

        return ['filterd'=>$filterdesk, 'filterm'=>$filtermobile, 'filters'=>$filtershare];
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
