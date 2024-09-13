<?php

namespace Membergate\Configuration;

if (!defined('ABSPATH')) {
    exit;
}

use Illuminate\Container\Container;
use Membergate\Subscriber\Admin;
use Membergate\Subscriber\AjaxEndpoints;
use Membergate\Subscriber\Assets;
use Membergate\Subscriber\OverlayPostType;
use Membergate\Subscriber\ProtectSubscriber;
use Membergate\Subscriber\RulePostType;
use Membergate\Subscriber\SSRSettings;
use Membergate\Subscriber\Shortcodes;

class EventManagementConfiguration {
    /** @return array<class-string>  */
    public function get_subscribers():array {
        $subscribers = [
            //add Subscriber classes
            Shortcodes::class,
            Assets::class,
            Admin::class,
            AjaxEndpoints::class,
            ProtectSubscriber::class,
            SSRSettings::class,
            RulePostType::class,
            OverlayPostType::class,
        ];

        return $subscribers;
    }

    public function make_subscribers(Container $container):void {
        foreach ($this->get_subscribers() as $class) {
            $container->tag($class, 'subscriber');
        }
    }
}
