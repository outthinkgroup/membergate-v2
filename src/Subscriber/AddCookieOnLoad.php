<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\PostSettings;

class AddCookieOnLoad implements SubscriberInterface {
    private $meta;
    public function __construct(PostSettings $meta) {
        $this->meta = $meta;
    }

    public static function get_subscribed_events(): array {
        return [
            'enqueue_block_editor_assets' => 'editor_assets',
            'init' => 'register_meta',
            'wp'=>'add_cookie',
        ];
    }

    public function editor_assets() {
        /*TODO rebuild this if needed*/
        // global $membergate;
        // $vars = $membergate->get_container()->get('Vars');
        // $asset_file = include($vars['plugin_path'] . 'extend-block-editor/build/index.asset.php');
        // wp_enqueue_script(
        //     'membergate-extend-block-editor',
        //     $vars['plugin_url'] . 'extend-block-editor/build/index.js',
        //     $asset_file['dependencies'],
        //     $asset_file['version'],
        //     true
        // );
        //
        // wp_localize_script(
        //     'membergate-extend-block-editor',
        //     'membergatePostMeta',
        //     array_reduce($this->meta->available_options(), function ($settings, $key) {
        //         $settings[$key] = $this->meta->{$key}();
        //         return $settings;
        //     }, []),
        // );
    }

    public function register_meta() {
        register_post_meta('', "membergate_should_set_cookie", [
            'type' => "boolean",
            'single' => true,
            'default' => false,
            'show_in_rest' => true,
        ]);

        register_post_meta('', "membergate_cookie_name", [
            'type' => "string",
            'single' => true,
            'default' => 'is_member',
            'show_in_rest' => true,
        ]);
        register_post_meta('', "membergate_cookie_value", [
            'type' => "string",
            'single' => true,
            'default' => 'true',
            'show_in_rest' => true,
        ]);
    }

    public function add_cookie(){
        if(!get_post_meta(get_the_ID(), "membergate_should_set_cookie", true)) return;
        $name = get_post_meta(get_the_ID(), "membergate_cookie_name", true);
        $value= get_post_meta(get_the_ID(), "membergate_cookie_value", true);
        setcookie($name,$value, time() + YEAR_IN_SECONDS, "/");
    }
}
