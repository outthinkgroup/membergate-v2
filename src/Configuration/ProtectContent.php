<?php

namespace Membergate\Configuration;

use Membergate\Settings\Rules;
use Membergate\Configuration\RuleEntity;
use WP_Post;

// add as a singleton
class ProtectContent {

    public $post;
    public bool $is_protected;
    public $condition_id;
    private $rules;
    private $ruleEntity;
    public function __construct(Rules $rules, RuleEntity $ruleEntity) {
        $this->rules = $rules;
        $this->post = get_post(get_the_ID());
        $this->is_protected = false;
        $this->ruleEntity = $ruleEntity;
    }

    public function configure_protection() {
        global $post;
        $conditions = $this->rules->get_conditions();
        $passes = true;
        foreach ($conditions as $condition_id => $condition) {
            switch ($condition->parameter) {
                case "cookie":
                    $passes = $this->passes_cookie_condition($condition);
                    break;
                case "urlparam":
                    $passes = $this->passes_urlparam_condition($condition);
                    break;
            }


            if ($passes) {
                continue;
            }

            if ($post && $this->is_post_protected($post, $condition_id)) {
                $this->is_protected = true;
                $this->condition_id = $condition_id;
                $this->ruleEntity->init($condition_id);
                do_action('membergate_condition_set', $this->ruleEntity, $condition_id);
                break;
            }
        }
        return false;
    }


    /**
     * @param WP_Post $post 
     * @param mixed $rule_id 
     * @return bool 
     */
    public function is_post_protected(\WP_Post $post, $rule_id = null):bool {
        $rule_sets = $this->rules->get_rules($rule_id);
        if ($rule_id) {
            // so the loops will work with both contexts
            $rule_sets = [$rule_sets];
        }

        $is_protected = false;
        foreach ($rule_sets as $rule_set) {
            // only loop through until we get a true since its a "OR" clause
            if ($is_protected) break;
            foreach ($rule_set as $rule_group) {
                // only loop through until we get a true since its a "OR" clause
                if ($is_protected) break;
                foreach ($rule_group as $rule) {
                    // must loop through all because its an "AND" clause
                    switch ($rule->parameter) {
                        case 'post_type':
                            debug("inside posttype");
                            $is_protected = $this->post_type_rule($post, $rule);
                            debug("post_type: $is_protected"); //" . $is_protected ? "true":"false");
                            break;
                        case "post":
                            debug("post: $is_protected");
                            $is_protected = $this->post_rule($post, $rule);
                            break;
                        case "page":
                            $is_protected = $this->post_rule($post, $rule);
                            debug("page: $is_protected");
                            break;
                        case "category":
                            $is_protected = $this->term_rule($post, $rule, 'category');
                            debug("category: $is_protected");
                            break;
                        case "tag":
                            $is_protected = $this->term_rule($post, $rule, 'post_tag');
                            debug("tag: $is_protected");
                            break;
                        case "page_template":
                            $is_protected = $this->page_template_rule($post, $rule);
                            debug("tag: $is_protected");
                            break;
                        default:
                            $is_protected = false;
                            break;
                    }
                }
            }
        }
        return $is_protected;
    }

    public function get_active_rule() {
        if (!$this->ruleEntity->isSet) {
            return null;
        }
        return $this->ruleEntity;
    }

    private function post_type_rule(\WP_Post $post, $rule) {
        if (!is_singular()) return false;
        if ($rule->operator == 'is') {
            return get_post_type($post) == $rule->value;
        }
        if ($rule->operator == 'not') {
            return get_post_type($post) != $rule->value;
        }
    }

    private  function post_rule($post, $rule) {
        if (!is_singular()) return false;
        if ($rule->operator == 'is') {
            return $post->ID == (int)$rule->value;
        }
        if ($rule->operator == 'not') {
            return $post->ID != (int)$rule->value;
        }
    }

    private function term_rule($post, $rule, $tax) {
        if (!is_single()) return false;
        //TODO: check if post type has this taxonomy
        // if(in_array(get_object_taxonomies())) return false;
        if ($rule->operator == 'is') {
            return has_term($rule->value, $tax, $post);
        }
        if ($rule->operator == 'not') {
            return !has_term($rule->value, $tax, $post);
        }
    }

    private function page_template_rule(\WP_Post $post, $rule) {
        $template = $post->page_template;
        debug($template);
        if ($rule->operator == 'is') {
            return $template == $rule->value;
        }

        if ($rule->operator == 'not') {
            return $template != $rule->value;
        }
    }

    private function passes_cookie_condition($condition): bool {
        if (isset($_COOKIE[$condition->key])) {
            if ($condition->operator == 'notequal') {
                return $_COOKIE[$condition->key] == $condition->operator;
            }
            debug("Passes Cookies");
            return true;
        }
        debug([$condition, $_COOKIE]);
        return false;
    }

    private function passes_urlparam_condition($condition): bool {
        if (isset($_GET[$condition->key])) {
            if ($condition->operator == 'notequal') {
                return $_GET[$condition->key] == $condition->operator;
            }
            return true;
        }
        return false;
    }
}
