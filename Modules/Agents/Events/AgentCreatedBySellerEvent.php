<?php

namespace Modules\Agents\Events;

use App\Models\Access\User\User;
use Illuminate\Queue\SerializesModels;

class AgentCreatedBySellerEvent
{
    use SerializesModels;
    /**
     * @var User
     */
    public $seller;


    public function __construct(User $seller)
    {
        $this->seller = $seller;
    }
}
