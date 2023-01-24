<?php
namespace Membergate\Subscriber;

use Membergate\Common\MemberCookie;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\PostTypeSettings;
use Membergate\Settings\ProtectedContentSettings;

class RedirectToProtectSubscriber implements SubscriberInterface {
	private $post_type_settings;
	private $form_renderer;
	private ProtectedContentSettings $protected_content_settings;
	public function __construct(PostTypeSettings $post_type_settings, $form_renderer, $protected_content_settings ){
		$this->post_type_settings = $post_type_settings;
		$this->form_renderer = $form_renderer;
		$this->protected_content_settings = $protected_content_settings;

	}

	public static function get_subscribed_events():array{
		
		return [
			'wp'=> 'protect_protected_types_template',
			'the_content' => 'protect_protected_types_content',
			'the_excerpt'=>'remove_protect_content_for_excerpt',
		];
	}

	public function remove_protect_content_for_excerpt($excerpt){
		remove_filter('the_content', [$this, 'protect_protected_types_content']);
		return $excerpt;
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
		$use_page_redirect = $this->protected_content_settings->get_setting("protect_method")->value == "page_redirect";
		$use_page_redirect = apply_filters("use_page_redirect", $use_page_redirect, $post);
		if($use_page_redirect && $this->protected_content_settings->get_setting("redirect_page")->value !== ""){
			$url = get_permalink($this->protected_content_settings->get_setting("redirect_page")->value);
			$url = add_query_arg("redirect_to", get_permalink(), $url);
			wp_redirect($url);
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

		// returning subscribe form
		return $this->form_renderer->include_full_form_markup("signup_form");
	}

}
