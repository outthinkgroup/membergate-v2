<?php

namespace Membergate;

use Membergate\Configuration\EventManagementConfiguration;
use Membergate\Configuration\FormHandlerConfiguration;
use Membergate\Configuration\MembergateFormConfiguration;
use Membergate\Configuration\ProvidersConfiguration;
use Membergate\Configuration\SettingsConfiguration;
use Membergate\DependencyInjection\Container;

class Plugin {
    public const DOMAIN = 'membergate';

    public const VERSION = '0.0.1';

    private $container;

    private $loaded;

    public function __construct($file) {
        $this->container = new Container([
            'plugin_basename' => plugin_basename($file),
            'plugin_domain' => self::DOMAIN,
            'plugin_path' => plugin_dir_path($file),
            'plugin_relative_path' => basename(plugin_dir_path($file)),
            'plugin_url' => plugin_dir_url($file),
            'plugin_version' => self::VERSION,
        ]);
        $this->loaded = false;
    }

    public function get_plugin_path() {
        return $this->container['plugin_path'];
    }

    public function get_plugin_url() {
        return $this->container['plugin_url'];
    }

    public function get_container($key) {
        return $this->container[$key];
    }

    public function load() {
        if ($this->loaded) {
            return;
        }

        $this->container->configure([
            EventManagementConfiguration::class,
            ProvidersConfiguration::class,
            SettingsConfiguration::class,
            FormHandlerConfiguration::class,
            MembergateFormConfiguration::class,
        ]);
        foreach ($this->container['subscribers'] as $subber) {
            $this->container['event_manager']->add_subscriber($subber);
        }

        $this->loaded = true;
    }
}
