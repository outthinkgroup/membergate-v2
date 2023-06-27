<?php

namespace Membergate\AJAX;

if (!defined('ABSPATH')) {
    exit;
}

interface AjaxInterface {
    public function get_action(): string;

    public function get_name(): string;

    public function handle();
}
