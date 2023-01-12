<?php

namespace Membergate\AJAX;

use Membergate\Settings\ListProviderSettings;

class SaveGeneralListSettings implements AjaxInterface {
	const ACTION = "save_general_settings";
	private ListProviderSettings $list_settings;

	public $dependencies = ['list_settings'];
	public function __construct(){
		// $this->list_settings = $list_settings;	
	}
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
		$provider = isset($_POST['providerName']) ? sanitize_text_field($_POST['providerName']) : $this->list_settings->get_provider();
		$api_key = isset($_POST['apiKey']) ? sanitize_text_field($_POST['apiKey']) : $this->list_settings->get_api_key();

		$list = isset($_POST['list']) ?  sanitize_text_field($_POST['list']) : check_and_return($this->list_settings->get_api_key()['list']);
		$group = isset($_POST['group']) ?  sanitize_text_field($_POST['group']) : check_and_return($this->list_settings->get_api_key()['group']);


		$list_config = [
			'list'=>$list,
			'group'=>$group,	
		];

		$this->list_settings->set_info(
			$provider,
			$api_key,
			$list_config,
		);		
		echo json_encode(['data'=> 1, 'errors'=>[]]);		
		exit;
	}
}

