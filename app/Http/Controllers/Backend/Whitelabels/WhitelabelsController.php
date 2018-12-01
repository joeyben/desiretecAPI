<?php

namespace App\Http\Controllers\Backend\Whitelabels;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Whitelabels\ManageWhitelabelsRequest;
use App\Http\Requests\Backend\Whitelabels\StoreWhitelabelsRequest;
use App\Http\Requests\Backend\Whitelabels\UpdateWhitelabelsRequest;
use App\Models\Whitelabels\Whitelabel;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Backend\Distributions\DistributionsRepository;

/**
 * Class WhitelabelsController.
 */
class WhitelabelsController extends Controller
{
    /**
     * Whitelabel Status.
     */
    protected $status = [
        'Active' => 'Active',
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
     * @param \App\Repositories\Backend\Whitelabels\WhitelabelsRepository $whitelabel
     * @param \App\Repositories\Backend\Distributions\DistributionsRepository $distribution
     */
    public function __construct(WhitelabelsRepository $whitelabel, DistributionsRepository $distributions)
    {
        $this->whitelabel = $whitelabel;
        $this->distributions = $distributions;
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

    /**
     * @param \App\Http\Requests\Backend\Whitelabels\ManageWhitelabelsRequest $request
     *
     * @return mixed
     */
    public function create(Whitelabel $whitelabel,ManageWhitelabelsRequest $request)
    {

        return view('backend.whitelabels.create')->with([
            'status'         => $this->status,
            'distributions' => $this->distributions->getAll(),
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
            'whitelabel'        => $whitelabel,
            'status'            => $this->status,
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
