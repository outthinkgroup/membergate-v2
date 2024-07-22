<?php

namespace Membergate;

if (!defined('ABSPATH')) {
    exit;
}

use Exception;
use Illuminate\Container\Container;
use Illuminate\Container\EntryNotFoundException;
use Membergate\Assets\Vite;
use Membergate\Configuration\EventManagementConfiguration;
use Membergate\Configuration\ProtectContent;
use Membergate\Configuration\RuleEntity;
use Membergate\EventManagement\EventManager;
use Membergate\Settings\OverlayEditor;
use Membergate\Settings\Rules;
use Membergate\Subscriber\Admin;
use TypeError;

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
        $this->container = new Container();
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

    /**
     * @param int $id 
     * @return mixed 
     * @throws Exception 
     * @throws EntryNotFoundException 
     */
    private function maybe_get_protect_rule($id = null) {
        if ($id) {
            $rule_entity = $this->container->get(RuleEntity::class);
            $rule_entity->init($id);
            return $rule_entity;
        }
        $protect_content = $this->container->get(ProtectContent::class);
        return $protect_content->get_active_rule();
    }

    /**
     * Used By Extension Plugins to get the cookie_name and url to redirect to
     * @return array 
     * @throws Exception 
     * @throws EntryNotFoundException 
     */
    public function extension_protect_data() {
        $data = [];
        global $wp;

        $current_url = home_url(add_query_arg([], $wp->request));
        $redirect_url = $_GET['redirect_url'] ?? $current_url;
        $data['redirect_url'] = $redirect_url;

        $condition = $this->getCondition();
        $data['cookie_name'] = $condition->parameter === 'cookie' ? $condition->key : null;

        return $data;
    }

    /**
     * @return mixed 
     * @throws Exception 
     * @throws EntryNotFoundException 
     */
    private function getCondition() {
        $condition = null;

        if (isset($_GET['condition_id'])) {
            $rule_entity = $this->maybe_get_protect_rule(intval($_GET['condition_id']));
            $condition = $rule_entity->condition() ?? null;
        } elseif ($rule = $this->maybe_get_protect_rule()) {
            $condition = $rule->condition() ?? null;
        }

        return $condition;
    }

    /**
     * @return void 
     * @throws TypeError 
     */
    private function make_services() {
        // Needs Manual Binding to add the pluign path var
        $this->container->bind(Admin::class, function (Container $container) {
            return new Admin($container->get('Vars')['plugin_path']);
        });
        $this->container->bind(OverlayEditor::class, function (Container $container) {
            return new OverlayEditor($container->get('Vars')['plugin_url'], $container->get('Vars')['plugin_path']);
        });

        $this->container->singleton(Vite::class, function (Container $container) {
            $vars = $container->get('Vars');
            return new Vite($vars['plugin_url'], $vars['plugin_path']);
        });

        $this->container->singleton(ProtectContent::class, function (Container $container) {
            return new ProtectContent($container->get(Rules::class), $container->get(RuleEntity::class));
        });

        //subscribers
        $emc = new EventManagementConfiguration();
        $emc->make_subscribers($this->container);
    }


    public function load() {
        if ($this->loaded) {
            return;
        }

        $this->container->singleton('Vars', function () {
            return [
                'plugin_basename' => plugin_basename($this->file),
                'plugin_domain' => self::DOMAIN,
                'plugin_path' => plugin_dir_path($this->file),
                'plugin_relative_path' => basename(plugin_dir_path($this->file)),
                'plugin_url' => plugin_dir_url($this->file),
                'plugin_version' => self::VERSION,
            ];
        });

        $this->container->singleton(EventManager::class, function () {
            return new EventManager();
        });

        // pulls all dependencies into container.
        $this->make_services();
        // adds event listeners to wordpress hooks
        $subscribers = $this->container->tagged('subscriber');
        foreach ($subscribers as $subscriber) {
            $this->container->make(EventManager::class)->add_subscriber($subscriber);
        }

        $this->loaded = true;
    }
}
