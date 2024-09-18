<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}
use Membergate\Admin\AdminPage;
use Membergate\EventManagement\SubscriberInterface;

class Admin implements SubscriberInterface {
    private string $plugin_path;

    public function __construct(string $plugin_path) {
        $this->plugin_path = $plugin_path;
    }

    /** @return array<string, string|mixed> **/
    public static function get_subscribed_events(): array {
        return [
            'admin_menu' => 'register_admin_pages',
            'admin_head' => 'add_admin_icon_styles',
        ];
    }

    /**
     * @return void
     */
    public function register_admin_pages():void {
        $admin_page = new AdminPage($this->plugin_path . '/templates', $this->plugin_path);
        add_menu_page(
            $admin_page->get_page_title(),
            $admin_page->get_menu_title(),
            $admin_page->get_capability(),
            $admin_page->get_slug(),
            [$admin_page, 'render_page'],
            $admin_page->get_icon_url(),
        );

        // Adds link for post type
        add_submenu_page($admin_page->get_slug(), "Membergate Rules", "Rules", "manage_options", "edit.php?post_type=membergate_rule");

        // Rule Single
        add_submenu_page(null, 'Rules', 'Rules', 'manage_options', 'membergate-rules', function(){
            include $this->plugin_path . "/templates/rules.php";
        });
        // Adds link for post type
        add_submenu_page($admin_page->get_slug(), 'Overlays ','Overlays', 'manage_options', 'edit.php?post_type=membergate_overlay');
    }
    /**
     * @return void
     */
    public function add_admin_icon_styles():void {
        $admin_page = new AdminPage($this->plugin_path . '/templates', $this->plugin_path);
        $admin_page->icons_styles();
    }
}
