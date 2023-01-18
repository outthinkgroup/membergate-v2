<?php

namespace Membergate\FormHandlers;

class AddSubscriberToService implements FormHandlerInterface{
	private $list_client;
	private $list_settings;
	private $setup;
	private $list_id;

	public function __construct($list_provider_settings, $providers){
		$provider_key = $list_provider_settings->get_provider();
		$provider = $providers[$provider_key];
		$this->list_client = $provider['client'];
		$settings_class = $list_provider_settings->get_provider_settings_class();
		$this->list_settings = new $settings_class();

		$apikey = $this->list_settings->get_setting('apikey');
		if($apikey->has_error()){
			$this->setup = false;
		}
		$list_id = $this->list_settings->get_setting('list_id');
		if($list_id->has_error()){
			$this->setup = false;
		}
		if($this->setup){
			$this->list_id = $list_id->value;
			$this->list_client = new $this->list_client($apikey->value);
		}

	}
	public function execute_action($submission){
		error_log(print_r($submission,true));	
	}
}
