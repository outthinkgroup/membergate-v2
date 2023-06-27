<?php

namespace Membergate\Configuration;

if (!defined('ABSPATH')) {
    exit;
}

use Illuminate\Container\Container;
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

    public function make_subscribers(Container $container) {
        foreach ($this->get_subscribers() as $class) {
            $container->tag($class, 'subscriber');
        }
    }
}
