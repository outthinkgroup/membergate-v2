<?php

namespace Membergate\AJAX;

use Membergate\Settings\ListProviderSettings;

class SaveGeneralListSettings implements AjaxInterface
{
    const ACTION = 'save_list_settings';

    public $dependencies = ['list_settings'];

    private ListProviderSettings $list_settings;

    public function __construct()
    {
    }

    public function set_dependencies($list_settings)
    {
        $this->list_settings = $list_settings;
    }

    public function get_name(): string
    {
        return self::class;
    }

    public function get_action(): string
    {
        return self::ACTION;
    }

    public function handle()
    {
        if (isset($_POST['providerName'])) {
            $this->list_settings->set_provider($_POST['providerName']);
        }
        $provider_class = $this->list_settings->get_provider_settings_class();
        $provider_class = new $provider_class();
        $result = $provider_class->update_settings($_POST);
        if ($result->has_error()) {
            echo json_encode(['data' => 0, 'errors' => $result->errors]);
            exit;
        }
        echo json_encode(['data' => $result->data, 'errors' => []]);
        exit;
    }
}
