<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\ListProviders\MailchimpProvider;
use Membergate\ListProviders\MockESProvider;
use Membergate\Settings\EMSSettings\MailchimpSettings;
use Membergate\Settings\EMSSettings\MockServerSettings;

class ProvidersConfiguration implements ContainerConfigurationInterface {
    public function modify(Container $container) {
        $container['list_providers'] = $container->service(function (Container $container) {
            $providers = [
                MailchimpProvider::provider_name => [
                    'client' => MailchimpProvider::class,
                    'settings' => MailchimpSettings::class,
                ],
            ];
            if (MG_IS_TEST) {
                $providers[MockESProvider::provider_name] = [
                    'client'=>MockESProvider::class,
                    'settings'=>MockServerSettings::class,
                ];
            }
            return $providers;
        });
    }
}
