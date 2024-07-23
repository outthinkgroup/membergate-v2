<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\SubscriberInterface;

class OverlayPostType implements SubscriberInterface {

    public static function get_subscribed_events(): array {
        return [
            'init' => ['register', 100000000],
        ];
    }

    public function register() {
        register_post_type(
            'membergate_overlay',
            [
                'labels' => [
                    'name' => __('Membergate Overlay'),
                    'singular_name' => __('Membergate Overlay')
                ],
                'public' => true,
                'show_in_menu' => false,
                'show_in_rest' => true,
                'publicly_queryable' => false,
                'exclude_from_search' => true,
                'supports' => ['editor', 'title'],
            ]
        );
    }

    public function register_post_meta() {


        register_post_meta('membergate_overlay', "membergate_overlay_settings", [
            'type' => "object",
            "show_in_rest" => [
                'schema' => [
                    'type' => 'object',
                    "properties" => [
                        "bgColor" => ["type" => "string"],
                        "textColor" => ["type" => "string"],
                        "maxWidth" => ["type" => "number"],
                        "padding" => [
                            "type" => "object",
                            "properties" => [
                                "top" => ["type" => "number"],
                                "right" => ["type" => "number"],
                                "bottom" => ["type" => "number"],
                                "left" => ["type" => "number"],
                            ],
                        ],
                    ],
                ]
            ],
            'single' => true,
            'default' => $this->default_overlay_settings(),
        ]);
    }

    function default_overlay_settings() {
        return [
            'bgColor' => "#ffffff",
            "textColor" => "#000000",
            "maxWidth" => 20,
            "padding" => [
                'top' => 20,
                'right' => 20,
                'bottom' => 20,
                'left' => 20,
            ],
        ];
    }
}
