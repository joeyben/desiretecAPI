<?php

namespace Modules\Trendtours\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wishes\Wish;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;

/**
 * Class MasterWishesController.
 */
class TrendtoursWishesController extends Controller
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

    public function __construct(WishesRepository $wish, WhitelabelsRepository $whitelabel)
    {
        $this->wish = $wish;
        $this->whitelabel = $whitelabel;
        $this->whitelabelId = \Config::get('$MODULESMALL$.id');
    }

    /**
     * @return mixed
     */
    public function details(Wish $wish, string $token)
    {
        $this->wish->validateToken($token);

        return redirect()->to('/wish/' . $wish->id);
    }
}
