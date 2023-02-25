<?php

namespace Membergate\Settings;

use Membergate\Common\PossibleError;

class FormSettings {
    public const FORM_KEY = 'membergate_form_settings';

    private $settings;

    public function __construct() {
        $this->settings = get_option(self::FORM_KEY, $this->defaults());
    }

    public function get_all() {
        return $this->settings;
    }

    public function save($settings): array {
        $this->settings = $settings;
        $res = update_option(self::FORM_KEY, $settings);
        return $this->settings;
    }

    public function get_setting($key): PossibleError {
        if (!array_key_exists($key, $this->settings)) {
            return new PossibleError(null, "Not a valid settings: $key");
        }

        return new PossibleError($this->settings[$key]);
    }

    private function defaults() {
        return [
            "PrimaryForm" => [
                "headingText" => "This Content is for Subscribers only",
                "descriptionText" => "Please fill in the form below to get access to this content.",
                "fields" => [
                    [
                        "type" => "NAME",
                        "id" => "wasdf23",
                        "label" => "Name",
                        "name" => "name",
                        "isRequired" => true
                    ],
                    [
                        "type" => "EMAIL",
                        "id" => "asdfase32",
                        "name" => "email",
                        "label" => "Email"
                    ]
                ],
                "altFormLink" => [
                    "show" => true,
                    "text" => "Not a member yet?"
                ],
                "submit" => [
                    "text" => "Login"
                ],
                "action" => "LOGIN"
            ],
            "SecondaryForm" => [
                "isEnabled" => true,
                "headingText" => "Register to get access to VIP Content",
                "descriptionText" => "Please fill in the form below to get access to this content.",
                "fields" => [
                    [
                        "type" => "EMAIL",
                        "name" => "email",
                        "id" => "axca3",
                        "label" => "Email"
                    ],
                    [
                        "type" => "NAME",
                        "id" => "23aass3",
                        "label" => "Name",
                        "name" => "name",
                        "isRequired" => true
                    ],
                    [
                        "type" => "CHECKBOX",
                        "id" => "a233aaa",
                        "label" => "Subscribe to daily newsletter",
                        "name" => "daily_newsletter"
                    ],
                    [
                        "type" => "TEXT",
                        "id" => "oppase3",
                        "label" => "Some text field",
                        "name" => "MERGE_FIELD",
                        "isRequired" => false
                    ]
                ],
                "altFormLink" => [
                    "show" => true,
                    "text" => "Already a member?"
                ],
                "submit" => [
                    "text" => "Register"
                ],
                "action" => "REGISTER"
            ]
        ];
        ;
    }
}
