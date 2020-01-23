<?php

namespace Modules\DesiretecDemo\Http\Controllers;

use App\Jobs\callTrafficsApi;
use App\Jobs\sendAutoOffersMail;
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
use Modules\DesiretecDemo\Http\Requests\StoreWishRequest;

class DesiretecDemoController extends Controller
{
    const BODY_CLASS = 'landing';

    protected $whitelabel;
    protected $whitelabelId;
    protected $attachements;
    protected $adults = [];
    protected $kids = [];
    protected $ages = [];
    protected $catering = [];
    protected $duration = [];

    /* @param \Modules\Categories\Repositories\Contracts\CategoriesRepository $categories
     * @param \Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository $attachements
     * @param WhitelabelsRepository $whitelabel
     */
    public function __construct(WhitelabelsRepository $whitelabel, CategoriesRepository $categories, EloquentAttachmentsRepository $attachements)
    {
        $this->whitelabel = $whitelabel;
        $this->whitelabelId = \Config::get('desiretecdemo.id');
        $this->attachements = $attachements;
        $this->adults = $categories->getChildrenFromSlug('slug', 'adults');
        $this->kids = $categories->getChildrenFromSlug('slug', 'kids');
        $this->catering = $categories->getChildrenFromSlug('slug', 'hotel-catering');
        $this->duration = $this->getFullDuration($categories->getChildrenFromSlug('slug', 'duration'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('desiretecdemo::index')->with([
            'display_name'  => $this->whitelabel->getById($this->whitelabelId)['display_name'],
            'color'         => $this->whitelabel->getById($this->whitelabelId)['color'],
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
        $html = view('desiretecdemo::layer.popup')->with([
            'adults_arr'   => $this->adults,
            'kids_arr'     => $this->kids,
            'catering_arr' => $this->catering,
            'duration_arr' => $this->duration,
            'ages_arr'     => $this->ages,
            'request'      => $request->all(),
            'color'        => $this->whitelabel->getById($this->whitelabelId)['color'],
        ])->render();

        return response()->json(['success' => true, 'html'=>$html]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRepository   $user
     * @param \Modules\Desiretecdemo\Http\Requests\StoreWishRequest $request
     * @param WishesRepository $wish
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreWishRequest $request, UserRepository $user, WishesRepository $wish)
    {
        $whitelabel = $this->whitelabel->getByName('Desiretecdemo');

        $is_autooffer = false;
        $input = $request->all();
        $wishRepo = $wish;
        if ($request->failed()) {
            $html = view('desiretecdemo::layer.popup')->with([
                'errors'       => $request->errors(),
                'adults_arr'   => $this->adults,
                'kids_arr'     => $this->kids,
                'catering_arr' => $this->catering,
                'duration_arr' => $this->duration,
                'ages_arr'     => $this->ages,
                'color'        => $this->whitelabel->getById($this->whitelabelId)['color'],
                'request'      => $request->all()
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

            $wishJob = (new callTrafficsApi($wish->id, $this->whitelabelId, $newUser->id));
            dispatch($wishJob);
            //$wishRepo->callTraffics($wish->id);

            $view = \View::make('wishes::emails.autooffer',
                [
                    'url'=> $wish->whitelabel->domain . '/offer/olist/' . $wish->id . '/' . $newUser->token->token
                ]
            );
            $contents = $view->render();

            $details = [
                'email' => $newUser->email,
                'token' => $newUser->token->token,
                'type' => 0,
                'email_name' => trans('autooffers.email.name'),
                'email_subject' => trans('autooffer.email.subject'),
                'email_content' => $contents,
                'current_wl_email' => getCurrentWhiteLabelEmail()
            ];
            dispatch((new sendAutoOffersMail($details, $wish->id, getCurrentWhiteLabelEmail()))->delay(Carbon::now()->addMinutes(rand(1,2))));
            $is_autooffer = true;
        }

        $html = view('desiretecdemo::layer.created')->with([
            'token' => $newUser->token->token,
            'id'    => $wish->id,
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
