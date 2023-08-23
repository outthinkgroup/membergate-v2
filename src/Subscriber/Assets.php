<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\Assets\Vite;
use Membergate\EventManagement\SubscriberInterface;

class Assets implements SubscriberInterface {
    public $vite;
    public function __construct(Vite $vite){
        $this->vite = $vite;
    }
    public static function get_subscribed_events(): array {
        return [
            'admin_enqueue_scripts' => 'enqueue_admin_assets',
            'script_loader_tag' => ['use_esm_modules', 10, 3],
            'wp_enqueue_scripts' => 'enqueue_form_syles',
        ];
    }

    public function enqueue_admin_assets($hook) {
        //check get_current_screen
        if ($hook == 'toplevel_page_membergate-settings') {
            $this->vite->use('assets/main.ts');
        }

        if (get_current_screen()->id == 'membergate_rule') {
            $this->vite->use("assets/rule-editor.ts");
        }

    }

    public function enqueue_form_syles() {
        $this->vite->use('assets/frontend.ts');
    }

    public function use_esm_modules($tag, $handle, $src) {
        if (false !== stripos($handle, 'module')) {
            $str = "type='module'";
            $str .= MG_IS_DEVELOPMENT ? ' crossorigin' : '';
            $tag = str_replace("type='text/javascript'", $str, $tag);

            return "<script type='module' src='$src' id='$handle' crossorigin></script>";
        } else {
            return $tag;
        }
    }

}
