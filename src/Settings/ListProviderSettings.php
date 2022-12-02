<?php

namespace Membergate\Settings;

class ListProviderSettings {

	public function get_info(){
		return get_option('list_provider_info', [
			'api_key'=>null,
			'provider'=>null,
			'list_config'=>[],
		]);	
	}

	public function set_info($provider, $api_key, $list_config){
		return update_option('list_provider_info', [
			'api_key'=>$api_key,
			'provider'=>$provider,
			'list_config'=>$list_config,
		]);	
	}
}
