<?php

namespace Membergate\Subscriber;

use Membergate\AJAX\CompleteSetup;
use Membergate\AJAX\FetchAltForm;
use Membergate\AJAX\FetchGroupsFromProvider;
use Membergate\AJAX\FetchListsFromProvider;
use Membergate\AJAX\SaveDisplayProtectedContent;
use Membergate\AJAX\SaveGeneralListSettings;
use Membergate\AJAX\SaveMembergateFormSettings;
use Membergate\AJAX\SaveProtectedPostTypes;
use Membergate\Configuration\ProvidersConfiguration;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\RenderForm\MembergateFormRenderer;
use Membergate\Settings\FormSettings;
use Membergate\Settings\ListProviderSettings;
use Membergate\Settings\PostTypeSettings;
use Membergate\Settings\ProtectedContentSettings;

class AdminPageAJaxSubscriber implements SubscriberInterface {
    public $list_provider_settings;

    public $providers_list;

    public $post_type_settings;

    public $form_settings;

    public $protected_content_settings;

    public $form_renderer;

    private $container;

    public function __construct(
        ListProviderSettings $list_provider_settings,
        ProvidersConfiguration $providers,
        PostTypeSettings $post_type_settings,
        FormSettings $form_settings,
        ProtectedContentSettings $protected_content_settings,
        MembergateFormRenderer $form_renderer
    ) {
        $this->list_provider_settings = $list_provider_settings;
        $this->providers_list = $providers;
        $this->post_type_settings = $post_type_settings;
        $this->form_settings = $form_settings;
        $this->protected_content_settings = $protected_content_settings;
        $this->form_renderer = $form_renderer;

        // $this->containers = [
        //     'list_settings' => $this->list_provider_settings,
        //     'providers' => $this->providers_list,
        //     'post_type_settings' => $this->post_type_settings,
        //     'settings.forms' => $this->form_settings,
        //     'settings.protected_content' => $this->protected_content_settings,
        //     'form_renderer' =>$this->form_renderer,
        // ];
        global $membergate;
        $this->container = $membergate->get_container();
    }

    public static function get_subscribed_events(): array {
        return [
            'wp_ajax_mg_admin_endpoint' => 'admin_endpoints',
            'wp_ajax_nopriv_mg_public_endpoint' => 'public_endpoints',
            'wp_ajax_mg_public_endpoint' => 'public_endpoints',
        ];
    }

    public function admin_endpoints() {
        $endpoints = [
            SaveGeneralListSettings::ACTION => SaveGeneralListSettings::class,
            FetchListsFromProvider::ACTION => FetchListsFromProvider::class,
            FetchGroupsFromProvider::ACTION => FetchGroupsFromProvider::class,
            CompleteSetup::ACTION => CompleteSetup::class,
            SaveProtectedPostTypes::ACTION => SaveProtectedPostTypes::class,
            SaveMembergateFormSettings::ACTION => SaveMembergateFormSettings::class,
            SaveDisplayProtectedContent::ACTION => SaveDisplayProtectedContent::class,
        ];
        if (! isset($_REQUEST['mg_action'])) {
            error_log('no action set');
        }
        $endpoint = $endpoints[$_REQUEST['mg_action']];
        if (! $endpoint) {
            error_log('no endpoint was found for: ' . $_REQUEST['mg_action']);
            exit;
        }
        
        $handlerClass = $this->container->make($endpoint);
        $handlerClass->handle();
    }

    public function public_endpoints() {
        $endpoints = [
            FetchAltForm::ACTION => FetchAltForm::class,
        ];

        if (! isset($_REQUEST['mg_public_action'])) {
            error_log('no action set');
        }
        $endpoint = $endpoints[$_REQUEST['mg_public_action']];
        if (! $endpoint) {
            error_log('no endpoint was found for: ' . $_REQUEST['mg_public_action']);
            exit;
        }

        $handlerClass = $this->container->make($endpoint);
        $handlerClass->handle();
    }
}
