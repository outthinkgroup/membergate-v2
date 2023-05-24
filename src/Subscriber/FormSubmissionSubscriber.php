<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\SubscriberInterface;

class FormSubmissionSubscriber implements SubscriberInterface {
    protected $post_var = 'membergate_form';

    public $form_handlers;

    public function __construct($form_handlers) {
        $this->form_handlers = $form_handlers;
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
