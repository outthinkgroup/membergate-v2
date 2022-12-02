<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\EventManagement\EventManager;
use Membergate\Subscriber\FormSubmissionSubscriber;
use Membergate\Subscriber\TestSubscriber;

class EventManagementConfiguration implements ContainerConfigurationInterface {
	public function modify(Container $container){
		$container['event_manager'] = $container->service(function(Container $container){
			return new EventManager();
		});	

		$container['subscribers'] = $container->service(function(Container $container){
			$subscribers = [
				//add Subscriber classes	
				new TestSubscriber(),
				new FormSubmissionSubscriber($container['form_handler']),
			];
			return $subscribers;
		});
	}
}
