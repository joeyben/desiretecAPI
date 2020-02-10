<?php

namespace Modules\Reiserebellen\Http\Controllers;

use App\Models\Whitelabels\Whitelabel;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;
use Modules\Reiserebellen\Http\Requests\StoreWishRequest;

class ReiserebellenController extends Controller
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
        $this->whitelabelId = \Config::get('reiserebellen.id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $whitelabel = $this->whitelabel->getByName('Reiserebellen');

        return view('reiserebellen::index')->with([
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, WishesRepository $wish)
    {
        $whitelabel = $this->whitelabel->getByName('Reiserebellen');
        $wishRepo = $wish;
        $html = view('reiserebellen::layer.popup')->with([
            'adults_arr'   => $this->adults,
            'kids_arr'     => $this->kids,
            'catering_arr' => $this->catering,
            'duration_arr' => $this->duration,
            'ages_arr'     => $this->ages,
            'request'      => $request->all(),
            'color'        => $whitelabel['color'],
            'ruleType'     => $wishRepo->getRuleType()
        ])->render();

        return response()->json(['success' => true, 'html'=>$html]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreWishRequest $request, UserRepository $user, WishesRepository $wish)
    {
        $whitelabel = $this->whitelabel->getByName('Reiseexperten');
        $is_autooffer = false;
        $input = $request->all();
        $wishRepo = $wish;

        if ($request->failed()) {
            $html = view('reiserebellen::layer.popup')->with([
                'adults_arr'   => $this->adults,
                'errors'       => $request->errors(),
                'kids_arr'     => $this->kids,
                'catering_arr' => $this->catering,
                'duration_arr' => $this->duration,
                'ages_arr'     => $this->ages,
                'request'      => $request->all(),
                'color'        => $whitelabel['color'],
                'ruleType'     => $wishRepo->getRuleType()
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        }

        $newUser = $user->createUserFromLayer(
            $request->only('first_name', 'last_name', 'email', 'password', 'is_term_accept', 'terms'),
            $this->whitelabelId
        );

        $wish = $this->createWishFromLayer($request, $wish);

        $wishTye = $wishRepo->manageRules($wish);

        if ($wishTye > 0) {
            $wishJob = (new \App\Jobs\callTrafficsApi($wish->id, $this->whitelabelId, $newUser->id));
            dispatch($wishJob);
            //$wishRepo->callTraffics($wish->id);

            $view = \View::make('wishes::emails.autooffer',
                [
                    'url'=> $wish->whitelabel->domain . '/offer/olist/' . $wish->id . '/' . $newUser->token->token
                ]
            );
            $contents = $view->render();

            $details = [
                'email'            => $newUser->email,
                'token'            => $newUser->token->token,
                'type'             => 0,
                'email_name'       => trans('autooffers.email.name'),
                'email_subject'    => trans('autooffer.email.subject'),
                'email_content'    => $contents,
                'current_wl_email' => getCurrentWhiteLabelEmail()
            ];
            dispatch((new \App\Jobs\sendAutoOffersMail($details, $wish->id, getCurrentWhiteLabelEmail()))->delay(Carbon::now()->addMinutes(rand(1, 2))));
            $is_autooffer = true;
        }

        $html = view('reiserebellen::layer.created')->with([
            'token'    => $newUser->token->token,
            'id'       => $wish->id,
            'is_auto'  => $is_autooffer
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
     * @param UserRepository $user
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
     *
     * @return object
     */
    private function createWishFromLayer(StoreWishRequest $request, $wish)
    {
        $input = $request->all();

        $ages1 = isset($input['ages1']) ? $input['ages1'] . ',' : '';
        $ages2 = isset($input['ages2']) ? $input['ages2'] . ',' : '';
        $ages3 = isset($input['ages3']) ? $input['ages3'] . ',' : '';
        $ages4 = isset($input['ages4']) ? $input['ages4'] : '';
        $ages = rtrim($ages1 . $ages2 . $ages3 . $ages4, ',');

        $request->merge(['featured_image' => 'bg.jpg', 'ages' => $ages]);

        $new_wish = $wish->create(
            $request->except('variant', 'first_name', 'last_name', 'email', 'password', 'is_term_accept', 'name', 'terms', 'ages1', 'ages2', 'ages3', 'ages4'),
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

    public function getPDF()
    {
        return view('reiserebellen::layer.pdf');
    }
}
