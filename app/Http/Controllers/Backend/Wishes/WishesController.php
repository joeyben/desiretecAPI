<?php

namespace App\Http\Controllers\Backend\Wishes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Wishes\ManageWishesRequest;
use App\Http\Requests\Backend\Wishes\StoreWishesRequest;
use App\Http\Requests\Backend\Wishes\UpdateWishesRequest;
use App\Models\Wishes\Wish;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Backend\Wishes\WishesRepository;

/**
 * Class WishesController.
 */
class WishesController extends Controller
{
    /**
     * Wish Status.
     */
    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
        'Deleted'      => 'Deleted',
    ];

    /**
     * Wish Category.
     */
    protected $category = [
        '1'  => 1,
        '2'  => 2,
        '3'  => 3,
        '4'  => 4,
        '5'  => 5,
    ];

    /**
     * Wish Catering.
     */
    protected $catering = [
        'any'           => 'any',
        'Breakfast'     => 'Breakfast',
        'Pension'       => 'Pension',
        'Full Pension'  => 'Full Pension',
        'All Inclusive' => 'All Inclusive',
    ];

    /**
     * @var WishesRepository
     */
    protected $wish;

    /**
     * @var WhitelabelsRepository
     */
    protected $whitelabels;

    /**
     * @param \App\Repositories\Backend\Wishes\WishesRepository $wish
     * @param WhitelabelsRepository                             $whitelabels
     */
    public function __construct(WishesRepository $wish, WhitelabelsRepository $whitelabels)
    {
        $this->wish = $wish;
        $this->whitelabels = $whitelabels;
    }

    /**
     * @param \App\Http\Requests\Backend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function index(ManageWishesRequest $request)
    {
        return view('backend.wishes.index')->with([
            'status'  => $this->status,
            'category'=> $this->category,
            'catering'=> $this->catering,
        ]);
    }

    /**
     * @param \App\Http\Requests\Backend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function create(ManageWishesRequest $request)
    {
        return view('backend.wishes.create')->with([
            'status'         => $this->status,
            'category'       => $this->category,
            'catering'       => $this->catering,
            'whitelabels'    => $this->whitelabels->getAll(),
        ]);
    }

    /**
     * @param \App\Http\Requests\Backend\Wishes\StoreWishesRequest $request
     *
     * @return mixed
     */
    public function store(StoreWishesRequest $request)
    {
        $this->wish->create($request->except('_token'));

        return redirect()
            ->route('admin.wishes.index')
            ->with('flash_success', trans('alerts.backend.wishes.created'));
    }

    /**
     * @param \App\Models\Wishes\Wish                               $wish
     * @param \App\Http\Requests\Backend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function edit(Wish $wish, ManageWishesRequest $request)
    {
        return view('backend.wishes.edit')->with([
            'wish'               => $wish,
            'status'             => $this->status,
            'category'           => $this->category,
            'catering'           => $this->catering,
            'whitelabels'        => $this->whitelabels->getAll(),
        ]);
    }

    /**
     * @param \App\Models\Wishes\Wish                               $wish
     * @param \App\Http\Requests\Backend\Wishes\UpdateWishesRequest $request
     *
     * @return mixed
     */
    public function update(Wish $wish, UpdateWishesRequest $request)
    {
        $input = $request->all();

        $this->wish->update($wish, $request->except(['_token', '_method']));

        return redirect()
            ->route('admin.wishes.index')
            ->with('flash_success', trans('alerts.backend.wishes.updated'));
    }

    /**
     * @param \App\Models\Wishes\Wish                               $wish
     * @param \App\Http\Requests\Backend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function destroy(Wish $wish, ManageWishesRequest $request)
    {
        $this->wish->delete($wish);

        return redirect()
            ->route('admin.wishes.index')
            ->with('flash_success', trans('alerts.backend.wishes.deleted'));
    }
}
