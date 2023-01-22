<?php
namespace Membergate\AJAX;

use Membergate\Settings\ProtectedConentSettings;

class SaveDisplayProtectedContent implements AjaxInterface {
	const ACTION = "save_blocked_content_settings";
	private ProtectedConentSettings $protected_content_settings; 
	public $dependencies = ['settings.protected_content'];

	public function __construct(){
	}
	public function set_dependencies(ProtectedConentSettings $protected_content_settings){
		$this->protected_content_settings = $protected_content_settings;	
	}


	public function get_action(): string {
		return self::ACTION;
	}

	public function get_name(): string {
		return self::class;
	}

	public function handle(){
		$settings = $this->protected_content_settings->get_all();
		foreach ( $settings	as $key => $val ){
			if(isset($_POST[$key]))	{
				$settings[$key] = $_POST[$key];
			}
		}
		$updated = $this->protected_content_settings->save($settings);
		echo json_encode(['data'=>$updated, 'errors'=>[]]);
		exit;
	}
}
