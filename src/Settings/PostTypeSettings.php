<?php
namespace Membergate\Settings;

use Membergate\Common\PossibleError;

class PostTypeSettings {
	const POST_TYPE_KEY = "membergate_post_type";
	private $post_types;
	public function __construct(){
		$this->post_types = get_option(self::POST_TYPE_KEY, []);
		$this->post_types = $this->ensure_contains_all_post_types();
	}
	public function get_all(){
		return $this->post_types;	
	}

	public function save($post_types){
		$this->post_types = $post_types;
		update_option(self::POST_TYPE_KEY, $post_types);
		return $post_types;	
	}

	public function get_type($type): PossibleError {
		if(!key_exists($type, $this->post_types)){
			return new PossibleError(null, "Not a valid post type slug: $type");
		}	
		return new PossibleError($this->post_types[$type]);
	}

	private function ensure_contains_all_post_types(){
		$current_post_types = get_post_types([],'object');
		$default_settings = [];
		foreach($current_post_types as $cur_ptype) {
			$default_settings[$cur_ptype->name] = $this->create_default_ptype_settings($cur_ptype);
		}
		return array_merge($default_settings, $this->post_types);
	}

	private function create_default_ptype_settings(\WP_Post_Type $ptype){
		return [
			'slug' => $ptype->name,
			"name" => $ptype->label,
			"protected" => false,
		];	
	}
}


