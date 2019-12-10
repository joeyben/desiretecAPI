<?php

namespace App\Http\Controllers\Frontend\Wishes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Wishes\ChangeWishesStatusRequest;
use App\Http\Requests\Frontend\Wishes\ManageWishesRequest;
use App\Http\Requests\Frontend\Wishes\StoreWishesRequest;
use App\Http\Requests\Frontend\Wishes\UpdateWishesRequest;
use App\Models\Access\User\User;
use App\Models\Access\User\UserToken;
use App\Models\Agents\Agent;
use App\Models\Wishes\Wish;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Auth;
use Illuminate\Http\Request;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;
use Modules\Rules\Repositories\Eloquent\EloquentRulesRepository;
use Illuminate\Auth\AuthManager;

/**
 * Class WishesController.
 */
class WishesController extends Controller
{
    const BODY_CLASS = 'wish';
    const BODY_CLASS_LIST = 'wishlist';
    const OFFER_URL = 'img/offer/';
    /**
     * Wish Status.
     */
    protected $status = [
        'new'               => 'new',
        'offer_created'     => 'offer_created',
        'completed'         => 'completed',
    ];

    /**
     * Wish Category.
     */
    protected $category = [
        '1'  => 1,
        '2'  => 2,
        '3'  => 3,
        '4'  => 4,
        '5'  => 5,
    ];

    /**
     * Wish Catering.
     */
    protected $catering = [
        'any'           => 'any',
        'Breakfast'     => 'Breakfast',
        'Pension'       => 'Pension',
        'Full Pension'  => 'Full Pension',
        'All Inclusive' => 'All Inclusive',
    ];

    /**
     * @var WishesRepository
     */
    protected $wish;
    protected $categories;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @var \Modules\Rules\Repositories\Eloquent\EloquentRulesRepository
     */
    private $rules;

