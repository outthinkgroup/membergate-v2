<?php

namespace Membergate\FormHandlers;

use Membergate\Common\MemberCookie;

class AddSubscriberToService implements FormHandlerInterface {
    private $list_client;

    private $list_settings;

    private $setup = true;

    private $list_id;

    private $form_renderer;
    public function __construct($list_provider_settings, $providers, $form_renderer) {
        $provider_key = $list_provider_settings->get_provider();
        $provider = $providers[$provider_key];
        $this->list_client = $provider['client'];
        $this->form_renderer = $form_renderer;
        $settings_class = $list_provider_settings->get_provider_settings_class();
        if(class_exists($settings_class)){
            $this->list_settings = new $settings_class();
        } else{
            $this->setup = false;
            return;
        }

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
            } catch(\Exception $error) {
                $this->list_client = null;
            }
        }
    }

    public function execute_action($submission) {
        if (! $this->setup) {
            unset($_POST);
            return;
        }

        $email = isset($submission['email']) ? $submission['email'] : null;
        // TODO: Check all Required form fields
        if (is_null($email) || !$email) {
            $this->form_renderer->add_error("Email is requred");
            unset($_POST);
            return;
        }

        $cookie = new MemberCookie();

        $settings = $this->list_settings->get_settings();
        if ($settings->has_error()) {
            debug(['get_settings' => $settings->error]);
            $this->form_renderer->add_error("An Error occured, " . $settings->error);
            unset($_POST);
            return;	//TODO: Error Reporting show ADMIN
        }
        if (! $this->list_client) {
            unset($_POST);
            return;
        }
        $subbed_res = $this->list_client->add_subscriber($email, $settings->value, $submission);
        if ($subbed_res->has_error()) {
            $this->form_renderer->add_error("An Error occured, " . $subbed_res->error);
            debug(['add_subscriber' => $subbed_res->error]);
            unset($_POST);
            return;
        }
        $cookie->set_member_cookie();
        if (! empty($_POST['redirect_to'])) {
            wp_redirect($_POST['redirect_to']);
            exit;
        }
        wp_redirect(site_url($_SERVER['REQUEST_URI']));
        exit;
    }
}
