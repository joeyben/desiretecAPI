<?php

namespace App\Events\Frontend\Wishes;

use Illuminate\Queue\SerializesModels;

/**
 * Class WishDeleted.
 */
class WishDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $wishes;

    /**
     * @param $wishes
     */
    public function __construct($wishes)
    {
        $this->wishes = $wishes;
    }
}