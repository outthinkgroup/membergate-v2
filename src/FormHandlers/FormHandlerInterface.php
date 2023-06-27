<?php

namespace Membergate\FormHandlers;

if (!defined('ABSPATH')) {
    exit;
}

interface FormHandlerInterface {
    public function execute_action(array $submission);
}
