<?php

namespace Membergate;

use Membergate\DependencyInjection\Container; 
use Membergate\Configuration\EventManagementConfiguration;
use Membergate\Configuration\FormHandlerConfiguration;

class Plugin {

	const DOMAIN = 'membergate';
	const VERSION = '0.0.1';

	private $container;

	private $loaded;

	public function __construct( $file ){
		$this->container = new Container([
			'plugin_basename'=>plugin_basename($file),
			'plugin_domain' => self::DOMAIN,
			'plugin_path'=> plugin_dir_path($file),
			'plugin_relative_path'=>basename(plugin_dir_path($file)),
			'plugin_url' => plugin_dir_url($file),
			'plugin_version'=>self::VERSION,
		]);
		$this->loaded = false;
	}

	public function load(){
		if ($this->loaded){
			return;	
		}

		$this->container->configure([
			EventManagementConfiguration::class,
			FormHandlerConfiguration::class,
		]);	

		foreach($this->container['subscribers'] as $subber){
			$this->container['event_manager']->add_subscriber($subber);	
		}

		$this->loaded = true;
	}
}
