<?php

namespace Membergate\Configuration;

use Membergate\Settings\Rules;
use Membergate\Configuration\RuleEntity;
use Membergate\DTO\Rules\ConditionDTO;
use WP_Post;

// add as a singleton
class ProtectContent {

    public \WP_Post|null $post;

    public bool $is_protected;
    public int $activated_rule_id;
    public string $overlayContent;

    private Rules $rules;
    private RuleEntity $ruleEntity;

    public function __construct(Rules $rules, RuleEntity $ruleEntity) {
        $this->rules = $rules;
        /** @psalm-suppress PossiblyFalseArgument */
        $this->post = \get_post(get_the_ID());
        $this->is_protected = false;
        $this->ruleEntity = $ruleEntity;

        $this->activated_rule_id = -1;
        $this->overlayContent = "";
    }

    public function configure_protection(): bool {
        global $post;
        $conditions = $this->rules->get_conditions();
        $passes = true;
        foreach ($conditions as $rule_id => $condition) {
            if ($condition->parameter == 'cookie') {
                $passes = $this->passes_condition($condition, $_COOKIE);
            } else {
                $passes = $this->passes_condition($condition, $_GET);
            }

            if ($passes) {
                continue;
            }

            if ($post && $this->is_post_protected($post, $rule_id)) {
                $this->is_protected = true;
                $this->activated_rule_id = $rule_id;
                $this->ruleEntity->init($rule_id);

                $this->prepare_protect_method();

                do_action('membergate_condition_set', $this->ruleEntity, $rule_id);
                break;
            }
        }
        return $passes;
    }


    /**
     * @param \WP_Post $post post being checked
     * @param mixed $rule_id id of the membergate rule post type
     * @return bool 
     */
    public function is_post_protected(\WP_Post $post, $rule_id = null): bool {
        $rule_sets = $this->rules->get_rules($rule_id); //TODO will change when we output specific types

        // If we are getting a specific rule set
        if (is_int($rule_id)) {
            // so the loops will work with both contexts
            $rule_sets = [$rule_sets];
        }

        /** @var bool $is_protected */
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
                        case "taxonomy":
                            $is_protected = $this->taxonomy_rule($post, $rule);
                            break;
                        case "page_template":
                            $is_protected = $this->page_template_rule($post, $rule);
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

    public function get_active_rule(): null|RuleEntity {
        if (!$this->ruleEntity->isSet) {
            return null;
        }
        return $this->ruleEntity;
    }

    private function post_type_rule(\WP_Post $post, object $rule): bool {
        if (!is_singular()) return false;
        if ($rule->operator == 'is') {
            return get_post_type($post) == $rule->value;
        }
        if ($rule->operator == 'not') {
            return get_post_type($post) != $rule->value;
        }
        return false;
    }

    private  function post_rule(\WP_Post $post, object $rule): bool {
        if (!is_singular()) return false;
        if ($rule->operator == 'is') {
            return $post->ID == (int)$rule->value;
        }
        if ($rule->operator == 'not') {
            return $post->ID != (int)$rule->value;
        }
        return false;
    }

    private function term_rule(\WP_Post $post, object $rule, string $tax): bool {
        if (!is_single()) return false;
        //TODO: check if post type has this taxonomy
        // if(in_array(get_object_taxonomies())) return false;
        if ($rule->operator == 'is') {
            return has_term($rule->value, $tax, $post);
        }
        if ($rule->operator == 'not') {
            return !has_term($rule->value, $tax, $post);
        }
        return false;
    }

    private function taxonomy_rule(\WP_Post $post, object $rule): bool {
        if (!is_singular() || !str_contains($rule->value, "::")) return false;
        list($tax, $term_id) = explode("::", $rule->value);
        // if (!taxonomy_exists($tax) || !is_numeric($term_id)) return false;
        if ($rule->operator == 'is') {
            return has_term((int)$term_id, $tax, $post);
        }
        if ($rule->operator == 'not') {
            return !has_term((int)$term_id, $tax, $post);
        }
        return false;
    }

    private function page_template_rule(\WP_Post $post, object $rule): bool {
        $template = $post->page_template;
        if ($rule->operator == 'is') {
            return $template == $rule->value;
        }

        if ($rule->operator == 'not') {
            return $template != $rule->value;
        }
        return false;
    }


    /**
     * TODO: may need to have seperate methods for each condition type
     *
     * @param ConditionDTO $condition 
     * @param array $mapToCheck
     * @return bool 
     */
    private function passes_condition(ConditionDTO $condition, array $mapToCheck): bool {
        if (isset($mapToCheck[$condition->key])) {
            if ($condition->operator == 'notequal') {
                return $mapToCheck[$condition->key] == $condition->value;
            }
            if ($condition->operator == 'equals') {
                return $mapToCheck[$condition->key] != $condition->value;
            }
            return true;
        }
        return false;
    }


    private function prepare_protect_method(): void {
        // logic for method preperation
        if ($this->ruleEntity->protect_method()->method == 'overlay') {
            $id = $this->ruleEntity->protect_method()->value;
            $p = get_post((int)$id);
            $this->overlayContent = apply_filters('the_content', $p->post_content);
        }
    }
}
