<?php

namespace Membergate\Shortcode;

interface ShortcodeInterface {

    public function run(array $atts): string;

    public function get_default_args(): array;
}
