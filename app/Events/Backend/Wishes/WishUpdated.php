<?php

namespace App\Events\Backend\Wishes;

use Illuminate\Queue\SerializesModels;

/**
 * Class WishUpdated.
 */
class WishUpdated
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
