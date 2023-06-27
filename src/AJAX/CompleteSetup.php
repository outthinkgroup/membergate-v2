<?php

namespace Membergate\AJAX;

use Membergate\Settings\AccountSettings;

class CompleteSetup implements AjaxInterface {
    public const ACTION = 'complete_setup';

    public function get_action(): string {
        return self::ACTION;
    }

    public function get_name(): string {
        return self::class;
    }

    public function handle() {
        AccountSettings::set_is_setup(1);
        echo json_encode(['data' => 1, 'errors' => []]);
        exit;
    }
}
