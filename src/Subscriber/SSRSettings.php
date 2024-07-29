<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\RuleEditor;
use Membergate\Settings\Rules;

class SSRSettings implements SubscriberInterface {

    public function __construct(
        private RuleEditor $ruleEditor
    ) {
    }

    public static function get_subscribed_events(): array {
        return [
            'wp_head' => 'add_public_vars',
            'admin_head' => 'render_rule_settings',
        ];
    }

    /**
     * @return void
     */
    public function render_rule_settings(): void {
        if (get_current_screen()->id == "admin_page_membergate-rules") {
            $this->ruleEditor->render_rule_settings();
        }
    }
    /**
     * @return void
     */
    public function add_public_vars(): void {
?>
        <script>
            window.publicMembergate = {
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
            }
        </script>
<?php
    }
}
