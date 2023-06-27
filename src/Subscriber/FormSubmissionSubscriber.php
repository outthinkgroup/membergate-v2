<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\EventManagement\SubscriberInterface;
use Membergate\FormHandlers\AddSubscriberToService;
use Membergate\FormHandlers\CheckSubscriptionStatus;

class FormSubmissionSubscriber implements SubscriberInterface {
    protected $post_var = 'membergate_form';

    public $form_handlers;

    public function __construct(AddSubscriberToService $add_subscriber, CheckSubscriptionStatus $check_subscriber_status) {
        $this->form_handlers = [
            "add_subscriber_to_service" => $add_subscriber,
            "check_if_subscriber" => $check_subscriber_status,
        ];
    }

    public static function get_subscribed_events(): array {
        return [
            'init' => 'listen_for_submissions',
        ];
    }

    public function listen_for_submissions() {
        debug($_POST);
        if (isset($_POST[$this->post_var])) {
            $this->form_handlers[$_POST[$this->post_var]]->execute_action($_POST);
        }
    }
}
