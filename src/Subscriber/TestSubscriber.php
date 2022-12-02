<?php

namespace Membergate\Subscriber;

use Membergate\EventManagement\SubscriberInterface;

class TestSubscriber implements SubscriberInterface {
	public function __construct(){}

	public static function get_subscribed_events(): array{
		return [
			'init' => 'say_hi',
		];
	}

	public function say_hi(){
		error_log('hi');
	}
}
