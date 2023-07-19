<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Plugin Name:     Membergate
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     membergate
 * Requires PHP:    7.3
 * Domain Path:     /languages
 * Version:         0.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}
require __DIR__ . '/vendor/autoload.php';

// this is used for asset loading for vite
require_once dirname(__FILE__) . '/env.php';
define('MG_IS_DEVELOPMENT', (MG_APP_ENV === 'development') || (MG_APP_ENV === 'test'));

require_once 'utils.php';

require_once dirname(__FILE__) . '/src/Autoloader.php';
\Membergate\Autoloader::register();

global $membergate;
$membergate = new \Membergate\Plugin(__FILE__);
add_action('after_setup_theme', [$membergate, 'load']);

require_once 'pluggable.php';

// Please move re build this. Only intended as prototype
add_action('init', function () {
    register_post_type(
        'membergate_rule',
        [
            'labels' => [
                'name' => __('Membergate Rules'),
                'singular_name' => __('Membergate Rule')
            ],
            'public' => true,
            'show_in_menu' => false,
        ]
    );
});

add_action('admin_menu', function () {
    add_submenu_page("membergate-settings", 'Rules', 'Rules', 'manage_options', 'edit.php?post_type=membergate_rule');
});

add_action('admin_head', function () {
    if (get_current_screen()->id !== 'membergate_rule') {
        return;
    }
    \Membergate\Assets\Vite::useVite("assets/rule-editor.ts");
    ?>
<?php
});
