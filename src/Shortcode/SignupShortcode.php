<?php

namespace Membergate\Shortcode;

class SignupShortcode implements ShortcodeInterface {
	private $template_dir_path;
	private $template_name = "signup_form";
	
	public function __construct($base_path,$template_dir){
		$this->template_dir_path = $base_path . '/' . $template_dir;
	}

	public function get_template_path(): string{
		return $this->template_dir_path . '/' . $this->template_name . '.php';	
	}

	public function get_default_args(): array{
		return [];	
	}
}
