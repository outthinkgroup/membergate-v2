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
        if (get_current_screen()->id == "membergate_page_membergate-rules") {
            $post_types = $this->rules->editor->load_post_types();
            $id = (int)isset($_GET['id']) ? $_GET['id'] : 1;
            $rules = $this->rules->get_rules($id);
            $condition = $this->rules->get_conditions($id);
            $protect_method = $this->rules->get_protect_method($id);
?>
            <script>
                window.membergate = {
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    postId: "<?= $id; ?>",
                    title: "<?= get_the_title($id); ?>",
                    Rules: {
                        initialRuleValueOptionStore: {
                            post_type: <?= json_encode($post_types); ?>,
                        },
                        ruleList: <?= json_encode($rules); ?>,
                        ruleCondition: <?= json_encode($condition); ?>,
                        protectMethod: <?= json_encode($protect_method); ?>,
                    },
                }
            </script>
        <?php
        }
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
