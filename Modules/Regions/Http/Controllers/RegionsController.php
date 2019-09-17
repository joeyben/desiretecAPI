<?php

namespace Modules\Regions\Http\Controllers;

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
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Regions\Http\Requests\StoreRegionRequest;
use Modules\Regions\Http\Requests\UpdateRegionRequest;
use Modules\Regions\Repositories\Contracts\RegionsRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class RegionsController extends Controller
{
    /**
     * @var \Modules\Regions\Repositories\Contracts\RegionsRepository
     */
    private $regions;
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
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;

    public function __construct(RegionsRepository $regions, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, WhitelabelsRepository $whitelabels)
    {
        $this->regions = $regions;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->activities = $activities;
        $this->whitelabels = $whitelabels;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('regions::index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function view(Request $request)
    {
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->regions->withCriteria([
                new WithTrashed(),
                new OrderBy($sort[0], $sort[1]),
                new WhereBetween('regions.created_at', $request->get('start'), $request->get('end')),
                new Filter($request->get('filter'))
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $result['region'] = [
                'id' => 0,
                'region_code' => '',
                'region_name' => '',
                'country_code' => '',
                'type' => 0,
            ];

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
     *
     * @param \Modules\Regions\Http\Requests\StoreRegionRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRegionRequest $request)
    {
        try {
            $result['region'] = $this->regions->create(
                $request->only('region_code', 'region_name', 'country_code', 'type')
            );

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Region']);
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
     * @return Response
     */
    public function show()
    {
        return view('regions::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id)
    {
        try {
            $region = $this->regions->find($id);

            $result['region'] = [
                'id' => $region->id,
                'region_code' => $region->region_code,
                'region_name' => $region->region_name,
                'country_code' => $region->country_code,
                'type' => $region->type,
            ];

            $result['region']['logs'] = $this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE) ? $this->activities->byModel($region) : [];

            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_PRESERVE_ZERO_FRACTION);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Modules\Regions\Http\Requests\UpdateRegionRequest $request
     * @param int                                                $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRegionRequest $request, int $id)
    {
        try {
            $region = $this->regions->update(
                $id,
                $request->only('region_code', 'region_name', 'country_code', 'type')
            );

            $result['region'] = $region;
            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Region']);
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
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $result['region'] = $this->regions->delete($id);
            $result['message'] = $this->lang->get('messages.deleted', ['attribute' => 'Rule']);
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
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(int $id)
    {
        try {
            $result['region'] = $this->regions->restore($id);
            $result['message'] = $this->lang->get('messages.restored', ['attribute' => 'Rule']);
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
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(int $id)
    {
        try {
            $result['region'] = $this->regions->forceDelete($id);
            $result['message'] = $this->lang->get('messages.destroyed', ['attribute' => 'Rule']);
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
