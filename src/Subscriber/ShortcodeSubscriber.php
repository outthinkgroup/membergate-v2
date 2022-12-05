<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\SubscriberInterface;
use Membergate\Shortcode\ShortcodeInterface;
use Membergate\Shortcode\SignupShortcode;

class ShortcodeSubscriber implements SubscriberInterface {
	public function __construct($path){
		$this->path = $path;	
	}

	public static function get_subscribed_events(): array{
		return [
			'init'=>'load_shortcodes',	
		];
	}
	public function load_shortcodes(){
		$shortcodes = [
			'mg_signup_form'=> SignupShortcode::class,
		];

		foreach($shortcodes as $name=>$shortcode_class){
			$shortcode = new $shortcode_class($this->path, 'templates');
			if($shortcode instanceof ShortcodeInterface){
				$template_path = $shortcode->get_template_path();
				$args = $shortcode->get_default_args();	

				add_shortcode($name, function($atts) use($template_path, $args,$name) {
					$atts = shortcode_atts($args,$atts, $name);
					ob_start();
					include $template_path;
					$template = ob_get_clean();
					unset($atts);
					return $template;
				});
			}
		}
	}
}
