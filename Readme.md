# Membergate

---

## Development

This is how we will organize our projects

### Subscribers

Functions or classes that call wordpress plugin api `add_action` or `add_filter`
will need to implement a class in the `src/Subscriber` directory that implements `SubscriberInterface`.
Instantiate these in the `EventManagementConfiguration` class adding in dependencies to the constructor of the
subscriber class. The Subscriber needs to implement a public static method `get_subscribed_events`. This method will
return an array of `"event_name"=> "class_method"`. The key is the hook name like `init` and the value is the a string
of the method name that will be called on the event/hook. You can also do `["event_name"=>["method_name",10,2]]` allowing you to set priority and argument count to the hook.

#### example

```php
<?php
class AssetSubscriber implements SubscriberInterface {
	public static function get_subscribed_events():array{
		return [
			'admin_enqueue_scripts'=>'enqueue_admin_assets',
			'script_loader_tag' => ['use_esm_modules',10,3],
		];
	}
	public function enqueue_admin_assets(){}
	public function use_esm_modules($tag, $handle, $src){}
}
```
This allows us a repeatable, and readable way to see what hooks are being used for each module.


### Configuration 

Classes that deal with data or are dependencies of Subscribers should be placed in `src/Configuration`
They should implement `ContainerConfigurationInterface` interface. Implement a modify method that adds what ever you
need to be available to subscribers to the container array. Add the configuraton to the `src/Plugin.php` file in the
`load` method.

#### example

Example of A configuration class for settings
```php
<?php
class SiteSettingsConfiguration implements ContainerConfigurationInterface {
	public function modify(Container $container){
		$container['settings'] = $container->service(function(Container $container){
			return [
				new SiteSettings(),
			];
			
		});
	}
}
```

adding configuration to plugin 
```php
<?php
class Plugin {
//...
	public function load(){
		//...
		$this->container->configure([
			EventManagementConfiguration::class,
			// your Configration Class here
			SiteSettings::class, //example from above
		]);	
		//...
	}
}
```

This Classes will live through out the life cycle of our plugin and can be consumed by Subscriber classes.

