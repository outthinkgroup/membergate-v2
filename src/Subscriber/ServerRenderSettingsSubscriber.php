<?php

namespace Membergate\Subscriber;

use Membergate\Configuration\ProvidersConfiguration;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\AccountSettings;
use Membergate\Settings\FormSettings;
use Membergate\Settings\ListProviderSettings;
use Membergate\Settings\PostTypeSettings;
use Membergate\Settings\ProtectedContentSettings;

class ServerRenderSettingsSubscriber implements SubscriberInterface {
    private ListProviderSettings $list_provider_settings;

    private PostTypeSettings $post_type_settings;

    private $account_settings;

    private $list_providers;

    private $form_settings;

    private $protect_content_settings;

    public function __construct(
        ListProviderSettings $list_provider_settings,
        ProvidersConfiguration $list_providers,
        AccountSettings $account_settings,
        PostTypeSettings $post_type_settings,
        FormSettings $form_settings,
        ProtectedContentSettings $protect_content_settings
    ) {
        $this->list_provider_settings = $list_provider_settings;
        $this->protect_content_settings = $protect_content_settings;
        $this->list_providers = $list_providers->providers();
        $this->account_settings = $account_settings;
        $this->post_type_settings = $post_type_settings;
        $this->form_settings = $form_settings;
    }

    public static function get_subscribed_events(): array {
        return [
            'admin_head' => 'add_global_vars',
            'wp_head' => 'add_public_vars',
        ];
    }

    public function add_global_vars() {
        $provider_settings_class = $this->list_provider_settings->get_provider_settings_class();

        // In case the class no longer exists for some reason. 
        // This can happen if the Mock server was selected, but the env is no longer in test mode
        if(class_exists($provider_settings_class)){
            $provider_settings_class = new $provider_settings_class();
        } else {
            $provider_settings_class = false;
        }
        $settings = $provider_settings_class ? $provider_settings_class->get_settings() : false;
        if (!$provider_settings_class || !$settings || $settings->has_error()) {
            $api_key = '';
            $provider_name = '';
            $list_id = '';
            $group_id = '';
        } else {
            $settings = $settings->value;
            $api_key = $settings['apikey'] ? $settings['apikey'] : '';
            $provider_name = $this->list_provider_settings->get_provider() ?: '';
            $list_id = !is_null($settings['list_id']) ? $settings['list_id'] : '';
            $group_id = !is_null($settings['group_id']) ? $settings['group_id'] : '';
        }

        $lists = '';
        $groups = '';
        if ($provider_name && $api_key) {
            $provider = new $this->list_providers[$provider_name]['client']($api_key);
            $lists = $provider->get_lists();
            if (!is_null($list_id)) {
                $groups = $provider->get_groups($list_id);
            }
        }

        $providers = array_reduce($this->list_providers, function ($acc, $provider) {
            $acc[$provider['client']::provider_name] = $provider['client']::label;
            return $acc;
        }, []);

        $pages = get_posts([
            'post_type' => 'page',
            'posts_per_page' => -1,
        ]);

        $page_list = array_reduce($pages, function ($list, $page) {
            $list[$page->ID] = $page->post_title;
            return $list;
        }, []);

        $post_types = $this->post_type_settings->get_all();
        $form_settings = $this->form_settings->get_all();
        $blocked_content = $this->protect_content_settings->get_all();
        ?>	
		<script>
			window.membergate = {
				url:"<?php echo admin_url('admin-ajax.php'); ?>",
                providers: <?= json_encode($providers); ?>,
				pageList: <?= json_encode($page_list); ?>,
				completedSetup: "<?=$this->account_settings->get_is_setup(); ?>",
				settings: {
					emailService:{
						apiKey: "<?= $api_key; ?>",
						providerName: "<?= $provider_name; ?>",
						listId: "<?= $list_id; ?>",
						groupId: "<?= $group_id; ?>",
						lists: <?= isset($lists['lists']) && is_array($lists['lists']) ? json_encode($lists['lists']) : '[]'; ?>, 
						groups: <?= is_array($groups) ? json_encode($groups) : '[]'; ?>,
					},
					postTypes:<?= json_encode($post_types); ?>,
					formSettings:<?= json_encode($form_settings); ?>,
					blockedContent:<?= json_encode($blocked_content); ?>,
				},
			}
		</script>
		<?php
    }

    public function add_public_vars() {
        ?>
	<script>
		window.publicMembergate = {
			url:"<?php echo admin_url('admin-ajax.php'); ?>",
		}
	</script>
	<?php
    }
}
