<?php

namespace Modules\Autooffers\Http\Controllers;

use App\Models\Wishes\Wish;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Autooffers\Repositories\AutooffersNovasolRepository;

class AutooffersNovasolController extends Controller
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
     * @param \Modules\Autooffers\Repositories\AutooffersRepository $autooffers
     */
    public function __construct(AutooffersNovasolRepository $autooffers)
    {
        $this->autooffers = $autooffers;
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
     *
     * @return mixed
     */
    public function details(Wish $wish)
    {


        return view('autooffers::autooffer.details');
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return mixed
     */
    public function create(Wish $wish)
    {
        $params = [
            'country' => '280',
            'company' => 'nov',
            'arrival' => str_replace(['-'], [''], $wish->earliest_start),
            'departure' =>str_replace(['-'], [''], $wish->latest_return),
            'salesmarket' => '280',
            'adults' => $wish->adults,
        ];
        $this->autooffers->saveWishData($wish);
        $response = $this->autooffers->getNovasolData($params);
        var_dump($response);
        //$this->autooffers->storeMany($response, $wish->id);

        //return redirect()->to('novasoloffer/list/' . $wish->id);
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
        //$this->autooffers->saveWishData($request->all());
        //$response = $this->autooffers->getTrafficsData();
        //$this->autooffers->storeMany($response);
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return Response
     */
    public function show(Wish $wish)
    {
        $offers = $this->autooffers->getOffersDataFromId($wish->id);

        return view('autooffers::autooffer.show', compact('wish', 'offers'));
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
