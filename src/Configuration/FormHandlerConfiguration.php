<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\FormHandlers\AddSubscriberToService;

class FormHandlerConfiguration implements ContainerConfigurationInterface {
    public function modify(Container $container) {
        $container['form_handler'] = $container->service(function (Container $container): array {
            //action => form_handler
            return [
                'add_subscriber_to_service' => new AddSubscriberToService($container['settings.list_provider'], $container['list_providers']),
            ];
        });
    }
}
