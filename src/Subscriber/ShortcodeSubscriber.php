<?php

namespace Membergate\Subscriber;

use Membergate\DependencyInjection\Container;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Shortcode\ShortcodeInterface;
use Membergate\Shortcode\SignupShortcode;

class ShortcodeSubscriber implements SubscriberInterface {
    private Container $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public static function get_subscribed_events(): array {
        return [
            'init' => 'load_shortcodes',
        ];
    }

    public function load_shortcodes() {
        $shortcodes = [
            'mg_signup_form' => SignupShortcode::class,
        ];

        foreach ($shortcodes as $name => $shortcode_class) {
            $container = $this->container;
            $dep_keys = $shortcode_class::get_dependencies();
            $deps = [];
            foreach ($dep_keys as $dkey) {
                $deps[$dkey] = $container[$dkey];
            }
            $shortcode = new $shortcode_class($deps);
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
