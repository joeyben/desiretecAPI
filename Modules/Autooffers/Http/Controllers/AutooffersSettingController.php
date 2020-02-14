<?php

namespace Modules\Autooffers\Http\Controllers;

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
use Modules\Autooffers\Repositories\Contracts\AutooffersRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class AutooffersSettingController extends Controller
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
     * @var \Maatwebsite\Excel\Excel
     */
    private $excel;
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;
    /**
     * @var \Modules\Autooffers\Repositories\Contracts\AutooffersRepository
     */
    private $autooffers;

    public function __construct(AutooffersRepository $autooffers, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, WhitelabelsRepository $whitelabels, Excel $excel)
    {
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->activities = $activities;
        $this->excel = $excel;
        $this->whitelabels = $whitelabels;
        $this->autooffers = $autooffers;
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

            if ((int) $whitelabel->state < 10) {
                $this->whitelabels->update(
                    $this->auth->guard('web')->user()->whitelabels()->first()->id,
                    ['state' => 10]
                );
            }

            $step = Flag::step()[11];
        }

        return view('autooffers::index', compact(['step']));
    }

    public function view(Request $request)
    {
        try {
            $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();

            if ((null === $whitelabel) && $request->has('whitelabelId') && (0 !== (int) $request->get('whitelabelId'))) {
                $whitelabel = $this->whitelabels->find($request->get('whitelabelId'));
            } else {
                $whitelabel = $this->whitelabels->first();
            }
            $autooffer = $this->autooffers->findWhere('whitelabel_id', $whitelabel->id)->first();

            if (null === $autooffer) {
                $autooffer = $this->autooffers->firstOrNew([
                    'id'             => 0,
                    'display_offer'  => 3,
                    'recommendation' => 50,
                    'rating'         => 5,
                    'price'          => 'asc',
                    'price_loop'     => 20,
                    'hotel_loop'     => 3,
                    'status'         => false,
                    'user_id'        => $this->auth->guard('web')->user()->id,
                    'whitelabel_id'  => $whitelabel->id,
                ]);
            }

            $result['autooffer'] = $autooffer;
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
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $result['autooffer'] = $this->autooffers->create(
                array_merge(
                    $request->only('display_offer', 'recommendation', 'rating', 'price', 'price_loop', 'hotel_loop', 'status', 'whitelabel_id'),
                    ['user_id' => $this->auth->guard('web')->user()->id]
                )
            );

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
        return view('autooffers::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('autooffers::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        try {
            $result['autooffer'] = $this->autooffers->update(
                $id,
                array_merge(
                    $request->only('display_offer', 'recommendation', 'rating', 'price', 'price_loop', 'hotel_loop', 'status'),
                    ['user_id' => $this->auth->guard('web')->user()->id]
                )
            );

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
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy()
    {
    }
}
