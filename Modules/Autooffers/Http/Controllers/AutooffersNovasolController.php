<?php

namespace Modules\Autooffers\Http\Controllers;

use App\Models\Wishes\Wish;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\Autooffers\Entities\Autooffer;
use Modules\Autooffers\Http\Services\AutooffersNovasolService;
use Modules\Autooffers\Repositories\AutooffersNovasolRepository;
use Mpdf\Tag\Input;
use Nwidart\Modules\Collection;

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
     * @var AutooffersNovasolService
     */
    private $service;

    /**
     * @param \Modules\Autooffers\Repositories\AutooffersRepository $autooffers
     */
    public function __construct(AutooffersNovasolRepository $autooffers, AutooffersNovasolService $service)
    {
        $this->autooffers = $autooffers;
        $this->service    = $service;
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
    public function create(Wish $wish){
        $offersCounter = Autooffer::where('wish_id', $wish->id)->count();
        if($offersCounter == 0){
        //if(!isset($wish->id)){
            logger()->info('AufoofferNovasolController.php > create() wurde aufgerufen!');
            $this->autooffers->saveWishData($wish);
            $response = $this->autooffers->getNovasolData($this->service->prepareParamForNovasolApi($this->autooffers, $wish));
            $response = simplexml_load_string($response);
            $properties = $this->service->fetchAllProperties($response);
            $this->autooffers->storeMany($response, $properties, $wish->id);
        }

        return redirect()->to('novasoloffer/list/' . $wish->id);
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
        // todo: die NOVASOL-Daten abspeichern!!!
        logger()->info('AufoofferNovasolController.php > store() wurde aufgerufen!');
        $this->autooffers->saveWishData($request->all());
        $response = $this->autooffers->getNovasolData($this->service->prepareParamForNovasolApi($this->autooffers, $request->all()));

        //$response = $this->autooffers->getTrafficsData();
        $this->autooffers->storeMany($response);

        //dd(['request' => $request, 'response' => $response]);
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return Response
     */
    public function show(Wish $wish){

        $autooffers = Autooffer::where('wish_id', $wish->id)->orderBy('totalPrice', 'asc')->paginate(5);
        return view('autooffers::autooffer.show', [
            'autooffers' => $autooffers,
            'wish' => $wish
        ]);
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

    /**
     * Creates the url to novasol and opens it on new tab
     */
    public function toTheOffer($wishid){
       $autooffer = Autooffer::where('wish_id', $wishid)->first();
       dd(json_decode($autooffer->hotel_data));
       if(!is_null($autooffer)){
           $url = "https://www.novasol.de/ferienhaeuser/";
           $url .= str_replace(' ', '-', strtolower($autooffer->destination)).'/';


           $url .= str_replace(' ', '-', strtolower($autooffer->destination)).'/';
           $url .= str_replace(' ', '-', strtolower($autooffer->catering)).'/';
           $url .= '?adults='. str_replace(' Erwachsene', '',$autooffer->adults);
           $url .= '&children='. $autooffer->kids;
           $url .= '&from='. str_replace('-', '', $autooffer->earliest_start);
           $url .= '&to='. str_replace('-', '', $autooffer->latest_return);

           // todo: The NOVASOL-ID is mising into the URL
           return Redirect::away($url);
       }
    }
}
