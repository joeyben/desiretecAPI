<?php

namespace Modules\Whitelabels\Http\Controllers;

use App\Repositories\Backend\Distributions\DistributionsRepository;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WithTrashed;
use App\Services\Flag\Src\Flag;
use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;
use Maatwebsite\Excel\Excel;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Whitelabels\Http\Requests\DomainWhitelabelRequest;
use Modules\Whitelabels\Http\Requests\SaveWhitelabelRequest;
use Modules\Whitelabels\Http\Requests\StoreWhitelabelAttachmentRequest;
use Modules\Whitelabels\Http\Requests\StoreWhitelabelRequest;
use Modules\Whitelabels\Http\Requests\UpdateWhitelabelRequest;
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
     */
    public function __construct(WhitelabelsRepository $whitelabels, DistributionsRepository $distributions, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, Excel $excel, FilesystemManager $storage, Kernel $artisan, Str $str)
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
                'distribution_id'                  => 1,
                'owner'                            => $this->auth->guard('web')->user()->first_name . ' ' . $this->auth->guard('web')->user()->last_name,
                'background'                       => [],
                'logo'                             => [],
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
                    ['created_by' => $this->auth->guard('web')->user()->id, 'name' => $this->str->studly($request->get('name')), 'state' => 1, 'bg_image' => $request->get('background')[0]['uid'], 'logo_image' => $request->get('logo')[0]['uid']]
                )
            );

            ini_set('max_execution_time', 300);
            $this->artisan->call('module:make', ['name' => [$result['whitelabel']->name], '--force' => true]);
            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Whitelabel']);
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

    public function uploadFile(StoreWhitelabelAttachmentRequest $request) {
        try {
            $path = 'img' . \DIRECTORY_SEPARATOR . 'whitelabel' . \DIRECTORY_SEPARATOR;
            $attachment = $request->file('attachment');
            $fileName = time() . $attachment->getClientOriginalName();

            $this->storage->disk('s3')->put($path . $fileName, file_get_contents($attachment->getRealPath()), 'public');

            $result['id'] = $fileName;
            $result['url'] = $this->storage->disk('s3')->url($path . $fileName);
            $result['name'] = $request->get('name');
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function destroyFile(string $id) {
        try {
            $path = 'img' . \DIRECTORY_SEPARATOR . 'whitelabel' . \DIRECTORY_SEPARATOR . $id;
            $this->storage->disk('s3')->delete($path);

            $result['id'] = $id;
            $result['url'] = $this->storage->disk('s3')->url($path);
            $result['name'] = $id;
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
                'id'                  => $whitelabel->id,
                'name'                => $whitelabel->name,
                'display_name'        => $whitelabel->display_name,
                'status'              => $whitelabel->status,
                'domain'              => $whitelabel->domain,
                'owner'               => $whitelabel->owner->full_name,
                'distribution_id'              => $whitelabel->distribution_id,
                'bg_image'              => $whitelabel->bg_image,
                'logo_image'              => $whitelabel->logo_image,
                'state'              => $whitelabel->state,
            ];
            $result['whitelabel']['logs'] = $this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE) ? $this->activities->byModel($whitelabel) : [];

            $distributions = $this->distributions->getAll();

            $result['whitelabel']['distributions'] = $distributions->map(function ($distribution) {
                return [
                    'id'   => $distribution->id,
                    'name' => $distribution->display_name
                ];
            });
            $result['whitelabel']['background'][] = [
                'uid' => $whitelabel->bg_image,
                'name' => $whitelabel->bg_image,
                'url' => $this->storage->disk('s3')->url($path . $whitelabel->bg_image)
            ];
            $result['whitelabel']['logo'][] = [
                'uid' => $whitelabel->bg_image,
                'name' => $whitelabel->bg_image,
                'url' => $this->storage->disk('s3')->url($path . $whitelabel->logo_image)
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
     * @param \Modules\Whitelabels\Http\Requests\UpdateWhitelabelRequest $request
     *
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
                    ['state' => 1, 'bg_image' => $request->get('background')[0]['uid'], 'logo_image' => $request->get('logo')[0]['uid']]
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
     *
     * @param int                                                        $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(SaveWhitelabelRequest $request, int $id)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->update(
                $id,
                array_merge(
                    $request->only('display_name', 'status', 'distribution_id'),
                    ['state' => 1, 'bg_image' => $request->get('background')[0]['uid'], 'logo_image' => $request->get('logo')[0]['uid']]
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
     * @param \Modules\Whitelabels\Http\Requests\DomainWhitelabelRequest $request
     *
     * @param int                                                        $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function domain(DomainWhitelabelRequest $request, int $id)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->update(
                $id,
                ['domain' => str_slug($request->get('domain')), 'state' => 2]
            );

            ini_set('max_execution_time', 300);
            $this->artisan->call('whitelabel:make-route', ['domain' => $result['whitelabel']->domain, 'module' => $result['whitelabel']->name]);

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
     * @return Response
     */
    public function destroy()
    {
    }
}
