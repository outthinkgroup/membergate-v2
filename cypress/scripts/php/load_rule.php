<?php

use Membergate\Settings\RuleEditor;

if (!is_readable($args[0])) {
    throw new \RuntimeException("No valid file was given as input");
}
$json = file_get_contents($args[0]);
$settings = json_decode($json);

$rule_editor = new RuleEditor;
error_log(print_r($settings, true));
$rule_editor->save_rules($settings->config);

