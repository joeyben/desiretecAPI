<?php

namespace Modules\Whitelabels\Http\Controllers;

use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Where;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Whitelabels\Entities\Whitelabel;
use Modules\Whitelabels\Http\Services\LayersContentService;
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

    public function __construct(WhitelabelsRepository $whitelabels, Translator $lang, ResponseFactory $response, AuthManager $auth)
    {
        $this->whitelabels = $whitelabels;
        $this->lang = $lang;
        $this->response = $response;
        $this->auth = $auth;
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->withCriteria([
                new EagerLoad(['layers']),
            ])->find($request->get('id'));

            $layers = $request->get('layers');
            //$this->layersContentService->updateWhitelabelLayersInfo($request, $result['whitelabel']->layers);

            foreach ($result['whitelabel']->layers as $key => $layer) {
                $pivot = $layer->pivot;
                $requestPivot = $layers[$key]['pivot'];

                //dd($requestPivot, $layer);
                $pivot->headline = $requestPivot['headline'];
                $pivot->subheadline = $requestPivot['subheadline'];
                $pivot->headline_success = $requestPivot['headline_success'];
                $pivot->subheadline_success = $requestPivot['subheadline_success'];
                $pivot->save();
            }

            //dd($result['whitelabel']->layers->where('id', 1));

            /*$result['whitelabel'] = $this->whitelabels->with()->update(
                $request->get('id'),
                $request->only('headline', 'subheadline', 'headline_success', 'subheadline_success')
            );*/

            file_put_contents(public_path('whitelabels-config.son'), json_encode($this->whitelabels->all()));

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
