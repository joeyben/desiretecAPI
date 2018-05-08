<?php

namespace App\Events\Backend\Groups;

use Illuminate\Queue\SerializesModels;

/**
 * Class GroupUpdated.
 */
class GroupUpdated
{
    use SerializesModels;

    /**
     * @var
     */
    public $groups;

    /**
     * @param $groups
     */
    public function __construct($groups)
    {
        $this->groups = $groups;
    }
}
