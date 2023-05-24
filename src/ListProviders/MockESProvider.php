<?php

namespace Membergate\ListProviders;

use Membergate\Cache\ListProviderCache;
use Membergate\Common\PossibleError;
use Membergate\ListProviders\EMSClients\MockClient;

class MockESProvider implements ListProvidersInterface {
    private $api_key;

    private MockClient $client;

    private $cache;

    public const provider_name = 'mockclient';
    public const label = "Mock Client";

    public function __construct($api_key) {
        $this->api_key = $api_key;
        $this->client = new MockClient($this->api_key);
        $this->cache = new ListProviderCache(self::provider_name);
    }

    public static function capabilities(): array {
        return [
            'has_groups',
            'has_lists',
        ];
    }

    public function add_subscriber($email, $settings, $submission = null): PossibleError {
        $list_id = $settings['list_id'];
        $res = $this->client->add_subscriber($list_id, [
            'email'=>$submission['email'],
            'status'=>'subscribed',
            'tags'=>[$settings['group_id']],
        ]);
        return $res;
    }

    public function get_user($list_id, $email): PossibleError {
        return $this->client->get_subscriber_by_email($list_id, $email);
    }

    public function is_user_subscribed($list_id, $email_address): PossibleError {
        $res = $this->get_user($list_id, $email_address);
        if ($res->has_error()) {
            return $res;
        }
        $res->value = $res->value->status == 'subscribed';
        return $res;
    }

    public function get_lists(){
        $possible_err = $this->client->get_lists();
        if($possible_err->has_error()){
            return null;
        }
        return ['lists'=>$possible_err->value];
    }

    public function get_groups( $list_id ) {
        $possible_err = $this->client->get_tags((int)$list_id);
        if($possible_err->has_error()){
            return null;
        }
        debug(["hihihihhi",$possible_err]);
        return array_map(function($tag){return ['id'=>$tag,'name'=>$tag];},$possible_err->value->tags);
    }
}
