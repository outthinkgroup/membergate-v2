<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\Settings\ListProviderSettings;

class SettingsConfiguration implements ContainerConfigurationInterface {
	public function modify(Container $container){
		$container['settings.list_provider'] = $container->service(function (Container $container){
			return new ListProviderSettings();
		});
	}
}
