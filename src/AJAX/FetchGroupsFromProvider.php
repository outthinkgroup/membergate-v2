<?php

namespace Membergate\AJAX;

use Membergate\Settings\ListProviderSettings;

class FetchGroupsFromProvider implements AjaxInterface {
	const ACTION = "get_groups";
	public $dependencies = ['list_settings', 'providers'];

	private ListProviderSettings $list_settings;
	private $providers;

	public function __construct(){
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
		$client = $this->providers[$provider_key]['client'];
		$provider_settings =  $this->providers[$provider_key]['settings'];
		$provider_settings = new $provider_settings();

		if (! in_array("has_groups", $client::capabilities()) ){
			echo json_encode(['data'=>[],'errors'=>["groups are not supported by $provider_key"]]);
			exit;
		}

		$list_id = $provider_settings->get_setting("list_id");
		if($list_id->has_error()){
			echo json_encode(['data'=>[],'errors'=>["Couldnt load List Id", $list_id->errors]]);
			exit;
		}
		if(!$list_id->value){
			echo json_encode(['data'=>[],'errors'=>["No List Id is set yet"]]);
			exit;
		}

		$apikey	= $provider_settings->get_setting("apikey");
		if($apikey->has_error()){
			echo json_encode(['data'=>[],'errors'=>["Couldnt load apikey", $apikey->errors]]);
			exit;	
		}

		$client = new $client($apikey->value);
		$results = $client->get_groups($list_id->value);
		if (! is_array($results) ){
			echo json_encode(['data'=>[],'errors'=>["Unexpected Data recieved "]]);
		}
		
		echo json_encode(['data'=> $results, 'errors'=>[]]);	
		exit;
	}
}
