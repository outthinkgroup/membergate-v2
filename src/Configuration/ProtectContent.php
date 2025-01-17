<?php

namespace Membergate\Configuration;

use Membergate\Settings\Rules;
use Membergate\Configuration\RuleEntity;
use Membergate\DTO\Rules\ConditionDTO;
use WP_Post;

// add as a singleton
class ProtectContent {

    const DEFAULT_PROTECT_EVENT = "PAGE_LOAD";

    public \WP_Post|null $post;

    public bool $is_protected;
    public int $activated_rule_id;
    public string $overlayContent;
    public string $redirectUrl;

    /**
     * @var string $protectEvent
     * Could be when to activate the protection in place
     * or an condition that is needed that should be in place
     **/
    public string $protectEvent;

    private Rules $rules;
    private RuleEntity $ruleEntity;


    public function __construct(Rules $rules, RuleEntity $ruleEntity, public ProtectionModifier $protectionModifier) {
        $this->rules = $rules;

        $this->post = \get_post(get_the_ID());
        $this->is_protected = false;
        $this->ruleEntity = $ruleEntity;

        $this->activated_rule_id = -1;
        $this->overlayContent = "";
        $this->redirectUrl = "";
        $this->protectEvent = self::DEFAULT_PROTECT_EVENT;
    }

    public function configure_protection(): bool {
        global $post;
        $isAdminUser = current_user_can('edit_posts');// not exactly an admin but will work for our case. make configurable later
        $conditions = $this->rules->get_conditions();
        $passes = true;
        foreach ($conditions as $rule_id => $condition) {

            if ($condition->parameter == 'cookie') {
                $passes = $this->passes_condition($condition, $_COOKIE);
            } else {
                $passes = $this->passes_condition($condition, $_GET);
            }

            // allow admin users if the condtion has been set up
            // for that.
            if($isAdminUser && $this->rules->get_allow_logged_in_users($rule_id)){
                $passes = true;
            }

            if ($passes) {
                continue;
            }

            if ($post && $this->is_post_protected($post, $rule_id)) {
                $this->is_protected = true;
                $this->activated_rule_id = $rule_id;
                $this->ruleEntity->init($rule_id);

                $this->prepare_protect_method();

                //used in extensions
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
            foreach ((array)$rule_set as $rule_group) {
                // only loop through until we get a true since its a "OR" clause
                if ($is_protected) break;

                /**@var int[] $is_protected_set */
                $is_protected_set = []; 
                foreach ($rule_group->sets as $rule) {
                    // must loop through all because its an "AND" clause
                    switch ($rule->parameter) {
                        case 'post_type':
                            $is_protected_set[] = (int)$this->post_type_rule($post, $rule);
                            break;
                        case "post":
                            $is_protected_set[] = (int)$this->post_rule($post, $rule);
                            break;
                        case "page":
                            $is_protected_set[] = (int)$this->post_rule($post, $rule);
                            break;
                        case "category":
                            $is_protected_set[] = (int)$this->term_rule($post, $rule, 'category');
                            break;
                        case "tag":
                            $is_protected_set[] = (int)$this->term_rule($post, $rule, 'post_tag');
                            break;
                        case "taxonomy":
                            $is_protected_set[] = (int)$this->taxonomy_rule($post, $rule);
                            break;
                        case "page_template":
                            $is_protected_set[] = (int)$this->page_template_rule($post, $rule);
                            break;
                        default:
                            $is_protected_set[] = 0;
                            break;
                    }
                }
                $is_protected = array_sum($is_protected_set) == count($is_protected_set);
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
            do_action("qm/debug", "post id: {$post->ID} is {$rule->value}");
            return get_post_type($post) == $rule->value;
        }
        if ($rule->operator == 'not') {
            do_action("qm/debug", "post id: {$post->ID} is not {$rule->value}");
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
                    $checking  = has_term((int)$term_id, $tax, $post) ? 'has' : 'does not have';
        if ($rule->operator == 'is') {
            do_action("qm/debug", "post id: {$post->ID} {$checking} term {$term_id } in taxonomy {$tax}");
            return has_term((int)$term_id, $tax, $post);
        }
        if ($rule->operator == 'not') {
            do_action("qm/debug", "post id: {$post->ID} does not have term {$term_id } in taxonomy {$tax}");
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
     * @param array<string, string> $mapToCheck
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

        if( $this->ruleEntity->protect_method()->method == 'redirect') {
            $id = $this->ruleEntity->protect_method()->value;
            $this->redirectUrl = get_the_permalink((int)$id);
        }

        // this will be used in the subscriber to add additional information to the page
        // that will be picked up with js to protect the content in some other way than 
        // configure in the rule.
        if($this->protectionModifier->hasMods()){
            $this->protectEvent = $this->protectionModifier->protectEvent(); 
        }
    }

    public function hasMods():bool {
        return $this->protectEvent != self::DEFAULT_PROTECT_EVENT;
    }
}
