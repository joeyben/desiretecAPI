<?php

namespace App\Events\Backend\Whitelabels;

use Illuminate\Queue\SerializesModels;

/**
 * Class WhitelabelUpdated.
 */
class WhitelabelUpdated
{
    use SerializesModels;

    /**
     * @var
     */
    public $whitelabels;

    /**
     * @param $whitelabels
     */
    public function __construct($whitelabels)
    {
        $this->whitelabels = $whitelabels;
    }
}
