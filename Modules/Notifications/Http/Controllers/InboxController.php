<?php

namespace Modules\Notifications\Http\Controllers;

use App\Repositories\Criteria\ByUser;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\Latest;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WhereIn;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Notifications\Repositories\Contracts\NotificationsRepository;

class InboxController extends Controller
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
     * @var \Illuminate\Support\Carbon
     */
    private $carbon;

    /**
     * InboxController constructor.
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
     *
     * @return Response
     */
    public function index()
    {
        return view('notifications::index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->notifications->withCriteria([
                new ByUser($this->auth->guard('web')->user()->id),
                new OrderBy($sort[0], $sort[1]),
                new Latest(),
                new Filter($request->get('filter')),
                new WhereBetween('notifications.created_at', $request->get('start'), $request->get('end')),
                new EagerLoad(['from' => function ($query) {
                    $query->select('users.id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'));
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

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('notifications::create');
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
        return view('notifications::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('notifications::edit');
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
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(Request $request, int $id)
    {
        try {
            $notification = $this->notifications->withCriteria([
                new ByUser($this->auth->guard('web')->user()->id),
            ])->update($id, ['is_read' => true]);

            $result['notification'] = $notification;
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
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function readNotification(Request $request)
    {
        try {
            $notifications = $this->notifications->withCriteria([
                new ByUser($this->auth->guard('web')->user()->id),
                new WhereIn('notifications.id', $request->get('checked')),
            ])->get();

            foreach ($notifications as $notification) {
                $notification->update(['is_read' => true]);
            }

            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Notifications']);
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
