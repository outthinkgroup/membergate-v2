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
        $conditions = $this->rules->get_conditions();
        $passes = true;
        foreach($conditions as $condition_id=>$condition){
            switch($condition->parameter){
                case "cookie":
                    $passes = $this->passes_cookie_condition($condition );
                    break;
                case "urlparam":
                    $passes = $this->passes_urlparam_condition($condition);
                    break;
            }
            
            if($passes){
                continue;
            }

            if($this->is_post_protected($post, $condition_id)){
                $this->protect($condition_id);
                break;
            }
        }
    }

    public function is_post_protected(\WP_Post $post, $rule_id=null){
        $rule_sets = $this->rules->get_rules($rule_id);
        if($rule_id){
            // so the loops will work with both contexts
            $rule_sets = [$rule_sets];
        }

        $is_protected = false;
        foreach ($rule_sets as $rule_set) {
            // only loop through until we get a true since its a "OR" clause
            if($is_protected) break;
            foreach ($rule_set as $rule_group) {
                // only loop through until we get a true since its a "OR" clause
                if($is_protected) break;
                foreach($rule_group as $rule){
                    // must loop through all because its an "AND" clause
                    switch($rule->parameter){
                        case 'post_type':
                            $is_protected = $this->post_type_rule($post, $rule);
                            break;
                        case "post":
                            $is_protected = $this->post_rule($post, $rule);
                            break;
                        case "page":
                            $is_protected = $this->post_rule($post, $rule);
                            break;
                        case "category":
                            $is_protected = $this->term_rule($post, $rule, 'category');
                            break;
                        case "tag":
                            $is_protected = $this->term_rule($post, $rule, 'post_tag');
                            break;
                        case "user_role":
                            $is_protected = $this->user_role_rule($rule);
                            break;
                        case "page_template":
                            $is_protected = $this->page_template_rule($post, $rule);
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        return $is_protected;
    }

    private function protect(int $protect_method_id){
        $protect_method = $this->rules->get_protect_method($protect_method_id);
        if($protect_method->method = 'redirect'){
            $page = get_post(intval($protect_method->value));
            wp_safe_redirect(get_permalink($page));
            exit;
        }
    }

    private function post_type_rule(\WP_Post $post, $rule){
        if(!is_single()) return false;
        if($rule->operator == 'is'){
            return get_post_type($post) == $rule->value;
        }
        if ($rule->operator == 'not'){
            return get_post_type($post) != $rule->value;
        }
    }

    private  function post_rule($post, $rule){
        if(!is_single()) return false;
        if($rule->operator == 'is'){
            return $post->ID == (int)$rule->value;
        }
        if($rule->operator == 'not'){
            return $post->ID != (int)$rule->value;
        }
    }

    private function term_rule($post, $rule, $tax){
        if(!is_single()) return false;
        if($rule->operator == 'is'){
            return has_term($rule->value, $tax, $post);
        }
        if($rule->operator == 'not'){
            return !has_term($rule->value, $tax, $post);
        }
    }

    private function user_role_rule($rule){
        $user = wp_get_current_user();
        if(is_home()) return false;

        if(!$user->ID) return true; // not logged in
        if($rule->operator == 'is'){
            return in_array($rule->value, $user->roles);
        }
        if($rule->operator == 'not'){
            return !in_array($rule->value, $user->roles);
        }
    }

    private function page_template_rule(\WP_Post $post, $rule){
        $template = $post->page_template;
        debug($template);
        if($rule->operator == 'is'){
            return $template == $rule->value;
        }

        if($rule->operator == 'not'){
            return $template != $rule->value;
        }
    }

    private function passes_cookie_condition($condition):bool {
        if(isset($_COOKIE[$condition->key])){
            if($condition->operator == 'notequal'){
                return $_COOKIE[$condition->key] == $condition->operator;
            }
            return true;
        }
        return false;
    }

    private function passes_urlparam_condition($condition):bool {
        if(isset($_GET[$condition->key])){
            if($condition->operator == 'notequal'){
                return $_GET[$condition->key] == $condition->operator;
            }
            return true;
        }
        return false;
    }
}
