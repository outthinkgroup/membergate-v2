<?php

namespace Membergate\FormHandlers;

use Membergate\Common\MemberCookie;

class AddSubscriberToService implements FormHandlerInterface{
	private $list_client;
	private $list_settings;
	private $setup = true;
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
		if(!$this->setup) return;

		$name = isset( $_POST['user_name'] ) ? $_POST['user_name'] : null;
		$email = isset( $_POST['email'] ) ? $_POST['email'] : null;
		debug(["in AddSubscriberToService execute_action", $name, $email]);
		if(is_null($name) || is_null($email)) return; //TODO: Error Reporting show USER 
		$res = $this->list_client->is_user_subscribed($this->list_id, $email);
		if($res->has_error()){
			debug(["checked if user subbed",$res->error]);
			return; //TODO: Error Reporting show USER
		}
		$cookie = new MemberCookie();
		if( $res->value == true ){
			$cookie->set_member_cookie();
			wp_redirect(site_url($_SERVER['REQUEST_URI']));
			exit;
		}
		$settings = $this->list_settings->get_settings();

		if($settings->has_error()){
			return;	//TODO: Error Reporting show ADMIN
		}
		$subbed_res = $this->list_client->add_subscriber($email, $settings->value);
		if($subbed_res->has_error()){
			//TODO: Error Reporting show USER
			return;
		}
		
		$cookie->set_member_cookie();
		wp_redirect(site_url($_SERVER['REQUEST_URI']));
		exit;

	}
}
