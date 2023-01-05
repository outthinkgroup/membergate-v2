<?php

namespace Membergate\ListProviders;

interface ListProvidersInterface {
	public function __construct($api_key);
	public static function capabilities():array;
	public function add_subscriber($email, $info);
	public function get_user($email):array;
}
