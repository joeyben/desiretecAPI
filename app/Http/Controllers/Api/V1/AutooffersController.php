<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Wishes\Wish;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Autooffers\Repositories\AutooffersRepository;
use Modules\Autooffers\Repositories\AutooffersTTRepository;
use Modules\Autooffers\Repositories\Eloquent\EloquentAutooffersRepository;

class AutooffersController extends APIController
{
    const BODY_CLASS = 'wish';

    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
        'Deleted'      => 'Deleted',
    ];

    protected $category = [
        '1'  => 1,
        '2'  => 2,
        '3'  => 3,
        '4'  => 4,
        '5'  => 5,
    ];

    protected $catering = [
        'any'           => 'any',
        'Breakfast'     => 'Breakfast',
        'Pension'       => 'Pension',
        'Full Pension'  => 'Full Pension',
        'All Inclusive' => 'All Inclusive',
    ];

    private $autooffers;
    private $TTautooffers;
    private $rules;

    public function __construct(WishesRepository $wish, AutooffersRepository $autooffers, AutooffersTTRepository $TTautooffers, EloquentAutooffersRepository $rules)
    {
        $this->wish = $wish;
        $this->autooffers = $autooffers;
        $this->TTautooffers = $TTautooffers;
        $this->rules = $rules;
    }

    public function index()
    {
        return view('frontend.autooffer.index');
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     * @param string                  $index
     *
     * @return mixed
     */
    public function details(Wish $wish, $index)
    {
        $offers = $this->autooffers->getOffersDataFromId($wish->id);
        $offer = $offers[$index];
        $body_class = 'autooffer_list';

        return view('frontend.offer.details', compact('wish', 'offer', 'body_class'));
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     * @param string                  $index
     *
     * @return mixed
     */
    public function ttdetails(Wish $wish, $index)
    {
        $offers = $this->autooffers->getOffersDataFromId($wish->id);
        $offer = $offers[$index];
        $body_class = 'autooffer_list';

        return view('autooffers::autooffer.details_tt', compact('wish', 'offer', 'body_class'));
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return mixed
     */
    public function createTT(Wish $wish)
    {
        $rules = $this->rules->getSettingsForWhitelabel((int) (getCurrentWhiteLabelId()));
        //dd(getRegionCode($wish->airport, 0));
        $this->TTautooffers->saveWishData($wish);
        //$response = $this->autooffers->getTrafficsData();
        $this->TTautooffers->getToken();
        $response = $this->TTautooffers->getTTData();
        $this->TTautooffers->storeMany($wish->id, $rules);

        return redirect()->to('offer/list/' . $wish->id);
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return mixed
     */
    public function create(Wish $wish)
    {
        //$rules = $this->rules->getSettingsForWhitelabel((int) (getCurrentWhiteLabelId()));
        //dd(getRegionCode($wish->airport, 0));
        //$this->autooffers->saveWishData($wish);
        //$response = $this->autooffers->getTrafficsData();
        //$this->autooffers->storeMany($response, $wish->id, $rules);

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

    public function list(int $wishId)
    {
        try {
            $offers['data'] = $this->autooffers->getOffersDataFromId($wishId);;

            return $this->responseJson($offers);

        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return Response
     */
    public function showttredirect(Wish $wish, string $token)
    {
        if (!$this->wish->validateToken($token)) {
            return redirect()->to('/');
        }

        $wlAutooffer = getWhitelabelAutooffers();
        $type = $wlAutooffer ? $wlAutooffer['type'] : 1;
        $url = $type == 0 ? '/offer/list/' : '/offer/ttlist/';

        return redirect()->to($url . $wish->id);
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return Response
     */
    public function showtt(Wish $wish)
    {
        $offers = $this->autooffers->getOffersDataFromId($wish->id);
        //dd($offers[0]);
        $body_class = 'autooffer_list';
        //dd($offers);
        return view('autooffers::autooffer.list_tt', compact('wish', 'offers', 'body_class'));
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

    public function testTT()
    {
        $this->TTautooffers->getToken();
        $this->TTautooffers->testTT();
    }
}
