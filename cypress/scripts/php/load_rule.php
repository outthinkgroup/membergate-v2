<?php

use Membergate\Settings\RuleEditor;

if (!is_readable($args[0])) {
    throw new \RuntimeException("No valid file was given as input");
}
$json = file_get_contents($args[0]);
$settings = json_decode($json);

global $membergate;
$rule_editor = $membergate->get_container()->get(RuleEditor::class);

