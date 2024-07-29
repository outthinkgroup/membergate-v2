<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\Configuration\ProtectContent;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\Rules;

class Protect implements SubscriberInterface {

    private $rules;
    private $protect_content;

    public function __construct(Rules $rules, ProtectContent $protect_content) {
        $this->rules = $rules;
        $this->protect_content = $protect_content;
    }

    public static function get_subscribed_events(): array {
        //TODO: conditionally return these based on setings
        return [
            'wp' => 'get_protect_status',
            'template_redirect' => 'redirect_protect',
            // 'wp_enqueue_scripts' => 'add_overlay_assets',
            'wp_footer' => 'overlay_protect',
        ];
    }


    public function get_protect_status() {
        $this->protect_content->configure_protection();
    }

    public function overlay_protect() {
        if (!$this->protect_content->is_protected) return;

        if (
            $this->protect_content->activated_rule_id
            && $this->uses_overlay_method($this->protect_content->activated_rule_id)
        ) {
            $protect_condition_id = $this->protect_content->activated_rule_id;
            $protect_method = $this->rules->get_protect_method($protect_condition_id);
            $overlay = get_post((int)$protect_method->value);
            if(!$overlay){ 
                error_log("Could not find overlay with id ".$protect_method->value);
                return;
            }
            $overlay_content = $overlay->post_content;
            $overlay_settings = get_post_meta($overlay->ID, "membergate_overlay_settings", true);
?>
            <div id="membergate_overlay_root">
                <div class="membergate-overlay-wrapper" style="<?= $this->rules->rule_editor->as_css_vars($overlay_settings); ?>">
                    <?= apply_filters('the_content', $overlay_content); ?>
                </div>
            </div>
<?php
        }
    }


    public function redirect_protect() {
        if (!$this->protect_content->is_protected) return;

        $protected_post_id = get_the_ID();
        $protect_condition_id = $this->protect_content->activated_rule_id;
        $protect_method = $this->rules->get_protect_method($protect_condition_id);

        if ($protect_method->method == 'redirect') {
            $page = get_post(intval($protect_method->value));
            // avoid redirect loops
            if (get_the_ID() == $page->ID) return;

            $link = get_permalink($page);
            if ($protected_post_id) {
                $protected_link = get_permalink($protected_post_id);
                if ($protected_link) {
                    $link = add_query_arg('redirect_url', $protected_link, $link);
                    $link = add_query_arg('condition_id', $protect_condition_id, $link);
                }
            }
            wp_safe_redirect($link);
            exit;
        }
    }

    private function uses_overlay_method($condition_id) {
        return $this->rules->get_protect_method($condition_id)->method == "overlay";
    }
}
