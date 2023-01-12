<?php

namespace Membergate\AJAX;

class SaveProtectedPostTypes implements AjaxInterface {
	const ACTION = "save_protecte_post_types";
	private $post_type_settings; 
	public $dependencies = ['post_type_settings'];

	public function __construct(){
		// $this->post_type_settings = $post_type_settings;	
	}
	public function set_dependencies($post_type_settings){
		$this->post_type_settings = $post_type_settings;	
	}


	public function get_action(): string {
		return self::ACTION;
	}

	public function get_name(): string {
		return self::class;
	}

	public function handle(){
		$post_types = isset($_POST['postTypes']) ? $_POST['postTypes'] : null;
		if(!$post_types){
			echo json_encode(['data'=>[],'errors'=>['Not post types were provided']]);
			exit;
		}

		$post_types = $this->post_type_settings->save($post_types);
		echo json_encode(['data'=>$post_types, 'errors'=>[]]);
		exit;
	}
}
