<?php
namespace Membergate\AJAX;

use Membergate\Settings\AccountSettings;

class CompleteSetup implements AjaxInterface {
		
	const ACTION = "complete_setup";
	public $dependencies = [];
	public function get_action(): string{
		return self::ACTION;	
	}	
	public function set_dependencies(...$deps){
		
	}

	public function get_name(): string{
		return self::class;	
	}	

	public function handle(){
		AccountSettings::set_is_setup(1);
		echo json_encode(["data"=>1,"errors"=>[]]);
		exit;
	}

}
