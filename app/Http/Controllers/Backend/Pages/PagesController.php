<?php

namespace App\Http\Controllers\Backend\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Pages\CreatePageRequest;
use App\Http\Requests\Backend\Pages\DeletePageRequest;
use App\Http\Requests\Backend\Pages\EditPageRequest;
use App\Http\Requests\Backend\Pages\ManagePageRequest;
use App\Http\Requests\Backend\Pages\StorePageRequest;
use App\Http\Requests\Backend\Pages\UpdatePageRequest;
use App\Http\Responses\Backend\Page\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\Page\Page;
use App\Repositories\Backend\Pages\PagesRepository;

/**
 * Class PagesController.
 */
class PagesController extends Controller
{
    protected $pages;

    public function __construct(PagesRepository $pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePageRequest $request)
    {
        return new ViewResponse('backend.pages.index');
    }

    /**
     * @return \App\Http\Responses\ViewResponse
     */
    public function create(CreatePageRequest $request)
    {
        return new ViewResponse('backend.pages.create');
    }

    /**
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePageRequest $request)
    {
        $this->pages->create($request->except(['_token']));

        return new RedirectResponse(route('admin.pages.index'), ['flash_success' => trans('alerts.backend.pages.created')]);
    }

    /**
     * @return \App\Http\Responses\Backend\Page\EditResponse
     */
    public function edit(Page $page, EditPageRequest $request)
    {
        return new EditResponse($page);
    }

    /**
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(Page $page, UpdatePageRequest $request)
    {
        $this->pages->update($page, $request->except(['_method', '_token']));

        return new RedirectResponse(route('admin.pages.index'), ['flash_success' => trans('alerts.backend.pages.updated')]);
    }

    /**
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Page $page, DeletePageRequest $request)
    {
        $this->pages->delete($page);

        return new RedirectResponse(route('admin.pages.index'), ['flash_success' => trans('alerts.backend.pages.deleted')]);
    }
}
