<?php

namespace Modules\Novasol\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Wishes\ManageWishesRequest;
use App\Models\Wishes\Wish;
use App\Models\Agents\Agent;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;

/**
 * Class MasterWishesController.
 */
class NovasolWishesController extends Controller
{
    const BODY_CLASS = 'wish';
    const BODY_CLASS_LIST = 'wishlist';
    const OFFER_URL = 'img/offer/';
    /**
     * Wish Status.
     */
    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
        'Deleted'      => 'Deleted',
    ];



    protected $adults = [];
    protected $kids = [];
    protected $pets = [];
    protected $duration = [];
    protected $categories;

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
     * @param \App\Repositories\Frontend\Wishes\WishesRepository $wish
     */
    public function __construct(WishesRepository $wish, WhitelabelsRepository $whitelabel, CategoriesRepository $categories)
    {
        $this->wish = $wish;
        $this->whitelabel = $whitelabel;
        $this->whitelabelId = \Config::get('novasol.id');
        $this->adults = $categories->getChildrenFromSlug('slug', 'adults');
        $this->kids = $categories->getChildrenFromSlug('slug', 'kids');
        $this->pets = $this->translatePets($categories->getChildrenFromSlug('slug', 'pets'));
        $this->duration = $this->getFullDuration($categories->getChildrenFromSlug('slug', 'duration'));
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
        if ($this->wish->validateToken($token)) {
            return redirect()->to('/wish/' . $wish->id);
        }
        return redirect()->to('/');
    }

    /**
     * @param string $token
     *
     * @return mixed
     */
    public function validateTokenList($token)
    {
        if ($this->wish->validateToken($token)) {
            return redirect()->to('/wishlist');
        }
        return redirect()->to('/');
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return mixed
     */
    public function view(Wish $wish)
    {
        if (!auth()->user()){
            return redirect()->to('/');
        }

        $offers = $wish->offers;
        $avatar = [];
        $agentName = [];
        $isOwner = auth()->user()->id === $wish->created_by;
        foreach ($offers as $offer) {
            array_push($avatar, Agent::where('id', $offer->agent_id)->value('avatar'));
            array_push($agentName, Agent::where('id', $offer->agent_id)->value('name'));
        }

        return view('novasol::wish.wish')->with([
            'wish'               => $wish,
            'avatar'             => $avatar,
            'agent_name'         => $agentName,
            'body_class'         => $this::BODY_CLASS,
            'offer_url'          => $this::OFFER_URL,
            'kids_arr'     => $this->kids,
            'pets_arr' => $this->pets,
            'duration_arr' => $this->duration,
            'adults_arr'   => $this->adults,
            'is_owner'            => $isOwner
        ]);

    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function wishList(ManageWishesRequest $request)
    {
        //var_dump($request->ip());
        return view('novasol::wish.index')->with([
            'status'     => $this->status,
            'count'      => count($this->wish->getForDataTable()->get()->toArray()),
            'body_class' => $this::BODY_CLASS_LIST,
        ]);
    }

    public function getWish(Wish $wish)
    {
        return response()->json($wish->only(
            ['destination', 'earliest_start', 'latest_return', 'duration', 'adults', 'kids', 'pets', 'budget']
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

    /**
     * @param array $pets
     *
     * @return array
     */
    private function translatePets($pets)
    {

        foreach ($pets as $key => $value) {
            $pets[$key] = trans('layer.pets.'.$value);
        }

        return $pets;
    }
}
