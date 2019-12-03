<?php

namespace Modules\Agents\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\Agents\Events\AgentCreatedBySellerEvent;
use Modules\Agents\Repositories\Contracts\AgentsRepository;

class AgentListener
{
    /**
     * @var \Modules\Agents\Repositories\Contracts\AgentsRepository
     */
    private $agents;

    public function __construct(AgentsRepository $agents)
    {
        $this->agents = $agents;
    }

    public function subscribe($events)
    {
        $events->listen(AgentCreatedBySellerEvent::class, [$this, 'onCreatedAgentBySeller']);
    }

    public function onCreatedAgentBySeller($event)
    {
        $this->agents->create([
            'name'         => $event->seller->whitelabels()->get()->first()->display_name . ' Agent',
            'display_name' => $event->seller->whitelabels()->get()->first()->display_name . ' Agent',
            'email'        => $event->seller->email,
            'telephone'    => '',
            'status'       => 'Active',
            'avatar'       => 'default_agent_avatar.png',
            'user_id'      => $event->seller->id
        ]);

        Log::info('new Agent has been created by sellerId: ' . $event->seller->id);
    }
}
