<?php

namespace Modules\Tui\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Wishes\ManageWishesRequest;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Models\Access\User\User;
use App\Models\Access\User\UserToken;
use App\Models\Wishes\Wish;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Auth;
use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;

/**
 * Class TuiWishesController.
 */
class TuiWishesController extends Controller
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
        $this->whitelabelId = \Config::get('tui.id');
    }

    /**
     * @param \App\Models\Wishes\Wish                                $wish
     * @param string $token
     * @return mixed
     */
    public function details(Wish $wish, string $token, ManageWishesRequest $request)
    {
        $whitelabel = $this->whitelabel->getByName('tui');

        return view('tui::wish.details')->with([
            'wish'               => $wish,
            'body_class'         => $this::BODY_CLASS,
            'display_name' => $whitelabel['display_name'],
            'bg_image'     => $whitelabel['bg_image'],
        ]);
    }
}