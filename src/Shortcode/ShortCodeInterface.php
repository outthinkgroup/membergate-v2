<?php

namespace Membergate\Shortcode;

if (!defined('ABSPATH')) {
    exit;
}

interface ShortcodeInterface {
    public function run(array $atts): string;

    public function get_default_args(): array;
}
