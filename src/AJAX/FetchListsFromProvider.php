<?php

namespace Membergate\AJAX;

use Membergate\Settings\ListProviderSettings;

class FetchListsFromProvider implements AjaxInterface {
	const ACTION = "get_lists";
	public $dependencies = ['list_settings', 'providers'];
	private ListProviderSettings $list_settings;
	private $providers;

	public function __construct(){
		// $this->list_settings = $list_settings;	
		// $this->providers = $providers;
	}
	public function set_dependencies($list_settings, $providers){
		$this->list_settings = $list_settings;	
		$this->providers = $providers;
	}

	public function get_action(): string{
		return self::ACTION;	
	}	

	public function get_name(): string{
		return self::class;	
	}	

	public function handle(){
		if(isset($_POST['apiKey'])) {
			$this->list_settings->set_api_key($_POST["apiKey"]);
		} 
		if(isset($_POST['providerName'])) {
			$this->list_settings->set_provider($_POST['providerName']);
		}

		$provider_key = $this->list_settings->get_provider();
		$provider = $this->providers[$provider_key];

		if (! in_array("has_lists", $provider::capabilities()) ){
			echo json_encode(['data'=>[],'errors'=>["lists are not supported by $provider_key"]]);
			exit;
		}

		$provider = new $provider($this->list_settings->get_api_key());
		$results = $provider->get_lists();

		if (! is_array($results) ){
			echo json_encode(['data'=>[],'errors'=>["Unexpected Data recieved "]]);
			exit;
		}
		
		echo json_encode(['data'=> $results, 'errors'=>[]]);	
		exit;
	}
}
