<?php

namespace Membergate\EventManagement;

if (!defined('ABSPATH')) {
    exit;
}

interface SubscriberInterface {
    public static function get_subscribed_events(): array;
}
