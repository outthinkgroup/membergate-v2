<?php

namespace Membergate;

use Illuminate\Container\Container;
use Membergate\Configuration\EventManagementConfiguration;
use Membergate\EventManagement\EventManager;
use Membergate\RenderForm\MembergateFormRenderer;
use Membergate\Settings\FormSettings;
use Membergate\Subscriber\AdminSubscriber;

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
        return $this->container->make('Vars')['plugin_path'];
    }

    public function get_plugin_url() {
        return $this->container->make('Vars')['plugin_url'];
    }

    public function get_container() {
        return $this->container;
    }
    
    private function make_services() {

        // Required to be singleton so we can store errors and then render them.
        $this->container->singleton(MembergateFormRenderer::class, function(Container $container){
            $template_path = $container->make('Vars')['plugin_path']."/templates/";
            $template_path = apply_filters('membergate_form_template_path',$template_path);
            return new MembergateFormRenderer($container->make(FormSettings::class), $template_path);
        });
        // Needs Manual Binding to add the pluign path var
        $this->container->bind(AdminSubscriber::class, function (Container $container){
            return new AdminSubscriber($container->get('Vars')['plugin_path']);
        });

        //subscribers
        $emc = new EventManagementConfiguration;
        $emc->make_subscribers($this->container);
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


