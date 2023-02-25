<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\PostTypeSettings;

class LoadAdditionalPostTypesSubscriber implements SubscriberInterface
{
    private PostTypeSettings $post_type_settings;

    public function __construct($post_type_settings)
    {
        $this->post_type_settings = $post_type_settings;
    }

    public static function get_subscribed_events(): array
    {
        return[
            'init' => ['add_posttypes_after_init', 900],
        ];
    }

    public function add_posttypes_after_init()
    {
        $this->post_type_settings->add_addtional_post_types();
    }
}
