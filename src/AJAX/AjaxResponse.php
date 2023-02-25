<?php

namespace Membergate\AJAX;

class AjaxResponse {
    private array $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function add_error($msg) {
        $this->data['errors'][] = $msg;
    }

    public function send() {
        echo json_encode($this->data);
        exit;
    }
}
