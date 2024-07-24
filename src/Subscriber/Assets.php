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
            'admin_enqueue_scripts' => ['enqueue_admin_assets', 1],
            'script_loader_tag' => ['use_esm_modules', 10, 3],
            'wp_enqueue_scripts' => 'enqueue_form_syles',
            'current_screen' => ['on_current_screen', 10, 1],
            'init' => ['register_blocks', 10, 1],
            'allowed_block_types' => ['overlay_only_blocks', 10, 2],
        ];
    }

    public function enqueue_admin_assets($hook) {
        //check get_current_screen
        if ($hook == 'toplevel_page_membergate-settings') {
            $this->vite->use('assets/main.ts');
        }

        if ($hook == 'admin_page_membergate-rules') {
            $this->rules->load_editor();
        }

        if (get_current_screen()->id == "membergate_overlay") {
            $asset_file = include($this->vite->plugin_path . '/extend-block-editor/build/overlaySettings.asset.php');
            wp_enqueue_script("membergate_overlay-settings", $this->vite->plugin_url . "/extend-block-editor/build/overlaySettings.js", $asset_file['dependencies'], $asset_file['version'], false);
            wp_enqueue_style("membergate_overlay-settings", $this->vite->plugin_url . "/extend-block-editor/build/overlaySettings.css");

        }
    }

    public function register_blocks(){
        register_block_type($this->vite->plugin_path . "/extend-block-editor/build/backbutton");
    }

    public function overlay_only_blocks($allowed_blocks){
        $post_type = get_post_type();
        if(!is_array($allowed_blocks)) return true;
        if( $post_type != "membergate_overlay"){
            //TODO: use method maybe on overlay post type

            return array_filter($allowed_blocks, fn($blockname)=> $blockname != "membergate/backbutton");
        }
        return $allowed_blocks;
    }



    public function enqueue_form_syles() {
        $this->vite->use('assets/frontend.ts');
    }

    public function use_esm_modules($tag, $handle, $src) {
        return $this->vite->use_esm_modules($tag, $handle, $src);
    }

    public function on_current_screen($current_screen) {
        if ($current_screen->id == "admin_page_membergate-rules") {
            /*TODO Uncomment this when the rule editor is ready*/
            //return $this->rules->rule_editor->overlay_editor->on_current_screen($current_screen);
        }
        return $current_screen;
    }
}
