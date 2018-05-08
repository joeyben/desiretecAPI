<?php

namespace App\Events\Frontend\Offers;

use Illuminate\Queue\SerializesModels;

/**
 * Class OfferCreated.
 */
class OfferCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $offers;

    /**
     * @param $offers
     */
    public function __construct($offers)
    {
        $this->offers = $offers;
    }
}
