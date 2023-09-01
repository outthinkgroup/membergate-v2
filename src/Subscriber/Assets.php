<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\Assets\Vite;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\Rules;

class Assets implements SubscriberInterface {
    public $vite;
    private $rules;
    public function __construct(Vite $vite, Rules $rules) {
        $this->vite = $vite;
        $this->rules = $rules;
    }

    public static function get_subscribed_events(): array {
        return [
            'admin_enqueue_scripts' => ['enqueue_admin_assets',1],
            'script_loader_tag' => ['use_esm_modules', 10, 3],
            'wp_enqueue_scripts' => 'enqueue_form_syles',
            // 'use_block_editor_for_post_type' =>['prefix_disable_gutenberg', 10, 2]
        ];
    }

    public function prefix_disable_gutenberg($current_status, $post_type) {
        // Use your post type key instead of 'product'
        if ($post_type === 'membergate_rule') return false;
        return $current_status;
    }
    public function enqueue_admin_assets($hook) {
        //check get_current_screen
        if ($hook == 'toplevel_page_membergate-settings') {
            $this->vite->use('assets/main.ts');
        }

        if ($hook == 'admin_page_membergate-rules') {
            $this->rules->load_editor();
        }
    }

    public function enqueue_form_syles() {
        $this->vite->use('assets/frontend.ts');
    }

    public function use_esm_modules($tag, $handle, $src) {
        return $this->vite->use_esm_modules($tag, $handle, $src);
    }
}
