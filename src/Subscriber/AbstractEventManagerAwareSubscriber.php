<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\EventManager;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\EventManagement\EventManagerAwareInterface;

abstract class AbstractEventManagerAwareSubscriber implements EventManagerAwareInterface, SubscriberInterface {
	protected $event_manager;

	public function set_event_manager(EventManager $eventManager){
		$this->event_manager = $eventManager;	
	}
}
