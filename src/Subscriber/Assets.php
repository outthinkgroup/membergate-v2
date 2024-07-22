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
            'current_screen' => ['on_current_screen', 10, 1],
        ];
    }

    public function enqueue_admin_assets($hook) {
        //check get_current_screen
        if ($hook == 'toplevel_page_membergate-settings') {
            $this->vite->use('assets/main.ts');
        }

        if ($hook == 'admin_page_membergate-rules') {
            /*TODO Uncomment this when the rule editor is ready*/
            //$this->rules->load_editor();
        }
    }


    public function enqueue_form_syles() {
        $this->vite->use('assets/frontend.ts');
    }

    public function use_esm_modules($tag, $handle, $src) {
        return $this->vite->use_esm_modules($tag, $handle, $src);
    }

    public function on_current_screen($current_screen) {
        if($current_screen->id == "admin_page_membergate-rules"){
            /*TODO Uncomment this when the rule editor is ready*/
            //return $this->rules->rule_editor->overlay_editor->on_current_screen($current_screen);
        }
        return $current_screen;
    }
}
