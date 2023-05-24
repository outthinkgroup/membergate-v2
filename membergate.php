<?php

/**
 * Plugin Name:     Membergate
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     ot-gf-quiz
 * Domain Path:     /languages
 * Version:         0.1.0
 */
// this is used for asset loading for vite
require __DIR__ . '/vendor/autoload.php';

require_once dirname(__FILE__) . '/env.php';
define('MG_IS_DEVELOPMENT', (MG_APP_ENV === 'development') || (MG_APP_ENV === 'test'));
require_once 'utils.php';

require_once dirname(__FILE__) . '/src/Autoloader.php';
\Membergate\Autoloader::register();

global $membergate;
$membergate = new \Membergate\Plugin(__FILE__);
add_action('after_setup_theme', [$membergate, 'load']);

require_once 'pluggable.php';
