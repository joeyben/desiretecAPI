<?php

namespace Modules\Tui\Http\Controllers;

use App\Models\Whitelabels\Whitelabel;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Tui\Http\Requests\StoreWishRequest;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;

class TuiController extends Controller
{
    protected $adults = [];
    protected $kids = [];
    protected $catering = [];
    protected $duration = [];

    private $whitelabelId;

    const BODY_CLASS = 'landing';
    /**
     * @var WhitelabelsRepository
     */
    protected $whitelabel;

    /* @param \Modules\Categories\Repositories\Contracts\CategoriesRepository $categories
     * @param WhitelabelsRepository $whitelabel
     */
    public function __construct(WhitelabelsRepository $whitelabel, CategoriesRepository $categories)
    {
        $this->whitelabel = $whitelabel;
        $this->adults = $categories->getChildrenFromSlug('slug', 'adults');
        $this->kids = $categories->getChildrenFromSlug('slug', 'kids');
        $this->catering = $categories->getChildrenFromSlug('slug', 'hotel-catering');
        $this->duration = $this->getFullDuration($categories->getChildrenFromSlug('slug', 'duration'));
        $this->whitelabelId = \Config::get('tui.id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $whitelabel = $this->whitelabel->getByName('tui');

        return view('tui::index')->with([
            'display_name' => $whitelabel['display_name'],
            'bg_image'     => $whitelabel['bg_image'],
            'body_class'         => $this::BODY_CLASS,
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
        $html = view('tui::layer.popup')->with([
            'adults_arr' => $this->adults,
            'kids_arr' => $this->kids,
            'catering_arr' => $this->catering,
            'duration_arr' => $this->duration,
        ])->render();

        return response()->json(['success' => true, 'html'=>$html]);
    }

    /**
     * Store a newly created resource in storage.
     * @param UserRepository $user
     * @param StoreWishRequest $request
     * @param WishesRepository $wish
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreWishRequest $request, UserRepository $user, WishesRepository $wish)
    {

        if ($request->failed()) {
            $html = view('tui::layer.popup')->with([
                'adults_arr' => $this->adults,
                'errors'      => $request->errors(),
                'kids_arr' => $this->kids,
                'catering_arr' => $this->catering,
                'duration_arr' => $this->duration,
            ])->render();
            return response()->json(['success' => true, 'html'=>$html]);
        }


        $newUser = $this->createUserFromLayer($request, $user);
        $wish = $this->createWishFromLayer($request, $wish);
        $html = view('tui::layer.created')->with([
            'token' => $newUser->token->token,
            'id' => $wish->id
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
     * @param UserRepository $user
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
        $request->merge(
            array(
                'first_name' => "John",
                'last_name' => "Doe",
                "password" => "tui2019",
                "is_term_accept" => true
            )
        );
        $new_user = $user->create($input);
        $new_user->storeToken();
        $new_user->attachWhitelabel($this->whitelabelId);
        access()->login($new_user);

        return $new_user;
    }

    /**
     * Create new user from Layer.
     * @param WishesRepository $wish
     * @param StoreWishRequest $request
     *
     * @return object
     */

    private function createWishFromLayer(StoreWishRequest $request, $wish)
    {

        $new_wish = $wish->create($request->except('variant', 'first_name', 'last_name', 'email', 'password', 'is_term_accept', 'name', 'terms'));
        return $new_wish;
    }

    /**
     * @param array $duration
     *
     * @return array
     */

    private function getFullDuration($duration)
    {

        for ($i = 1; $i < 29; $i++) {
            $night = $i === 1 ? "Nacht" : "Nächte";
            $duration[$i] = $i." ".$night;
        }

        return $duration;
    }
}
