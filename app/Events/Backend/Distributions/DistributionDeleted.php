<?php

namespace App\Events\Backend\Distributions;

use Illuminate\Queue\SerializesModels;

/**
 * Class DistributionDeleted.
 */
class DistributionDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $distributions;

    /**
     * @param $distributions
     */
    public function __construct($distributions)
    {
        $this->distributions = $distributions;
    }
}
