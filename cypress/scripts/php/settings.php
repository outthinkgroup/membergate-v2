<?php

global $membergate;

$settings = json_decode($args[0], true);
/*
    'settings.list_provider'
    'settings.post_types'
    'settings.protected_content'
    'settings.forms'
    'settings.account'
 */

foreach($settings as $setting=>$value){
    $setting_conf = $membgate->get_container("settings.$setting");
    if($setting == 'list_provider'){
        if($provider = $value['membergate_provider']){
            $setting_conf->set_provider($provider);
            $provider_conf = $setting_conf->get_provider_settings_class($provider)['settings'];
            $provider_conf->update_settings($value['provider_settings']);
        } else {
            continue;
        }
    }
    if($setting = 'account'){
        $setting_conf->set_is_setup($value);
    } 

    // THE REST
    else {
        $setting_conf->save($value);
    }
}


