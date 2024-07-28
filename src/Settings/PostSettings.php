<?php

namespace Membergate\Settings;

class PostSettings {
    public $id;
    private $settings = [
        "membergate_should_set_cookie" => false,
        "membergate_cookie_key" => "is_member",
        "membergate_cookie_value" => "true",
    ];

    /**
     * @param int|null $id
     **/
    public function __construct($id = null) {
        if (is_null($id)) {
            $id = get_the_ID();
        }
        $this->id = $id;
    }
    /**
     * @return int|bool|mixed
     * @param mixed $name
     * @param mixed $args
     */
    public function __call($name, $args = null): mixed {
        error_log("DEBUG: " . $name);
        if (in_array($name, $this->available_options())) {
            // if their is an arg passed we will set it.
            if (isset($args[0]) && !is_null($args[0])) {
                $result = update_post_meta($this->id, $name, $args[0]);
                return $result;
            }
            // if null then we will return it
            $value = get_post_meta($this->id, $name, true);
            if (!$value) {
                // set it to default
                $value = $this->settings[$name];
            }
            return $value;
        } else {
            throw new \Exception("Not a valid Setting $name");
        }
    }
    /**
     * @return int[]|string[]
     */
    public function available_options(): array {
        return array_keys($this->settings);
    }
}
