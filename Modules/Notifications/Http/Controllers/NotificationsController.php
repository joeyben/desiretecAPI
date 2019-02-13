<?php

namespace Modules\Notifications\Http\Controllers;

use App\Repositories\Criteria\ByUser;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\Latest;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WithTrashed;
use App\Services\Flag\Src\Flag;
use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Notifications\Http\Requests\UpdateNotificationRequest;
use Modules\Notifications\Repositories\Contracts\NotificationsRepository;

class NotificationsController extends Controller
{
    /**
     * @var \Modules\Notifications\Repositories\Contracts\NotificationsRepository
     */
    private $notifications;
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
     * NotificationsController constructor.
     *
     * @param \Modules\Notifications\Repositories\Contracts\NotificationsRepository $notifications
     * @param \Illuminate\Routing\ResponseFactory                                   $response
     * @param \Illuminate\Auth\AuthManager                                          $auth
     * @param \Illuminate\Translation\Translator                                    $lang
     * @param \Carbon\Carbon                                                        $carbon
     */
    public function __construct(NotificationsRepository $notifications, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon)
    {
        $this->notifications = $notifications;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('notifications::index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        try {
            $perPage = $request->has('per_page') ? $request->get('per_page') : 10;

            $result['notifications'] = $this->notifications->withCriteria([
                new ByUser($this->auth->guard('web')->user()->id),
                new Latest(),
                new EagerLoad(['from' => function ($query) {
                    $query->select('users.id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'));
                }]),
            ])->paginate($perPage);

            $result['userId'] = $this->auth->guard('web')->user()->id;

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
     * @return Response
     */
    public function create()
    {
        return view('notifications::create');
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
        return view('notifications::show');
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
            $notification = $this->notifications->find($id);

            $result['notification'] = [
                'id' => $notification->id,
                'message' => $notification->message
            ];

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
     * @param  Request $request
     * @param int      $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateNotificationRequest $request, int $id)
    {
        try {
            $group = $this->notifications->update(
                $id,
                $request->only(
                    'message'
                )
            );
            $result['notification'] = $group;
            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Notification']);
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
            $result['notification'] = $this->notifications->delete($id);
            $result['message'] = $this->lang->get('messages.deleted', ['attribute' => 'Notification']);
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(int $id)
    {
        try {
            $result['notification'] = $this->notifications->forceDelete($id);
            $result['message'] = $this->lang->get('messages.destroyed', ['attribute' => 'Notification']);
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
            $result['notification'] = $this->notifications->restore($id);
            $result['message'] = $this->lang->get('messages.restored', ['attribute' => 'Notification']);
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
