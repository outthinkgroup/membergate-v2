<?php

namespace Membergate\Settings;

class ListProviderSettings {
	const KEY = "general_list_provider_info";
	private $api_key;
	private $provider;
	private $list_config;

	public $post_type_list_settings;

	public function __construct(){
		//Im not sure if this is a good idea.
		// $this->post_type_list_settings = new PostTypeListProviderSettings();

		$info = $this->get_info();	
		$this->api_key = $info['api_key'];
		$this->provider = $info['provider'];
		$this->list_config = $info['list_config'];
	}

	private function get_info() {
		return get_option(self::KEY, [
			'api_key'=>null,
			'provider'=>null,
			'list_config'=>[],
		]);	
	}

	public function set_info($provider=null, $api_key=null, $list_config=null){
		$provider = isset($provider) ? $provider : $this->provider;
		$api_key = isset($api_key) ? $api_key : $this->api_key;
		$list_config = isset($list_config) ? $list_config : $this->$list_config;

		return update_option(self::KEY, [
			'api_key'=>isset($api_key) ? $api_key : $this->api_key,
			'provider'=>isset($provider) ? $provider : $this->provider,
			'list_config'=>isset($list_config) ? $list_config : $this->list_config,
		]);	
	}

	public function get_api_key(){
		return $this->api_key;	
	}

	public function get_provider(){
		return $this->provider;	
	}

	public function get_list_config(){
		return $this->list_config;
	}

	public function get_provider_lists(){

	}

	public function get_provider_groups(){
			
	}

	public function set_api_key($api_key){
		$this->api_key = $api_key;	
		$this->save();
	}

	public function set_provider($provider){
		$this->provider = $provider;	
		$this->save();
	}

	public function set_list_config($list_config){
		$this->list_config = $list_config;	
		$this->save();
	}

	public function save(){
		$this->set_info();	
	}

}
