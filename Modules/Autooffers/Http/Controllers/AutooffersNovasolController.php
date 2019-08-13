<?php

namespace Modules\Autooffers\Http\Controllers;

use App\Models\OfferFiles\OfferFile;
use App\Models\Wishes\Wish;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
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
        $offers = Autooffer::where('wish_id', $wish->id)->get();
        if($offers->count() == 0){
        //if(!isset($wish->id)){
            logger()->info('AufoofferNovasolController.php > create() wurde aufgerufen!');
            $this->autooffers->saveWishData($wish);
            $response = $this->autooffers->getNovasolData($this->service->prepareParamForNovasolApi($this->autooffers, $wish));
            $response = simplexml_load_string($response);
            $properties = $this->service->fetchAllProperties($response);
            $this->autooffers->storeMany($response, $properties, $wish->id);
        }
        $offers = Autooffer::where('wish_id', $wish->id)->get();
        foreach ($offers as $offer){
            $this->getProduct($offer->code);
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
        $images = [];
        $capacities = [];
        $rooms = [];
        $sizes = [];
        $autooffers = Autooffer::where('wish_id', $wish->id)->orderBy('totalPrice', 'asc')->paginate(5);
        foreach ($autooffers as $autooffer){
            $images[] = DB::table('offer_files')->select('file')->where('offer_id', $autooffer->code)->get();
            $capacities[] = DB::table('offer_files')->select('capacity')->where('offer_id', $autooffer->code)->get();
            $rooms[] = DB::table('offer_files')->select('room')->where('offer_id', $autooffer->code)->get();
            $sizes[] = DB::table('offer_files')->select('size')->where('offer_id', $autooffer->code)->get();
        }
        return view('autooffers::autooffer.show', [
            'autooffers' => $autooffers,
            'wish' => $wish,
            'images' => $images,
            'capacities' => $capacities,
            'rooms' => $rooms,
            'sizes' => $sizes
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
    public function toTheOffer($offer_id){
       $autooffer = Autooffer::find($offer_id);

       if(!is_null($autooffer)){
           $novasol_area    = DB::table('novasol_area')->select('*')->where('novasol_area_code', $autooffer->hotel_location_region_code)->first();
           $novasol_country = DB::table('novasol_country')->select('*')->where('id', $novasol_area->novasol_country_id)->first();
/*
           dd([
               'autooffer' => $autooffer,
               'novasol_area' => $novasol_area,
               'novasol_country' => $novasol_country,
               'wish' => $autooffer->wish
           ]);
*/
           $url = "https://www.novasol.de/ferienhaeuser/";
           $url .= str_replace(' ', '-', strtolower($novasol_country->name)).'/';
           $url .= str_replace(' ', '-', strtolower($novasol_area->name)).'/';
           $url .= str_replace(' ', '-', 'ferienwohnung-'.strtolower($autooffer->hotel_location_name)).'-'.strtolower($autooffer->hotel_code).'?';
           $url .= 'agency=2051402&';
           if($autooffer->wish->adults > 0){
               $url .= 'adults='.$autooffer->wish->adults.'&';
           }
           if($autooffer->wish->kids > 0){
               $url .= 'children='.$autooffer->wish->kids.'&';
           }
           if($autooffer->wish->kids > 0){
               $url .= 'children='.$autooffer->wish->kids.'&';
           }
           $url .= 'from='. str_replace('-', '', $autooffer->wish->earliest_start).'&';
           $url .= 'to='. str_replace('-', '', $autooffer->wish->latest_return);

//           https://www.novasol.de/ferienhaeuser/spanien/hinterland/ferienwohnung-córdoba-eac214?adults=2&children=0&from=20190812&to=20190819 => von uns erstellt
//           https://www.novasol.de/ferienhaeuser/spanien/andalusien/ferienwohnung-cordoba-eac214?adults=2&children=3&from=20190812&to=20190819 => URL bei NOVASOL


           //dd($url);

           // todo: The NOVASOL-ID is mising into the URL
           return Redirect::away($url);
       }
    }

    public function getProduct($id)
    {
        $url = 'https://safe.novasol.com/api/products/'. $id . '?salesmarket=208&season=2019';

        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Accept-language: en\r\n" .
                    "Key: WEvoSrIfHvZtVhlyKIWYfP5WjGcPVB\r\n" .
                    "Host: novasol.reise-wunsch.com\r\n"
            ]
        ];

        $context = stream_context_create($opts);

        // Open the file using the HTTP headers set above
        $file = file_get_contents($url, false, $context);
        $arr = [];
        $product = simplexml_load_string($file);
        $offer_file =  DB::table('offer_files')->select('file')->where('offer_id', $id)->get();
        if($offer_file->count() == 0) {
            foreach ($product->pictures as $picture) {
                foreach ($picture->picture as $pic) {
                    $arr[] = [
                        'offer_id' => $id,
                        'file' => $pic->domain . $pic->path . $pic->file,
                        'capacity' => $product->information->adultCount,
                        'room' => $product->buildings->building->room->count(),
                        'size' => $product->features->feature[0]->unit['size']
                    ];
                }
            }
            DB::table('offer_files')->insert($arr);
        }
    }
}
