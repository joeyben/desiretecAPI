<?php

namespace Modules\Whitelabels\Listeners;

use Modules\Whitelabels\Entities\Whitelabel;

class WhitelabelSubscriber
{
    /**
     * @var \Modules\Whitelabels\Entities\Whitelabel
     */
    private $whitelabel;

    /**
     * Create the event listener.
     *
     * @param \Modules\Whitelabels\Entities\Whitelabel $whitelabel
     */
    public function __construct(Whitelabel $whitelabel)
    {
        $this->whitelabel = $whitelabel;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('eloquent.created: Modules\Whitelabels\Entities\Whitelabel', [$this, 'onCreatedWhitelabel']);
    }

    public function onCreatedWhitelabel(Whitelabel $whitelabel)
    {
    }
}
