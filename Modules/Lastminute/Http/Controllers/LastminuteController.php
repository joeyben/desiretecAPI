<?php

namespace Modules\Lastminute\Http\Controllers;

use App\Jobs\callTTApi;
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
use Modules\Lastminute\Http\Requests\StoreWishRequest;

class LastminuteController extends Controller
{
    protected $adults = [];
    protected $kids = [];
    protected $catering = [];
    protected $duration = [];
    protected $budget = [];
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
        $this->budget = $categories->getChildrenFromSlug('slug', 'prices');
        $this->ages = $categories->getChildrenFromSlug('slug', 'ages');
        $this->whitelabelId = \Config::get('lastminute.id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $whitelabel = $this->whitelabel->getByName('Lastminute');

        return view('lastminute::index')->with([
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
        $whitelabel = $this->whitelabel->getByName('Lastminute');

        $html = view('lastminute::layer.popup')->with([
            'adults_arr'   => $this->adults,
            'kids_arr'     => $this->kids,
            'catering_arr' => $this->catering,
            'duration_arr' => $this->duration,
            'budget_arr'   => $this->budget,
            'ages_arr'     => $this->ages,
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
        $whitelabel = $this->whitelabel->getByName('Lastminute');

        if ($request->failed()) {
            $html = view('lastminute::layer.popup')->with([
                'adults_arr'   => $this->adults,
                'errors'       => $request->errors(),
                'kids_arr'     => $this->kids,
                'catering_arr' => $this->catering,
                'duration_arr' => $this->duration,
                'budget_arr'   => $this->budget,
                'ages_arr'     => $this->ages,
                'request'      => $request->all(),
                'color'        => $whitelabel['color'],
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        }

        $newUser = $this->createUserFromLayer($request, $user);
        $wish = $this->createWishFromLayer($request, $wish);

        $wishJob = (new callTTApi($wish->id))->delay(Carbon::now()->addSeconds(3));
        dispatch($wishJob);

        $view = \View::make('wishes::emails.autooffer',
            [
                'url'=> $wish->whitelabel->domain . '/offer/olist/' . $wish->id . '/' . $newUser->token->token
            ]
        );
        $contents = $view->render();

        $details = [
            'email' => $newUser->email,
            'token' => $newUser->token->token,
            'email_name' => trans('autooffers.email.name'),
            'email_subject' => trans('autooffer.email.subject'),
            'email_content' => $contents,
            'current_wl_email' => getCurrentWhiteLabelEmail(),
            'type'  => 0
        ];
        dispatch((new sendAutoOffersMail($details, $wish->id, getCurrentWhiteLabelEmail()))->delay(Carbon::now()->addSeconds(1)));

        $html = view('lastminute::layer.created')->with([
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
        $input = $request->all();
        $ages1 = isset($input['ages1']) ? $input['ages1']."," : '';
        $ages2 = isset($input['ages2']) ? $input['ages2']."," : '';
        $ages3 = isset($input['ages3']) ? $input['ages3']."," : '';
        $ages4 = isset($input['ages4']) ? $input['ages4'] : '';
        $ages = rtrim($ages1.$ages2.$ages3.$ages4, ",");


        $request->merge(['featured_image' => 'bg.jpg','ages' => $ages]);

        $new_wish = $wish->create(
            $request->except('variant', 'first_name', 'last_name', 'email', 'password', 'is_term_accept', 'name', 'terms', 'ages1', 'ages2', 'ages3'),
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
        for ($i = 1; $i < 23; ++$i) {
            $night = 1 === $i ? 'Tag' : 'Tage';
            $duration[$i] = $i . ' ' . $night;
        }

        return $duration;
    }

    public function testAPI()
    {
        $curl = curl_init();
        $auth_data = [
            'username'  => 'MKT_315150_DE',
            'password' 	=> '!9kj7g6f5d4s3A1',
            'client_id' => 'gateway',
            'grant_type'=> 'password'
        ];

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $auth_data);
        // curl_setopt($curl, CURLOPT_URL, 'https://staging-auth.ws.traveltainment.eu:443/SystemUser-BasicAccessLevel/protocol/openid-connect/token');
        curl_setopt($curl, CURLOPT_URL, 'https://de-staging-ttxml.traveltainment.eu/TTXml-1.8/DispatcherWS/SystemUser-BasicAccessLevel/protocol/openid-connect/token');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $result = curl_exec($curl);
        if (!$result) {
            die('Connection Failure');
        }
        curl_close($curl);
        echo $result;
    }

    public function getHotels(Request $request)
    {
        $url = 'https://test.api.amadeus.com/v2/shopping/hotel-offers?cityCode=MAD';
        $access_token = $this->testAPI();
        // use key 'http' even if you send the request to https://...
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
                    'Authorization: Bearer ' . $access_token . "\r\n",
                'method'  => 'GET',
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $contents = utf8_encode($result);
        $results = json_decode($contents);

        dd($results);
    }
}
