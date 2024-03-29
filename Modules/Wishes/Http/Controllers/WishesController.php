<?php

namespace Modules\Wishes\Http\Controllers;

use App\Models\Groups\Group;
use App\Repositories\Backend\Groups\GroupsRepository;
use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WhereIn;
use App\Repositories\Criteria\WithTrashed;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Wishes\Entities\Wish;
use Modules\Wishes\Exports\WishExport;
use Modules\Wishes\Http\Requests\StoreWishRequest;
use Modules\Wishes\Http\Requests\UpdateWishRequest;
use Modules\Wishes\Notifications\CreatedWishNotificationForSeller;
use Modules\Wishes\Repositories\Contracts\WishesRepository;

class WishesController extends Controller
{
    use AuthorizesRequests;
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
     * @var \Modules\Activities\Repositories\Contracts\ActivitiesRepository
     */
    private $activities;
    /**
     * @var \App\Repositories\Backend\Groups\GroupsRepository
     */
    private $groups;
    /**
     * @var \Illuminate\Notifications\ChannelManager
     */
    private $notification;

    /**
     * WishesController constructor.
     */
    public function __construct(WishesRepository $wishes, ChannelManager $notification, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, GroupsRepository $groups)
    {
        $this->wishes = $wishes;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->activities = $activities;
        $this->groups = $groups;
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('view', Wish::class);

        return view('wishes::index');
    }

    public function view(Request $request)
    {
        $this->authorize('view', Wish::class);
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->wishes->withCriteria([
                new WithTrashed(),
                new OrderBy($sort[0], $sort[1]),
                new Where('wishes.whitelabel_id', $request->get('whitelabel')),
                new WhereBetween('wishes.created_at', $request->get('start'), $request->get('end')),
                new Filter($request->get('filter')),
                new EagerLoad(['owner' => function ($query) {
                    $select = 'CONCAT(first_name, " ", last_name) AS full_name, email';
                    $query->select('id', DB::raw($select));
                }, 'group'  => function ($query) {
                    $query->select('id', 'display_name');
                }, 'whitelabel'  => function ($query) {
                    $query->select('id', 'display_name');
                }]),
                new ByWhitelabel()
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id)
    {
        try {
            $result['wish'] = $this->wishes->withCriteria([
                new EagerLoad(['owner' => function ($query) {
                    $query->select('id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'));
                }, 'group'  => function ($query) {
                    $query->select('id', 'display_name');
                }, 'whitelabel'  => function ($query) {
                    $query->select('id', 'display_name');
                }]),
                new ByWhitelabel()
            ])->find($id);

            $result['wish']['logs'] = $this->auth->guard('web')->user()->hasPermission('logs-wish') ? $this->activities->byModel($result['wish']) : [];
            $groups = Group::where('whitelabel_id', $result['wish']->whitelabel_id)->get();

            $result['wish']['alert_email'] = false;
            $result['wish']['groups'] = $groups->map(function ($whitelabel) {
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

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateWishRequest $request, int $id)
    {
        try {
            $originalWish = $this->wishes->find($id);
            $wish = $this->wishes->withCriteria([
                new ByWhitelabel()
            ])->update(
                $id,
                $request->only(
                    'status',
                    'group_id'
                )
            );

            if ($request->get('alert_email') && ($originalWish->group_id !== $wish->group_id)) {
                $sellers = $this->groups->find($wish->group_id)->users()->get();
                $this->notification->send($sellers, new CreatedWishNotificationForSeller($wish));
            }

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

    public function export(Request $request)
    {
        $records = $request->has('checked') ? explode(',', $request->get('checked')) : null;
        $sort = explode('|', $request->get('sort'));

        return new WishExport($this->wishes->withCriteria([
            new OrderBy('id', 'ASC'),
            new WhereIn('wishes.id', $records),
            new Where('wishes.whitelabel_id', $request->get('whitelabel')),
            new WhereBetween('wishes.created_at', $request->get('start'), $request->get('end')),
            new Filter($request->get('filter')),
            new EagerLoad(['owner' => function ($query) {
                $select = 'CONCAT(first_name, " ", last_name) AS full_name, email';
                $query->select('id', DB::raw($select));
            }, 'group'  => function ($query) {
                $query->select('id', 'display_name');
            }, 'whitelabel'  => function ($query) {
                $query->select('id', 'display_name');
            }]),
            new ByWhitelabel()
        ]));
    }

    public function destroy(int $id)
    {
        try {
            $result['wish'] = $this->wishes->delete($id);
            $result['message'] = $this->lang->get('messages.deleted', ['attribute' => $this->lang->get('labels.wish')]);
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
            $result['group'] = $this->wishes->restore($id);
            $result['message'] = $this->lang->get('messages.restored', ['attribute' => $this->lang->get('labels.wish')]);
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(int $id)
    {
        $this->authorize('forceDelete', Wish::class);

        try {
            $result['wish'] = $this->wishes->forceDelete($id);
            $result['message'] = $this->lang->get('messages.destroyed', ['attribute' => $this->lang->get('labels.wish')]);
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
