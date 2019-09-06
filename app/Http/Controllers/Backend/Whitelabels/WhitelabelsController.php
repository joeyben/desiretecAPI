<?php

namespace App\Http\Controllers\Backend\Whitelabels;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Whitelabels\ManageWhitelabelsRequest;
use App\Http\Requests\Backend\Whitelabels\StoreWhitelabelsRequest;
use App\Http\Requests\Backend\Whitelabels\UpdateWhitelabelsRequest;
use App\Models\Whitelabels\Whitelabel;
use App\Repositories\Backend\Distributions\DistributionsRepository;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class WhitelabelsController.
 */
class WhitelabelsController extends Controller
{
    /**
     * Whitelabel Status.
     */
    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
    ];

    /**
     * @var WhitelabelsRepository
     */
    protected $whitelabel;

    /**
     * @var DistributionsRepository
     */
    protected $distributions;
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private $response;

    /**
     * @param \App\Repositories\Backend\Whitelabels\WhitelabelsRepository     $whitelabel
     * @param \App\Repositories\Backend\Distributions\DistributionsRepository $distributions
     * @param \Illuminate\Routing\ResponseFactory                             $response
     */
    public function __construct(WhitelabelsRepository $whitelabel, DistributionsRepository $distributions, ResponseFactory $response)
    {
        $this->whitelabel = $whitelabel;
        $this->distributions = $distributions;
        $this->response = $response;
    }

    /**
     * @param \App\Http\Requests\Backend\Whitelabels\ManageWhitelabelsRequest $request
     *
     * @return mixed
     */
    public function index(ManageWhitelabelsRequest $request)
    {
        return view('backend.whitelabels.index')->with([
            'status'=> $this->status,
        ]);
    }

    public function view()
    {
        try {
            $whitelabels = $this->whitelabel->getAll();
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

    public function compile()
    {

        $whitelabelName = ucfirst(access()->user()->whitelabels[0]->name);
        $process = new Process("cd ../Modules/$whitelabelName && npm install && npm run dev");
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        echo $process->getOutput();
    }

    /**
     * @param \App\Http\Requests\Backend\Whitelabels\ManageWhitelabelsRequest $request
     *
     * @return mixed
     */
    public function create(Whitelabel $whitelabel, ManageWhitelabelsRequest $request)
    {
        return view('backend.whitelabels.create')->with([
            'status'            => $this->status,
            'distributions'     => $this->distributions->getAll(),
            'whitelabel'        => $whitelabel
        ]);
    }

    /**
     * @param \App\Http\Requests\Backend\Whitelabels\StoreWhitelabelsRequest $request
     *
     * @return mixed
     */
    public function store(StoreWhitelabelsRequest $request)
    {
        $this->whitelabel->create($request->except('_token'));

        return redirect()
            ->route('admin.whitelabels.index')
            ->with('flash_success', trans('alerts.backend.whitelabels.created'));
    }

    /**
     * @param \App\Models\Whitelabels\Whitelabel                              $whitelabel
     * @param \App\Http\Requests\Backend\Whitelabels\ManageWhitelabelsRequest $request
     *
     * @return mixed
     */
    public function edit(Whitelabel $whitelabel, ManageWhitelabelsRequest $request)
    {
        return view('backend.whitelabels.edit')->with([
            'whitelabel'         => $whitelabel,
            'status'             => $this->status,
            'distributions'      => $this->distributions->getAll(),
        ]);
    }

    /**
     * @param \App\Models\Whitelabels\Whitelabel                              $whitelabel
     * @param \App\Http\Requests\Backend\Whitelabels\UpdateWhitelabelsRequest $request
     *
     * @return mixed
     */
    public function update(Whitelabel $whitelabel, UpdateWhitelabelsRequest $request)
    {
        $input = $request->all();

        $this->whitelabel->update($whitelabel, $request->except(['_token', '_method']));

        return redirect()
            ->route('admin.whitelabels.index')
            ->with('flash_success', trans('alerts.backend.whitelabels.updated'));
    }

    /**
     * @param \App\Models\Whitelabels\Whitelabel                              $whitelabel
     * @param \App\Http\Requests\Backend\Whitelabels\ManageWhitelabelsRequest $request
     *
     * @return mixed
     */
    public function destroy(Whitelabel $whitelabel, ManageWhitelabelsRequest $request)
    {
        $this->whitelabel->delete($whitelabel);

        return redirect()
            ->route('admin.whitelabels.index')
            ->with('flash_success', trans('alerts.backend.whitelabels.deleted'));
    }
}
