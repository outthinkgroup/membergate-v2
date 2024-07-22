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

require __DIR__ . '/vendor/autoload.php';

// this is used for asset loading for vite

require_once 'utils.php';

require_once dirname(__FILE__) . '/src/Autoloader.php';
\Membergate\Autoloader::register();

global $membergate;
$membergate = new \Membergate\Plugin(__FILE__);
add_action('after_setup_theme', [$membergate, 'load']);

require_once 'pluggable.php';

add_filter( 'block_editor_settings_all', 'example_restrict_code_editor' );

function example_restrict_code_editor( $settings ) {
    $can_active_plugins = current_user_can( 'activate_plugins' );

    // Disable the Code Editor for users that cannot activate plugins (Administrators).
    if ( ! $can_active_plugins ) {
        $settings[ 'codeEditingEnabled' ] = false;
    }

    return $settings;
}
