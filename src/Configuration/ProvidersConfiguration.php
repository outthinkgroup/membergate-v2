<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\ListProviders\MailchimpProvider;
use Membergate\Settings\EMSSettings\MailchimpSettings;

class ProvidersConfiguration implements ContainerConfigurationInterface
{
    public function modify(Container $container)
    {
        $container['list_providers'] = $container->service(function (Container $container) {
            return [
                MailchimpProvider::provider_name => [
                    'client' => MailchimpProvider::class,
                    'settings' => MailchimpSettings::class,
                ],
            ];
        });
    }
}
