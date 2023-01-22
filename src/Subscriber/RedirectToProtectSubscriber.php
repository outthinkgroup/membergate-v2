<?php
namespace Membergate\Subscriber;

use Membergate\Common\MemberCookie;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\PostTypeSettings;

class RedirectToProtectSubscriber implements SubscriberInterface {
	private $post_type_settings;
	private $form_renderer;
	public function __construct(PostTypeSettings $post_type_settings, $form_renderer ){
		$this->post_type_settings = $post_type_settings;
		$this->form_renderer = $form_renderer;
	}

	public static function get_subscribed_events():array{
		
		return [
			'template_redirect'=> 'protect_protected_types_template',
			'the_content' => 'protect_protected_types_content',
		];
	}

	public function protect_protected_types_template(){
		if( is_user_logged_in() ) return;
		global $post;
		$is_protected = $this->post_type_settings->is_post_protected($post->ID);
		if(!$is_protected) return; 

		$cookie_handler = new MemberCookie();
		if($cookie_handler->user_has_cookie()){
			return; 
		}

		$use_page_redirect = apply_filters("use_page_redirect", false, $post);
		if($use_page_redirect){
			$this->form_renderer->include_form("signup_form");
			exit;
		}
	}

	public function protect_protected_types_content($content){
		global $post;
		if( is_user_logged_in() ) return $content;
		$is_protected = $this->post_type_settings->is_post_protected($post->ID);
		if(!$is_protected) return $content;

		$cookie_handler = new MemberCookie();
		if($cookie_handler->user_has_cookie()){
			return $content;
		}

		error_log("the_content is getting called");
		// returning subscribe form
		$this->form_renderer->include_full_form_markup("signup_form");
		exit;
	}

}
