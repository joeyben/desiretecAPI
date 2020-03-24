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
     * @return \Illuminate\Http\JsonResponse
     */
    public function wishesMonth(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $startDate = null === $request->get('start') ? '' : str_replace('-', '', $request->get('start'));
            $endDate = null === $request->get('end') ? '' : str_replace('-', '', $request->get('end'));

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $result['wunsch'] = $this->dashboard->getFilterCategory('Wünsche');
            $result['wishesmonth'] = $this->dashboard->wishesMonth($whitelabel['id'], $startDate, $endDate);
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function wishesDay(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $startDate = null === $request->get('start') ? '' : str_replace('-', '', $request->get('start'));
            $endDate = null === $request->get('end') ? '' : str_replace('-', '', $request->get('end'));

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $result['wunsch'] = $this->dashboard->getFilterCategory('Wünsche');
            $result['wishesday'] = $this->dashboard->wishesDay($whitelabel['id'], $startDate, $endDate);
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function perMonth(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $filter = $this->getFilter($whitelabel->name);
            $optParams = [
                'dimensions' => 'ga:yearMonth',
                'filters'    => $filter['filterd'],
            ];

            $result['lidesktop'] = $this->dashboard->getFilterCategory('LI Desktop');
            $result['ga'] = $this->dashboard->uniqueEventsMonth(config('analytics.view_id'), $optParams, $startDate, $endDate);
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

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $filter = $this->getFilter();

            $optParams = [
                'dimensions' => 'ga:date',
                'filters'    => $filter['filterd'],
            ];

            $result['lidesktop'] = $this->dashboard->getFilterCategory('LI Desktop');
            $result['ga'] = $this->dashboard->uniqueEventsDay(config('analytics.view_id'), $optParams, $startDate, $endDate);
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

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = null === $whitelabel['ga_view_id'] ? '192484069' : $whitelabel['ga_view_id'];
            $filter = $this->getFilter();

            $optParams1 = [
                'dimensions' => 'ga:yearMonth',
                'filters'    => $filter['filterphone'],
            ];
            $optParams2 = [
                'dimensions' => 'ga:yearMonth',
                'filters'    => $filter['filtertablet'],
            ];
            $result['phone'] = $this->dashboard->uniqueEventsMonth($viewId, $optParams1, $startDate, $endDate);
            $result['tablet'] = $this->dashboard->uniqueEventsMonth($viewId, $optParams2, $startDate, $endDate);

            for ($i = 0; $i < \count($result['phone']); ++$i) {
                $result['mobile'][$i][0] = $result['phone'][$i][0];
                $result['mobile'][$i][1] = $result['phone'][$i][1] + $result['tablet'][$i][1];
            }

            $result['limobile'] = $this->dashboard->getFilterCategory('LI Mobile');
            $result['ga'] = $result['mobile'];

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

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = null === $whitelabel['ga_view_id'] ? '192484069' : $whitelabel['ga_view_id'];
            $filter = $this->getFilter();

            $optParams1 = [
                'dimensions' => 'ga:date',
                'filters'    => $filter['filterphone'],
            ];
            $optParams2 = [
                'dimensions' => 'ga:date',
                'filters'    => $filter['filtertablet'],
            ];

            $result['phone'] = $this->dashboard->uniqueEventsDay($viewId, $optParams1, $startDate, $endDate);
            $result['tablet'] = $this->dashboard->uniqueEventsDay($viewId, $optParams2, $startDate, $endDate);

            for ($i = 0; $i < \count($result['phone']); ++$i) {
                $result['mobile'][$i][0] = $result['phone'][$i][0];
                $result['mobile'][$i][1] = $result['phone'][$i][1] + $result['tablet'][$i][1];
            }

            $result['limobile'] = $this->dashboard->getFilterCategory('LI Mobile');
            $result['ga'] = $result['mobile'];

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

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
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

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
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

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
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

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
                    $whitelabel = $this->whitelabels->find(config($url[0] . '.id'));
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = null === $whitelabel['ga_view_id'] ? '192484069' : $whitelabel['ga_view_id'];
            $filter = $this->getFilter();

            $optParams1 = [
            'dimensions' => 'ga:yearMonth',
            'filters'    => $filter['filterphone'],
            ];
            $optParams2 = [
                'dimensions' => 'ga:yearMonth',
                'filters'    => $filter['filtertablet'],
            ];
            $result['phone'] = $this->dashboard->uniqueEventsMonth($viewId, $optParams1, $startDate, $endDate);
            $result['tablet'] = $this->dashboard->uniqueEventsMonth($viewId, $optParams2, $startDate, $endDate);

            for ($i = 0; $i < \count($result['phone']); ++$i) {
                $result['mobile'][$i][0] = $result['phone'][$i][0];
                $result['mobile'][$i][1] = $result['phone'][$i][1] + $result['tablet'][$i][1];
            }

            $result['response'] = $this->dashboard->getFilterCategory('Response Rate');
            $result['ga'] = $result['mobile'];

            $data = $this->wishes->withCriteria([
            new ByWhitelabel(),
            new Where('wishes.whitelabel_id', $request->get('whitelabelId')),
            new Where('wishes.mobile', 1),
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

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
                    $whitelabelId = config($url[0] . '.id');
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $result['email'] = $this->dashboard->getFilterCategory('E-Mail');
            $result['clickrate'] = $this->dashboard->loadClickRate($whitelabelId, $startDate, $endDate);
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function clickRateauto(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
                    $whitelabelId = config($url[0] . '.id');
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $result['email'] = $this->dashboard->getFilterCategory('E-Mail');
            $result['clickrate'] = $this->dashboard->loadClickRateauto($whitelabelId, $startDate, $endDate);
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

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
                    $whitelabelId = config($url[0] . '.id');
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $result['email'] = $this->dashboard->getFilterCategory('E-Mail');
            $result['openrate'] = $this->dashboard->loadOpenRate($whitelabelId, $startDate, $endDate);
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function openRateauto(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $startDate = null === $request->get('start') ? '' : $request->get('start');
            $endDate = null === $request->get('end') ? '' : $request->get('end');

            if (null === $whitelabelId) {
                $whitelabel = $this->whitelabels->first();
                $url = explode('.', $_SERVER['HTTP_HOST']);

                if (false === mb_strpos($url[0], env('DOMAIN_PREFIX', 'mvp'))) {
                    $whitelabelId = config($url[0] . '.id');
                }
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $result['email'] = $this->dashboard->getFilterCategory('E-Mail');
            $result['openrate'] = $this->dashboard->loadOpenRateauto($whitelabelId, $startDate, $endDate);
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

    public function getFilter($name = 'desiretec')
    {
        $filterdesk = 'ga:eventLabel==eil-desktop;ga:eventAction==shown;ga:eventCategory==' . $name . '_exitwindow';
        $filtermobile = 'ga:eventLabel==eil-mobile;ga:eventAction==shown;ga:eventCategory==' . $name . '_exitwindow';
        $filterphone = 'ga:eventLabel==eil-phone;ga:eventAction==shown;ga:eventCategory==' . $name . '_exitwindow';
        $filtertablet = 'ga:eventLabel==eil-tablet;ga:eventAction==shown;ga:eventCategory==' . $name . '_exitwindow';
        $filtershare = 'ga:eventLabel==eil-n1;ga:eventAction==Submit-Button;ga:eventCategory==' . $name . '_exitwindow';

        return ['filterd'=>$filterdesk, 'filterm'=>$filtermobile, 'filters'=>$filtershare, 'filterphone'=>$filterphone, 'filtertablet'=>$filtertablet];
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
