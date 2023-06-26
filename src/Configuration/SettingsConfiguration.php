<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\Settings\AccountSettings;
use Membergate\Settings\FormSettings;
use Membergate\Settings\ListProviderSettings;
use Membergate\Settings\PostTypeSettings;
use Membergate\Settings\ProtectedContentSettings;

class SettingsConfiguration implements ContainerConfigurationInterface {
    public function modify(Container $container) {
        $container[rsettings.list_provider'] = $container->service(function (Container $container) {
            return new ListProviderSettings($container['list_providers']);
        });
        $container['settings.account'] = $container->service(function (Container $container) {
            return new AccountSettings();
        });
        $container['settings.post_types'] = $container->service(function (Container $container) {
            return new PostTypeSettings();
        });
        $container['settings.forms'] = $container->service(function (Container $container) {
            $settings = new FormSettings();
            return $settings;
        });
        $container['settings.protected_content'] = $container->service(function (Container $container) {
            $settings = new ProtectedContentSettings();
            return $settings;
        });
    }
}
