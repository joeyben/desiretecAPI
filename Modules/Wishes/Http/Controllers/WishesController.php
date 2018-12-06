<?php

namespace Modules\Wishes\Http\Controllers;

use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Translation\Translator;
use Modules\Wishes\Http\Requests\StoreWishRequest;
use Modules\Wishes\Http\Requests\UpdateWishRequest;
use Modules\Wishes\Repositories\Contracts\WishesRepository;

class WishesController extends Controller
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
     * @var \Illuminate\Support\Carbon
     */
    private $carbon;

    /**
     * WishesController constructor.
     *
     * @param \Modules\Wishes\Repositories\Contracts\WishesRepository $wishes
     * @param \Illuminate\Routing\ResponseFactory                     $response
     * @param \Illuminate\Auth\AuthManager                            $auth
     * @param \Illuminate\Translation\Translator                      $lang
     * @param \Illuminate\Support\Carbon                              $carbon
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('wishes::index');
    }

    public function view(Request $request)
    {
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->wishes->withCriteria([
                new OrderBy($sort[0], $sort[1]),
                new Filter($request->get('filter')),
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
     *
     * @return Response
     */
    public function create()
    {
        try {
            $result['wish'] = [
                'title'                    => '',
                'description'              => '',
                'airport'                  => '',
                'destination'              => '',
                'earliest_start'           => $this->carbon->now()->toDateString(),
                'latest_return'            => $this->carbon->now()->addDay()->toDateString(),
                'budget'                   => 0,
                'adults'                   => 1,
                'kids'                     => 0,
                'duration'                 => 0,
                'status'                   => true,
                'created_by'               => $this->auth->guard('web')->user()->id,
                'updated_by'               => $this->auth->guard('web')->user()->id,
            ];

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
     * Store a newly created resource in storage.
     *
     * @param \Modules\Wishes\Http\Requests\StoreWishRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreWishRequest $request)
    {
        try {
            $result['wish'] = $this->wishes->create(
                array_merge(
                     $request->only('title', 'catering', 'description', 'airport', 'destination', 'earliest_start', 'latest_return', 'budget', 'adults', 'kids', 'duration', 'status'),
                     ['created_by' => $this->auth->guard('web')->user()->id, 'updated_by' => $this->auth->guard('web')->user()->id]
                )
            );

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Wish']);
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
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('wishes::show');
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
            $result['wish'] = $this->wishes->find($id);

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
     * @param \Modules\Wishes\Http\Requests\UpdateWishRequest $request
     * @param int                                             $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateWishRequest $request, int $id)
    {
        try {
            $wish = $this->wishes->update($id, $request->only('title', 'description', 'airport', 'destination', 'earliest_start', 'latest_return', 'budget', 'adults', 'kids', 'duration', 'status', 'updated_by'));

            $result['wish'] = $wish;
            $result['message'] = $this->lang->get('messages.updated', ['attribute' => $this->lang->get('labels.wish')]);
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
     * @return Response
     */
    public function destroy()
    {
    }
}
