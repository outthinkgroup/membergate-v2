<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Illuminate\Container\Container;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Plugin;
use Membergate\Shortcode\ShortcodeInterface;

class ShortcodeSubscriber implements SubscriberInterface {
    private Container $container;

    public function __construct() {
        /**@var Plugin **/
        $membergate=null;
        global $membergate;
        $this->container = $membergate->get_container();
    }

    public static function get_subscribed_events(): array {
        return [
            'init' => 'load_shortcodes',
        ];
    }

    public function load_shortcodes() {
        $shortcodes = [
        ];

        foreach ($shortcodes as $name => $shortcode_class) {
            $container = $this->container;
            $shortcode = $container->make($shortcode_class);
            if ($shortcode instanceof ShortcodeInterface) {
                $args = $shortcode->get_default_args();
                add_shortcode($name, function ($atts) use ($shortcode, $args, $name) {
                    $atts = shortcode_atts($args, $atts, $name);
                    return $shortcode->run($atts);
                });
            }
        }
    }
}
