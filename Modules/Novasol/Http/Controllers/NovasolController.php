<?php

namespace Modules\Novasol\Http\Controllers;

use App\Models\Whitelabels\Whitelabel;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;
use Modules\Novasol\Http\Requests\StoreWishRequest;
use Underscore\Parse;


class NovasolController extends Controller
{
    protected $adults = [];
    protected $kids = [];
    protected $pets = [];
    protected $duration = [];

    private $whitelabelId;

    const BODY_CLASS = 'landing';
    /**
     * @var WhitelabelsRepository
     */
    protected $whitelabel;
    protected $attachements;
    protected $categories;

    /* @param WhitelabelsRepository $whitelabel
     * @param \Modules\Categories\Repositories\Contracts\CategoriesRepository $categories
     * @param \Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository $attachements
     */
    public function __construct(WhitelabelsRepository $whitelabel, CategoriesRepository $categories, EloquentAttachmentsRepository $attachements)
    {
        $this->whitelabel = $whitelabel;
        $this->attachements = $attachements;
        $this->adults = $categories->getChildrenFromSlug('slug', 'adults');
        $this->kids = $categories->getChildrenFromSlug('slug', 'kids');
        $this->pets = $this->translatePets($categories->getChildrenFromSlug('slug', 'pets'));
        $this->duration = $this->getFullDuration($categories->getChildrenFromSlug('slug', 'duration'));
        $this->whitelabelId = \Config::get('novasol.id');
        $this->categories = $categories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $whitelabel = $this->whitelabel->getByName('Novasol');

        return view('novasol::index')->with([
            'display_name'  => $whitelabel['display_name'],
            'bg_image'      => $this->attachements->getAttachementsByType($this->whitelabelId, 'background')['url'],
            'logo'          => $this->attachements->getAttachementsByType($this->whitelabelId, 'logo')['url'],
            'body_class'    => $this::BODY_CLASS,
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
        $input = $request->only('variant');
        $layer = $input['variant'] === "eil-mobile" ? "layer.popup-mobile" : "layer.popup";

        $html = view('novasol::'.$layer)->with([
            'adults_arr'   => $this->adults,
            'kids_arr'     => $this->kids,
            'pets_arr' => $this->pets,
            'duration_arr' => $this->duration,
            'request' => $request->all(),
        ])->render();

        return response()->json(['success' => true, 'html'=>$html]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRepository   $user
     * @param StoreWishRequest $request
     * @param WishesRepository $wish
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreWishRequest $request, UserRepository $user, WishesRepository $wish)
    {
        $input = $request->all();
        if ($request->failed()) {
            $layer = $input['variant'] === "eil-mobile" ? "layer.popup-mobile" : "layer.popup";
            $html = view('novasol::'.$layer)->with([
                'adults_arr'   => $this->adults,
                'errors'       => $request->errors(),
                'kids_arr'     => $this->kids,
                'pets_arr' => $this->pets,
                'duration_arr' => $this->duration,
                'request' => $request->all()
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        }

        $newUser = $user->createUserFromLayer(
            $request->only('first_name', 'last_name', 'email', 'password', 'is_term_accept', 'terms'),
            $this->whitelabelId
        );

        $wish = $this->createWishFromLayer($request, $wish);
        $html = view('novasol::layer.created')->with([
            'token' => $newUser->token->token,
            'id'    => $wish->id
        ])->render();

        return response()->json(['success' => true, 'html'=>$html]);
    }

    private function setAdults()
    {
        for ($i = 1; $i <= 8; ++$i) {
            $this->adults[$i] = $i;
        }
        for ($i = 0; $i <= 3; ++$i) {
            $this->kids[$i] = $i;
        }
    }

    /**
     * Create new user from Layer.
     *
     * @param WishesRepository $wish
     * @param StoreWishRequest $request
     *
     * @return object
     */
    private function createWishFromLayer(StoreWishRequest $request, $wish)
    {
        $request->merge(['featured_image' => 'novasol.jpg']);
        $new_wish = $wish->create(
            $request->except('variant', 'first_name', 'last_name', 'email', 'password', 'is_term_accept', 'name', 'terms','pets'),
            $this->whitelabelId
        );
        $pets = $this->categories->getCategoryIdByParentValue('pets', $request->get('pets'));
        $wish->storeCategoryWish($pets, $new_wish);
        return $new_wish;
    }

    /**
     * @param array $duration
     *
     * @return array
     */
    private function getFullDuration($duration)
    {
        for ($i = 1; $i < 29; ++$i) {
            $night = 1 === $i ? 'Nacht' : 'Nächte';
            $duration[$i] = $i . ' ' . $night;
        }

        return $duration;
    }

    /**
     * @param array $pets
     *
     * @return array
     */
    private function translatePets($pets)
    {
        foreach ($pets as $key => $value) {
            $pets[$key] = trans('layer.pets.'.$value);
        }

        return $pets;
    }

    public function fillCountriesFromNovasolApi(){
        /*$url = 'https://safe.novasol.com/api/countries';

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
        $file = file_get_contents($url, false, $context);*/

        $file = <<<XML
        <countries>
            <country iso="056">Belgium</country>
            <country iso="826">United Kingdom</country>
            <country iso="280">Germany</country>
            <country iso="196">Cyprus</country>
            <country iso="191">Croatia</country>
            <country iso="380">Italy</country>
            <country iso="558">Nicaragua</country>
            <country iso="724">Spain</country>
            <country iso="620">Portugal</country>
            <country iso="703">Slovakia</country>
            <country iso="578">Norway</country>
            <country iso="705">Slovenia</country>
            <country iso="100">Bulgaria</country>
            <country iso="246">Finland</country>
            <country iso="250">France</country>
            <country iso="203">Czech Republic</country>
            <country iso="300">Greece</country>
            <country iso="752">Sweden</country>
            <country iso="008">Albania</country>
            <country iso="818">Egypt</country>
            <country iso="188">Costa Rica</country>
            <country iso="499">Montenegro</country>
            <country iso="630">Puerto Rico</country>
            <country iso="208">Denmark</country>
            <country iso="756">Switzerland</country>
            <country iso="348">Hungary</country>
            <country iso="792">Turkey</country>
            <country iso="352">Iceland</country>
            <country iso="442">Luxembourg</country>
            <country iso="040">Austria</country>
            <country iso="616">Poland</country>
            <country iso="528">Holland</country>
        </countries>
        XML;

        return $file;
        
        dd($coutry_codes);
    }

    public function fillAreasFromNovasolApi(){
        $countries_xml = $this->fillCountriesFromNovasolApi();
        $xml=simplexml_load_string($countries_xml);
            foreach ($xml as $country) {
                $url = 'https://safe.novasol.com/api/countries/'. $country['iso'];
                var_dump($url);
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

        dd(Parse::fromXML($file));
        }
    }
}
