<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;
use Membergate\Shortcode\MembergateFormRenderer;

class MembergateFormConfiguration implements ContainerConfigurationInterface
{
    public function modify(Container $container)
    {
        $container['form_renderer'] = $container->service(function (Container $container) {
            $form_settings = $container['settings.forms'];
            $template_path = apply_filters('membergate_form_template_path', $container['plugin_path'].'templates/');

            return new MembergateFormRenderer($form_settings, $template_path);
        });
    }
}
