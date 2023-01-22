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
		debug(["types "=>$types]);
		add_meta_box(self::PROTECT_POST_KEY . "_metabox", __( 'Protect with Membergate', 'textdomain' ),[$this,  'display_metabox' ], $types, 'side', 'high' );
	}
	public function save_protect_metabox_meta($post_id){
		debug($_POST);
		$this->post_type_settings->set_post_protected_meta($post_id, $_POST['membergate_should_protect_post']);
	}
	public function display_metabox($post){
		$is_protected = $this->post_type_settings->is_post_protected($post->ID);
		debug("is_protected $is_protected");
		?>
		<div class="membergate-protect-metabox-wrapper">
			<label for="membergate_should_protect_post">
				<input 
					type="checkbox" 
					name="membergate_should_protect_post" 
					id="membergate_should_protect_post" 
					<?= $is_protected ? "checked" : "" ?>
				/>
				<span>protect post</span>
			</label>
		</div>	
		<?php
	}
}
