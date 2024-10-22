<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\Admin\AdminPage;
use Membergate\Common\JsonResponse;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\RuleEditor;
use Membergate\UpdatePlugin;

/** @package Membergate\Subscriber */
class AjaxEndpoints implements SubscriberInterface {
    private $container;


    private AdminPage $adminPage;
    public function __construct(
        private RuleEditor $rule_editor,
    ) {
        global $membergate;
        $this->container = $membergate->get_container();
        $vars = $this->container->get("Vars");
        $plugins_path = $vars['plugin_path'];
        $this->adminPage = new AdminPage($plugins_path."/templates", $plugins_path, $this->container->get(UpdatePlugin::class));
    }

    public static function get_subscribed_events(): array {
        return [
            'wp_ajax_nopriv_mg_public_endpoint' => 'public_endpoints',
            'wp_ajax_mg_public_endpoint' => 'public_endpoints',
            'wp_ajax_membergate_settings' => 'membergate_settings_endpoint',
        ];
    }


    public function public_endpoints() {
        $endpoints = [];

        if (!isset($_REQUEST['mg_public_action'])) {
            error_log('no action set');
        }
        $endpoint = $endpoints[$_REQUEST['mg_public_action']];
        if (!$endpoint) {
            error_log('no endpoint was found for: ' . $_REQUEST['mg_public_action']);
            exit;
        }

        $handlerClass = $this->container->make($endpoint);
        $handlerClass->handle();
    }

    private function get_request_body() {
        $body = file_get_contents("php://input");
        $body = json_decode($body);
        return $body;
    }

    public function membergate_settings_endpoint() {
        $body = $this->get_request_body();

        switch ($body->membergate_action) {
                /* RULE EDITOR */
            case "rule_editor__load_param_value":
                $data = new JsonResponse($this->rule_editor->load_rule_value_options($body));
                $data->send();
                die;
            case "rule_editor__save_rules":
                $data = new JsonResponse($this->rule_editor->save_rules($body));
                $data->send();
                die;
            case "dissmiss_help":
                $data  =new JsonResponse($this->adminPage->dissmiss_help());
                $data->send();
                die;
            case "save_license_key":
                $data = new JsonResponse(['success'=>$this->adminPage->saveLicenseKey($body->key)]);
                $data->send();
                die;
        }
    }

}
