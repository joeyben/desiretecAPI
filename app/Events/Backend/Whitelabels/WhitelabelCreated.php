<?php

namespace App\Events\Backend\Whitelabels;

use Illuminate\Queue\SerializesModels;

/**
 * Class WhitelabelCreated.
 */
class WhitelabelCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $Whitelabels;

    /**
     * @param $whitelabels
     */
    public function __construct($whitelabels)
    {
        $this->whitelabels = $whitelabels;
    }
}
