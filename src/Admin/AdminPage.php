<?php

namespace Membergate\Admin;

use Membergate\UpdatePlugin;

if (!defined('ABSPATH')) {
    exit;
}

class AdminPage {
    const showHelpFlagMetaKey = 'membergate_shouldShowHelp';
    private string $template_path;
    public UpdatePlugin $updater; 
    private string $plugin_path;

    public function __construct(string $template_path, string $plugin_path, UpdatePlugin $updater) {
        $this->template_path = $template_path;
        $this->plugin_path = $plugin_path;
        $this->updater = $updater;
    }

    public function get_page_title(): string {
        return 'Membergate Setup';
    }

    public function get_menu_title(): string {
        return 'Membergate';
    }

    public function get_capability(): string {
        return 'manage_options';
    }

    public function get_slug(): string {
        return 'membergate-settings';
    }

    public function get_icon_url(): string {
        return 'none';
    }

    public function icons_styles(): void {
        echo file_get_contents($this->plugin_path . 'assets/SVG/membergate_star_icon.svg');
?>

        <style>
            li .toplevel_page_membergate-settings .wp-menu-image {
                background-color: currentColor;
                clip-path: url(#membergate-admin-page-icon);
                width: 100%;
            }

            li .toplevel_page_membergate-settings.wp-not-current-submenu .wp-menu-image {
                opacity: .6
            }

            .toplevel_page_membergate-settings.wp-not-current-submenu:hover .wp-menu-image {
                opacity: 1;
            }
        </style>
<?php
    }

    public function render_page(): void {
        $this->render_template('admin_settings');
    }

    protected function ssrData(): string {
        return json_encode([
            'urls' => [
                'newRule' => admin_url('admin.php?page=membergate-rules'),
                'newOverlay' => admin_url("post-new.php?post_type=membergate_overlay"),
            ],
            'overlays' => $this->listOverlays(),
            'rules' => $this->listRules(),
            'showHelp' => $this->shouldShowHelp(),
            'license' => $this->getLicenseKey(),
        ]);
    }

    /** 
     * @return array<array{title:string, link:string, ID:int, protectType:string, methodType:string}>  
     **/
    protected function listRules(): array {
        $rules = get_posts([
            'post_type' => 'membergate_rule',
            'posts_per_page' => 6,
        ]);
        $rules = array_map(function (\WP_Post $rule) {
            return [
                'title' => $rule->post_title,
                'link' => get_edit_post_link($rule->ID),
                'ID' => $rule->ID,
                'protectType' => "Has Cookie",
                'methodType' => "Overlay",
            ];
        }, $rules);
        return $rules;
    }

    /** @return array<array{title:string, link:string, ID:int}>  */
    protected function listOverlays() {
        $overlays = get_posts([
            'post_type' => 'membergate_overlay',
            'posts_per_page' => 6,
        ]);
        $overlays = array_map(function (\WP_Post $overlay) {
            return [
                'title' => $overlay->post_title,
                'link' => get_edit_post_link($overlay->ID),
                'ID' => $overlay->ID,
            ];
        }, $overlays);
        return $overlays;
    }

    public function render_template(string $template): void {
        $template_path = $this->template_path . '/' . $template . '.php';
        if (! is_readable($template_path)) {
            error_log("$template_path is not readable");

            return;
        }

        include $template_path;
    }

    public function shouldShowHelp(): bool {
        $user = wp_get_current_user();
        $meta = get_user_meta($user->ID, self::showHelpFlagMetaKey, true);
        return ($meta === '' || $meta === 1 || $meta === true);
    }

    /**
     * @return array{success:bool}
     **/
    public function dissmiss_help():array{
        $user = wp_get_current_user();
        $meta = update_user_meta($user->ID, self::showHelpFlagMetaKey, 0);
        if($meta === false){
            return ['success'=>false];
        }
        return ['success'=>true];
    }

    public function saveLicenseKey(string $key):bool{
        return update_option($this->updater::LICENSE_KEY, $key);
    }


    function getLicenseKey():string {
        return get_option($this->updater::LICENSE_KEY);
    }
}
