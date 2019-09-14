<?php

namespace Modules\Autooffers\Http\Controllers;

use App\Models\Wishes\Wish;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Autooffers\Repositories\AutooffersRepository;
use Modules\Autooffers\Repositories\Eloquent\EloquentAutooffersRepository;

class AutooffersController extends Controller
{
    const BODY_CLASS = 'wish';
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
     * @var \Modules\Wishes\Repositories\Contracts\WishesRepository
     */
    private $autooffers;

    /**
     * @var \Modules\Wishes\Repositories\Contracts\WishesRepository
     */
    private $rules;

    /**
     * @param \Modules\Autooffers\Repositories\AutooffersRepository $autooffers
     * @param \Modules\Autooffers\Repositories\Eloquent\EloquentAutooffersRepository $rules
     */
    public function __construct(AutooffersRepository $autooffers, EloquentAutooffersRepository $rules)
    {
        $this->autooffers = $autooffers;
        $this->rules = $rules;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('autooffers::index');
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     * @param string $index
     * @return mixed
     */
    public function details(Wish $wish, $index)
    {
        $offers = $this->autooffers->getOffersDataFromId($wish->id);
        $offer =  $offers[$index];
        $body_class = 'autooffer_list';
        return view('autooffers::autooffer.details', compact('wish', 'offer', 'body_class'));
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return mixed
     */
    public function create(Wish $wish)
    {
        $rules = $this->rules->getSettingsForWhitelabel(intval(getCurrentWhiteLabelId()));
        //dd(getRegionCode($wish->airport, 0));
        $this->autooffers->saveWishData($wish);
        $response = $this->autooffers->getTrafficsData();
        $this->autooffers->storeMany($response, $wish->id, $rules);

        return redirect()->to('offer/list/' . $wish->id);
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
        $this->autooffers->saveWishData($request->all());
        $response = $this->autooffers->getTrafficsData();
        $this->autooffers->storeMany($response);
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return Response
     */
    public function show(Wish $wish)
    {
        $offers = $this->autooffers->getOffersDataFromId($wish->id);
        //dd($offers[0]);
        $body_class = 'autooffer_list';
        return view('autooffers::autooffer.list', compact('wish', 'offers', 'body_class'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('autooffers::edit');
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
