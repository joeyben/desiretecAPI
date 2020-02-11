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

    public function __construct(WhitelabelsRepository $whitelabel, DistributionsRepository $distributions, ResponseFactory $response)
    {
        $this->whitelabel = $whitelabel;
        $this->distributions = $distributions;
        $this->response = $response;
    }

    /**
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
        $output = [];
        $return_var = -1;
        $command = "cd ../Modules/$whitelabelName && npm run development";
        // $command = "which npm";
        $last_line = exec($command, $output, $return_var);

        if (0 === $return_var) {
            var_dump($output);
        } else {
            // fail or other exceptions
            var_dump($output);
        }
    }

    /**
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
