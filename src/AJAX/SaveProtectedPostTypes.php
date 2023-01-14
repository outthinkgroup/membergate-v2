<?php

namespace Membergate\AJAX;

use Membergate\Settings\PostTypeSettings;

class SaveProtectedPostTypes implements AjaxInterface {
	const ACTION = "save_protected_post_types";
	private PostTypeSettings $post_type_settings; 
	public $dependencies = ['post_type_settings'];

	public function __construct(){
		// $this->post_type_settings = $post_type_settings;	
	}
	public function set_dependencies(PostTypeSettings $post_type_settings){
		$this->post_type_settings = $post_type_settings;	
	}


	public function get_action(): string {
		return self::ACTION;
	}

	public function get_name(): string {
		return self::class;
	}

	public function handle(){
		$post_types = $this->post_type_settings->get_all();
		foreach ( $post_types	as $ptype => $data ){
			if(isset($_POST[$ptype]))	{
				$data['protected'] = $_POST[$ptype];
				$post_types[$ptype] = $data;
			}
		}

		if(!$post_types){
			echo json_encode(['data'=>[],'errors'=>['No post types were provided']]);
			exit;
		}

		$post_types = $this->post_type_settings->save($post_types);
		echo json_encode(['data'=>$post_types, 'errors'=>[]]);
		exit;
	}
}
