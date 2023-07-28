<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\Common\JsonResponse;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\Rules;

class AjaxEndpoints implements SubscriberInterface {
    private $container;

    private $rules;

    public function __construct(
        Rules $rules
    ) {
        $this->rules= $rules;
        global $membergate;
        $this->container = $membergate->get_container();
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

    public function membergate_settings_endpoint() {
        $body = file_get_contents("php://input");
        $body = json_decode($body);
        switch ($body->membergate_action) {
            /* RULE EDITOR */
            case "rule_editor__load_param_value":
                $data = new JsonResponse($this->rules->editor->load_rule_value_options($body));
                $data->send();
                die;
            case "rule_editor__save_rules":
                $data = new JsonResponse($this->rules->editor->save_rules($body));
                $data->send();
                die;
        }
    }
}
