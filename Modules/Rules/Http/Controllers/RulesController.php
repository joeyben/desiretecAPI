<?php

namespace Modules\Rules\Http\Controllers;

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
use Modules\Rules\Http\Requests\CreateRuleRequest;
use Modules\Rules\Http\Requests\StoreRuleRequest;
use Modules\Rules\Http\Requests\UpdateRuleRequest;
use Modules\Rules\Repositories\Contracts\RulesRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class RulesController extends Controller
{
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
    /**
     * @var \Modules\Rules\Repositories\Contracts\RulesRepository
     */
    private $rules;

    public function __construct(RulesRepository $rules, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, WhitelabelsRepository $whitelabels)
    {
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->activities = $activities;
        $this->whitelabels = $whitelabels;
        $this->rules = $rules;
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

            if ((int)$whitelabel->state < 9) {
                $this->whitelabels->update(
                    $this->auth->guard('web')->user()->whitelabels()->first()->id,
                    ['state' =>  9]
                );
            }

            $step = Flag::step()[10];
        }

        return view('rules::index', compact(['step']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function view(Request $request)
    {
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->rules->withCriteria([
                new WithTrashed(),
                new OrderBy($sort[0], $sort[1]),
                new Where('rules.whitelabel_id', $request->get('whitelabel')),
                new WhereBetween('rules.created_at', $request->get('start'), $request->get('end')),
                new Filter($request->get('filter')),
                new EagerLoad(['user' => function ($query) {
                    $query->select('id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'));
                }, 'whitelabel'  => function ($query) {
                    $query->select('id', 'display_name');
                }]),
                new ByWhitelabel('rules')
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRuleRequest $request)
    {
        try {
            $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();

            if ((null === $whitelabel) && $request->has('whitelabelId')) {
                $whitelabel = $this->whitelabels->find($request->get('whitelabelId'));
            }

            $result['rule'] = [
                'id'                               => 0,
                'type'                             => 'manuel',
                'budget'                           => null,
                'destination'                      => [],
                'status'                           => true,
                'user'                             => ['full_name' => $this->auth->guard('web')->user()->first_name . ' ' . $this->auth->guard('web')->user()->last_name],
                'whitelabel'                       => $whitelabel,
                'whitelabel_id'                    => $whitelabel->id,
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRuleRequest $request)
    {
        try {
            if ('mix' === $request->get('type')) {
                $result['rule'] = $this->rules->create(
                    array_merge(
                        $request->only('type', 'budget', 'whitelabel_id'),
                        ['destination' => json_encode($request->get('destination')), 'user_id' => $this->auth->guard('web')->user()->id]
                    )
                );
            } else {
                $result['rule'] = $this->rules->create(
                    array_merge(
                        $request->only('type', 'whitelabel_id'),
                        ['budget' => null, 'destination' => null, 'user_id' => $this->auth->guard('web')->user()->id]
                    )
                );
            }

            if ($request->has('status') && $request->get('status')) {
                $this->rules->updateStatus($result['rule'], $request->only('status'), $request->get('whitelabel_id'));
            }

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Rule']);
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
        return view('rules::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id)
    {
        try {
            $rule = $this->rules->withCriteria([
                new EagerLoad(['user' => function ($query) {
                    $query->select('id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'));
                }, 'whitelabel'  => function ($query) {
                    $query->select('id', 'display_name');
                }])
            ])->find($id);

            $result['rule'] = [
                'id'             => $rule->id,
                'type'           => $rule->type,
                'budget'         => $rule->budget,
                'destination'    => null === $rule->destination ? [] : $rule->destination,
                'status'         => $rule->status,
                'user'           => $rule->user,
                'whitelabel'     => $rule->whitelabel,
                'whitelabel_id'  => $rule->whitelabel_id,
            ];

            $result['rule']['logs'] = $this->auth->guard('web')->user()->hasPermission('logs-rule') ? $this->activities->byModel($rule) : [];

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
    public function update(UpdateRuleRequest $request, int $id)
    {
        $destination = 0 === \count($request->get('destination')) ? null : $request->get('destination');

        try {
            if ('mix' === $request->get('type')) {
                $rule = $this->rules->update(
                    $id,
                    array_merge(
                        $request->only('type', 'budget'),
                        ['destination' => json_encode($destination)]
                    )
                );
            } else {
                $rule = $this->rules->update(
                    $id,
                    array_merge(
                        $request->only('type'),
                        ['budget' => null, 'destination' => null]
                    )
                );
            }

            if ($request->has('status') && $request->get('status') && ($rule->status !== $request->get('status'))) {
                $this->rules->updateStatus($rule, $request->only('status'), $request->get('whitelabel_id'));
            } else {
                $rule = $this->rules->update(
                    $id,
                    $request->only('status')
                );
            }

            $result['rule'] = $rule;
            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Rule']);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $result['rule'] = $this->rules->delete($id);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(int $id)
    {
        try {
            $result['rule'] = $this->rules->restore($id);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(int $id)
    {
        try {
            $result['rule'] = $this->rules->forceDelete($id);
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
