<?php

namespace Membergate\ListProviders;

use Membergate\Common\PossibleError;

interface ListProvidersInterface {
	public function __construct($api_key);
	public static function capabilities():array;
	public function add_subscriber($list_id, $email, $info): PossibleError;
	public function get_user($list_id, $email):PossibleError;
	public function is_user_subscribed($list_id, $email_address): PossibleError;
}
