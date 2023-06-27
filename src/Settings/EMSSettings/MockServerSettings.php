<?php

namespace Membergate\Settings\EMSSettings;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\Common\PossibleError;

/**
 *  Saves and Gets settings required to use FOR using the  MOCK Server During Testing
 *
 *  apikey
 *  list_id
 *  group_id
 *
 *	TODO: add merge fields
 **/
class MockServerSettings implements EMSSettingsInterface {
    public const PREFIX = 'membergate_mockserver';

    private string $apikey;

    private string $list_id;

    private string $group_id; // tag_name

    private array $valid_options = ['apikey', 'list_id', 'group_id'];

    public function __construct() {
        $this->apikey = get_option(self::PREFIX . 'apikey', '');
        $this->list_id = get_option(self::PREFIX . 'list_id', '');
        $this->group_id = get_option(self::PREFIX . 'group_id', '');
    }

    public function update_settings(array $post_arr): PossibleError {
        $errors = [];
        $data = [];

        if (isset($post_arr['apikey'])) {
            $res = $this->update_setting('apikey', $post_arr['apikey']);
            if ($res->has_error()) {
                $errors[] = $res->error;
            }
            if ($res->value) {
                $data[] = $res->value;
            }
        }
        if (isset($post_arr['list_id'])) {
            $res = $this->update_setting('list_id', (string)$post_arr['list_id']);
            if ($res->has_error()) {
                $errors[] = $res->error;
            }
            if ($res->value) {
                $data[] = $res->value;
            }
        }
        if (isset($post_arr['group_id'])) {
            $res = $this->update_setting('group_id', $post_arr['group_id']);
            if ($res->has_error()) {
                $errors[] = $res->error;
            }
            if ($res->value) {
                $data[] = $res->value;
            }
        }
        $data = count($data) > 0 ? $data : null;
        $errors = count($errors) > 0 ? $errors : null;
        return new PossibleError($data, $errors);
    }

    public function update_setting(string $key, $value): PossibleError {
        $this->valid_options = ['apikey', 'list_id', 'group_id'];
        if (! in_array($key, $this->valid_options)) {
            $options_string = implode(',', $this->valid_options);
            return new PossibleError(null, "$key is not a valid option: use $options_string");
        }
        $this->{$key} = $value;
        if ($value===0) {
            $value='0';
        }
        $res = update_option(self::PREFIX . $key, $value);

        return new PossibleError($res);
    }

    public function get_settings(): PossibleError {
        $data = [
            'apikey' => $this->apikey,
            'list_id' => (string)$this->list_id,
            'group_id' => $this->group_id,
        ];

        return new PossibleError($data);
    }

    public function get_setting(string $key): PossibleError {
        if (! in_array($key, $this->valid_options)) {
            $options_string = implode(',', $this->valid_options);

            return new PossibleError(null, "$key is not a valid option: use $options_string");
        }
        $option = (string)$this->{$key};
        $res = new PossibleError();
        $res->value = sprintf("%s", $option);
        return $res;
    }
}
