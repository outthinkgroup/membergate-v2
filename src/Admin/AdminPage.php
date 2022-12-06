<?php

namespace Membergate\Admin;

class AdminPage {
	private $template_path;
	
	public function __construct($template_path){
		$this->template_path = $template_path;	
	}

	public function get_page_title(){
		return "Membergate Setup";	
	} 

	public function get_menu_title(){
		return "Membergate";
	} 

	public function get_capability(){
		return "manage_options";	
	}

	public function get_slug(){
		return "membergate-settings";
	} 

	public function render_page(){
		error_log("running AdminPage\-\>render_page");
		$this->render_template('admin_settings');	
	}

	public function render_template($template){
		$template_path = $this->template_path . '/' . $template . '.php';	
		error_log($template_path);
		if (!is_readable($template_path)){
			error_log("$template_path is not readable");
			return;
		}

		include $template_path;
	}
}
