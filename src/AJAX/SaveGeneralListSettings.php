<?php

namespace Membergate\AJAX;

use Membergate\Settings\ListProviderSettings;

class SaveGeneralListSettings implements AjaxInterface {
	const ACTION = "save_general_settings";
	public $dependencies = ['list_settings'];

	private ListProviderSettings $list_settings;

	public function __construct(){}

	public function set_dependencies($list_settings){
		$this->list_settings = $list_settings;	
	}
	public function get_name():string{
		return self::class;
	}
	public function get_action(): string{
		return self::ACTION;	
	}	

	public function handle(){
		$settings =  [];
		$provider = isset($_POST['providerName']) ? sanitize_text_field($_POST['providerName']) : null;
		$api_key = isset($_POST['apiKey']) ? sanitize_text_field($_POST['apiKey']) : null;

		if($provider){
			$settings[] = $provider;
		}
		if($api_key){
			$settings[] = $api_key;
		}

		$list_config = [];
		$list = isset($_POST['list']) ?  sanitize_text_field($_POST['list']) : null;
		$group = isset($_POST['group']) ?  sanitize_text_field($_POST['group']) : null;

		if($list){
			$list_config['list'] = $list;
		}
		if($group){
			$list_config['group'] = $group;
		}
		$settings[] = $list_config;
		$this->list_settings->set_info(...$settings);		
		echo json_encode(['data'=> 1, 'errors'=>[]]);		
		exit;
	}
}

