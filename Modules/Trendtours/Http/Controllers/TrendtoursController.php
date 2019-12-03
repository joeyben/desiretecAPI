<?php

namespace Modules\Trendtours\Http\Controllers;

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
    protected $categories;

    /* @param \Modules\Categories\Repositories\Contracts\CategoriesRepository $categories
     * @param \Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository $attachements
     * @param WhitelabelsRepository $whitelabel
     */
    public function __construct(WhitelabelsRepository $whitelabel, CategoriesRepository $categories, EloquentAttachmentsRepository $attachements)
    {
        $this->whitelabel = $whitelabel;
        $this->attachements = $attachements;
        $this->adults = $categories->getChildrenFromSlug('slug', 'adults');
        $this->months = $this->transformMonth($categories->getChildrenFromSlug('slug', 'months'));
        $this->catering = $categories->getChildrenFromSlug('slug', 'hotel-catering');
        $this->duration = $this->getFullDuration($categories->getChildrenFromSlug('slug', 'duration'));
        $this->whitelabelId = \Config::get('trendtours.id');
        $this->categories = $categories;
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
        $layer = 'eil-mobile' === $input['variant'] ? 'layer.popup-mobile' : 'layer.popup';
        $html = view('trendtours::' . $layer)->with([
            'adults_arr'     => $this->adults,
            'months_arr'     => $this->months,
            'catering_arr'   => $this->catering,
            'duration_arr'   => $this->duration,
            'request'        => $request->all()
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
            $layer = 'eil-mobile' === $input['variant'] ? 'layer.popup-mobile' : 'layer.popup';
            $html = view('trendtours::' . $layer)->with([
                'adults_arr'     => $this->adults,
                'errors'         => $request->errors(),
                'months_arr'     => $this->months,
                'catering_arr'   => $this->catering,
                'duration_arr'   => $this->duration,
                'request'        => $input
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        }
        $newsletter = $request->has('newsletter') ? true : false;
        session(['newsletter' => $newsletter]);

        $newUser = $user->createUserFromLayer(
            $request->only('first_name', 'last_name', 'email', 'password', 'is_term_accept', 'terms'),
            $this->whitelabelId
        );

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
     * @param WishesRepository $wish
     * @param StoreWishRequest $request
     *
     * @return object
     */
    private function createWishFromLayer(StoreWishRequest $request, $wish)
    {
        $input = $request->except('variant', 'first_name', 'last_name', 'email', 'password', 'is_term_accept', 'name', 'terms', 'newsletter');
        $input['earliest_start'] = \Illuminate\Support\Carbon::createFromFormat('m.Y', $input['earliest_start'])->format('d.m.Y');
        $input['latest_return'] = '01.01.2020';
        $new_wish = $wish->create($input, $this->whitelabelId);

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
     * @param array  $children
     * @param string $type
     *
     * @return array
     */
    private function putPersonLabel($children, $type)
    {
        foreach ($children as $key => $value) {
            $label = $type ? ' ' . trans_choice('labels.categories.' . $type, (int) $value) : '';
            $children[$key] = $value . '' . $label;
        }

        return $children;
    }

    /**
     * @param array  $children
     * @param string $type
     *
     * @return array
     */
    private function transformMonth($children)
    {
        foreach ($children as $key => $value) {
            $date_arr = explode('.', $value);
            $date = Carbon::parse($date_arr[1] . '-' . $date_arr[0] . '-01');
            $now = Carbon::now();
            $length = $now->diffInDays($date, false);
            if ($length > -28) {
                $children[$key] = $this->translateToDe($date->formatLocalized('%B')) . ' ' . $date->formatLocalized('%Y');
            } else {
                unset($children[$key]);
            }
        }

        return $children;
    }

    /**
     * @param string $date
     *
     * @return string
     */
    private function translateToDe($date)
    {
        switch ($date) {
            case 'January':
                return 'Januar';
                break;
            case 'February':
                return 'Februar';
                break;
            case 'March':
                return 'März';
                break;
            case 'April':
                return 'April';
                break;
            case 'May':
                return 'Mai';
                break;
            case 'June':
                return 'Juni';
                break;
            case 'July':
                return 'Juli';
                break;
            case 'August':
                return 'August';
                break;
            case 'September':
                return 'September';
                break;
            case 'October':
                return 'Oktober';
                break;
            case 'November':
                return 'November';
                break;
            case 'December':
                return 'Dezember';
                break;
        }
    }
}
