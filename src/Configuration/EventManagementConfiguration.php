<?php

namespace Membergate\Configuration;

if (!defined('ABSPATH')) {
    exit;
}

use Illuminate\Container\Container;
use Membergate\Subscriber\Admin;
use Membergate\Subscriber\AjaxEndpoints;
use Membergate\Subscriber\Assets;
use Membergate\Subscriber\BlockEditorPluginSidebar;
use Membergate\Subscriber\MetaBoxes;
use Membergate\Subscriber\Protect;
use Membergate\Subscriber\SSRSettings;
use Membergate\Subscriber\Shortcodes;

class EventManagementConfiguration {
    public function get_subscribers() {
        $subscribers = [
            //add Subscriber classes
            Shortcodes::class,
            Assets::class,
            Admin::class,
            AjaxEndpoints::class,
            BlockEditorPluginSidebar::class,
            Protect::class,
            SSRSettings::class,
        ];

        return $subscribers;
    }

    public function make_subscribers(Container $container) {
        foreach ($this->get_subscribers() as $class) {
            $container->tag($class, 'subscriber');
        }
    }
}
