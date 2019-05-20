<?php

namespace Modules\LanguageLines\Http\Controllers;

use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereIn;
use Illuminate\Auth\AuthManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\LanguageLines\Entities\LanguageLines;
use Modules\LanguageLines\Http\Requests\StoreLanguageLineRequest;
use Modules\LanguageLines\Http\Requests\UpdateLanguageLineRequest;
use Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;

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
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;

    /**
     * LanguageLines constructor.
     *
     * @param LanguageLinesRepository                                           $languageline
     * @param \Illuminate\Routing\ResponseFactory                               $response
     * @param \Illuminate\Auth\AuthManager                                      $auth
     * @param \Illuminate\Translation\Translator                                $lang
     * @param \Illuminate\Support\Carbon                                        $carbon
     * @param \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository $whitelabels
     */
    public function __construct(LanguageLinesRepository $languageline, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, WhitelabelsRepository $whitelabels)
    {
        $this->languageline = $languageline;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->whitelabels = $whitelabels;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function copy(Request $request)
    {
        $collection = new Collection();
        try {
            $translations = $this->languageline->get();

            $whitelabels = $this->whitelabels->withCriteria([
                new WhereIn('whitelabels.id', $request->get('whitelabels')),
            ])->get();

            foreach ($whitelabels as $whitelabel) {
                $persistedTranslations = DB::table('language_lines_' . mb_strtolower($whitelabel->name))->get();

                foreach ($translations as $translation) {
                    $translationToCreate = $persistedTranslations->filter(function($item) use ($translation){
                        return ($item->locale === $translation->locale) && ($item->group === $translation->group) && ($item->key === $translation->key);
                    })->first();
                    if(is_null($translationToCreate)) {
                        $collection->add($translation);
                    }
                }
                $items = $collection->map(function ($languageLine) {
                    return [
                        'locale'      => $languageLine->locale,
                        'description' => $languageLine->description,
                        'group'       => $languageLine->group,
                        'key'         => $languageLine->key,
                        'text'        => $languageLine->text,
                    ];
                })->toArray();
                ini_set('max_execution_time', 600);
                DB::table('language_lines_' . mb_strtolower($whitelabel->name))->insert($items);
            }

            dd($items);






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
}
