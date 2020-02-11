<?php

namespace Modules\Activities\Http\Controllers;

use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Search;
use App\Services\Src\Flag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;

class ActivitiesController extends Controller
{
    /**
     * @var \Modules\Activities\Repositories\Contracts\ActivitiesRepository
     */
    private $activities;
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private $response;

    /**
     * ActivitiesController constructor.
     */
    public function __construct(ActivitiesRepository $activities, ResponseFactory $response)
    {
        $this->activities = $activities;
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('activities::index');
    }

    public function view(Request $request)
    {
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));
            $search = $request->get('filter');

            $result['data'] = $this->activities->withCriteria([
                new OrderBy($sort[0], $sort[1]),
                new EagerLoad(['causer' => function ($query) {
                    $query->select('id', 'first_name', 'last_name');
                }]),
                new Search(function ($query) use ($search) {
                    $query->where('activity_log.id', 'LIKE', '%' . $search . '%')
                        ->orWhere('activity_log.description', 'LIKE', '%' . $search . '%')
                        ->orWhere('activity_log.subject_id', 'LIKE', '%' . $search . '%')
                        ->orWhere('activity_log.subject_type', 'LIKE', '%' . $search . '%')
                        ->orWhere('activity_log.causer_id', 'LIKE', '%' . $search . '%')
                        ->orWhere('activity_log.causer_type', 'LIKE', '%' . $search . '%')
                        ->orWhere('activity_log.created_at', 'LIKE', '%' . $search . '%');
                }),
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
        return view('activities::create');
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
        return view('activities::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('activities::edit');
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
