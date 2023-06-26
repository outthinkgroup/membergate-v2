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
use Membergate\Subscriber\AdminSubscriber;

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
        return $this->container->make('Vars')['plugin_path'];
    }

    public function get_plugin_url() {
        return $this->container->make('Vars')['plugin_url'];
    }

    public function get_container() {
        return $this->container;
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
            return new AdminPage("/templates/", $vars['plugin_path']);
        });
        $this->container->singleton(MembergateFormRenderer::class, function(Container $container){
            $template_path = $container->make('Vars')['plugin_path']."/templates/";
            $template_path = apply_filters('membergate_form_template_path',$template_path);
            return new MembergateFormRenderer($container->make(FormSettings::class), $template_path);
        });
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


