<?php

namespace Membergate\FormHandlers;

use Membergate\Common\MemberCookie;

class CheckSubscriptionStatus implements FormHandlerInterface {
    private $list_client;

    private $list_settings;

	private $form_renderer;

    private $setup = true;

    private $list_id;

    public function __construct($list_provider_settings, $providers, $form_renderer) {
        $provider_key = $list_provider_settings->get_provider();
        $provider = $providers[$provider_key];
        $this->list_client = $provider['client'];
        $settings_class = $list_provider_settings->get_provider_settings_class();
        $this->list_settings = new $settings_class();

		$this->form_renderer = $form_renderer;

        $apikey = $this->list_settings->get_setting('apikey');
        if ($apikey->has_error()) {
            $this->setup = false;
        }
        $list_id = $this->list_settings->get_setting('list_id');
        if ($list_id->has_error()) {
            $this->setup = false;
        }
        if ($this->setup) {
            $this->list_id = $list_id->value;
            try {
                $this->list_client = new $this->list_client($apikey->value);
            } catch (\Exception $error) {
                $this->list_client = null;
            }
        }
    }
    public function execute_action(array $submission) {
        if (! $this->setup) {
            return;
        }

        $name = isset($submission['name']) ? $submission['name'] : null;
        $email = isset($submission['email']) ? $submission['email'] : null;
		// this depends on the form settings provided
		// TODO: update to reflect what is required by the settings
        if (is_null($name) || is_null($email)) {
			
            return;
        } //TODO: Error Reporting show USER

        $cookie = new MemberCookie();

        $settings = $this->list_settings->get_settings();
        if ($settings->has_error()) {
            debug(['get_settings' => $settings->error]);
			$this->form_renderer->add_error("An Error occured please try again.");
            return;	//TODO: Error Reporting show ADMIN
        }
        if (! $this->list_client) {
            return;
        }
        $subbed_res = $this->list_client->is_user_subscribed($this->list_id,$email);
		if($subbed_res->has_error()){
            //TODO: Error Reporting show USER
            debug(['is_user_subscribed' => $subbed_res->error]);
            return;
		}
		$status = $subbed_res->value; // true or false
		if($status){
			$cookie->set_member_cookie();
			if (! empty($_POST['redirect_to'])) {
				wp_redirect($_POST['redirect_to']);
				exit;
			}
			wp_redirect(site_url($_SERVER['REQUEST_URI']));
			exit;
		} 
		// well we need to let the user know that they are not subscribed
		$this->form_renderer->add_error("Oh no! You aren't a member yet!");
		
    }
}
