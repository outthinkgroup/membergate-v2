<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\SubscriberInterface;

class ServerRenderSettingsSubscriber implements SubscriberInterface {
	private $list_provider_settings;
	private $list_providers;
	public function __construct($list_provider_settings, $list_providers, $account_settings){
		$this->list_provider_settings = $list_provider_settings;
		$this->list_providers = $list_providers;
		$this->account_settings = $account_settings;
	}
	public static function get_subscribed_events(): array{
		return [
			'admin_head'=>'add_global_vars',
		];
	}

	public function add_global_vars(){
		$api_key = check_and_return( $this->list_provider_settings->get_api_key() );
		$provider_name = check_and_return( $this->list_provider_settings->get_provider() );
		$list_id = check_and_return($this->list_provider_settings->get_list_config()['list']);
		$group_id = check_and_return($this->list_provider_settings->get_list_config()['group']);

		$lists = "";
		$groups = "";
		if($provider_name && $api_key){
			$provider = new $this->list_providers[$provider_name]($api_key);
			$lists = $provider->get_lists();
			if($list_id){
				$groups = $provider->get_groups($list_id);
			}	
		}
		?>	
		<script>
			window.membergate = {
				url:"<?php echo admin_url('admin-ajax.php'); ?>",
				providers: {"mailchimp":"Mailchimp", "convertkit": "ConvertKit"},
				completedSetup: "<?=$this->account_settings->get_is_setup();?>",
				settings: {
					apiKey: "<?= $api_key; ?>",
					providerName: "<?= $provider_name; ?>",
					listId: "<?= $list_id; ?>",
					groupId: "<?= $group_id; ?>",
					lists: <?= json_encode($lists['lists']); ?>, 
					groups: <?= json_encode($groups); ?>,
				}
			}
		</script>
		<?php
	}


}

