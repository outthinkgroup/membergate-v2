<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\Configuration\ProtectContent;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\RuleEditor;

class ProtectSubscriber implements SubscriberInterface {

    public function __construct(private ProtectContent $protect_content, private RuleEditor $ruleEditor) {
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


    public function get_protect_status(): void {
        $this->protect_content->configure_protection();
    }

    public function overlay_protect(): void {
        if (!$this->protect_content->is_protected) return;

        if (
            $this->protect_content->activated_rule_id > 0
            && $this->uses_overlay_method()
        ) {
            $overlayContent = $this->protect_content->overlayContent;
            $protect_method = $this->protect_content->get_active_rule()?->protect_method();
            if (is_null($protect_method)) {
                return;
            }
            $overlay = get_post((int)$protect_method->value);
            if (!$overlay) {
                error_log("Could not find overlay with id " . $protect_method->value);
                return;
            }
            $pid = get_the_ID();
            if ($pid == false) return;
            $overlay_settings = get_post_meta($overlay->ID, "membergate_overlay_settings", true);
?>
            <div id="membergate_overlay_root">
                <div class="membergate-overlay-wrapper" style="<?= $this->ruleEditor->as_css_vars($overlay_settings); ?>">
                    <?= $overlayContent; ?>
                </div>
            </div>
<?php
        }
    }


    public function redirect_protect(): void {
        if (!$this->protect_content->is_protected) return;

        $protected_post_id = get_the_ID();
        $protect_condition_id = $this->protect_content->activated_rule_id;
        $protect_method = $this->protect_content->get_active_rule()?->protect_method();

        if ($protect_method?->method == 'redirect') {
            $page = get_post(intval($protect_method->value));
            // avoid redirect loops
            if (get_the_ID() == $page->ID) return;

            /** @var string $link */
            $link = get_permalink($page);
            if ($protected_post_id != false) {
                $protected_link = get_permalink($protected_post_id);
                if ($protected_link != false && $protected_link != "") {
                    $link = add_query_arg('redirect_url', $protected_link, $link);
                    $link = add_query_arg('condition_id', $protect_condition_id, $link);
                }
            }
            wp_safe_redirect($link);
            exit;
        }
    }

    private function uses_overlay_method(): bool {
        return $this->protect_content->get_active_rule()?->protect_method()?->method == "overlay";
    }
}
