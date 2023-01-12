<?php

namespace Membergate\AJAX;

use Membergate\Settings\ListProviderSettings;

class FetchGroupsFromProvider implements AjaxInterface {
	const ACTION = "get_groups";

	private ListProviderSettings $list_settings;
	private $providers;

	public function __construct($list_settings, $providers){
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
		$client = $this->providers[$provider_key];
		if (! in_array("has_groups", $client::capabilities()) ){
			echo json_encode(['data'=>[],'errors'=>["groups are not supported by $provider_key"]]);
			exit;
		}
		$list_id = check_and_return($this->list_settings->get_list_config()['list']);
		if(!$list_id){
			echo json_encode(['data'=>[],'errors'=>["No List Id is set yet"]]);
			exit;
		}
		$client = new $client($this->list_settings->get_api_key());
		$results = $client->get_groups($list_id);
		debug($results);	
		if (! is_array($results) ){
			echo json_encode(['data'=>[],'errors'=>["Unexpected Data recieved "]]);
		}
		
		echo json_encode(['data'=> $results, 'errors'=>[]]);	
		exit;
	}
}
