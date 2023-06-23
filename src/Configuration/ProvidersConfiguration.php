<?php

namespace Membergate\Configuration;

use Membergate\ListProviders\MailchimpProvider;
use Membergate\ListProviders\MockESProvider;
use Membergate\Settings\EMSSettings\MailchimpSettings;
use Membergate\Settings\EMSSettings\MockServerSettings;

class ProvidersConfiguration {
    public static function providers() {
        return [
            MailchimpProvider::provider_name => [
                'client' => MailchimpProvider::class,
                'settings' => MailchimpSettings::class,
            ],
            MockESProvider::provider_name => [
                MockESProvider::class,
                MockServerSettings::class,
            ],
        ];
    }
}
