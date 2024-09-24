<?php
namespace Membergate\Configuration;

interface ModifierInterface {
    public function checkPost(\WP_Post $post):bool;
    public function onEvent():string;
}
