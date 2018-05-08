<?php

namespace App\Events\Backend\Groups;

use Illuminate\Queue\SerializesModels;

/**
 * Class GroupDeleted.
 */
class GroupDeleted
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
