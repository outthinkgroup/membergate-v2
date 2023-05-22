<?php

global $membergate;

$settings = json_decode($args[0], true);
error_log($args[0]);
error_log(print_r($settings, true));
/*
    'settings.list_provider'
    'settings.post_types'
    'settings.protected_content'
    'settings.forms'
    'settings.account'
 */

foreach ($settings as $setting => $value) {
    $setting_conf = $membergate->get_container("settings.$setting");
    debug($setting_conf);
    if ($setting == 'list_provider') {
        if ($provider = $value['membergate_provider']) {
            $setting_conf->set_provider($provider);
            $provider_conf = $setting_conf->get_provider_settings_class($provider)['settings'];
            fwrite(STDOUT, print_r($provider_conf->update_settings($value['provider_settings'], true)));
        } else {
            continue;
        }
    }
    if ($setting == 'account') {
        $setting_conf->set_is_setup($value);
    }

    // THE REST
    else {
        fwrite(
            STDOUT,
            print_r($setting_conf->save($value), true)
        );
    }
}
