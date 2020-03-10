<?php

namespace Modules\Whitelabels\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Whitelabels\Http\Requests\LayerContentRequest;
use Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class LayersContentController extends Controller
{
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;
    /**
     * @var \Illuminate\Translation\Translator
     */
    private $lang;
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private $response;
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository
     */
    private $layerWhitelabels;

    public function __construct(WhitelabelsRepository $whitelabels, LayerWhitelabelRepository $layerWhitelabels, Translator $lang, ResponseFactory $response, AuthManager $auth)
    {
        $this->whitelabels = $whitelabels;
        $this->lang = $lang;
        $this->response = $response;
        $this->auth = $auth;
        $this->layerWhitelabels = $layerWhitelabels;
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

            if ((int) $whitelabel->state < 3) {
                $this->whitelabels->update(
                    $this->auth->guard('web')->user()->whitelabels()->first()->id,
                    ['state' => 3]
                );
            }

            $step = Flag::step()[4];
        }

        return view('whitelabels::content', compact(['step']));
    }

    public function view()
    {
        $result['data'] = [];

        try {
            if ($this->auth->guard('web')->user()->hasRole(Flag::EXECUTIVE_ROLE) && !$this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
                $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();
                $data = $this->layerWhitelabels->withCriteria([
                    new OrderBy('layer_id'),
                    new Where('whitelabel_id', $whitelabel->id),
                    new EagerLoad(['layer', 'attachments'])
                ])->all();

                $result['data'] = $data->map(function ($layer) {
                    return [
                        'id'                  => $layer->id,
                        'name'                => $layer->layer->name,
                        'layer_id'            => $layer->layer_id,
                        'whitelabel_id'       => $layer->whitelabel_id,
                        'headline'            => $layer->headline,
                        'headline_color'      => $layer->headline_color,
                        'subheadline'         => $layer->subheadline,
                        'headline_success'    => $layer->headline_success,
                        'subheadline_success' => $layer->subheadline_success,
                        'privacy'             => $layer->privacy,
                        'layer_url'           => $layer->layer_url,
                        'attachments'         => $layer->attachments->map(function ($attachment) {
                            return [
                                'uid'  => $attachment->id,
                                'name' => $attachment->name . '.' . $attachment->extension,
                                'url'  => $attachment->url
                            ];
                        })
                    ];
                });
            }

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('whitelabels::create');
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
        return view('whitelabels::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('whitelabels::edit');
    }

    public function update(LayerContentRequest $request)
    {
        try {
            $this->layerWhitelabels->update($request->get('id'), $request->only('headline', 'headline_color', 'subheadline', 'headline_success', 'subheadline_success', 'privacy'));

            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Content']);
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
