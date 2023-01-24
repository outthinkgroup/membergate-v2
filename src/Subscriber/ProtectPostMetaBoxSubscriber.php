<?php
namespace Membergate\Subscriber;

use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\PostTypeSettings;

class ProtectPostMetaBoxSubscriber implements SubscriberInterface{
	const PROTECT_POST_KEY = "membergate_protect_post";
	private PostTypeSettings $post_type_settings;
	public static function get_subscribed_events():array{
		return [
			'add_meta_boxes'=>['add_protect_metabox',1],
			'save_post' => 'save_protect_metabox_meta',
		];
	}

	public function __construct(PostTypeSettings $post_type_settings){
		$this->post_type_settings = $post_type_settings;
	}

	public function add_protect_metabox(){
		$types = array_keys($this->post_type_settings->get_all());
		add_meta_box(self::PROTECT_POST_KEY . "_metabox", __( 'Protect with Membergate', 'textdomain' ),[$this,  'display_metabox' ], $types, 'side', 'high' );
	}
	public function save_protect_metabox_meta($post_id){
		$this->post_type_settings->set_post_protected_meta($post_id, $_POST['membergate_should_protect_post']);
	}
	public function display_metabox($post){
		$protect_status = $this->get_post_protect_status($post->ID);
		?>
		<div class="membergate-protect-metabox-wrapper">
			<label for="membergate_should_protect_post">
				<span>Protected Post Setting</span>

				<select name="membergate_should_protect_post" id="membergate_should_protect_post">
					<option value="default" <?= "default"  === $protect_status  ? "selected" : ""; ?>>Post Type Default</option>
					<option value="always"	<?= "always"   === $protect_status  ? "selected" : ""; ?>>Always Protect</option>
					<option value="never"		<?= "never"    === $protect_status  ? "selected" : ""; ?>>Never Protect</option>
				</select>
			</label>
		</div>	
		<?php
	}

	public function get_post_protect_status($id){
		$pmeta = get_post_meta($id,$this->post_type_settings::POST_META_KEY,true);	
		if($pmeta == "always" || $pmeta == "never"){
			return $pmeta;
		}else{
			return "default";
		}
	}
}
