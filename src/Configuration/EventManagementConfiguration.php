<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\EventManagement\EventManager;
use Membergate\Subscriber\AdminPageAJaxSubscriber;
use Membergate\Subscriber\AdminSubscriber;
use Membergate\Subscriber\AssetSubscriber;
use Membergate\Subscriber\FormSubmissionSubscriber;
use Membergate\Subscriber\ServerRenderSettingsSubscriber;
use Membergate\Subscriber\ShortcodeSubscriber;

class EventManagementConfiguration implements ContainerConfigurationInterface {
	public function modify(Container $container){
		$container['event_manager'] = $container->service(function(Container $container){
			return new EventManager();
		});	

		$container['subscribers'] = $container->service(function(Container $container){
			$subscribers = [
				//add Subscriber classes	
				new FormSubmissionSubscriber($container['form_handler']),
				new ShortcodeSubscriber($container['plugin_path']),
				new AssetSubscriber(),
				new AdminSubscriber($container['plugin_path']),
				new AdminPageAJaxSubscriber($container['settings.list_provider'],$container['list_providers'], $container['settings.post_types']),
				new ServerRenderSettingsSubscriber($container['settings.list_provider'], $container['list_providers'], $container['settings.account']),
			];
			return $subscribers;
		});
	}
}
