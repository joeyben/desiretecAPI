<?php

namespace App\Events\Frontend\Agents;

use Illuminate\Queue\SerializesModels;

/**
 * Class AgentDeleted.
 */
class AgentDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $agents;

    /**
     * @param $agents
     */
    public function __construct($agents)
    {
        $this->agents = $agents;
    }
}
