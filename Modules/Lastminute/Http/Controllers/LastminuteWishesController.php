<?php

namespace Modules\Lastminute\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Wishes\ManageWishesRequest;
use App\Models\Agents\Agent;
use App\Models\Wishes\Wish;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Illuminate\Support\Facades\Route;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;

/**
 * Class LastminuteWishesController.
 */
class LastminuteWishesController extends Controller
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
    protected $adults = [];
    protected $kids = [];
    protected $duration = [];
    protected $budget = [];
    protected $ages = [];
    protected $categories;
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

    private $whitelabelId;
    /**
     * @var WhitelabelsRepository
     */
    protected $whitelabel;

    /**
     * @param \Modules\Categories\Repositories\Contracts\CategoriesRepository $categories
     * @param \App\Repositories\Frontend\Wishes\WishesRepository              $wish
     */
    public function __construct(WishesRepository $wish, WhitelabelsRepository $whitelabel, CategoriesRepository $categories)
    {
        $this->wish = $wish;
        $this->whitelabel = $whitelabel;
        $this->whitelabelId = \Config::get('lastminute.id');
        $this->adults = $categories->getChildrenFromSlug('slug', 'adults');
        $this->kids = $categories->getChildrenFromSlug('slug', 'kids');
        $this->duration = $this->getFullDuration($categories->getChildrenFromSlug('slug', 'duration'));
        $this->budget = $categories->getChildrenFromSlug('slug', 'prices');
        $this->ages = $categories->getChildrenFromSlug('slug', 'ages');
        $this->categories = $categories;
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     * @param string                  $token
     *
     * @return mixed
     */
    public function details(Wish $wish, string $token)
    {
        $this->wish->validateToken($token);

        return redirect()->to('/wish/' . $wish->id);
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return mixed
     */
    public function view(Wish $wish)
    {
        $offers = $wish->offers;
        $avatar = [];
        $agentName = [];
        $isOwner = auth()->user()->id === $wish->created_by;
        foreach ($offers as $offer) {
            array_push($avatar, Agent::where('id', $offer->agent_id)->value('avatar'));
            array_push($agentName, Agent::where('id', $offer->agent_id)->value('name'));
        }
        $whitelabel = $this->whitelabel->getById(getCurrentWhiteLabelId());

        return view('lastminute::wish.wish')->with([
            'wish'               => $wish,
            'avatar'             => $avatar,
            'agent_name'         => $agentName,
            'body_class'         => $this::BODY_CLASS,
            'offer_url'          => $this::OFFER_URL,
            'kids_arr'           => $this->kids,
            'duration_arr'       => $this->duration,
            'adults_arr'         => $this->adults,
            'budget_arr'         => $this->budget,
            'ages_arr'           => $this->ages,
            'is_owner'           => $isOwner,
            'color'              => $whitelabel['color'],
        ]);
    }

    /**
     * @param string $token
     *
     * @return mixed
     */
    public function validateTokenList($token)
    {
        if ($this->wish->validateToken($token)) {
            if (Route::has('lastminute.list')) {
                return redirect()->route('lastminute.list');
            }
        }

        return redirect()->route('frontend.wishes.list');
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function wishList(ManageWishesRequest $request)
    {
        $whitelabel = $this->whitelabel->getById(getCurrentWhiteLabelId());

        return view('lastminute::wish.index')->with([
            'status'     => $this->status,
            'count'      => $this->wish->getForDataTable()->where('whitelabel_id', getCurrentWhiteLabelId())->count(),
            'body_class' => $this::BODY_CLASS_LIST,
            'color'      => $whitelabel['color'],
        ]);
    }

    public function getWish(Wish $wish)
    {
        return response()->json($wish->only(
            ['destination', 'earliest_start', 'latest_return', 'duration', 'adults', 'kids', 'budget']
        ));
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
