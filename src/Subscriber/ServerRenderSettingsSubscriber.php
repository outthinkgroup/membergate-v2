<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\AccountSettings;
use Membergate\Settings\PostTypeSettings;

class ServerRenderSettingsSubscriber implements SubscriberInterface {

    private PostTypeSettings $post_type_settings;

    private $account_settings;

    private $list_providers;

    private $form_settings;

    private $protect_content_settings;

    public function __construct(
        AccountSettings $account_settings,
        PostTypeSettings $post_type_settings,
    ) {
        $this->account_settings = $account_settings;
        $this->post_type_settings = $post_type_settings;
    }

    public static function get_subscribed_events(): array {
        return [
            'admin_head' => 'add_global_vars',
            'wp_head' => 'add_public_vars',
        ];
    }

    public function add_global_vars() {

        // In case the class no longer exists for some reason.
        // This can happen if the Mock server was selected, but the env is no longer in test mode

        $pages = get_posts([
            'post_type' => 'page',
            'posts_per_page' => -1,
        ]);

        $page_list = array_reduce($pages, function ($list, $page) {
            $list[$page->ID] = $page->post_title;
            return $list;
        }, []);

        $post_types = $this->post_type_settings->get_all();
        ?>	
		<script>
			window.membergate = {
				url:"<?php echo admin_url('admin-ajax.php'); ?>",
				pageList: <?= json_encode($page_list); ?>,
				completedSetup: "<?=$this->account_settings->get_is_setup(); ?>",
				settings: {
					postTypes:<?= json_encode($post_types); ?>,
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
