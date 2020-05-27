<?php

namespace Modules\Variants\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Groups\Group;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Where;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Maatwebsite\Excel\Excel;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Groups\Http\Requests\UpdateGroupRequest;
use Modules\Variants\Http\Requests\StoreVariantRequest;
use Modules\Variants\Http\Requests\UpdateVariantRequest;
use Modules\Variants\Repositories\Contracts\VariantsRepository;
use Modules\Variants\Transformers\VariantCollection;
use Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository as ModuleWhitelabelsRepository;

class VariantsController extends Controller
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
     * @var \App\Repositories\Backend\Whitelabels\WhitelabelsRepository
     */
    private $whitelabels;
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $moduleWhitelabels;
    /**
     * @var \Maatwebsite\Excel\Excel
     */
    private $excel;
    /**
     * @var \Modules\Variants\Repositories\Contracts\VariantsRepository
     */
    private $variants;
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository
     */
    private $layerWhitelabels;

    public function __construct(VariantsRepository $variants, LayerWhitelabelRepository $layerWhitelabels, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, WhitelabelsRepository $whitelabels, ModuleWhitelabelsRepository $moduleWhitelabels, Excel $excel)
    {
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->activities = $activities;
        $this->whitelabels = $whitelabels;
        $this->moduleWhitelabels = $moduleWhitelabels;
        $this->excel = $excel;
        $this->variants = $variants;
        $this->layerWhitelabels = $layerWhitelabels;
    }


    public function index()
    {
        return view('variants::index');
    }

    public function view(Request $request)
    {
        try {
            $data = $this->variants->getVariants($this->parseRequest($request));

            return $this->responseJsonPaginated($data);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function edit(int $id)
    {
        try {
            $variant = $this->variants->withCriteria([
                new EagerLoad(['user', 'attachments', 'whitelabel', 'layerWhitelabel'  => function ($query) {
                    $query->select('id', 'whitelabel_id', 'layer_id');
                }]),
                new ByWhitelabel('variants'),
            ])->find($id);

            $result['variant'] = new VariantCollection($variant);

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function parseRequest($request)
    {
        return [
            $request->get('per_page', 10),
            explode('|', $request->get('sort', 'id|asc')),
            $request->get('filter')
        ];
    }


    public function create(Request $request)
    {
        try {
            $result['variant'] = [
                'id' => 0,
                'active' => false,
                'color' => '#540C0C',
                'headline' => null,
                'headline_success' => null,
                'subheadline' => null,
                'subheadline_success' => null,
                'layer_url' => null,
                'layer_whitelabel_id' => null,
                'privacy' => null,
                'user' => $this->auth->guard('web')->user()->first_name . ' ' . $this->auth->guard('web')->user()->last_name,
                'layer_whitelabel_id' => null,
                'layerWhitelabelsList' => $this->layerWhitelabelsList(),
                'logs' => [],
                'logo' => [],
                'visual' => [],
            ];

            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Variant']);

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function update(UpdateVariantRequest $request, int $id)
    {
        try {
            $variant = $this->variants->withCriteria([
                new ByWhitelabel('variants')
            ])->update(
                $id,
                $request->only(
                    'layer_url',
                    'color',
                    'headline',
                    'subheadline',
                    'privacy',
                    'active',
                    'headline_success',
                    'subheadline_success',
                    'layer_whitelabel_id'
                )
            );

            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Variant']);
            $result['variant'] = new VariantCollection($variant);

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function store(StoreVariantRequest $request)
    {
        try {
            $whitelabel = $this->variants->getWhitelabel($request);

            $variant = $this->variants->create(
                array_merge(
                    $request->only('layer_url', 'color', 'headline', 'subheadline', 'privacy', 'active', 'headline_success', 'subheadline_success', 'layer_whitelabel_id'),
                    ['whitelabel_id' => $whitelabel->id, 'user_id' => $this->auth->guard('web')->user()->id]
                )
            );


            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Variant']);
            $result['variant'] = new VariantCollection($variant);

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    private function layerWhitelabelsList()
    {
        $layerWhitelabels = $this->layerWhitelabels->withCriteria([
            new ByWhitelabel('layer_whitelabel'),
            new EagerLoad(['whitelabel', 'layer']),
        ])->all();

        return $layerWhitelabels->map(function ($layerWhitelabel) {
            return [
                'id' => $layerWhitelabel->id,
                'whitelabel' => $layerWhitelabel->whitelabel->name,
                'layer' => $layerWhitelabel->layer->name,
            ];
        });
    }

    public function destroy(int $id)
    {
        try {
            $result['variants'] = $this->variants->delete($id);
            $result['message'] = $this->lang->get('messages.deleted', ['attribute' => 'Variant']);

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }


    public function restore(int $id)
    {
        try {
            $result['variant'] = $this->variants->restore($id);
            $result['message'] = $this->lang->get('messages.restored', ['attribute' => 'Variant']);

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }


    public function forceDelete(int $id)
    {
        try {
            $result['variant'] = $this->variants->forceDelete($id);
            $result['message'] = $this->lang->get('messages.destroyed', ['attribute' => 'Group']);

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }
}
