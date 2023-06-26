<?php

namespace Membergate\Configuration;

use Illuminate\Container\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\EventManagement\EventManager;
use Membergate\Subscriber\AddModalTemplateSubscriber;
use Membergate\Subscriber\AdminPageAJaxSubscriber;
use Membergate\Subscriber\AdminSubscriber;
use Membergate\Subscriber\AssetSubscriber;
use Membergate\Subscriber\FormSubmissionSubscriber;
use Membergate\Subscriber\LoadAdditionalPostTypesSubscriber;
use Membergate\Subscriber\ProtectPostMetaBoxSubscriber;
use Membergate\Subscriber\RedirectToProtectSubscriber;
use Membergate\Subscriber\ServerRenderSettingsSubscriber;
use Membergate\Subscriber\ShortcodeSubscriber;

class EventManagementConfiguration {
    public function get_subscribers() {
        $subscribers = [
            //add Subscriber classes
             FormSubmissionSubscriber::class,
             ShortcodeSubscriber::class,
             AssetSubscriber::class,
             AdminSubscriber::class,
             AdminPageAJaxSubscriber::class,
             RedirectToProtectSubscriber::class,
             ServerRenderSettingsSubscriber::class,
             ProtectPostMetaBoxSubscriber::class,
             LoadAdditionalPostTypesSubscriber::class,
             AddModalTemplateSubscriber::class,
        ];

        return $subscribers;
    }

    public function make_subscribers(Container $container){
        $classes = [];
        foreach($this->get_subscribers() as $subber){
            $classes[] = [$subber, 'subscriber'];
        } 

        foreach ($classes as $class_cfg) {
            $tag = null;
            if(is_array($class_cfg)){
                $tag = $class_cfg[1];
                $class = $class_cfg[0];
            } else {
                $class = $class_cfg;
            }
            
            $container->get($class);
            if($tag){
                $container->tag($class,$tag);
            }
        }
    }
}

/*
    public function get_subscribers() {
        $subscribers = [
            //add Subscriber classes
            new FormSubmissionSubscriber($container['form_handler']),
            new ShortcodeSubscriber($container),
            new AssetSubscriber(),
            new AdminSubscriber($container['plugin_path']),
            new AdminPageAJaxSubscriber($container['settings.list_provider'], $container['list_providers'], $container['settings.post_types'], $container['settings.forms'], $container['settings.protected_content'], $container['form_renderer']),
            new RedirectToProtectSubscriber($container['settings.post_types'], $container['form_renderer'], $container['settings.protected_content']),
            new ServerRenderSettingsSubscriber($container['settings.list_provider'], $container['list_providers'], $container['settings.account'], $container['settings.post_types'], $container['settings.forms'], $container['settings.protected_content']),
            new ProtectPostMetaBoxSubscriber($container['settings.post_types']),
            new LoadAdditionalPostTypesSubscriber($container['settings.post_types']),
            new AddModalTemplateSubscriber($container['form_renderer'], $container['settings.protected_content'], $container['settings.post_types']),
        ];

        return $subscribers;
    }

 */
