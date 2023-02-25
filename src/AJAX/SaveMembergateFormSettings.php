<?php

namespace Membergate\AJAX;

use Membergate\Settings\FormSettings;

class SaveMembergateFormSettings implements AjaxInterface
{
    const ACTION = 'save_membergate_form_settings';

    private FormSettings $form_settings;

    public $dependencies = ['settings.forms'];

    public function __construct()
    {
        // $this->post_type_settings = $post_type_settings;
    }

    public function set_dependencies(FormSettings $form_settings)
    {
        $this->form_settings = $form_settings;
    }

    public function get_action(): string
    {
        return self::ACTION;
    }

    public function get_name(): string
    {
        return self::class;
    }

    public function handle()
    {
        $settings = $this->form_settings->get_all();
        foreach ($settings	as $key => $val) {
            if (isset($_POST[$key])) {
                $settings[$key] = $_POST[$key];
            }
        }
        $updated = $this->form_settings->save($settings);
        echo json_encode(['data' => $updated, 'errors' => []]);
        exit;
    }
}
