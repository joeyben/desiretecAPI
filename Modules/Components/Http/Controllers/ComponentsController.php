<?php

namespace Modules\Components\Http\Controllers;

use App\Services\Flag\Src\Flag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Components\Repositories\ComponentsRepository;

class ComponentsController extends Controller
{
    /**
     * @var \Modules\Components\Repositories\ComponentsRepository
     */
    private $componentsRepository;
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private $response;
    /**
     * @var \Illuminate\Translation\Translator
     */
    private $lang;

    public function __construct(ComponentsRepository $componentsRepository, ResponseFactory $response, Translator $lang)
    {
        $this->componentsRepository = $componentsRepository;
        $this->response = $response;
        $this->lang = $lang;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('components::index');
    }

    public function view(Request $request)
    {
        try {
            $data = $this->componentsRepository->getModules();

            if ($request->has('sort')) {
                $sort = explode('|', $request->get('sort'));
                $data = 'asc' === $sort[1] ? $data->sortBy($sort[0])->values()->all() : $data->sortByDesc($sort[0])->values()->all();
            }

            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data);
            $per_page = 10;
            $currentPageResults = $collection->slice(($currentPage - 1) * $per_page, $per_page)->all();
            $result['data'] = new LengthAwarePaginator($currentPageResults, \count($collection), $per_page);
            $result['data']->setPath($request->url());

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_FORBIDDEN;
        }

        return $this->response->json($result['data'], $result['status'], [], JSON_PRESERVE_ZERO_FRACTION);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('components::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('components::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('components::edit');
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
