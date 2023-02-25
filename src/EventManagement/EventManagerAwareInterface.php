<?php

namespace Membergate\EventManagement;

interface EventManagerAwareInterface {
    public function set_event_manager(EventManager $eventManager);
}
