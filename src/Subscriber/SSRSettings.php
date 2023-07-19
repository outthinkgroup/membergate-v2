<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\Rules;

class SSRSettings implements SubscriberInterface {

    private $rules;

    public function __construct(
        Rules $rules
    ) {
        $this->rules = $rules;
    }

    public static function get_subscribed_events(): array {
        return [
            'admin_head' => 'add_global_vars',
            'wp_head' => 'add_public_vars',
        ];
    }

    public function add_global_vars() {
        $post_types = $this->rules->load_post_types();
?>
        <script>
            window.membergate = {
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                Rules: {
                    initialRuleValueOptionStore: {
                        post_type: <?= json_encode($post_types); ?>,
                    },
                },
            }
        </script>
    <?php
    }

    public function add_public_vars() {
    ?>
        <script>
            window.publicMembergate = {
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
            }
        </script>
    <?php
    }
}
