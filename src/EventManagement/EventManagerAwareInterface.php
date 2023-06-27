<?php

namespace Membergate\EventManagement;

if (!defined('ABSPATH')) {
    exit;
}

interface EventManagerAwareInterface {
    public function set_event_manager(EventManager $eventManager);
}
