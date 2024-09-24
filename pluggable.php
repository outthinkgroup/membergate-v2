<?php

use Membergate\Plugin;

if (!defined('ABSPATH')) {
    exit;
}

if(!defined("membergate")){
    function membergate():Plugin{
        global $membergate;
        return $membergate;
    }
}

