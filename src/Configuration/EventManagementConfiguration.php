<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\EventManagement\EventManager;
use Membergate\Subscriber\AddModalTemplateSubscriber;
use Membergate\Subscriber\AdminPageAJaxSubscriber;
use Membergate\Subscriber\AdminSubscriber;
use Membergate\Subscriber\AssetSubscriber;
use Membergate\Subscriber\FormSubmissionSubscriber;
use Membergate\Subscriber\LoadAdditionalPostTypesSubscriber;
use Membergate\Subscriber\ProtectPostMetaBoxSubscriber;
use Membergate\Subscriber\RedirectToProtectSubscriber;
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
				new ShortcodeSubscriber($container),
				new AssetSubscriber(),
				new AdminSubscriber($container['plugin_path']),
				new AdminPageAJaxSubscriber($container['settings.list_provider'],$container['list_providers'], $container['settings.post_types'],$container['settings.forms'],$container['settings.protected_content']),
				new RedirectToProtectSubscriber($container['settings.post_types'], $container['form_renderer'], $container['settings.protected_content'] ),
				new ServerRenderSettingsSubscriber($container['settings.list_provider'], $container['list_providers'], $container['settings.account'], $container['settings.post_types'], $container['settings.forms'], $container['settings.protected_content']),
				new ProtectPostMetaBoxSubscriber($container['settings.post_types']),
				new LoadAdditionalPostTypesSubscriber($container['settings.post_types']),
				new AddModalTemplateSubscriber($container['form_renderer'], $container['settings.protected_content'], $container['settings.post_types']),
			];
			return $subscribers;
		});
	}
}
