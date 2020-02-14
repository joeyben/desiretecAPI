<?php

namespace Modules\Whitelabels\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Whitelabels\Http\Requests\LayerRequest;
use Modules\Whitelabels\Repositories\Contracts\LayersRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class LayersController extends Controller
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
     * @var \Modules\Whitelabels\Repositories\Contracts\LayersRepository
     */
    private $layers;

    public function __construct(WhitelabelsRepository $whitelabels, LayersRepository $layers, Translator $lang, ResponseFactory $response, AuthManager $auth)
    {
        $this->whitelabels = $whitelabels;
        $this->lang = $lang;
        $this->response = $response;
        $this->auth = $auth;
        $this->layers = $layers;
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

            if ((int) $whitelabel->state < 2) {
                $this->whitelabels->update(
                    $this->auth->guard('web')->user()->whitelabels()->first()->id,
                    ['state' => 2]
                );
            }

            $step = Flag::step()[3];
        }

        return view('whitelabels::layers', compact(['step']));
    }

    public function view()
    {
        try {
            $result['layers'] = $this->layers->all();

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

    public function update(LayerRequest $request)
    {
        try {
            $data = [];
            $whitelabel = $this->auth->user()->whitelabels()->first();
            foreach ($request->get('layers') as $layer) {
                $data[$layer] = ['layer_url' => $request->get('pivot')[$layer]];
            }

            $this->whitelabels->sync($whitelabel->id, 'layers', $data);

            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Layer']);
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
