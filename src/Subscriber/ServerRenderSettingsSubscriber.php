<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\ListProviderSettings;
use Membergate\Settings\PostTypeSettings;

class ServerRenderSettingsSubscriber implements SubscriberInterface {
	private ListProviderSettings $list_provider_settings;
	private PostTypeSettings $post_type_settings;
	private $account_settings;
	private $list_providers;
	private $form_settings;
	private $protect_content_settings;
	public function __construct($list_provider_settings, $list_providers, $account_settings, $post_type_settings, $form_settings, $protect_content_settings){
		$this->list_provider_settings = $list_provider_settings;
		$this->protect_content_settings = $protect_content_settings;
		$this->list_providers = $list_providers;
		$this->account_settings = $account_settings;
		$this->post_type_settings = $post_type_settings;
		$this->form_settings = $form_settings;
	}
	public static function get_subscribed_events(): array{
		return [
			'admin_head'=>'add_global_vars',
			'wp_head'=>'add_public_vars',
		];
	}

	public function add_global_vars(){
		$provider_settings_class = $this->list_provider_settings->get_provider_settings_class();
		$provider_settings_class = new $provider_settings_class();
		$settings = $provider_settings_class->get_settings();
		if( $settings->has_error() ){
			$api_key = "";
			$provider_name="";
			$list_id = "";
			$group_id = "";
		} else{
			$settings = $settings->value;
			$api_key = $settings['apikey'] ? $settings['apikey'] : "";
			$provider_name = $this->list_provider_settings->get_provider();
			$list_id = $settings['list_id'] ? $settings['list_id'] : "";
			$group_id = $settings['group_id'] ? $settings['group_id'] : "";
		}

		$lists = "";
		$groups = "";
		if($provider_name && $api_key){
			$provider = new $this->list_providers[$provider_name]['client']($api_key);
			$lists = $provider->get_lists();
			if($list_id){
				$groups = $provider->get_groups($list_id);
			}	
		}

		$pages = get_posts([
			'post_type'	=> "page",
			'posts_per_page' => -1,
		]);
		$page_list = array_reduce($pages, function($list, $page){
			$list[$page->ID] = $page->post_title;
			return $list;
		},[]);

		$post_types = $this->post_type_settings->get_all();
		$form_settings = $this->form_settings->get_all();
		$blocked_content = $this->protect_content_settings->get_all();
		?>	
		<script>
			window.membergate = {
				url:"<?php echo admin_url('admin-ajax.php'); ?>",
				providers: {"mailchimp":"Mailchimp", "convertkit": "ConvertKit"},
				pageList: <?= json_encode($page_list); ?>,
				completedSetup: "<?=$this->account_settings->get_is_setup();?>",
				settings: {
					emailService:{
						apiKey: "<?= $api_key; ?>",
						providerName: "<?= $provider_name; ?>",
						listId: "<?= $list_id; ?>",
						groupId: "<?= $group_id; ?>",
						lists: <?= isset($lists['lists']) && is_array($lists['lists']) ? json_encode($lists['lists']) : []; ?>, 
						groups: <?= is_array($groups) ? json_encode($groups) : []; ?>,
					},
					postTypes:<?= json_encode($post_types); ?>,
					formSettings:<?= json_encode($form_settings); ?>,
					blockedContent:<?= json_encode($blocked_content);?>,
				},
			}
		</script>
		<?php
	}

	public function add_public_vars(){
	?>
	<script>
		window.publicMembergate = {
			url:"<?php echo admin_url('admin-ajax.php'); ?>",
		}
	</script>
	<?php
	}
}

