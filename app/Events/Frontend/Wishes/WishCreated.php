<?php

namespace App\Events\Frontend\Wishes;

use Illuminate\Queue\SerializesModels;

/**
 * Class WishCreated.
 */
class WishCreated
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
