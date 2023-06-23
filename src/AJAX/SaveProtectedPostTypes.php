<?php

namespace Membergate\AJAX;

use Membergate\Settings\PostTypeSettings;

class SaveProtectedPostTypes implements AjaxInterface {
    public const ACTION = 'save_protected_post_types';

    private PostTypeSettings $post_type_settings;

    public $dependencies = ['post_type_settings'];


    public function __construct(PostTypeSettings $post_type_settings) {
        $this->post_type_settings = $post_type_settings;
    }

    public function get_action(): string {
        return self::ACTION;
    }

    public function get_name(): string {
        return self::class;
    }

    public function handle() {
        $post_types = $this->post_type_settings->get_all();
        foreach ($post_types as $ptype => $data) {
            if (isset($_POST[$ptype])) {
                $data['protected'] = $_POST[$ptype]; // this will be the string value of "true" or "false"
                $post_types[$ptype] = $data;
            }
        }

        if (! $post_types) {
            echo json_encode(['data' => [], 'errors' => ['No post types were provided']]);
            exit;
        }

        $post_types = $this->post_type_settings->save($post_types); // this saves em all
        echo json_encode(['data' => $post_types, 'errors' => []]);
        exit;
    }
}
