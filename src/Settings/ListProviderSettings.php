<?php

namespace Membergate\Settings;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\Configuration\ProvidersConfiguration;

class ListProviderSettings {
    public const PROVIDER_NAME = 'membergate_provider';

    private $provider;

    private $provider_list;

    public $post_type_list_settings;

    public function __construct(ProvidersConfiguration $provider_list) {
        $this->provider_list = $provider_list->providers();
        $this->provider = get_option(self::PROVIDER_NAME, 'mailchimp');
    }

    public function get_provider_settings_class() {
        return $this->provider_list[$this->get_provider()]['settings'];
    }

    public function set_provider(string $provider_name) {
        update_option(self::PROVIDER_NAME, $provider_name);
    }

    public function get_provider() {
        return $this->provider;
    }
}
