<?php

namespace App\Http\Controllers\Frontend\Offers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Offers\ManageOffersRequest;
use App\Http\Requests\Frontend\Offers\StoreOffersRequest;
use App\Http\Requests\Frontend\Offers\UpdateOffersRequest;
use App\Models\Offers\Offer;
use App\Models\Wishes\Wish;
use App\Repositories\Frontend\Offers\OffersRepository;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Modules\Wishes\Repositories\Contracts\WishesRepository;

/**
 * Class OffersController.
 */
class OffersController extends Controller
{
    const BODY_CLASS = 'offer';
    /**
     * Offer Status.
     */
    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
        'Deleted'      => 'Deleted',
    ];

    /**
     * @var OffersRepository
     */
    protected $offer;
    /**
     * @var \Modules\Wishes\Repositories\Contracts\WishesRepository
     */
    private $wishes;
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    public function __construct(OffersRepository $offer, WishesRepository $wishes, AuthManager $auth)
    {
        $this->offer = $offer;
        $this->wishes = $wishes;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index(ManageOffersRequest $request)
    {
        return view('frontend.offers.index')->with([
            'status'     => $this->status,
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param type $id
     *
     * @return mixed
     */
    public function create($id, ManageOffersRequest $request)
    {
        return view('frontend.offers.create')->with([
            'status'         => $this->status,
            'wish_id'        => $id,
            'body_class'     => $this::BODY_CLASS,
        ]);
    }

    /**
     * @return mixed
     */
    public function store(StoreOffersRequest $request)
    {
        $this->offer->create($request);

        if ($this->auth->guard('agent')->check() && $this->auth->guard('web')->user()->hasRole(Flag::SELLER_ROLE)) {
            $wish = $this->wishes->find($request->get('wish_id'));
            $this->wishes->update($wish->id, ['agent_id' => $this->auth->guard('agent')->user()->id]);
        }

        return redirect()
            ->route('frontend.offers.index')
            ->with('flash_success', trans('alerts.frontend.offers.created'));
    }

    /**
     * @return mixed
     */
    public function edit(Offer $offer, ManageOffersRequest $request)
    {
        return view('frontend.offers.edit')->with([
            'offer'               => $offer,
            'status'              => $this->status,
            'body_class'          => $this::BODY_CLASS,
        ]);
    }

    /**
     * @return mixed
     */
    public function update(Offer $offer, UpdateOffersRequest $request)
    {
        $input = $request->all();

        $this->offer->update($offer, $request->except(['_token', '_method']));

        return redirect()
            ->route('admin.offers.index')
            ->with('flash_success', trans('alerts.frontend.offers.updated'));
    }

    /**
     * @return mixed
     */
    public function destroy(Offer $offer, ManageOffersRequest $request)
    {
        $this->offer->delete($offer);

        return redirect()
            ->route('admin.offers.index')
            ->with('flash_success', trans('alerts.frontend.offers.deleted'));
    }

    /**
     * @return mixed
     */
    public function getWishOffers(Wish $wish, ManageOffersRequest $request)
    {
        return view('frontend.offers.wishoffers')->with([
            'status'     => $this->status,
            'wish'       => $wish,
            'body_class' => $this::BODY_CLASS,
        ]);
    }
}
