<?php

namespace App\Http\Controllers\Backend\Distributions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Distributions\ManageDistributionsRequest;
use App\Http\Requests\Backend\Distributions\StoreDistributionsRequest;
use App\Http\Requests\Backend\Distributions\UpdateDistributionsRequest;
use App\Models\Distributions\Distribution;
use App\Repositories\Backend\Distributions\DistributionsRepository;

/**
 * Class DistributionsController.
 */
class DistributionsController extends Controller
{
    /**
     * @var DistributionsRepository
     */
    protected $distribution;

    /**
     * @param \App\Repositories\Backend\Distributions\DistributionsRepository $distribution
     */
    public function __construct(DistributionsRepository $distribution)
    {
        $this->distribution = $distribution;
    }

    /**
     * @param \App\Http\Requests\Backend\Distributions\ManageDistributionsRequest $request
     *
     * @return mixed
     */
    public function index(ManageDistributionsRequest $request)
    {
        return view('backend.distributions.index')->with([
        ]);
    }

    /**
     * @param \App\Http\Requests\Backend\Distributions\ManageDistributionsRequest $request
     *
     * @return mixed
     */
    public function create(ManageDistributionsRequest $request)
    {
        return view('backend.distributions.create')->with([
        ]);
    }

    /**
     * @param \App\Http\Requests\Backend\Distributions\StoreDistributionsRequest $request
     *
     * @return mixed
     */
    public function store(StoreDistributionsRequest $request)
    {
        $this->distribution->create($request->except('_token'));

        return redirect()
            ->route('admin.distributions.index')
            ->with('flash_success', trans('alerts.backend.distributions.created'));
    }

    /**
     * @param \App\Models\Distributions\Distribution                              $distribution
     * @param \App\Http\Requests\Backend\Distributions\ManageDistributionsRequest $request
     *
     * @return mixed
     */
    public function edit(Distribution $distribution, ManageDistributionsRequest $request)
    {
        return view('backend.distributions.edit')->with([
            'distribution'               => $distribution,
            'status'                     => $this->status,
        ]);
    }

    /**
     * @param \App\Models\Distributions\Distribution                              $distribution
     * @param \App\Http\Requests\Backend\Distributions\UpdateDistributionsRequest $request
     *
     * @return mixed
     */
    public function update(Distribution $distribution, UpdateDistributionsRequest $request)
    {
        $input = $request->all();

        $this->distribution->update($distribution, $request->except(['_token', '_method']));

        return redirect()
            ->route('admin.distributions.index')
            ->with('flash_success', trans('alerts.backend.distributions.updated'));
    }

    /**
     * @param \App\Models\Distributions\Distribution                              $distribution
     * @param \App\Http\Requests\Backend\Distributions\ManageDistributionsRequest $request
     *
     * @return mixed
     */
    public function destroy(Distribution $distribution, ManageDistributionsRequest $request)
    {
        $this->distribution->delete($distribution);

        return redirect()
            ->route('admin.distributions.index')
            ->with('flash_success', trans('alerts.backend.distributions.deleted'));
    }
}
