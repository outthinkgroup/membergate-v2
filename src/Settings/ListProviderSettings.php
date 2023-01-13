<?php

namespace Membergate\Settings;

class ListProviderSettings {
	const PROVIDER_NAME = "membergate_provider";
	private $provider;
	private $provider_list;

	public $post_type_list_settings;

	public function __construct($provider_list){
		$this->provider_list = $provider_list;
		$this->provider = get_option(self::PROVIDER_NAME, "mailchimp");
	}

	public function get_provider_settings_class() {
		return $this->provider_list[$this->get_provider()]['settings'];	
	}

	public function set_provider(string $provider_name){
		update_option(self::PROVIDER_NAME, $provider_name);
	}

	public function get_provider(){
		return $this->provider;	
	}

}
