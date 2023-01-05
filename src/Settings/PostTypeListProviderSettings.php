<?php

namespace Membergate\Settings;

class PostTypeListProviderSettings {
	public function __construct(){}

	public function get_post_type_info($post_type){
		return get_option("{$post_type}_list_provider_info", [
			'api_key'=>null,
			'provider'=>null,
			'list_config'=>[],
		]);	
	}

	public function set_info($post_type, $provider=null, $api_key=null, $list_config=null){
		$provider = isset($provider) ? $provider : $this->provider;
		$api_key = isset($api_key) ? $api_key : $this->api_key;
		$list_config = isset($list_config) ? $list_config : $this->$list_config;

		return update_option("{$post_type}_list_provider_info", [
			'api_key'=>isset($api_key) ? $api_key : $this->api_key,
			'provider'=>isset($provider) ? $provider : $this->provider,
			'list_config'=>isset($list_config) ? $list_config : $this->list_config,
		]);	
	}

	public function get_api_key($post_type){
		return $this->get_post_type_info($post_type)['api_key'];
	}

	public function get_provider($post_type){
		return $this->get_post_type_info($post_type)['provider'];
	}

	public function get_list_config($post_type){
		return $this->get_post_type_info($post_type)['list_config'];
	}

	public function set_api_key($post_type,$api_key){
		$this->api_key = $api_key;	
		$this->save($post_type);
	}

	public function set_provider($post_type,$provider){
		$this->provider = $provider;	
		$this->save($post_type);
	}

	public function set_list_config($post_type,$list_config){
		$this->list_config = $list_config;	
		$this->save($post_type);
	}

	public function save($post_type){
		$this->set_info($post_type);	
	}
}
