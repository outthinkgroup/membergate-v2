<?php

namespace Membergate\Subscriber;

use Membergate\Common\MemberCookie;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\PostTypeSettings;
use Membergate\Settings\ProtectedContentSettings;
use Membergate\RenderForm\MembergateFormRenderer;

class AddModalTemplateSubscriber implements SubscriberInterface {
    private MembergateFormRenderer $render_form;

    private ProtectedContentSettings $protect_content_settings;

    private PostTypeSettings $post_type_settings;

    public static function get_subscribed_events(): array {
        $hooks = [
            'wp_footer' => 'render_modal_template',
            'post_type_link' => ['mark_protected_with_queryparm', 10, 2],
            'post_link' => ['mark_protected_with_queryparm', 10, 2],
        ];
        return $hooks;
    }

    public function __construct(MembergateFormRenderer $render_form, ProtectedContentSettings $protect_content_settings, PostTypeSettings $post_type_settings) {
        $this->render_form = $render_form;
        $this->protect_content_settings = $protect_content_settings;
        $this->post_type_settings = $post_type_settings;
    }

    //If user has opted out return;
    private function can_use_modal(): bool {
        $use_modal_setting = $this->protect_content_settings->get_setting('show_modal');
        $c = new MemberCookie();

        // Is the modal setting turned on and was accessed without an error
        $can_use_modal_setting = (!$use_modal_setting->has_error()) && $use_modal_setting->value == 'true';

        // is the user an logged-in, in an production environment 
        $is_admin_on_production = (is_user_logged_in() && wp_get_environment_type() == "production");

        // does the user have privilages to view content
        $should_block_user = !( $c->user_has_cookie() || $is_admin_on_production);

        return $can_use_modal_setting && $should_block_user;
    }

    public function mark_protected_with_queryparm($url, $post) {
        if (is_admin()) {
            return $url;
        }

        if (!$this->can_use_modal()) {
            return $url;
        }

        $id = $post->ID;

        if ($this->post_type_settings->is_post_protected($id)) {
            $url = add_query_arg('membergate_protect', 'true', $url);
        }

        return $url;
    }

    public function render_modal_template() {
        if (!$this->can_use_modal()) {
            return;
        }
        ?>
        <template id="membergate-modal-template">
            <?php $this->render_form->modal_markup(); ?>
        </template>
<?php
    }
}
