<?php

namespace Membergate\FormHandlers;

interface FormHandlerInterface {
    public function execute_action(array $submission);
}
