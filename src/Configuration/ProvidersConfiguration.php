<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\ListProviders\MailchimpProvider;

class ProvidersConfiguration implements ContainerConfigurationInterface {
	public function modify(Container $container){
		$container['list_providers'] = $container->service(function(Container $container){
			return [
				MailchimpProvider::provider_name => MailchimpProvider::class,	
			];	
		});
	
	}
}
