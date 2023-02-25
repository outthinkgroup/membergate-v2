<?php

namespace Membergate\Settings;

use Membergate\Common\PossibleError;

class ProtectedContentSettings
{
    const PROTECTED_CONTENT_KEY = 'membergate_protected_content_settings';

    private $settings;

    public function __construct()
    {
        $this->settings = get_option(self::PROTECTED_CONTENT_KEY, [
            'protect_method' => 'override_content',
            'redirect_page' => '',
            'show_modal' => 'true',
        ]);
    }

    public function get_all()
    {
        return $this->settings;
    }

    public function save($settings): array
    {
        $this->settings = $settings;
        $res = update_option(self::PROTECTED_CONTENT_KEY, $settings);

        return $this->settings;
    }

    public function get_setting($key): PossibleError
    {
        if (! array_key_exists($key, $this->settings)) {
            return new PossibleError(null, "Not a valid settings: $key");
        }

        return new PossibleError($this->settings[$key]);
    }
}
