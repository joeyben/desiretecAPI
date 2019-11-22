<?php

namespace Modules\Whitelabels\Http\Controllers;

use App\Repositories\Backend\Distributions\DistributionsRepository;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WithTrashed;
use App\Services\Flag\Src\Flag;
use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;
use Maatwebsite\Excel\Excel;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Attachments\Repositories\Contracts\AttachmentsRepository;
use Modules\Languages\Repositories\Contracts\LanguagesRepository;
use Modules\Roles\Repositories\Contracts\RolesRepository;
use Modules\Whitelabels\Http\Requests\DomainWhitelabelRequest;
use Modules\Whitelabels\Http\Requests\SaveWhitelabelRequest;
use Modules\Whitelabels\Http\Requests\StoreWhitelabelRequest;
use Modules\Whitelabels\Http\Requests\UpdateWhitelabelRequest;
use Modules\Whitelabels\Notifications\CreateWhitelabelNotification;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class WhitelabelsController extends Controller
{
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
     * @var \Carbon\Carbon
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
     * @var \App\Repositories\Backend\Distributions\DistributionsRepository
     */
    private $distributions;
    /**
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    private $storage;
    /**
     * @var \Illuminate\Contracts\Console\Kernel
     */
    private $artisan;
    /**
     * @var \Illuminate\Support\Str
     */
    private $str;
    /**
     * @var \Modules\Attachments\Repositories\Contracts\AttachmentsRepository
     */
    private $attachments;
    /**
     * @var \Illuminate\Notifications\ChannelManager
     */
    private $notification;
    /**
     * @var \Modules\Roles\Repositories\Contracts\RolesRepository
     */
    private $roles;
    /**
     * @var \Modules\Languages\Repositories\Contracts\LanguagesRepository
     */
    private $languages;

    /**
     * WhitelabelsController constructor.
     *
     * @param \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository $whitelabels
     * @param \App\Repositories\Backend\Distributions\DistributionsRepository   $distributions
     * @param \Illuminate\Routing\ResponseFactory                               $response
     * @param \Illuminate\Auth\AuthManager                                      $auth
     * @param \Illuminate\Translation\Translator                                $lang
     * @param \Carbon\Carbon                                                    $carbon
     * @param \Modules\Activities\Repositories\Contracts\ActivitiesRepository   $activities
     * @param \Maatwebsite\Excel\Excel                                          $excel
     * @param \Illuminate\Filesystem\FilesystemManager                          $storage
     * @param \Illuminate\Contracts\Console\Kernel                              $artisan
     * @param \Illuminate\Support\Str                                           $str
     * @param \Modules\Attachments\Repositories\Contracts\AttachmentsRepository $attachments
     * @param \Illuminate\Notifications\ChannelManager                          $notification
     * @param \Modules\Roles\Repositories\Contracts\RolesRepository             $roles
     * @param LanguagesRepository                                               $languages
     */
    public function __construct(WhitelabelsRepository $whitelabels, DistributionsRepository $distributions, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, Excel $excel, FilesystemManager $storage, Kernel $artisan, Str $str, AttachmentsRepository $attachments, ChannelManager $notification, RolesRepository $roles, LanguagesRepository $languages)
    {
        $this->whitelabels = $whitelabels;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->activities = $activities;
        $this->excel = $excel;
        $this->distributions = $distributions;
        $this->storage = $storage;
        $this->artisan = $artisan;
        $this->str = $str;
        $this->attachments = $attachments;
        $this->notification = $notification;
        $this->roles = $roles;
        $this->languages = $languages;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('whitelabels::index');
    }

    public function view()
    {
        try {
            $whitelabels = $this->whitelabels->all();
            $result['whitelabels'] = $whitelabels->map(function ($whitelabel) {
                return [
                    'id'   => $whitelabel->id,
                    'name' => $whitelabel->display_name
                ];
            });
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
        try {
            $perPage = $request->get('per_page');
            $sort = explode('|', $request->get('sort'));

            $result['data'] = $this->whitelabels->withCriteria([
                new WithTrashed(),
                new OrderBy($sort[0], $sort[1]),
                new Where('whitelabels.id', $request->get('whitelabel')),
                new Filter($request->get('filter')),
                new WhereBetween('whitelabels.created_at', $request->get('start'), $request->get('end')),
                new EagerLoad(['owner' => function ($query) {
                    $select = $this->auth->guard('web')->user()->hasRole('Administrator') ? 'CONCAT(first_name, " ", last_name, " ( ", email, " ) ") AS full_name' : 'CONCAT(first_name, " ", last_name) AS full_name';
                    $query->select('users.id', DB::raw($select));
                }, 'distribution'  => function ($query) {
                    $query->select('id', 'display_name');
                }]),
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
            $result['whitelabel'] = [
                'id'                               => 0,
                'name'                             => '',
                'display_name'                     => '',
                'status'                           => true,
                'domain'                           => null,
                'email'                            => null,
                'distribution_id'                  => 1,
                'owner'                            => $this->auth->guard('web')->user()->first_name . ' ' . $this->auth->guard('web')->user()->last_name,
                'background'                       => [],
                'logo'                             => [],
                'favicon'                          => [],
                'state'                            => 0,
                'logs'                             => []
            ];

            $distributions = $this->distributions->getAll();

            $result['whitelabel']['distributions'] = $distributions->map(function ($distribution) {
                return [
                    'id'   => $distribution->id,
                    'name' => $distribution->display_name
                ];
            });

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
     * @param \Modules\Whitelabels\Http\Requests\StoreWhitelabelRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreWhitelabelRequest $request)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->create(
                array_merge(
                    $request->only('display_name', 'status', 'distribution_id'),
                    ['created_by' => $this->auth->guard('web')->user()->id, 'name' => $this->str->studly($request->get('name')), 'state' => 1]
                )
            );

            foreach ($request->get('background') as $item) {
                $this->attachments->update(
                    $item['uid'],
                    ['attachable_id' => $result['whitelabel']->id]
                );
            }

            foreach ($request->get('logo') as $item) {
                $this->attachments->update(
                    $item['uid'],
                    ['attachable_id' => $result['whitelabel']->id]
                );
            }

            foreach ($request->get('favicon') as $item) {
                $this->attachments->update(
                    $item['uid'],
                    ['attachable_id' => $result['whitelabel']->id]
                );
            }

            ini_set('max_execution_time', 500);
            $this->artisan->call('module:make', ['name' => [$result['whitelabel']->name], '--force' => true]);
            $this->artisan->call('cache:clear');
            $this->artisan->call('config:clear');
            $this->artisan->call('view:clear');
            $this->whitelabels->generateFiles($result['whitelabel']->id, $result['whitelabel']->name);
            $this->artisan->call('module:migrate', ['module' => $result['whitelabel']->name, '--force' => true]);
            $whitelabelLangTable = 'language_lines_' . mb_strtolower($result['whitelabel']->name);

            $locales = array_keys(config('locale.languages'));

            foreach ($locales as $locale) {
                $language = $this->languages->findWhereFirst('locale', $locale);
                $language->whitelabels()->attach($result['whitelabel']->id);

                $this->whitelabels->copyLanguage($whitelabelLangTable, $locale);
            }
            $whitelabelName = $result['whitelabel']->name;
            $output = shell_exec("cd ../Modules/$whitelabelName && npm install && npm run development");

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Whitelabel']);
            $result['language'] = $language;
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function current(): JsonResponse
    {
        try {
            $result['whitelabel'] = $this->whitelabels->current();

            $background = $this->whitelabels->getBackgroundImage($result['whitelabel']);

            $logo = $this->whitelabels->getLogo($result['whitelabel']);

            $favicon = $this->whitelabels->getFavicon($result['whitelabel']);

            $visual = $this->whitelabels->getVisual($result['whitelabel']);

            $domain = null !== $result['whitelabel'] ? $result['whitelabel']->domain : '';

            $result['whitelabel']['background'] = null !== $background ? [$background->first()] : [];
            $result['whitelabel']['logo'] = null !== $logo ? [$logo->first()] : [];
            $result['whitelabel']['favicon'] = null !== $favicon ? [$favicon->first()] : [];
            $result['whitelabel']['visual'] = null !== $visual ? [$visual->first()] : [];
            $result['whitelabel']['sub_domain'] = $this->whitelabels->getSubDomain($domain);
            $result['whitelabel']['main_domain'] = $this->whitelabels->getDomain($domain);

            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $result['whitelabel'] = $this->whitelabels->find($id);

            $background = $this->whitelabels->getBackgroundImage($result['whitelabel']);

            $logo = $this->whitelabels->getLogo($result['whitelabel']);

            $favicon = $this->whitelabels->getFavicon($result['whitelabel']);

            $visual = $this->whitelabels->getVisual($result['whitelabel']);

            $result['whitelabel']['background'] = (!is_null($background) && !is_null($background->first())) ? [$background->first()] : [];
            $result['whitelabel']['logo'] = (!is_null($logo) && !is_null($logo->first())) ? [$logo->first()] : [];
            $result['whitelabel']['favicon'] = (!is_null($favicon) && !is_null($favicon->first())) ? [$favicon->first()] : [];
            $result['whitelabel']['visual'] = (!is_null($visual) && !is_null($visual->first())) ? [$visual->first()] : [];

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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id)
    {
        try {
            $path = 'img' . \DIRECTORY_SEPARATOR . 'whitelabel' . \DIRECTORY_SEPARATOR;

            $whitelabel = $this->whitelabels->withCriteria([
                new EagerLoad(['owner' => function ($query) {
                    $query->select('users.id', DB::raw('CONCAT(users.first_name, " ", users.last_name) AS full_name'));
                }])
            ])->find($id);

            $result['whitelabel'] = [
                'id'                           => $whitelabel->id,
                'name'                         => $whitelabel->name,
                'display_name'                 => $whitelabel->display_name,
                'ga_view_id'                   => $whitelabel->ga_view_id,
                'status'                       => $whitelabel->status,
                'domain'                       => $whitelabel->domain,
                'email'                        => $whitelabel->email,
                'owner'                        => $whitelabel->owner->full_name,
                'distribution_id'              => $whitelabel->distribution_id,
                'state'                        => $whitelabel->state,
            ];
            $result['whitelabel']['logs'] = $this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE) ? $this->activities->byModel($whitelabel) : [];

            $distributions = $this->distributions->getAll();

            $result['whitelabel']['distributions'] = $distributions->map(function ($distribution) {
                return [
                    'id'   => $distribution->id,
                    'name' => $distribution->display_name
                ];
            });

            $background = $this->whitelabels->getBackgroundImage($whitelabel);

            $logo = $this->whitelabels->getLogo($whitelabel);

            $favicon = $this->whitelabels->getFavicon($whitelabel);

            $result['whitelabel']['background'] = null !== $background->first() ? [$background->first()] : [];
            $result['whitelabel']['logo'] = null !== $logo->first() ? [$logo->first()] : [];
            $result['whitelabel']['favicon'] = null !== $favicon->first() ? [$favicon->first()] : [];
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
     * @param \Modules\Whitelabels\Http\Requests\UpdateWhitelabelRequest $request
     * @param int                                                        $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateWhitelabelRequest $request, int $id)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->update(
                $id,
                array_merge(
                    $request->only('display_name', 'status', 'distribution_id'),
                    ['state' => 1]
                )
            );

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Whitelabel']);
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
     * Update the specified resource in storage.
     *
     * @param \Modules\Whitelabels\Http\Requests\SaveWhitelabelRequest $request
     * @param int                                                      $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(SaveWhitelabelRequest $request, int $id)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->update(
                $id,
                array_merge(
                    $request->only('display_name', 'ga_view_id', 'status', 'distribution_id', 'email'),
                    ['state' => 2]
                )
            );

            if ($result['whitelabel']->domain !== $this->str->lower($request->get('domain'))) {
                ini_set('max_execution_time', 300);
                $result['whitelabel'] = $this->whitelabels->update($id, $request->only('domain'));
                $this->whitelabels->updateRoute($id, $result['whitelabel']->name, $this->whitelabels->getSubDomain($result['whitelabel']->domain));
                $this->artisan->call('whitelabel:make-route', ['domain' => $this->whitelabels->getSubDomain($result['whitelabel']->domain), 'module' => $result['whitelabel']->name]);
            }

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Whitelabel']);
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
     * Update the specified resource in storage.
     *
     * @param \Modules\Whitelabels\Http\Requests\DomainWhitelabelRequest $request
     * @param int                                                        $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function domain(DomainWhitelabelRequest $request, int $id)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->update(
                $id,
                ['domain' => $this->str->lower($request->get('domain')), 'email' => $request->get('email'), 'state' => 2]
            );

            ini_set('max_execution_time', 300);
            $this->whitelabels->updateRoute($id, $result['whitelabel']->name, $this->whitelabels->getSubDomain($result['whitelabel']->domain));
            $this->artisan->call('whitelabel:make-route', ['domain' => $this->whitelabels->getSubDomain($result['whitelabel']->domain), 'module' => $result['whitelabel']->name]);
            $users = $this->roles->findWhereFirst('name', Flag::ADMINISTRATOR_ROLE)->users()->get();
            $this->notification->send($users, new CreateWhitelabelNotification($result['whitelabel'], 'Step 2'));

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Domain']);
            $result['message'] .= $this->artisan->output();
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
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->delete($id);
            $result['message'] = $this->lang->get('messages.deleted', ['attribute' => 'Whitelabel']);
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
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(int $id)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->restore($id);
            $result['message'] = $this->lang->get('messages.restored', ['attribute' => 'Whitelabel']);
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
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(int $id)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->forceDelete($id);
            $result['message'] = $this->lang->get('messages.destroyed', ['attribute' => 'Whitelabel']);
            $result['success'] = $this->delTree(base_path('Modules/' . $result['whitelabel']->name));
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    private function delTree($dir)
    {
        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
            }

            return rmdir($dir);
        }

        return true;
    }
}
