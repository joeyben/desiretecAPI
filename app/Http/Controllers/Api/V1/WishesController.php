<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\PagesResource;
use App\Models\Wishes\Wish;
use App\Repositories\Backend\Wishes\WishesRepository;
use Illuminate\Http\Request;
use Validator;

class WishesController extends APIController
{
    protected $wish;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(WishesRepository $wish)
    {
        $this->wish = $wish;
    }

    /**
     * Return wishes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
    }

    /**
     * Return the specified resource.
     *
     * @param Wishes $wish
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $html = view('whitelabel.layer.form')->with([
        ])->render();

        return response()->json(['success' => true, 'html'=>$html]);
    }

    /**
     * Creates the Resource for Page.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validation = $this->validatePages($request);
        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $page = $this->wish->create($request->all());

        return new PagesResource($page);
    }

    /**
     *  Update Page.
     *
     * @param Page    $page
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Page $page)
    {
        $validation = $this->validatePages($request, $page->id);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->wish->update($page, $request->all());

        $page = Page::findOrfail($page->id);

        return new PagesResource($page);
    }

    /**
     *  Delete Page.
     *
     * @param Page              $page
     * @param DeletePageRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Page $page, Request $request)
    {
        $this->wish->delete($page);

        return $this->respond([
            'message' => trans('alerts.backend.pages.deleted'),
        ]);
    }

    /**
     * validateUser Pages Requests.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatePages(Request $request, $id = 0)
    {
        $validation = Validator::make($request->all(), [
            'title'       => 'required|max:191|unique:pages,title,' . $id,
            'description' => 'required',
        ]);

        return $validation;
    }
}
