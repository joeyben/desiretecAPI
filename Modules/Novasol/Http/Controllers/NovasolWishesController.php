<?php

namespace Modules\Novasol\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wishes\Wish;
use App\Models\Agents\Agent;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;

/**
 * Class MasterWishesController.
 */
class NovasolWishesController extends Controller
{
    const BODY_CLASS = 'wish';
    const OFFER_URL = 'img/offer/';
    /**
     * Wish Status.
     */
    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
        'Deleted'      => 'Deleted',
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

    private $whitelabelId;
    /**
     * @var WhitelabelsRepository
     */
    protected $whitelabel;

    /**
     * @param \App\Repositories\Frontend\Wishes\WishesRepository $wish
     */
    public function __construct(WishesRepository $wish, WhitelabelsRepository $whitelabel)
    {
        $this->wish = $wish;
        $this->whitelabel = $whitelabel;
        $this->whitelabelId = \Config::get('novasol.id');
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     * @param string                  $token
     *
     * @return mixed
     */
    public function details(Wish $wish, string $token)
    {
        $this->wish->validateToken($wish->id, $token);
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
        ]);

    }
}
