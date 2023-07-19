<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\AccountSettings;
use Membergate\Settings\PostTypeSettings;
use Membergate\Settings\RuleEditor;

class SSRSettings implements SubscriberInterface {
    private PostTypeSettings $post_type_settings;

    private $account_settings;

    private $ruleEditor;

    private $list_providers;

    private $form_settings;

    private $protect_content_settings;

    public function __construct(
        AccountSettings $account_settings,
        PostTypeSettings $post_type_settings,
        RuleEditor $ruleEditor
    ) {
        $this->account_settings = $account_settings;
        $this->post_type_settings = $post_type_settings;
        $this->ruleEditor = $ruleEditor;
    }

    public static function get_subscribed_events(): array {
        return [
            'admin_head' => 'add_global_vars',
            'wp_head' => 'add_public_vars',
        ];
    }

    public function add_global_vars() {
        $post_types=$this->ruleEditor->load_post_types();
        ?>	
		<script>
			window.membergate = {
				url:"<?php echo admin_url('admin-ajax.php'); ?>",
				completedSetup: "<?=$this->account_settings->get_is_setup(); ?>",
                initialParameterValueStore:{
                    post_type: <?=json_encode($post_types); ?>,
                },
				settings: {
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
