<?php
namespace Membergate\Settings;

use Membergate\Common\PossibleError;

class PostTypeSettings {
	const POST_TYPE_KEY = "membergate_post_type";
	const POST_META_KEY = "membergate_post_is_protected";
	private $post_types;
	public function __construct(){
		$this->post_types = get_option(self::POST_TYPE_KEY, []);
		$this->post_types = $this->ensure_contains_all_post_types();
	}

	public function add_addtional_post_types(){
		$this->post_types = $this->ensure_contains_all_post_types();
		$this->save();
	}

	public function get_all(){
		return $this->post_types;	
	}

	public function save($post_types=null){
		if($post_types){
			$this->post_types = $post_types;
		}else{
			$post_types = $this->post_types;
		}
		$res = update_option(self::POST_TYPE_KEY, $post_types);
		return $post_types;	
	}

	public function get_type($type): PossibleError {
		if(!is_string($type))	return new PossibleError(null, "Not a valid post type slug: $type");
		if(!key_exists($type, $this->post_types)){
			return new PossibleError(null, "Not a valid post type slug: $type");
		}	
		return new PossibleError($this->post_types[$type]);
	}

	public function is_post_protected($post_id){
		// first check if post has meta	

		$post_meta = get_post_meta($post_id, self::POST_META_KEY, true);
		debug([$post_id=>$post_meta]);
		if( $post_meta === "always" || $post_meta === "never" ){
			return $post_meta === "always" ? true : false;
		}
		// if not check default post type settings
		$ptype = get_post_type($post_id);
		$default = $this->get_type($ptype);
		if ($default->has_error()){
			debug($default);
			return false;
		}

		return $default->value['protected'];
	}
	public function set_post_protected_meta($post_id,$value){
		$res = update_post_meta($post_id, self::POST_META_KEY,$value); 
	}

	private function ensure_contains_all_post_types(){
		$current_post_types = get_post_types(['public'=>true],'object');
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


