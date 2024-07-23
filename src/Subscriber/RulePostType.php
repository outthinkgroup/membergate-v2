<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\SubscriberInterface;

class RulePostType implements SubscriberInterface {

    public static function get_subscribed_events(): array {
        return [
            'init' => ['register', 100000000],
            'admin_url' => ['change_new_post_editor', 10, 2],
            'get_edit_post_link' => ['change_post_editor', 10, 3]
        ];
    }

    public function change_new_post_editor($url, $path) {
        if ($path === 'post-new.php?post_type=membergate_rule') {
            $url = 'admin.php?page=membergate-rules';
        }
        return $url;
    }

    public function change_post_editor($url, $post_id, $context) {
        if (get_post_type($post_id) !== "membergate_rule") return $url;
        return admin_url("admin.php?page=membergate-rules&id=$post_id");
    }

    public function register() {
        register_post_type(
            'membergate_rule',
            [
                'labels' => [
                    'name' => __('Membergate Rules'),
                    'singular_name' => __('Membergate Rule')
                ],
                'public' => true,
                'show_in_menu' => false,
                'show_in_rest' => true,
            ]
        );
    }
}
