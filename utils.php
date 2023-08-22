<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('check_and_return')) {
    function check_and_return($var) {
        return isset($var) ? $var : null;
    }
}
if (!function_exists('debug')) {
    function debug($val) {
        error_log(print_r($val, true));
    }
}

