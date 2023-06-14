<?php

use Membergate\Settings\PostTypeSettings;

global $membergate, $wpdb;

$url = $args[0];
error_log($url);
$id = url_to_postid($url);
if (!$id) {
    throw new \Exception("URL 404 or did not have a post id");
}
if (!isset($args[1])) {
    throw new \Exception("No Meta file added");
}

$meta = $args[1];
if (!in_array($meta, ["default","always","never"])) {
    throw new \Exception("Not valid meta");
}
$pts = new PostTypeSettings();
$pts->set_post_protected_meta((int)$id, $meta);

debug(get_post_meta($id, PostTypeSettings::POST_META_KEY));
