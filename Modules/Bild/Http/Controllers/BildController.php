<?php

namespace Modules\Bild\Http\Controllers;

use App\Models\Whitelabels\Whitelabel;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository;
use Modules\Bild\Http\Requests\StoreWishRequest;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;

class BildController extends Controller
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
        $this->whitelabelId = \Config::get('bild.id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $whitelabel = $this->whitelabel->getByName('Bild');

        return view('bild::index')->with([
            'display_name'  => $whitelabel['display_name'],
            'color'         => $whitelabel['color'],
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
        $layer = 'eil-mobile' === $input['variant'] ? 'layer.popup-mobile' : 'layer.popup';
        $whitelabel = $this->whitelabel->getByName('Bild');

        $html = view('bild::' . $layer)->with([
            'adults_arr'   => $this->adults,
            'kids_arr'     => $this->kids,
            'catering_arr' => $this->catering,
            'duration_arr' => $this->duration,
            'request'      => $request->all(),
            'color'        => $whitelabel['color'],
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
        $whitelabel = $this->whitelabel->getByName('Bild');

        $input = $request->all();
        if ($request->failed()) {
            $layer = 'eil-mobile' === $input['variant'] ? 'layer.popup-mobile' : 'layer.popup';
            $html = view('bild::' . $layer)->with([
                'adults_arr'   => $this->adults,
                'errors'       => $request->errors(),
                'kids_arr'     => $this->kids,
                'catering_arr' => $this->catering,
                'duration_arr' => $this->duration,
                'request'      => $request->all(),
                'color'        => $whitelabel['color'],
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        }

        $newUser = $user->createUserFromLayer(
            $request->only('first_name', 'last_name', 'email', 'password', 'is_term_accept', 'terms'),
            $this->whitelabelId
        );

        $wish = $this->createWishFromLayer($request, $wish);
        $html = view('bild::layer.created')->with([
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
        $input['whitelabel_name'] = $this->whitelabel->getById((int) ($this->whitelabelId))['display_name'];

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
        $request->merge(['featured_image' => 'bg.jpg']);

        $new_wish = $wish->create(
            $request->except('variant', 'first_name', 'last_name', 'email', 'password', 'is_term_accept', 'name', 'terms'),
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
