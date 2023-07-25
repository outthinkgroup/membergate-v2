<?php

namespace Membergate\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\Common\MemberCookie;
use Membergate\EventManagement\SubscriberInterface;
use Membergate\Settings\Rules;

class Redirects implements SubscriberInterface {

    private $rules;
    private $member_cookie;
    public function __construct(Rules $rules, MemberCookie $member_cookie ) {
        $this->rules = $rules;
        $this->member_cookie = $member_cookie;
    }

    public static function get_subscribed_events(): array {
        //TODO: conditionally return these based on setings
        return [
            'template_redirect' => 'on_template_redirect',
        ];
    }

    public function on_template_redirect() {
        global $post;
        if($this->member_cookie->user_has_cookie()) return;

        $rule_sets = $this->rules->get_rules();
        $should_redirect = false;
        foreach ($rule_sets as $rule_set) {
            // only loop through until we get a true since its a "OR" clause
            if($should_redirect) break;
            foreach ($rule_set as $rule_group) {
                // only loop through until we get a true since its a "OR" clause
                if($should_redirect) break;
                foreach($rule_group as $rule){
                    // must loop through all because its an "AND" clause
                    switch($rule['parameter']){
                        case 'post_type':
                            $should_redirect = $this->post_type_rule($post, $rule);
                            break;
                        case "post":
                            $should_redirect = $this->post_rule($post, $rule);
                            break;
                        case "page":
                            $should_redirect = $this->post_rule($post, $rule);
                            break;
                        case "category":
                            $should_redirect = $this->term_rule($post, $rule, 'category');
                            break;
                        case "tag":
                            $should_redirect = $this->term_rule($post, $rule, 'post_tag');
                            break;
                        case "user_role":
                            $should_redirect = $this->user_role_rule($rule);
                            break;
                        case "page_template":
                            $should_redirect = $this->page_template_rule($post, $rule);
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        if($should_redirect){
            wp_safe_redirect(site_url());
        }
    }

    private function post_type_rule(\WP_Post $post, $rule){
        if(!is_single()) return false;
        if($rule['operator'] == 'is'){
            return get_post_type($post) == $rule['value'];
        }
        if ($rule['operator'] == 'not'){
            return get_post_type($post) != $rule['value'];
        }
    }

    private  function post_rule($post, $rule){
        if(!is_single()) return false;
        if($rule['operator'] == 'is'){
            return $post->ID == (int)$rule['value'];
        }
        if($rule['operator'] == 'not'){
            return $post->ID != (int)$rule['value'];
        }
    }

    private function term_rule($post, $rule, $tax){
        if(!is_single()) return false;
        if($rule['operator'] == 'is'){
            return has_term($rule['value'], $tax, $post);
        }
        if($rule['operator'] == 'not'){
            return !has_term($rule['value'], $tax, $post);
        }
    }

    private function user_role_rule($rule){
        $user = wp_get_current_user();
        if(is_home()) return false;

        if(!$user->ID) return true; // not logged in
        if($rule['operator'] == 'is'){
            return in_array($rule['value'], $user->roles);
        }
        if($rule['operator'] == 'not'){
            return !in_array($rule['value'], $user->roles);
        }
    }

    private function page_template_rule(\WP_Post $post, $rule){
        $template = $post->page_template;
        debug($template);
        if($rule['operator'] == 'is'){
            return $template == $rule['value'];
        }

        if($rule['operator'] == 'not'){
            return $template != $rule['value'];
        }
    }
}
