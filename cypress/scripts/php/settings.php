<?php

use Membergate\Settings\AccountSettings;
use Membergate\Settings\FormSettings;
use Membergate\Settings\ListProviderSettings;
use Membergate\Settings\PostTypeSettings;
use Membergate\Settings\ProtectedContentSettings;

global $membergate, $wpdb;
if (!is_readable($args[0])) {
    throw new \RuntimeException("No valid file was given as input");
}
$json = file_get_contents($args[0]);
$settings = json_decode($json, true);
error_log(print_r($settings, true));
$setting_classes = [
    'list_provider'=> ListProviderSettings::class,
    'post_types'=>PostTypeSettings::class,
    'protected_content'=>ProtectedContentSettings::class,
    'forms'=>FormSettings::class,
    'account'=>AccountSettings::class,
];
/*
    'settings.list_provider'
    'settings.post_types'
    'settings.protected_content'
    'settings.forms'
    'settings.account'
 */
// reset options to defaults
if (isset($settings['reset'])) {
    delete_option(PostTypeSettings::POST_TYPE_KEY);
    delete_option(ProtectedContentSettings::PROTECTED_CONTENT_KEY);
    delete_option(AccountSettings::WIZARD_COMPLETE_KEY);
    delete_option(FormSettings::FORM_KEY);
    delete_option(ListProviderSettings::PROVIDER_NAME);
    $wpdb->get_results($wpdb->prepare("DELETE * from wp_postmeta where meta_key=%s", PostTypeSettings::POST_META_KEY));
    unset($settings['reset']);
}
if (isset($settings['reset_non_essential'])) {
    delete_option(PostTypeSettings::POST_TYPE_KEY);
    delete_option(ProtectedContentSettings::PROTECTED_CONTENT_KEY);
    delete_option(FormSettings::FORM_KEY);
    unset($settings['reset_non_essential']);
}
foreach ($settings as $setting => $value) {
    $setting_conf = $membergate->get_container()->make($setting_classes[$setting]);
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
