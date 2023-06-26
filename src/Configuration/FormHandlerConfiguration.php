<?php

namespace Membergate\Configuration;

use Membergate\FormHandlers\AddSubscriberToService;
use Membergate\FormHandlers\CheckSubscriptionStatus;

class FormHandlerConfiguration {
    public function modify() {
            return [
                 AddSubscriberToService::class,
                 CheckSubscriptionStatus::class
            ];
    }
}
