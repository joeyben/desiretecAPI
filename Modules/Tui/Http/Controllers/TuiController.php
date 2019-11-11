<?php

namespace Modules\Tui\Http\Controllers;

use App\Models\Whitelabels\Whitelabel;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;
use Modules\Tui\Http\Requests\StoreWishRequest;

class TuiController extends Controller
{
    protected $adults = [];
    protected $kids = [];
    protected $catering = [];
    protected $duration = [];
    protected $ages = [];


    private $whitelabelId;

    const BODY_CLASS = 'landing';
    /**
     * @var WhitelabelsRepository
     */
    protected $whitelabel;
    protected $attachements;

    /* @param \Modules\Categories\Repositories\Contracts\CategoriesRepository $categories
     * @param \Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository $attachements
     * @param WhitelabelsRepository $whitelabel
     */
    public function __construct(WhitelabelsRepository $whitelabel, CategoriesRepository $categories, EloquentAttachmentsRepository $attachements)
    {
        $this->whitelabel = $whitelabel;
        $this->attachements = $attachements;
        $this->adults = $categories->getChildrenFromSlug('slug', 'adults');
        $this->kids = $categories->getChildrenFromSlug('slug', 'kids');
        $this->catering = $categories->getChildrenFromSlug('slug', 'hotel-catering');
        $this->duration = $this->getFullDuration($categories->getChildrenFromSlug('slug', 'duration'));
        $this->ages = $categories->getChildrenFromSlug('slug', 'ages');
        $this->whitelabelId = \Config::get('tui.id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $whitelabel = $this->whitelabel->getByName('Tui');

        return view('tui::index')->with([
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

        $html = view('tui::'.$layer)->with([
            'adults_arr'   => $this->adults,
            'kids_arr'     => $this->kids,
            'catering_arr' => $this->catering,
            'duration_arr' => $this->duration,
            'ages_arr'     => $this->ages,
            'request' => $request->all()
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
            $html = view('tui::'.$layer)->with([
                'adults_arr'   => $this->adults,
                'errors'       => $request->errors(),
                'kids_arr'     => $this->kids,
                'catering_arr' => $this->catering,
                'duration_arr' => $this->duration,
                'ages_arr'     => $this->ages,
                'request' => $request->all()
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        }

        $newUser = $user->createUserFromLayer(
            $request->only('first_name', 'last_name', 'email', 'password', 'is_term_accept', 'terms'),
            $this->whitelabelId
        );

        $wish = $this->createWishFromLayer($request, $wish);
        $html = view('tui::layer.created')->with([
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
     * @param UserRepository   $user
     * @param StoreWishRequest $request
     *
     * @return UserRepository $user
     */
    private function createUserFromLayer(StoreWishRequest $request, $user)
    {
        $input = $request->only('first_name', 'last_name', 'email', 'password', 'is_term_accept', 'terms');
        if ($new_user = $user->findByEmail($input['email'])) {
            access()->login($new_user);

            return $new_user;
        }
        $input['whitelabel_name'] = $this->whitelabel->getById(intval($this->whitelabelId))['display_name'];

        $new_user = $user->create($input);
        $new_user->storeToken();
        $new_user->attachWhitelabel($this->whitelabelId);
        access()->login($new_user);

        return $new_user;
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

        $input = $request->all();
        // TODO: Change to only not except. (Exmpl: only('destination', etc
        $extra = [
            'locationAttributes' => isset($input['locationAttributes']) ? $input['locationAttributes'] : '',
            'facilityAttributes'=> isset($input['facilityAttributes']) ? $input['facilityAttributes'] : '',
            'travelAttributes'=> isset($input['travelAttributes']) ? $input['travelAttributes'] : '',
            'maxStopOver'=> isset($input['maxStopOver']) ? $input['maxStopOver'] : '',
            'cities'=> isset($input['cities']) ? $input['cities'] : '',
            'ratings'=> isset($input['ratings']) ? $input['ratings'] : '',
            'recommendationRate'=> isset($input['recommendationRate']) ? $input['recommendationRate'] : '',
            'minPrice'=> isset($input['minPrice']) ? $input['minPrice'] : '',
            'roomType'=> isset($input['roomType']) ? $input['roomType'] : '',
            'earlyBird'=> isset($input['earlyBird']) ? $input['earlyBird'] : '',
            'familyAttributes'=> isset($input['familyAttributes']) ? $input['familyAttributes'] : '',
            'wellnessAttributes'=> isset($input['wellnessAttributes']) ? $input['wellnessAttributes'] : '',
            'sportAttributes'=> isset($input['sportAttributes']) ? $input['sportAttributes'] : '',
            'airlines'=> isset($input['airlines']) ? $input['airlines'] : '',
            'hotelChains' => isset($input['hotelChains']) ? $input['hotelChains'] : '',
            'operators' => isset($input['operators']) ? $input['operators'] : ''
        ];

        $request->merge([
            'featured_image' => 'bg.jpg',
            'extra_params' => json_encode($extra)
        ]);
        $new_wish = $wish->create(
            $request->except('variant', 'first_name', 'last_name', 'email',
                'password', 'is_term_accept', 'name', 'terms','ages1','ages2','ages3',
                'locationAttributes',
  'facilityAttributes',
  'travelAttributes',
  'maxStopOver',
  'cities',
  'ratings',
  'recommendationRate',
  'minPrice',
  'roomType',
  'earlyBird',
  'familyAttributes',
  'wellnessAttributes',
  'sportAttributes',
  'airlines',
  'hotelChains',
  'operators'),
             $this->whitelabelId
        );

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
}
