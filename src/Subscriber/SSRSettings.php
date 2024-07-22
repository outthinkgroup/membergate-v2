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
            'wp_head' => 'add_public_vars',
            'admin_head'=>'render_rule_settings',
        ];
    }

    public function render_rule_settings() {
        if (get_current_screen()->id == "admin_page_membergate-rules") {
            $this->rules->render_rule_settings();
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
