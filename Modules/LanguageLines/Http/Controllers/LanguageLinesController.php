<?php

namespace Modules\LanguageLines\Http\Controllers;

use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Translation\Translator;
use Modules\LanguageLines\Entities\LanguageLines;
use Modules\LanguageLines\Http\Requests\StoreLanguageLineRequest;
use Modules\LanguageLines\Http\Requests\UpdateLanguageLineRequest;
use Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository;

class LanguageLinesController extends Controller
{
    use AuthorizesRequests;
    /**
     * @var \Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository
     */
    private $languageline;
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
     * LanguageLines constructor.
     *
     * @param LanguageLinesRepository             $languageline
     * @param \Illuminate\Routing\ResponseFactory $response
     * @param \Illuminate\Auth\AuthManager        $auth
     * @param \Illuminate\Translation\Translator  $lang
     * @param \Illuminate\Support\Carbon          $carbon
     */
    public function __construct(LanguageLinesRepository $languageline, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon)
    {
        $this->languageline = $languageline;
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
        return view('languagelines::index');
    }

    public function view(Request $request)
    {
//        $this->authorize('view', LanguageLines::class);

        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->languageline->withCriteria([
                new OrderBy($sort[0], $sort[1]),
                new Where('locale', $request->get('locale')),
                new Filter($request->get('filter')),
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
            $result['languageline'] = [
                'id'          => 0,
                'locale'      => '',
                'description' => '',
                'group'       => '',
                'key'         => '',
                'text'        => ''
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
    public function store(StoreLanguageLineRequest $request)
    {
        try {
            $result['languageline'] = $this->languageline->create(
                $request->only('locale', 'description', 'group', 'key', 'text')
            );

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'LanguageLine']);
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
        return view('languagelines::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id)
    {
        try {
            $languageline = $this->languageline->find($id);

            $result['languageline'] = [
                'id'          => $languageline->id,
                'locale'      => $languageline->locale,
                'description' => $languageline->description,
                'group'       => $languageline->group,
                'key'         => $languageline->key,
                'text'        => $languageline->text
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
     * Update the specified resource in storage.
     *
     * @param UpdateLanguageLineRequest $request
     * @param int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateLanguageLineRequest $request, int $id)
    {
        try {
            $languageline = $this->languageline->update(
                $id,
                $request->only(
                    'locale',
                    'group',
                    'description',
                    'key',
                    'text'
                )
            );
            $result['languageline'] = $languageline;
            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'LanguageLine']);
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
