<?php

namespace Modules\Permissions\Http\Controllers;

use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\WhereBetween;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Permissions\Repositories\Contracts\PermissionsRepository;

class PermissionsController extends Controller
{
    /**
     * @var \Modules\Permissions\Repositories\Contracts\PermissionsRepository
     */
    private $permissions;
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
     * @var \Modules\Activities\Repositories\Contracts\ActivitiesRepository
     */
    private $activities;

    public function __construct(PermissionsRepository $permissions, ResponseFactory $response, AuthManager $auth, Translator $lang, ActivitiesRepository $activities)
    {
        $this->permissions = $permissions;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->activities = $activities;
    }

    /**
     * Display a listing of the resource.
     *
     *
     * @return Response
     */
    public function index()
    {
        return view('permissions::index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->permissions->withCriteria([
                new OrderBy($sort[0], $sort[1]),
                new WhereBetween('permissions.created_at', $request->get('start'), $request->get('end')),
                new Filter($request->get('filter')),
                new EagerLoad(['owner'  => function ($query) {
                    $select = $this->auth->guard('web')->user()->hasRole('Administrator') ? 'CONCAT(first_name, " ", last_name, " ( ", email, " ) ") AS full_name' : 'CONCAT(first_name, " ", last_name) AS full_name';
                    $query->select('users.id', DB::raw($select));
                }]),
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
}
