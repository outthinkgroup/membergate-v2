<?php

namespace Membergate\Settings;

class AccountSettings{
	private $is_setup;
	const WIZARD_COMPLETE_KEY = 'wizard_complete';
	public function __construct(){
		$this->is_setup = get_option(self::WIZARD_COMPLETE_KEY, false);
	}		

	public function get_is_setup(){
			return $this->is_setup;
	}

	public static function set_is_setup($condition){
		update_option(self::WIZARD_COMPLETE_KEY, $condition);
	}
}
