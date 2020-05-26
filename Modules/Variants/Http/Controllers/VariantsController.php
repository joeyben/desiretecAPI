<?php

namespace Modules\Variants\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Translation\Translator;
use Maatwebsite\Excel\Excel;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Variants\Repositories\Contracts\VariantsRepository;
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

    public function __construct(VariantsRepository $variants, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, WhitelabelsRepository $whitelabels, ModuleWhitelabelsRepository $moduleWhitelabels, Excel $excel)
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

    public function parseRequest($request)
    {
        return [
            $request->get('per_page', 10),
            explode('|', $request->get('sort', 'id|asc')),
            $request->get('filter')
        ];
    }
}
