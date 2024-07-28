<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\EventManagement\EventManager;
use Membergate\EventManagement\EventManagerAwareInterface;
use Membergate\EventManagement\SubscriberInterface;

abstract class AbstractEventManagerAwareSubscriber implements EventManagerAwareInterface, SubscriberInterface {
    protected $event_manager;

    public function set_event_manager(EventManager $eventManager): void {
        $this->event_manager = $eventManager;
    }
}
