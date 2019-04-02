<?php

namespace Modules\Trendtours\Http\Controllers;

use App\Models\Whitelabels\Whitelabel;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;
use Modules\Trendtours\Http\Requests\StoreWishRequest;

class TrendtoursController extends Controller
{
    protected $adults = [];
    protected $months = [];
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
        $this->adults = $this->putPersonLabel($categories->getChildrenFromSlug('slug', 'adults'), 'adults');
        $this->months = $this->transformMonth($categories->getChildrenFromSlug('slug', 'months'));
        $this->catering = $categories->getChildrenFromSlug('slug', 'hotel-catering');
        $this->duration = $this->getFullDuration($categories->getChildrenFromSlug('slug', 'duration'));
        $this->whitelabelId = \Config::get('trendtours.id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $whitelabel = $this->whitelabel->getByName('Trendtours');

        return view('trendtours::index')->with([
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
        $html = view('trendtours::'.$layer)->with([
            'adults_arr'   => $this->adults,
            'months_arr'     => $this->months,
            'catering_arr' => $this->catering,
            'duration_arr' => $this->duration,
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
        if ($request->failed()) {
            $html = view('trendtours::layer.popup')->with([
                'adults_arr'   => $this->adults,
                'errors'       => $request->errors(),
                'months_arr'     => $this->months,
                'catering_arr' => $this->catering,
                'duration_arr' => $this->duration,
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        }

        $newUser = $this->createUserFromLayer($request, $user);
        $wish = $this->createWishFromLayer($request, $wish);
        $html = view('trendtours::layer.created')->with([
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
        $request->merge(
            [
                'first_name'     => 'John',
                'last_name'      => 'Doe',
                'password'       => 'master2019',
                'is_term_accept' => true
            ]
        );
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
        $input = $request->except('variant', 'first_name', 'last_name', 'email', 'password', 'is_term_accept', 'name', 'terms');
        $input['earliest_start'] = \Illuminate\Support\Carbon::createFromFormat('m.Y', $input['earliest_start'])->format('d.m.Y');
        $input['latest_return'] = "01.01.2020";
        $new_wish = $wish->create($input);

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
     * @param array $children
     * @param string $type
     *
     * @return array
     */
    private function putPersonLabel($children, $type)
    {

        foreach ($children as $key => $value) {
            $label = $type ? " ".trans_choice('labels.categories.'.$type, intval($value)) : "";
            $children[$key] = $value."".$label;
        }

        return $children;
    }

    /**
    * @param array $children
    * @param string $type
    *
    * @return array
    */
    private function transformMonth($children)
    {

        foreach ($children as $key => $value) {
            $date_arr = explode('.', $value);
            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $date_arr[1]."-".$date_arr[0]."-01");
            $children[$key] = $date->format('F Y');
        }

        return $children;
    }
}
