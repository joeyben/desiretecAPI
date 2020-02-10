<?php

namespace App\Http\Controllers\Backend\BlogCategories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BlogCategories\CreateBlogCategoriesRequest;
use App\Http\Requests\Backend\BlogCategories\DeleteBlogCategoriesRequest;
use App\Http\Requests\Backend\BlogCategories\EditBlogCategoriesRequest;
use App\Http\Requests\Backend\BlogCategories\ManageBlogCategoriesRequest;
use App\Http\Requests\Backend\BlogCategories\StoreBlogCategoriesRequest;
use App\Http\Requests\Backend\BlogCategories\UpdateBlogCategoriesRequest;
use App\Http\Responses\Backend\BlogCategory\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\BlogCategories\BlogCategory;
use App\Repositories\Backend\BlogCategories\BlogCategoriesRepository;

/**
 * Class BlogCategoriesController.
 */
class BlogCategoriesController extends Controller
{
    protected $blogcategory;

    public function __construct(BlogCategoriesRepository $blogcategory)
    {
        $this->blogcategory = $blogcategory;
    }

    /**
     * @return ViewResponse
     */
    public function index(ManageBlogCategoriesRequest $request)
    {
        return new ViewResponse('backend.blogcategories.index');
    }

    /**
     * @return \App\Http\Responses\ViewResponse
     */
    public function create(CreateBlogCategoriesRequest $request)
    {
        return new ViewResponse('backend.blogcategories.create');
    }

    /**
     * @return mixed
     */
    public function store(StoreBlogCategoriesRequest $request)
    {
        $this->blogcategory->create($request->all());

        return new RedirectResponse(route('admin.blogCategories.index'), ['flash_success' => trans('alerts.backend.blogcategories.created')]);
    }

    /**
     * @return \App\Http\Responses\Backend\BlogCategory\EditResponse
     */
    public function edit(BlogCategory $blogCategory, EditBlogCategoriesRequest $request)
    {
        return new EditResponse($blogCategory);
    }

    /**
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(BlogCategory $blogCategory, UpdateBlogCategoriesRequest $request)
    {
        $this->blogcategory->update($blogCategory, $request->all());

        return new RedirectResponse(route('admin.blogCategories.index'), ['flash_success' => trans('alerts.backend.blogcategories.updated')]);
    }

    /**
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(BlogCategory $blogCategory, DeleteBlogCategoriesRequest $request)
    {
        $this->blogcategory->delete($blogCategory);

        return new RedirectResponse(route('admin.blogCategories.index'), ['flash_success' => trans('alerts.backend.blogcategories.deleted')]);
    }
}
