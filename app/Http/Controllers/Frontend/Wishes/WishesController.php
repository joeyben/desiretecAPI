<?php

namespace App\Http\Controllers\Frontend\Wishes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Wishes\ManageWishesRequest;
use App\Http\Requests\Frontend\Wishes\StoreWishesRequest;
use App\Http\Requests\Frontend\Wishes\UpdateWishesRequest;
use App\Models\Access\User\User;
use App\Models\Access\User\UserToken;
use App\Models\Wishes\Wish;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Auth;
use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;


/**
 * Class WishesController.
 */
class WishesController extends Controller
{
    const BODY_CLASS = 'wish';
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

    /**
     * @param \App\Repositories\Frontend\Wishes\WishesRepository $wish
     */
    public function __construct(WishesRepository $wish)
    {
        $this->wish = $wish;
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function index(ManageWishesRequest $request)
    {
        //$location = GeoIP::getLocation('178.3.152.115');
        //var_dump($location);
        //die();
        return view('frontend.wishes.index')->with([
            'status'     => $this->status,
            'category'   => $this->category,
            'catering'   => $this->catering,
            'count'      => $this->wish->getForDataTable()->count(),
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
        return view('frontend.wishes.wish')->with([
            'wish'               => $wish,
            'body_class'         => $this::BODY_CLASS,
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
        return view('frontend.wishes.index')->with([
            'status'     => $this->status,
            'category'   => $this->category,
            'catering'   => $this->catering,
            'count'      => $this->wish->getForDataTable()->count(),
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function getList(ManageWishesRequest $request)
    {
        $status = $request->get('status');
        $wish = $this->wish->getForDataTable()
            ->when($status, function ($wish, $status) {
                return $wish->where(config('module.wishes.table') . '.status', $status);
            })
            ->paginate(10);

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

    public function validateToken(Wish $wish, $token)
    {
        $usertoken = UserToken::where('token', $token)->firstOrFail();

        $user_id = $usertoken->user_id;

        $user = User::where('id', $user_id)->firstOrFail();

        Auth::login($user);

        return redirect()->to('/wish/' . $wish->id);
    }
}
