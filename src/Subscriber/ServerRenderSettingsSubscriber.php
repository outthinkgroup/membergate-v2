<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\SubscriberInterface;

class ServerRenderSettingsSubscriber implements SubscriberInterface {
	private $list_provider_settings;
	public function __construct($list_provider_settings, $account_settings){
		$this->list_provider_settings = $list_provider_settings;
		$this->account_settings = $account_settings;
	}
	public static function get_subscribed_events(): array{
		return [
			'admin_head'=>'add_global_vars',
		];
	}

	public function add_global_vars(){
		?>	
		<script>
			window.membergate = {
				url:"<?php echo admin_url('admin-ajax.php'); ?>",
				providers: {"mailchimp":"Mailchimp", "convertkit": "ConvertKit"},
				completedSetup: "<?=$this->account_settings->get_is_setup();?>",
				settings: {
					apiKey: "<?= check_and_return( $this->list_provider_settings->get_api_key() ); ?>",
					providerName: "<?= check_and_return( $this->list_provider_settings->get_provider() ); ?>",
					list: "<?= check_and_return($this->list_provider_settings->get_list_config()['list']); ?>",
					group: "<?= check_and_return($this->list_provider_settings->get_list_config()['group']); ?>",
				}
			}
		</script>
		<?php
	}


}

