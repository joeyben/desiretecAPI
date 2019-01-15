<?php

namespace Modules\Whitelabels\Http\Controllers;

use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WithTrashed;
use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Maatwebsite\Excel\Excel;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class WhitelabelsController extends Controller
{
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;
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
     * @var \Modules\Activities\Repositories\Contracts\ActivitiesRepository
     */
    private $activities;
    /**
     * @var \Maatwebsite\Excel\Excel
     */
    private $excel;

    /**
     * WhitelabelsController constructor.
     *
     * @param \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository $whitelabels
     * @param \Illuminate\Routing\ResponseFactory                               $response
     * @param \Illuminate\Auth\AuthManager                                      $auth
     * @param \Illuminate\Translation\Translator                                $lang
     * @param \Carbon\Carbon                                                    $carbon
     * @param \Modules\Activities\Repositories\Contracts\ActivitiesRepository   $activities
     * @param \Maatwebsite\Excel\Excel                                          $excel
     */
    public function __construct(WhitelabelsRepository $whitelabels, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, Excel $excel)
    {
        $this->whitelabels = $whitelabels;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->activities = $activities;
        $this->excel = $excel;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('whitelabels::index');
    }

    public function view()
    {
        try {
            $whitelabels = $this->whitelabels->all();
            $result['whitelabels'] = $whitelabels->map(function ($whitelabel) {
                return [
                    'id'   => $whitelabel->id,
                    'name' => $whitelabel->display_name
                ];
            });
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_PRESERVE_ZERO_FRACTION);
    }

    public function list(Request $request)
    {
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->whitelabels->withCriteria([
                new WithTrashed(),
                new OrderBy($sort[0], $sort[1]),
                new Where('whitelabels.id', $request->get('whitelabel')),
                new WhereBetween('whitelabels.created_at', $request->get('start'), $request->get('end')),
                new EagerLoad(['owner' => function ($query) {
                    $select = $this->auth->guard('web')->user()->hasRole('Administrator') ? 'CONCAT(first_name, " ", last_name, " ( ", email, " ) ") AS full_name' : 'CONCAT(first_name, " ", last_name) AS full_name';
                    $query->select('users.id', DB::raw($select));
                }, 'distribution'  => function ($query) {
                    $query->select('id', 'display_name');
                }]),
            ])->paginate($perPage);

            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result['data'], $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('whitelabels::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('whitelabels::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('whitelabels::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
