# Membergate

## PHP Development

This is how we will organize our project on the PHP side of things

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

Classes that load other classes like subscribers or Email Service Provider services will go in here


### Containers, Automatic Dependency Injection

Our pluign uses illuminate-containers package to load classes and their dependencies. This works great when the
dependencies of the class are other classes. For this to work make sure you type hint the dependencies inside the class
constructor.

#### example
```php
<?php
public function __construct(MembergateFormRenderer $form_renderer) {
    $this->form_renderer = $form_renderer;
}
```

#### Manual Binding of classes

If you need to load a class that takes in non class you will need to bind
them in the main plugin class `src/Plugin.php` inside the `make_services` method of the class.

##### example
```php
<?php
    $this->container->bind(AdminSubscriber::class, function (Container $container) {
        return new AdminSubscriber($container->get('Vars')['plugin_path']);
    });
```
This code will load the class `AdminSubscriber` with a string from the `Vars` configuration module.

Another time you may need to load a class here is if you need to create a `Singleton` ( a class that is only created
once ). You will put that in the same place as the classes that depend on non class values described above,
`src/Plugin.php` in side the `make_services` method.

##### example

```php
<?php
$this->container->singleton(MembergateFormRenderer::class, function (Container $container) {
    $template_path = $container->make('Vars')['plugin_path'] . "/templates/";
    $template_path = apply_filters('membergate_form_template_path', $template_path);
    return new MembergateFormRenderer($container->make(FormSettings::class), $template_path);
});
```

### AJAX

When you need Ajax functionality, you will create a class inside `src/AJAX` directory. The class will need to implement
the Interface `AjaxInterface`, which requires you to also implement:
- `get_action()` method returning a string that will be used in the hook `wp_ajax_{ACTION}`;
- `get_name()` which returns usually just the name of the class,
- `handle()` this is where you will do the logic of the ajax call

### Admin

Admin pages will go here

### Assets

classes that deal with frontend assets like styles, javascript, and images.

### Cache 

Classes that use wp_transient or some any other performance classes that save results from longer tasks


### FormHandlers

Public actions that happen when a form is submitted will go here. ie Add a subscriber when the subscription form is
submitted.

These classes must implement the `FormHandlerInterface` and also the `execute_action($submission)` method (the
submission variable is usually just $_POST)

### Settings

Setting classes used to get options or postmeta will live here.

### Shortcodes

Shortcodes are represented as classes. These classes must implement the `ShortcodeInteface`.
And implement these functions
```php
<?php
/**
* this is the function that will return the output of the shortcode
*/
public function run(array $atts): string;

/**
* this is the function that will return default argument values
*/
public function get_default_args(): array;
```
Your shortcodes will then need to be added to the Shortcode Subscriber
```php
<?php
$shortcodes = [
    //[name_of_shortcode] => Class
    'mg_signup_form' => SignupShortcode::class,
    // yours here...
];
```

### Email Providers `ListProviders`

To add an email service provider you will need to implement 2 classes, and if there is not an SDK for then a 3rd for
sending api requests.

Inside the directory `src/ListProviders` create a class that implements `ListProvidersInterface` along with these
methods:
```php 
<?php
    const provider_name //a unique string that will be used as identifing this provider. Use `_` instead of spaces

    /** takes in an apikey */
    public function __construct(string $api_key);

    /**
      * return a list of strings that says what kinds of options it has ie `has_groups`
        full list:
            'has_groups',
            'has_lists',
            'has_tags',
            'has_merge_fields',
    **/
    public static function capabilities(): array;
    /**
      * add a subscriber to a list
      * @param $email is the emailaddress to you are subscribing
      * @param $settings is the ListProvider settings class that goes with this provider
      * @param $submission is usually just $_POST of the form.
      * @return PossibleError this is a class that takes in a value and or an error
      **/
    public function add_subscriber($email, $settings, $submission = null): PossibleError;

    /**
     * Get information about a user attached to a email address possibly subscribed to a list
     **/
    public function get_user($list_id, $email): PossibleError;
    
    /**
      * checks if emailaddress is subscribed to list id 
      * @return PossibleError a boolean value 
      **/
    public function is_user_subscribed($list_id, $email_address): PossibleError;

    /**
      * gets available lists to select from, from the options that users will be subscribed to
      **/
    public function get_lists();
    
    // if the provider has tags or groups you'll need methods for those as well
```

You will also need to implement a Settings class responsible for getting and setting the providers settings like
list_id, or groups. They will live in the `src/Settings/EMSSettings/` directory. These will need to implement the `EMSSettingsInterface` and implement
```php
<?php
    /** 
      * updates all settings
      * takes in usually $_POST
    **/
    public function update_settings(array $post_arr): PossibleError;
    /** 
      * update one setting 
      * takes in the key and then the value
    **/
    public function update_setting(string $key, mixed $value): PossibleError;
    /** gets all the settings **/
    public function get_settings(): PossibleError;
    /** gets just one setting by key**/
    public function get_setting(string $key): PossibleError;
```

if the service does not provide an SDK you will need to create a class in the `src/ListProviders/EMSClients` directory,
that your provider class can use to talk to the service.

Once you have your classes you can add your settings and your provider classes to the `ProvidersConfiguration` class's
method `providers` like so.

```php
<?php 
    public static function providers() {
        return [
            MailchimpProvider::provider_name => [
                'client' => MailchimpProvider::class,
                'settings' => MailchimpSettings::class,
            ],
            MockESProvider::provider_name => [
                'client'=>MockESProvider::class,
                'settings'=>MockServerSettings::class,
            ],
            // yours here
        ];
    }
```

### Common

The `Common` directory is used for utility classes

---

## Frontend Development

How our frontend code is developed.

This codebase is using typescript. Instead of `.js` files you will create `.ts` files. This gives us some type safety
and better autocomplete. Vite will turn this into `.js` files when we are ready to deploy. 

### Public Code

Code that runs on the user facing side (non admin) will use `assets/frontend.ts` as its entry point. You can import other files
to this file if you need to organize more.

#### Styles

Css that is used to style user facing forms can be but in the `assets/styles` directory.

### Admin Code

The main entry point for code that runs on the admin side of things is `assets/main.ts`

#### UI

Our admin pages UI is built using svelte. These components live in the `assets/lib`. 

#### Tailwind

For styling our admin UI we use tailwindcss. Any other classes that you need can be added to the `assets/tailwind.css` file. Try not
to add classes to svelte component `script` tag as they have trouble being bundled up with our current Vite config. This
limitation

### API 

Code that talks to our AJAX endpoints will be put in the `assets/api` directory. 

---

## Testing 

We are using cypress for testing. It is an End to End testing library that uses jquery syntax to drive a pupeteer like
browser to make sure our code works.

Currently testing this plugins requires an additional node server not included in this repo that is used for mocking
requests to email service providers. This is not necessary and will be rewritten to be more better.


## Thats all folks!
