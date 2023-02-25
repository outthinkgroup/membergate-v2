<?php

namespace Membergate\Subscriber;

use Membergate\Admin\AdminPage;
use Membergate\EventManagement\SubscriberInterface;

class AdminSubscriber implements SubscriberInterface {
    private $plugin_path;

    public function __construct($plugin_path) {
        $this->plugin_path = $plugin_path;
    }

    public static function get_subscribed_events(): array {
        return [
            'admin_menu' => 'register_admin_pages',
            'admin_head' => 'add_admin_icon_styles',
        ];
    }

    public function register_admin_pages() {
        $admin_page = new AdminPage($this->plugin_path . '/templates', $this->plugin_path);
        add_menu_page(
            $admin_page->get_page_title(),
            $admin_page->get_menu_title(),
            $admin_page->get_capability(),
            $admin_page->get_slug(),
            [$admin_page, 'render_page'],
            $admin_page->get_icon_url(),
        );
    }

    public function add_admin_icon_styles() {
        $admin_page = new AdminPage($this->plugin_path . '/templates', $this->plugin_path);
        $admin_page->icons_styles();
    }
}
