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

		$provider_key = $this->list_settings->get_provider();
		$provider = $this->providers[$provider_key]['client'];
		$provider_settings =  $this->providers[$provider_key]['settings'];

		if (! in_array("has_lists", $provider::capabilities()) ){
			echo json_encode(['data'=>[],'errors'=>["lists are not supported by $provider_key"]]);
			exit;
		}

		$provider_settings = new $provider_settings();
		$apikey = $provider_settings->get_setting('apikey');
		if($apikey->has_error()){
			echo json_encode(['data'=>[],'errors'=>["Could not load apikey"]]);
			exit;
		}
		$provider = new $provider($apikey->value);
		$results = $provider->get_lists();

		if (! is_array($results) ){
			echo json_encode(['data'=>[],'errors'=>["Unexpected Data recieved "]]);
			exit;
		}
		
		echo json_encode(['data'=> $results, 'errors'=>[]]);	
		exit;
	}
}
