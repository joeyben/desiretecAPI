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
     * @var
     */
    public $fromApi;

    /**
     * @param $wishes
     */
    public function __construct($wishes, $fromApi)
    {
        $this->wishes   = $wishes;
        $this->fromApi  = $fromApi;
    }
}
