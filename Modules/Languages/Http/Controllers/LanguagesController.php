<?php

namespace Modules\Languages\Http\Controllers;

use App\Repositories\Criteria\ByWhitelabelLanguages;
use App\Repositories\Criteria\OrderBy;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Translation\Translator;
use Modules\Languages\Http\Requests\StoreLanguageRequest;
use Modules\Languages\Repositories\Contracts\LanguagesRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class LanguagesController extends Controller
{
    use AuthorizesRequests;
    /**
     * @var \Modules\Languages\Repositories\Contracts\LanguagesRepository
     */
    private $languages;
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;
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
     * GroupsController constructor.
     *
     * @param LanguagesRepository   $languages
     * @param WhitelabelsRepository $whitelabels
     * @param ResponseFactory       $response
     * @param AuthManager           $auth
     * @param Translator            $lang
     * @param Carbon                $carbon
     */
    public function __construct(LanguagesRepository $languages, WhitelabelsRepository $whitelabels, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon)
    {
        $this->languages = $languages;
        $this->whitelabels = $whitelabels;
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
        return view('languages::index');
    }

    public function view()
    {
        try {
            $languages = $this->languages->findLanguages();
            $result['languages'] = $languages;
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
     * Languages missing on whitelabel.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function missing()
    {
        try {
            $missingLanguages = $this->languages->findMissingLanguages();
            $result['missingLanguages'] = $missingLanguages;
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_PRESERVE_ZERO_FRACTION);
    }

    public function list(Request $request)
    {
//        $this->authorize('view', Group::class);

        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->languages->withCriteria([
                new OrderBy($sort[0], $sort[1]),
                new ByWhitelabelLanguages()
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
            $result['language'] = [
                'id'            => 0,
                'language_id'   => 3,
                'whitelabel_id' => getCurrentWhiteLabelId(),
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(StoreLanguageRequest $request)
    {
        try {
            $language = $this->languages->find($request->get('language_id'));

            $language->whitelabels()->attach($request->get('whitelabel_id'));

            $whitelabelLangTable = 'language_lines_' . mb_strtolower($this->whitelabels->find($request->get('whitelabel_id'))->name);

            $this->whitelabels->copyLanguage($whitelabelLangTable, $language->locale);

            $result['language'] = $language;

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Language']);
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
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('languages::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('languages::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
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
            $result['group'] = $this->languages->delete($id);
            $result['message'] = $this->lang->get('messages.deleted', ['attribute' => 'Language']);
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
