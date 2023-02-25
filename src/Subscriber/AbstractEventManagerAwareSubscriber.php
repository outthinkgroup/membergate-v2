<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\EventManager;
use Membergate\EventManagement\EventManagerAwareInterface;
use Membergate\EventManagement\SubscriberInterface;

abstract class AbstractEventManagerAwareSubscriber implements EventManagerAwareInterface, SubscriberInterface
{
    protected $event_manager;

    public function set_event_manager(EventManager $eventManager)
    {
        $this->event_manager = $eventManager;
    }
}
