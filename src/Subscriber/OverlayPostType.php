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
                'publicly_queryable' => true,
                'exclude_from_search' => true,
                'supports' => ['editor', 'title', 'custom-fields'],
                'template' => [
                    $this->block_template(),
                ]
            ]
        );
        $this->register_post_meta();
    }




    public function register_post_meta() {


        register_post_meta('membergate_overlay', "membergate_overlay_settings", [
            'type' => "object",
            "show_in_rest" => [
                'schema' => [
                    'type' => 'object',
                    "properties" => [
                        "maxWidth" => ["type" => "string"],
                        "position" => ["type" => "string"],
                    ],
                ]
            ],
            'single' => true,
            'default' => $this->default_overlay_settings(),
        ]);
    }

    function default_overlay_settings(): array {
        return [
            "maxWidth" => "600px",
            "position" => "center",
        ];
    }

    public function block_template(): array {
        return [
            'core/cover',
            [
                "overlayColor" => "white",
                "isUserOverlayColor" => true,
                "isDark" => false,
                "style" => [
                    "border" => ["radius" => "10px", "width" => "4px"],
                    "shadow" => "var:preset|shadow|deep"
                ],
                "borderColor" => "tertiary",
                "layout" => ["type" => "constrained", "contentSize" => "600px"],
                "innerBlocks" => [
                    ["core/heading", ["align" => "center", "content" => "You Need Access To this"]],
                    ["core/paragraph", ["align" => "center", "content" => "Find out how to get access here"]],
                ],
            ],
            [
                ["core/heading", ["content" => "You Need Access To this", "textAlign" => "center", "textColor"=>"black"]],
                ["core/paragraph", ["align" => "center", "content" => "Find out how to get access here", "textColor"=>"black", "style"=>["elements"=>["text"=>["textColor"=>"var=>preset|color|black"],"link"=>["color"=>["text"=>"var:preset|color|black"]]]]
                ]],
                ["core/buttons", ["layout" => ["type" => "flex", "justifyContent" => "center"]],  [["core/button", ["text" => "Learn More"]]]],
                ["membergate/backbutton", ["className"=>"isAbsolute isBottom isRight", "buttonText"=>"&larr; Back"]]
            ]
        ];
    }
}
