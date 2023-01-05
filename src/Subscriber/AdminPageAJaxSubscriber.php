<?php


namespace Membergate\Subscriber;

use Membergate\AJAX\FetchGroupsFromProvider;
use Membergate\AJAX\FetchListsFromProvider;
use Membergate\AJAX\SaveGeneralListSettings;
use Membergate\EventManagement\SubscriberInterface;

class AdminPageAJaxSubscriber implements SubscriberInterface {
	public $list_provider_settings;
	public $providers_list;

	public function __construct($list_provider_settings, $providers){
		$this->list_provider_settings = $list_provider_settings;	
		$this->providers_list = $providers;
	}

	public static function get_subscribed_events():array{
		return [
			'wp_ajax_mg_admin_endpoint'=> 'endpoints',
		];
	}

	public function endpoints(){

		$endpoints = [	
			SaveGeneralListSettings::ACTION => SaveGeneralListSettings::class,
			FetchListsFromProvider::ACTION => FetchListsFromProvider::class,
			FetchGroupsFromProvider::ACTION => FetchGroupsFromProvider::class,
		];
		if( !isset( $_POST['mg_action'] ) ){
			error_log("no action set");	
		}
		$endpoint = $endpoints[$_POST['mg_action']];
		if ( !$endpoint ) { 
			error_log("no endpoint was found for: " . $_POST["mg_action"]);
			exit;
		}
		$handlerClass = new $endpoint($this->list_provider_settings, $this->providers_list);
		$handlerClass->handle();
	}

}
