<?php

namespace Modules\Tui\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\Whitelabels\Whitelabel;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;

class TuiController extends Controller
{
    protected $adults = [];

    protected $kids = [];

    /**
     * @var WhitelabelsRepository
     */
    protected $whitelabel;

    /**
     * @param WhitelabelsRepository $whitelabel
     */
    public function __construct(WhitelabelsRepository $whitelabel)
    {
        $this->whitelabel = $whitelabel;
        $this->setAdults();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $whitelabel = $this->whitelabel->getByName('tui');

        return view('tui::index')->with([
            'display_name' => $whitelabel['display_name'],
            'bg_image' => $whitelabel['bg_image'],
        ]);
    }

    /**
     * Return the specified resource.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $html =  view('tui::layer.popup')->with([
            'adults_arr' => $this->adults
        ])->render();

        return response()->json(array('success' => true, 'html'=>$html));
    }


    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    private function setAdults(){
        for($i=1; $i<=8;$i++){
            array_push($this->adults,$i);
        }
    }
}
