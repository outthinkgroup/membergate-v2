<?php

namespace Membergate\EventManagement;

class EventManager
{
    public function add_callback($hook_name, $callback, $priority = 10, $args_count = 1)
    {
        add_filter($hook_name, $callback, $priority, $args_count);
    }

    public function has_callback($hook_name, $callback = false)
    {
        return has_filter($hook_name, $callback);
    }

    public function remove_callback($hook_name, $callback, $priority = 10)
    {
        return remove_filter($hook_name, $callback, $priority);
    }

    public function add_subscriber(SubscriberInterface $subscriber)
    {
        if ($subscriber instanceof EventManagerAwareInterface) {
            $subscriber->set_event_manager($this);
        }
        foreach ($subscriber->get_subscribed_events() as $hook_name => $params) {
            $this->add_subscriber_callback($subscriber, $hook_name, $params);
        }
    }

    public function remove_subscriber(SubscriberInterface $subscriber)
    {
        foreach ($subscriber->get_subscribed_events() as $hook_name => $params) {
            $this->remove_subscriber_callback($subscriber, $hook_name, $params);
        }
    }

    public function add_subscriber_callback(SubscriberInterface $subscriber, $hook_name, $params)
    {
        if (is_string($params)) {
            $this->add_callback($hook_name, [$subscriber, $params]);
        } elseif (is_array($params)) {
            $this->add_callback($hook_name, [$subscriber, $params[0]], isset($params[1]) ? $params[1] : 10, isset($params[2]) ? $params[2] : 1);
        }
    }

    public function remove_subscriber_callback(SubscriberInterface $subscriber, $hook_name, $params)
    {
        if (is_string($params)) {
            $this->remove_callback($hook_name, [$subscriber, $params]);
        } elseif (is_array($params)) {
            $this->remove_callback($hook_name, [$subscriber, $params[0]], isset($params[1]) ? $params[1] : 10, isset($params[2]) ? $params[2] : 1);
        }
    }

    public function execute($hook_name, $arg = null)
    {
        $args = array_slice(func_get_args(), 1);
        do_action_ref_array($hook_name, $args);
    }

    public function filter($hook_name, $arg = null)
    {
        $args = array_slice(func_get_args(), 1);
        apply_filters_ref_array($hook_name, $args);
    }
}
