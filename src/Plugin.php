<?php

namespace Membergate;

use Illuminate\Container\Container;
use Membergate\Admin\AdminPage;
use Membergate\Configuration\EventManagementConfiguration;
use Membergate\Configuration\FormHandlerConfiguration;
use Membergate\Configuration\MembergateFormConfiguration;
use Membergate\Configuration\ProvidersConfiguration;
use Membergate\Configuration\SettingsConfiguration;
use Membergate\EventManagement\EventManager;
use Membergate\Settings\ListProviderSettings;
use Membergate\FormHandlers\AddSubscriberToService;
use Membergate\FormHandlers\CheckSubscriptionStatus;
use Membergate\RenderForm\MembergateFormRenderer;
use Membergate\Settings\FormSettings;

        //     'plugin_basename' => plugin_basename($file),
        //     'plugin_domain' => self::DOMAIN,
        //     'plugin_path' => plugin_dir_path($file),
        //     'plugin_relative_path' => basename(plugin_dir_path($file)),
        //     'plugin_url' => plugin_dir_url($file),
        //     'plugin_version' => self::VERSION,
        // ]);
/*╭──────────────────────────╮*/
/*│    [   The Plugin   ]    │*/
/*╰──────────────────────────╯*/
class Plugin {
    public const DOMAIN = 'membergate';

    public const VERSION = '0.0.1';

    private $container;

    private $loaded;
    private $file;

    public function __construct($file) {
        $this->container = new Container;
        $this->file = $file;
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

    private function make_services() {

        // $this->container->bind(ListProviderSettings::class, function(Container $container){
        //     return new ListProviderSettings($container->make(ProvidersConfiguration::class));
        // });
        // $this->container->bind(AddSubscriberToService::class, function(Container $container){
        //     return new AddSubscriberToService(
        //         $container->make(ListProviderSettings::classj
        //     );
        // });
        //
        $classes = [
        ];

        $this->container->bind(AdminPage::class, function(Container $container){
                $vars = $container->make('Vars');
                return new AdminPage($vars['template_path'], $vars['plugin_path']);
            });
        $this->container->bind(MembergateFormRenderer::class, function(Container $container){
            $vars = $container->make('Vars');
            return new MembergateFormRenderer($container->make(FormSettings::class), $vars['template_path']);
        });

        //subscribers
        $emc = new EventManagementConfiguration;
        foreach($emc->get_subscribers() as $subber){
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
            
            $this->container->get($class);
            if($tag){
                $this->container->tag($class,$tag);
            }
        }
    }

    public function load() {
        if ($this->loaded) {
            return;
        }

        $this->container->singleton('Vars',function(){
            return [            
                'plugin_basename' => plugin_basename($this->file),
                'plugin_domain' => self::DOMAIN,
                'plugin_path' => plugin_dir_path($this->file),
                'plugin_relative_path' => basename(plugin_dir_path($this->file)),
                'plugin_url' => plugin_dir_url($this->file),
                'plugin_version' => self::VERSION,
            ];
        });
        
        $this->container->singleton(EventManager::class, function(){
            return new EventManager;
        });

        // pulls all dependencies into container.
        $this->make_services();
        // adds event listeners to wordpress hooks
        $subscribers = $this->container->tagged('subscriber');
        foreach($subscribers as $subscriber){
            $this->container->make(EventManager::class)->add_subscriber($subscriber);
        }

        $this->loaded = true;
    }
}


