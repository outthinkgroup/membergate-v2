<?php
namespace Membergate\Subscriber;

use Membergate\Common\MemberCookie;
use Membergate\Configuration\MembergateFormConfiguration;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\PostTypeSettings;
use Membergate\Settings\ProtectedContentSettings;

class AddModalTemplateSubscriber implements SubscriberInterface {
	private MembergateFormConfiguration $render_form;
	private ProtectedContentSettings $protect_content_settings;
	private PostTypeSettings $post_type_settings;

	public static function get_subscribed_events():array{
		$hooks = [
			'wp_footer' => 'render_modal_template',
			'the_permalink' =>[  'mark_protected_with_queryparm',10, 2 ],
		];
		foreach(get_post_types() as $type){
			$hooks[$type . "_link"] = ['mark_protected_with_queryparm',10,2];
		}
		return $hooks;
	}

	public function __construct(MembergateFormConfiguration $render_form, ProtectedContentSettings $protect_content_settings, PostTypeSettings $post_type_settings){
		$this->render_form = $render_form;
		$this->protect_content_settings = $protect_content_settings;
		$this->post_type_settings = $post_type_settings;
	}

	//If user has opted out return;
	private function can_use_modal(){
		$use_modal_setting = $this->protect_content_settings->get_setting('show_modal');
		$c = new MemberCookie();
		return ((!$use_modal_setting->has_error()) || $use_modal_setting->value == 'true') && !($c->user_has_cookie() || is_user_logged_in());
	}
	
	public function mark_protected_with_queryparm($url){
		if(is_admin())return;
		if(!$this->can_use_modal()) return $url;

		$id = url_to_postid($url);
		if(!$id) return $url;

		if($this->post_type_settings->is_post_protected($id)){
			$url = add_query_arg("membergate_protect","true",$url);
		}
		return $url;
	}

	public function render_modal_template(){
		if(!$this->can_use_modal()){
			return;
		}
		?>
		<template id="membergate-modal-template">
			<?php $this->render_form->modal_markup(); ?>
		</template>
		<?php
	}

}