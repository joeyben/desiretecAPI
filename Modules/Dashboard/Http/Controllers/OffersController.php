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
     * WishesController constructor.
     *
     * @param \Modules\Wishes\Repositories\Contracts\WishesRepository $wishes
     * @param \Illuminate\Routing\ResponseFactory                     $response
     * @param \Illuminate\Auth\AuthManager                            $auth
     * @param \Illuminate\Translation\Translator                      $lang
     * @param \Carbon\Carbon                                          $carbon
     */
    public function __construct(WishesRepository $wishes, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon)
    {
        $this->wishes = $wishes;
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
        try {
            $result['wishCount'] = $this->wishes->withCriteria([
                new ByWhitelabel(),
                new Where('wishes.whitelabel_id', $request->get('whitelabelId')),
            ])->all()->count();
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function byMonth(Request $request)
    {
        try {
            $data = $this->wishes->withCriteria([
                new WhereYear($this->carbon->nowWithSameTz()->format('Y')),
                new ByWhitelabel(),
                new Where('wishes.whitelabel_id', $request->get('whitelabelId')),
                new GroupBy('month')
            ])->all(['id', 'whitelabel_id', 'created_at', DB::raw('MONTH(wishes.created_at) as month'), DB::raw('count(*) as wishes_count')])
                ->pluck('wishes_count', 'month')
                ->toArray();

            for ($i = 1; $i <= $this->carbon->nowWithSameTz()->format('m'); ++$i) {
                if (\array_key_exists($i, $data)) {
                    $result['data'][] = $data[$i];
                } else {
                    $result['data'][] = 0;
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function byDay(Request $request)
    {
        try {
            $data = $this->wishes->withCriteria([
                new WhereYear($this->carbon->nowWithSameTz()->format('Y')),
                new WhereMonth($this->carbon->nowWithSameTz()->format('m')),
                new ByWhitelabel(),
                new Where('wishes.whitelabel_id', $request->get('whitelabelId')),
                new GroupBy('day')
            ])->all(['id', 'whitelabel_id', 'created_at', DB::raw('DAY(created_at) as day'), DB::raw('count(*) as wishes_count')]);
            $items = [];
            foreach ($data as $item) {
                $items[$item->day] = [
                    $item->created_at->format('Y-m-d'),
                    $item->wishes_count
                ];
            }

            for ($i = 1; $i <= $this->carbon->nowWithSameTz()->format('d'); ++$i) {
                if (\array_key_exists($i, $items)) {
                    $result['data'][] = $items[$i];
                } else {
                    $result['data'][] = 0;
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
