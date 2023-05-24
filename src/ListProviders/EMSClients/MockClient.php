<?php

namespace Membergate\ListProviders\EMSClients;

use Membergate\Common\PossibleError;

class MockClient {
    private $api_key;
    public const URL = "http://localhost:3000/lists";
    public function __construct($api_key) {
        $this->api_key = $api_key;
    }

    public function get_lists() {
        $res = $this->get(self::URL."/");
        if (is_wp_error($res)) {
            return new PossibleError(null, $res->get_error_message());
        }
        $data = json_decode($res['body']);
        return new PossibleError($data);
    }
    public function get_list($list_id) {
        $res = $this->get(self::URL . "/$list_id");
        if (is_wp_error($res)) {
            return new PossibleError(null, $res->get_error_message());
        }
        $data = json_decode($res['body']);
        return new PossibleError($data);
    }
    public function get_subscriber($list_id, $subscriber_id) {
        $res = $this->get(self::URL . "/$list_id/subscribers/$subscriber_id");
        if (is_wp_error($res)) {
            return new PossibleError(null, $res->get_error_message());
        }
        $data = json_decode($res['body']);
        return new PossibleError($data);
    }
    public function add_subscriber($list_id, $subscriber_data) {
        $res = $this->post(self::URL . "/$list_id/subscribers", [
            'body'=>$subscriber_data,
        ]);
        if (is_wp_error($res)) {
            return new PossibleError(null, $res->get_error_message());
        }
        $data = json_decode($res['body']);
        return new PossibleError($data);
    }
    public function update_subscriber($list_id, $subscriber_id, $subscriber_data) {
        $res = $this->post(self::URL . "/$list_id/subscribers/$subscriber_id", [
            'body'=>$subscriber_data,
        ]);
        if (is_wp_error($res)) {
            return new PossibleError(null, $res->get_error_message());
        }
        $data = json_decode($res['body']);
        return new PossibleError($data);
    }
    public function get_tags($list_id) {
        $res = $this->get(self::URL . "/$list_id/tags");
        debug(["GETTING TAGS",$res]);
        if (is_wp_error($res)) {
            return new PossibleError(null, $res->get_error_message());
        }
        $data = json_decode($res['body']);
        return new PossibleError($data);
    }
    public function get_subscriber_by_email($list_id, $email) {
        $res = $this->get(self::URL . "/$list_id/subscribers/email/$email");
        if (is_wp_error($res)) {
            return new PossibleError(null, $res->get_error_message());
        }
        $data = json_decode($res['body']);
        return new PossibleError($data);
    }

    private function get($url) {
        $res = wp_remote_get($url, [
            'headers'=>[
                'Content-Type'=>'application/json',
                'x-api'=>$this->api_key,
            ],
        ]);

        if($res['response']['code'] !== 200){
            $err = new \WP_Error("BAD_REQUEST",$res['response']['message']);
            return $err;
        }
        return $res;
    }
    private function post($url, $body) {
        return wp_remote_post($url, [
            'headers'=>[
                'Content-Type'=>'application/json',
                'x-api'=>$this->api_key,
            ],
            'body'=>$body,
        ]);
    }
}
