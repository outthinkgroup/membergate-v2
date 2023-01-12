<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\Settings\ListProviderSettings;
use Membergate\Settings\AccountSettings;
use Membergate\Settings\PostTypeSettings;

class SettingsConfiguration implements ContainerConfigurationInterface {
	public function modify(Container $container){
		$container['settings.list_provider'] = $container->service(function (Container $container){
			return new ListProviderSettings();
		});
		$container['settings.account'] = $container->service(function (Container $container){
			return new AccountSettings();
		});
		$container['settings.post_types'] = $container->service(function(Container $container){
			return new PostTypeSettings();
		});
	}
}
