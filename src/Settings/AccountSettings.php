<?php

namespace Membergate\Settings;

if (!defined('ABSPATH')) {
    exit;
}

class AccountSettings {
    private $is_setup;

    public const WIZARD_COMPLETE_KEY = 'membergate_wizard_complete';

    public function __construct() {
        $this->is_setup = get_option(self::WIZARD_COMPLETE_KEY, false);
    }

    public function get_is_setup() {
        return $this->is_setup;
    }

    public static function set_is_setup($condition) {
        update_option(self::WIZARD_COMPLETE_KEY, $condition);
    }
}
