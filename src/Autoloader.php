<?php

namespace Membergate;

if (!defined('ABSPATH')) {
    exit;
}

class Autoloader {
    public static function autoload($class) {
        if (0 != strpos($class, __NAMESPACE__)) {
            return;
        }

        $class = substr($class, strlen(__NAMESPACE__));
        $file = dirname(__FILE__) . str_replace(['\\', "\0"], ['/', ''], $class) . '.php';
        if (is_file($file)) {
            require $file;
        }
    }

    public static function register($prepend = false) {
        spl_autoload_register([new self(), 'autoload'], true, $prepend);
    }
}
