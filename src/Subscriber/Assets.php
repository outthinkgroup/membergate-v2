<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\Assets\Vite;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\RuleEditor;
use Membergate\Settings\Rules;

class Assets implements SubscriberInterface {
    public function __construct(public Vite $vite, private RuleEditor $ruleEditor) {}

    /** @return array{'admin_enqueue_scripts':mixed, 'script_loader_tag':mixed, 'wp_enqueue_scripts':mixed, 'init':mixed, 'allowed_block_types':mixed} */
    public static function get_subscribed_events(): array {
        /** @psalm-suppress InvalidReturnStatement */
        return [
            'admin_enqueue_scripts' => ['enqueue_admin_assets', 1],
            'script_loader_tag' => ['use_esm_modules', 10, 3],
            'wp_enqueue_scripts' => 'enqueue_form_syles',
            'init' => ['register_blocks', 10, 1],
            'allowed_block_types' => ['overlay_only_blocks', 10, 2],
        ];
    }

    public function enqueue_admin_assets(string $hook): void {
        //check get_current_screen
        if ($hook == 'toplevel_page_membergate-settings') {
            $this->vite->use('assets/dashboard.ts', ["wp-data", "wp-core-data"]);
            $admin_ajax_url = admin_url("admin-ajax.php");

            echo "<script>(function(){if(!window.membergate){window.membergate = {}} window.membergate.url = \"$admin_ajax_url\"})()</script>";
        }

        if ($hook == 'admin_page_membergate-rules') {
            $this->ruleEditor->enqueue_assets();
        }



        if (get_current_screen()->id == "membergate_overlay") {
            $asset_file = include($this->vite->plugin_path . '/extend-block-editor/build/overlaySettings.asset.php');
            wp_enqueue_script("membergate_overlay-settings", $this->vite->plugin_url . "/extend-block-editor/build/overlaySettings.js", $asset_file['dependencies'], $asset_file['version'], false);
            wp_enqueue_style("membergate_overlay-settings", $this->vite->plugin_url . "/extend-block-editor/build/overlaySettings.css");

        }
    }

    public function register_blocks(): void{
        register_block_type_from_metadata($this->vite->plugin_path . "/extend-block-editor/build/backbutton");
        register_block_type_from_metadata($this->vite->plugin_path . "/extend-block-editor/build/protectedlink");
    }

    public function overlay_only_blocks(bool|array $allowed_blocks): array|bool {
        $post_type = get_post_type();
        if(!is_array($allowed_blocks)) return true;
        if( $post_type != "membergate_overlay"){
            //TODO: use method maybe on overlay post type

            return array_filter($allowed_blocks, fn($blockname)=> $blockname != "membergate/backbutton");
        }
        return $allowed_blocks;
    }



    public function enqueue_form_syles(): void {
        $this->vite->use('assets/frontend.ts');
    }

    public function use_esm_modules(string $tag, string $handle, string $src): string {
        return $this->vite->use_esm_modules($tag, $handle, $src);
    }

}
