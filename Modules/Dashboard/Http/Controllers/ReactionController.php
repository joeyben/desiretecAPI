<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\Has;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereDay;
use App\Repositories\Criteria\WhereMonth;
use App\Repositories\Criteria\WhereYear;
use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Wishes\Repositories\Contracts\WishesRepository;

class ReactionController extends Controller
{
    /**
     * @var \Modules\Wishes\Repositories\Contracts\WishesRepository
     */
    private $wishes;
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

    public function __construct(WishesRepository $wishes, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon)
    {
        $this->wishes = $wishes;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function timeByMonth(Request $request)
    {
        try {
            $wishesWithOffers = $this->wishes->withCriteria([
                new ByWhitelabel(),
                new Where('wishes.whitelabel_id', $request->get('whitelabelId')),
                new WhereYear($this->carbon->nowWithSameTz()->format('Y')),
                new WhereMonth($this->carbon->nowWithSameTz()->format('m')),
                new Has('offers'),
            ])->all();

            $diffInHours = 0;
            $count = 0;
            foreach ($wishesWithOffers as $wo) {
                ++$count;
                $wishDate = $this->carbon->parse($wo->created_at);
                $offerDate = $this->carbon->parse($wo->offers->first()->created_at);
                $diffInHours += $wishDate->diffInHours($offerDate);
            }

            $result['reactionTime'] = $wishesWithOffers->count() > 0 ? $diffInHours / $wishesWithOffers->count() : 0;
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function timeByDay(Request $request)
    {
        try {
            $wishesWithOffers = $this->wishes->withCriteria([
                new ByWhitelabel(),
                new Where('wishes.whitelabel_id', $request->get('whitelabelId')),
                new WhereYear($this->carbon->nowWithSameTz()->format('Y')),
                new WhereMonth($this->carbon->nowWithSameTz()->format('m')),
                new WhereDay($this->carbon->nowWithSameTz()->format('d')),
                new Has('offers'),
            ])->all();

            $diffInHours = 0;
            $count = 0;
            foreach ($wishesWithOffers as $wo) {
                ++$count;
                $wishDate = $this->carbon->parse($wo->created_at);
                $offerDate = $this->carbon->parse($wo->offers->first()->created_at);
                $diffInHours += $wishDate->diffInHours($offerDate);
            }

            $result['reactionTime'] = $wishesWithOffers->count() > 0 ? $diffInHours / $wishesWithOffers->count() : 0;
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('dashboard::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('dashboard::create');
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
        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('dashboard::edit');
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
