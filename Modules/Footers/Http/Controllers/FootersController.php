<?php

namespace Modules\Footers\Http\Controllers;

use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WithTrashed;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Translation\Translator;
use Maatwebsite\Excel\Excel;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Footers\Http\Requests\StoreFooterRequest;
use Modules\Footers\Http\Requests\UpdateFooterRequest;
use Modules\Footers\Repositories\Contracts\FootersRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class FootersController extends Controller
{
    /**
     * @var \Modules\Footers\Repositories\Contracts\FootersRepository
     */
    private $footers;
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
     * @var \Illuminate\Support\Carbon
     */
    private $carbon;
    /**
     * @var \Modules\Activities\Repositories\Contracts\ActivitiesRepository
     */
    private $activities;
    /**
     * @var \App\Repositories\Backend\Whitelabels\WhitelabelsRepository
     */
    private $whitelabels;
    /**
     * @var \Maatwebsite\Excel\Excel
     */
    private $excel;

    /**
     * FootersController constructor.
     */
    public function __construct(FootersRepository $footers, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, WhitelabelsRepository $whitelabels, Excel $excel)
    {
        $this->footers = $footers;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->activities = $activities;
        $this->whitelabels = $whitelabels;
        $this->excel = $excel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $step = null;

        if ($this->auth->guard('web')->user()->hasRole(Flag::EXECUTIVE_ROLE) && !$this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
            $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();

            if ((int) $whitelabel->state < 5) {
                $this->whitelabels->update(
                    $this->auth->guard('web')->user()->whitelabels()->first()->id,
                    ['state' => 5]
                );
            }

            $step = Flag::step()[6];
        }

        return view('footers::index', compact(['step']));
    }

    public function view(Request $request)
    {
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->footers->withCriteria([
                new WithTrashed(),
                new OrderBy($sort[0], $sort[1]),
                new Where('footers.whitelabel_id', $request->get('whitelabel')),
                new WhereBetween('footers.created_at', $request->get('start'), $request->get('end')),
                new Filter($request->get('filter')),
                new EagerLoad(['whitelabel'  => function ($query) {
                    $query->select('id', 'display_name');
                }]),
                new ByWhitelabel('footers')
            ])->paginate($perPage);

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result['data'], $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();

        $whitelabelId = (null === $whitelabel) ? null : $whitelabel->id;

        try {
            $result['footer'] = [
                'id'                               => 0,
                'name'                             => '',
                'url'                              => '',
                'position'                         => 1,
                'whitelabel'                       => null,
                'whitelabel_id'                    => $whitelabelId,
            ];

            $result['footer']['logs'] = [];
            $result['footer']['whitelabels'] = $this->whitelabels->all(['id', 'display_name']);

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
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreFooterRequest $request)
    {
        try {
            $result['footer'] = $this->footers->create($request->only('name', 'url', 'position', 'whitelabel_id'));

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Footer']);
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
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('footers::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id)
    {
        try {
            $footer = $this->footers->withCriteria([
                new EagerLoad(['whitelabel'  => function ($query) {
                    $query->select('id', 'display_name');
                }])
            ])->find($id);

            $result['footer'] = [
                'id'                   => $footer->id,
                'name'                 => $footer->name,
                'url'                  => $footer->url,
                'position'             => $footer->position,
                'whitelabel'           => $footer->whitelabel,
                'whitelabel_id'        => isset($footer->whitelabel) ? $footer->whitelabel->id : null,
            ];

            $result['footer']['logs'] = $this->auth->guard('web')->user()->hasPermission('logs-footer') ? $this->activities->byModel($footer) : [];
            $result['footer']['whitelabels'] = $this->whitelabels->all(['id', 'display_name']);
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
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateFooterRequest $request, int $id)
    {
        try {
            $footer = $this->footers->update($id, $request->only('name', 'url', 'position', 'whitelabel_id'));

            $result['footer'] = $footer;
            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Footer']);
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
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $result['footer'] = $this->footers->delete($id);
            $result['message'] = $this->lang->get('messages.deleted', ['attribute' => 'Footer']);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(int $id)
    {
        try {
            $result['footer'] = $this->footers->forceDelete($id);
            $result['message'] = $this->lang->get('messages.destroyed', ['attribute' => 'Footer']);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(int $id)
    {
        try {
            $result['group'] = $this->footers->restore($id);
            $result['message'] = $this->lang->get('messages.restored', ['attribute' => 'Footer']);
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }
}
