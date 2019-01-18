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
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Maatwebsite\Excel\Excel;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Whitelabels\Http\Requests\StoreWhitelabelAttachmentRequest;
use Modules\Whitelabels\Http\Requests\StoreWhitelabelRequest;
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
     */
    public function __construct(WhitelabelsRepository $whitelabels, DistributionsRepository $distributions, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, Excel $excel, FilesystemManager $storage)
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
                    $request->only('name', 'display_name', 'status', 'distribution_id'),
                    ['created_by' => $this->auth->guard('web')->user()->id, 'state' => 1, 'bg_image' => $request->get('background')[0]['uid'], 'logo_image' => $request->get('logo')[0]['uid']]
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
     * @return Response
     */
    public function destroy()
    {
    }
}