    /**
     * @param \App\Repositories\Frontend\Wishes\WishesRepository           $wish
     * @param \Modules\Rules\Repositories\Eloquent\EloquentRulesRepository $rules
     * @param \Illuminate\Auth\AuthManager                                      $auth
     */
    public function __construct(WishesRepository $wish, CategoriesRepository $categories, EloquentRulesRepository $rules, AuthManager $auth)
    {
        $this->wish = $wish;
        $this->categories = $categories;
        $this->rules = $rules;
        $this->auth = $auth;
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function index(ManageWishesRequest $request)
    {
        return view('frontend.wishes.index')->with([
            'status'     => $this->status,
            'category'   => $this->category,
            'catering'   => $this->catering,
            'count'      => $this->wish->getForDataTable()->get()->where('whitelabel_id', getCurrentWhiteLabelId())->count(),
            'wishes'     => $this->wish->getForDataTable()->get()->toArray(),
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     * @param \App\Models\Wishes\Wish                                $wish
     *
     * @return mixed
     */
    public function show(Wish $wish, ManageWishesRequest $request)
    {
        $wishTye = $this->manageRules($wish);

        if ($wishTye > 0) {
            return redirect()->route('autooffer.create', [$wish->id]);
        }

        $offers = $wish->offers;
        $avatar = [];
        $agentName = [];

        foreach ($offers as $offer) {
            array_push($avatar, Agent::where('id', $offer->agent_id)->value('avatar'));
            array_push($agentName, Agent::where('id', $offer->agent_id)->value('name'));
        }

        return view('frontend.wishes.wish')->with([
            'wish'               => $wish,
            'avatar'             => $avatar,
            'agent_name'         => $agentName,
            'body_class'         => $this::BODY_CLASS,
            'offer_url'          => $this::OFFER_URL,
            'categories'         => $this->categories,
            'extra'              => json_decode($wish->extra_params, true)
        ]);
    }

    public function getWish(Wish $wish, ManageWishesRequest $request)
    {
        return response()->json($wish->id);
    }

    public function newWish(ManageWishesRequest $request)
    {
        return view('frontend.wishes.newwishes.wish')->with([
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    public function newUserWish(ManageWishesRequest $request)
    {
        return view('frontend.wishes.newwishes.wish-user')->with([
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    public function offerLink(ManageWishesRequest $request)
    {
        return view('frontend.wishes.newwishes.offertextlink')->with([
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    public function offerText(ManageWishesRequest $request)
    {
        return view('frontend.wishes.newwishes.offerviatext')->with([
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    public function attach(ManageWishesRequest $request)
    {
        return view('frontend.wishes.newwishes.attach')->with([
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function wishList(ManageWishesRequest $request)
    {
        return view('frontend.wishes.index')->with([
            'status'     => $this->status,
            'category'   => $this->category,
            'catering'   => $this->catering,
            'count'      => $this->wish->getForDataTable()->get()->where('whitelabel_id', getCurrentWhiteLabelId())->count(),
            'body_class' => $this::BODY_CLASS_LIST,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function getList(ManageWishesRequest $request)
    {
        $status_arr = [
            'new'               => '1',
            'offer_created'     => '2',
            'completed'         => '3',
        ];


        $status = $request->get('status') ? $status_arr[$request->get('status')] : '1';
        $id = ($request->get('id') && $request->get('id') != "undefined") ? $request->get('id') : '';
        $rules = $this->rules->getRuleForWhitelabel((int) ($this->auth->guard('web')->user()->whitelabels()->first()->id));

        $wish = $this->wish->getForDataTable()
            ->when($status, function ($wish, $status) {
                return $wish->where(config('module.wishes.table') . '.status', $status)
                    ->where('whitelabel_id', (int) (getCurrentWhiteLabelId()));
            })->when($id, function($wish, $id) {
                return $wish->where(config('module.wishes.table') . '.id', 'like', '%'.$id.'%');
            })
            ->paginate(10);

        foreach($wish as $singleWish) {
            $singleWish['status'] = array_search($singleWish['status'], $status_arr, true) ? array_search($singleWish['status'], $status_arr, true) : 'new';

            $manuelFlag = false;

            if(is_array($rules['destination']) && !is_null($rules['destination'])) {
                if(is_array($singleWish['destination'])) {
                    foreach ($singleWish['destination'] as $destination) {
                        if (in_array($destination, $rules['destination']))  $manuelFlag = true;
                    }
                } else {
                    if (in_array($singleWish['destination'], $rules['destination']))    $manuelFlag = true;
                }
            }

            if($singleWish['budget'] > $rules['budget'])   $manuelFlag = true;

            $singleWish['manuelFlag'] = $manuelFlag;
            $singleWish['wlRule'] = $rules['type'];
        }

        $response = [
            'pagination' => [
                'total'        => $wish->total(),
                'per_page'     => $wish->perPage(),
                'current_page' => $wish->currentPage(),
                'last_page'    => $wish->lastPage(),
                'from'         => $wish->firstItem(),
                'to'           => $wish->lastItem()
            ],
            'data' => $wish
        ];

        return response()->json($response);
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function create(ManageWishesRequest $request)
    {
        return view('frontend.wishes.create')->with([
            'status'         => $this->status,
            'category'       => $this->category,
            'catering'       => $this->catering,
            'body_class'     => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\StoreWishesRequest $request
     *
     * @return mixed
     */
    public function store(StoreWishesRequest $request)
    {
        $this->wish->create($request->except('_token'));

        return redirect()
            ->route('frontend.wishes.index')
            ->with('flash_success', trans('alerts.frontend.wishes.created'));
    }

    /**
     * @param \App\Models\Wishes\Wish                                $wish
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function edit(Wish $wish, ManageWishesRequest $request)
    {
        return view('frontend.wishes.edit')->with([
            'wish'               => $wish,
            'status'             => $this->status,
            'category'           => $this->category,
            'catering'           => $this->catering,
            'body_class'         => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Models\Wishes\Wish                                $wish
     * @param \App\Http\Requests\Frontend\Wishes\UpdateWishesRequest $request
     *
     * @return mixed
     */
    public function update(Wish $wish, UpdateWishesRequest $request)
    {
        $input = $request->all();

        $this->wish->update($wish, $request->except(['_token', '_method']));

        return redirect()
            ->route('frontend.wishes.index')
            ->with('flash_success', trans('alerts.frontend.wishes.updated'));
    }

    /**
     * @param \App\Models\Wishes\Wish                                $wish
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function destroy(Wish $wish, ManageWishesRequest $request)
    {
        $this->wish->delete($wish);

        return redirect()
            ->route('admin.wishes.index')
            ->with('flash_success', trans('alerts.frontend.wishes.deleted'));
    }

    public function validateTokenWish(Wish $wish, $token)
    {
        $usertoken = UserToken::where('token', $token)->firstOrFail();

        $user_id = $usertoken->user_id;

        $user = User::where('id', $user_id)->firstOrFail();

        if ($user) {
            Auth::login($user);

            return redirect()->to('/wish/' . $wish->id);
        }

        return redirect()->to('/');
    }

    // To do: Define Auto and Manuel offer in const

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return string
     */
    public function manageRules($wish)
    {
        $rules = $this->rules->getRuleForWhitelabel((int) (getCurrentWhiteLabelId()));
        $offer = 0;
        switch ($rules['type']) {
            case 'mix':
                $destinations = \is_array($rules['destination']) ? $rules['destination'] : [];
                $budget_lower = $wish->budget < $rules['budget'];
                $description_notset = !$wish->description || '' === $wish->description;
                $destination_exists = empty($destinations) || \in_array($wish->destination, $destinations, true);

                if ($budget_lower && $description_notset && $destination_exists) {
                    $offer = 1;
                } else {
                    $offer = 0;
                }
                break;
            case 'auto':
                $offer = 1;
                break;
            case 'manuel':
                $offer = 0;
                break;
            default:
                $offer = 0;
        }

        return $offer;
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ChangeWishesStatusRequest $request
     *
     * @return JSON response
     */
    public function changeWishStatus(ChangeWishesStatusRequest $request)
    {
        try {
            $status_arr = [
                'new'               => '1',
                'offer_created'     => '2',
                'completed'         => '3',
            ];

            $status = $request->get('status') ? $status_arr[$request->get('status')] : '1';

            $wish = $this->wish->updateStatus($request->get('id'), $status);

            return json_response([]);
        } catch (Exception $e) {
            return json_response_error($e);
        }
    }
}
