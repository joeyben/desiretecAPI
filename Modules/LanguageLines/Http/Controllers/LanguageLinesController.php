<?php

namespace Modules\LanguageLines\Http\Controllers;

use App\Models\Access\Role\Role;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereIn;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Translation\Translator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\LanguageLines\Exports\LanguageImport;
use Modules\LanguageLines\Http\Requests\CloneLanguageLinesRequest;
use Modules\LanguageLines\Http\Requests\CopyLanguageLinesRequest;
use Modules\LanguageLines\Http\Requests\EmailSignatureStoreRequest;
use Modules\LanguageLines\Http\Requests\StoreLanguageLineRequest;
use Modules\LanguageLines\Http\Requests\UpdateLanguageLineRequest;
use Modules\LanguageLines\Notifications\CloneLanguageLinesNotification;
use Modules\LanguageLines\Notifications\CopyLanguageLinesNotification;
use Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository;
use Modules\Languages\Exports\LanguageExport;
use Modules\Languages\Repositories\Contracts\LanguagesRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

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
     * @var \Illuminate\Database\DatabaseManager
     */
    private $database;
    /**
     * @var \Illuminate\Notifications\ChannelManager
     */
    private $notification;
    /**
     * @var \App\Models\Access\Role\Role
     */
    private $role;
    /**
     * @var \Modules\Languages\Repositories\Contracts\LanguagesRepository
     */
    private $languages;
    /**
     * @var \Illuminate\Contracts\Console\Kernel
     */
    private $artisan;

    /**
     * LanguageLines constructor.
     *
     * @param LanguageLinesRepository                                           $languageline
     * @param \Illuminate\Routing\ResponseFactory                               $response
     * @param \Illuminate\Auth\AuthManager                                      $auth
     * @param \Illuminate\Translation\Translator                                $lang
     * @param \Illuminate\Support\Carbon                                        $carbon
     * @param \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository $whitelabels
     * @param \Illuminate\Database\DatabaseManager                              $database
     * @param \Illuminate\Notifications\ChannelManager                          $notification
     * @param \App\Models\Access\Role\Role                                      $role
     * @param \Modules\Languages\Repositories\Contracts\LanguagesRepository     $languages
     * @param \Illuminate\Contracts\Console\Kernel                              $artisan
     */
    public function __construct(LanguageLinesRepository $languageline, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, WhitelabelsRepository $whitelabels, DatabaseManager $database, ChannelManager $notification, Role $role, LanguagesRepository $languages, Kernel $artisan)
    {
        $this->languageline = $languageline;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->whitelabels = $whitelabels;
        $this->database = $database;
        $this->notification = $notification;
        $this->role = $role;
        $this->languages = $languages;
        $this->artisan = $artisan;
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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function cacheClear()
    {
        try {
            $this->artisan->call('config:clear');
            $this->artisan->call('view:clear');
            $this->artisan->call('cache:clear');

            $result['message'] = $this->artisan->output();
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
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
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $result['languageline'] = $this->languageline->delete($id);
            $result['message'] = $this->lang->get('messages.deleted', ['attribute' => 'Translation']);
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
     * @param \Modules\LanguageLines\Http\Requests\CopyLanguageLinesRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function copy(CopyLanguageLinesRequest $request)
    {
        $count = [];

        try {
            $translations = $this->languageline->get();

            $whitelabels = $this->whitelabels->withCriteria([
                new WhereIn('whitelabels.id', $request->get('whitelabels')),
            ])->get();

            foreach ($whitelabels as $whitelabel) {
                $table = 'language_lines_' . mb_strtolower($whitelabel->name);

                if (Schema::hasTable($table)) {
                    $persistedTranslations = $this->database->table($table)->get();
                    $collection = new Collection();

                    foreach ($translations as $translation) {
                        $translationToCreate = $persistedTranslations->filter(function ($item) use ($translation) {
                            return ($item->locale === $translation->locale) && ($item->group === $translation->group) && ($item->key === $translation->key);
                        })->first();
                        if (null === $translationToCreate) {
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

                    if (\count($items) > 0) {
                        ini_set('max_execution_time', 600);
                        $this->database->table($table)->insert($items);
                    }

                    $count[$whitelabel->name] = \count($items);
                }
            }

            $admins = $this->role->newQuery()->where('name', Flag::ADMINISTRATOR_ROLE)->first()->users()->get();
            $this->notification->send($admins, new CopyLanguageLinesNotification(json_encode($count)));

            $result['message'] = $this->lang->get(json_encode($count));
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
     * @param \Modules\LanguageLines\Http\Requests\CloneLanguageLinesRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clone(CloneLanguageLinesRequest $request)
    {
        $collection = new Collection();
        $count = [];
        $from = $request->get('from');
        $to = $request->get('to');
        $table = 'language_lines';

        try {
            if (Schema::hasTable($table)) {
                $translations = $this->languageline->withCriteria([
                    new Where($table . '.locale', $from),
                ])->get();

                $persistedTranslations = $this->database->table($table)->where($table . '.locale', $to)->get();

                foreach ($translations as $translation) {
                    $translationToCreate = $persistedTranslations->filter(function ($item) use ($translation) {
                        return ($item->group === $translation->group) && ($item->key === $translation->key);
                    })->first();
                    if (null === $translationToCreate) {
                        $collection->add($translation);
                    }
                }

                $items = $collection->map(function ($languageLine) use ($to) {
                    return [
                        'locale'      => $to,
                        'description' => $languageLine->description,
                        'group'       => $languageLine->group,
                        'key'         => $languageLine->key,
                        'text'        => $languageLine->text,
                    ];
                })->toArray();

                if (\count($items) > 0) {
                    ini_set('max_execution_time', 600);
                    $this->database->table($table)->insert($items);
                }

                $count['from'] = $from;
                $count['to'] = $to;
                $count['items'] = \count($items);
            }

            $admins = $this->role->newQuery()->where('name', Flag::ADMINISTRATOR_ROLE)->first()->users()->get();
            $this->notification->send($admins, new CloneLanguageLinesNotification(json_encode($count)));

            $result['message'] = $this->lang->get(json_encode($count));
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function export(Request $request)
    {
        $records = $request->has('checked') ? explode(',', $request->get('checked')) : null;

        return new LanguageExport($this->languageline->withCriteria([
            new OrderBy('id', 'ASC'),
            new WhereIn('id', $records)
        ]));
    }

    public function import(Request $request)
    {
        Excel::import(new LanguageImport(), $request->file('file'));
        try {
            $result['languageline'] = Excel::import(new LanguageImport(), $request->file('file'));
            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Translation']);
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
     * Fetch already existing Signature or Create new Signature.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function signature(string $lang)
    {
        try {
            $result['data']['text'] = $this->languageline->firstOrCreate([
                'locale' => $lang,
                'key'    => 'email_signature',
                'group'  => 'email'
            ])->text;

            $result['data']['language'] = $lang;
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return view('languagelines::email-signature', compact('result'));
    }

    /**
     * Edit already existing Signature or Create new Signature.
     *
     * @param EmailSignatureStoreRequest $request
     *
     * @return Response
     */
    public function signatureStore(EmailSignatureStoreRequest $request)
    {
        try {
            $languageline = $this->languageline->update(
                $this->languageline->firstOrCreate([
                'locale' => $request->get('language'),
                'key'    => 'email_signature',
                'group'  => 'email'])->id,
                ['text'=> $request->get('email_signature_editor')]
            );

            $result['success'] = true;
            $result['status'] = 200;

            return redirect(route('provider.email.signature', $request->language))->with('success', trans('email.signature.stored'));
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }
    }

    /**
     * Fetch already existing Footer Teilnahmebedingungen or Create new Teilnahmebedingungen.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function tnb(string $lang)
    {
        try {
            $result['data']['text'] = $this->languageline->firstOrCreate([
                'locale' => $lang,
                'key'    => 'email_signature',
                'group'  => 'email'
            ])->text;

            $result['data']['language'] = $lang;
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return view('languagelines::email-signature', compact('result'));
    }
}
