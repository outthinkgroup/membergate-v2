<?php

namespace Membergate\EventManagement;

interface SubscriberInterface{
	public static function get_subscribed_events():array;
}
