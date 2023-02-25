<?php

namespace Membergate\Settings;

use Membergate\Common\PossibleError;

class FormSettings
{
    const FORM_KEY = 'membergate_form_settings';

    private $settings;

    public function __construct()
    {
        $this->settings = get_option(self::FORM_KEY, [
            'form_button_label' => 'Get Access',
            'form_title' => 'This Content is for Subscribers only',
            'form_details' => 'Please fill in the form below to get access to this content.',
        ]);
    }

    public function get_all()
    {
        return $this->settings;
    }

    public function save($settings): array
    {
        $this->settings = $settings;
        $res = update_option(self::FORM_KEY, $settings);

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
