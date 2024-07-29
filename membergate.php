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
require_once 'utils.php';

global $membergate;
$membergate = new \Membergate\Plugin(__FILE__);
add_action('after_setup_theme', [$membergate, 'load']);

require_once 'pluggable.php';

