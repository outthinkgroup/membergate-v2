<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\EventManagement\SubscriberInterface;
use Membergate\UpdatePlugin;

class UpdatePluginsSubscriber implements SubscriberInterface {

    public function __construct(public UpdatePlugin $updater) {
    }

    public static function get_subscribed_events(): array {
        return [
            'site_transient_update_plugins' => ['on_transient_update', 10, 2],
            'plugins_api' => ['plugins_information', 10, 3],
            'http_request_args' => ['modify_update_requests', 999, 2],
        ];
    }

    public function on_transient_update($transient) {
        return $this->updater->transientUpdate($transient);
    }

    public function plugins_information($res, $action, $args) {
        return $this->updater->pluginInfo($res, $action, $args);
    }

    public function modify_update_requests($args, $url) {
        return $this->updater->modifyRequests($args, $url);
    }
}
