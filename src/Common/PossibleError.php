<?php

namespace Membergate\Common;

class PossibleError {
    public $error;

    public $value;

    public function __construct($value = null, $error = null) {
        if ($value) {
            $this->value = $value;
        }
        if ($error) {
            $this->error = $error;
        }
    }

    public function has_error() {
        if ($this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function get_value() {
        return $this->value;
    }
}
