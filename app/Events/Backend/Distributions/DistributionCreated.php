<?php

namespace App\Events\Backend\Distributions;

use Illuminate\Queue\SerializesModels;

/**
 * Class DistributionCreated.
 */
class DistributionCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $Distributions;

    /**
     * @param $distributions
     */
    public function __construct($distributions)
    {
        $this->distributions = $distributions;
    }
}
