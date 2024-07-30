<?php

namespace Membergate\Settings;

use Membergate\DTO\Rules\ConditionDTO;

class Rules {
    public function __construct() {
    }

    /**
     * @param null|int|string $id
     * @return array<object>
     */
    public function get_rules($id = null): array {
        if (!is_null($id) && $id !== "new") {
            return get_post_meta($id, 'rules', true) ?: $this->default_ruleset();
        } elseif ($id) {
            return $this->default_ruleset();
        }

        /** @var \WP_Post[] $rules_post */
        $rules_post = get_posts([
            'post_type' => "membergate_rule",
            'posts_per_page' => -1,
        ]);
        $rules = [];
        foreach ($rules_post as $p) {
            $rules[] = get_post_meta($p->ID, 'rules', true);
        }
        return $rules;
    }

    public function get_condition_by_id(int|string $id): ConditionDTO {
        if ($id && $id !== "new") {
            return get_post_meta((int)$id, 'condition', true)
                ? ConditionDTO::fromObject(get_post_meta((int)$id, 'condition', true))
                : $this->use_default_condition();
        } elseif ($id) {
            return $this->use_default_condition();
        }
        throw new \UnexpectedValueException("Bad Id was given");
    }

    /**
     * @return array<ConditionDTO>
     */
    public function get_conditions(): array {
        $rules_post = get_posts([
            'post_type' => "membergate_rule",
            'posts_per_page' => -1,
        ]);
        $conditions = [];
        foreach ($rules_post as $p) {
            $condition = get_post_meta($p->ID, 'condition', true);
            if ($condition) {
                $conditions[$p->ID] = ConditionDTO::fromObject($condition);
            }
        }
        return $conditions;
    }

    /**
     * @param int|string|null $id
     */
    public function get_protect_method($id): object {
        if ($id && $id !== "new") {
            return get_post_meta($id, 'protect_method', true) ?: $this->default_protect_method();
        } elseif ($id) {
            return $this->default_protect_method();
        }
        throw new \UnexpectedValueException("Bad Id was given");
    }

    public function use_default_condition(): ConditionDTO {
        return new ConditionDTO(parameter: "cookie", key: "is_member", operator: "notset");
    }
    /**
     * @return object{method:string,value:string}
     */
    public function default_protect_method(): object {
        /** @var \WP_Post $page */
        list($page) = get_posts([
            'post_type' => "page",
            'posts_per_page' => 1,
            'order' => 'ASC',
        ]);
        return (object)[
            'method' => 'redirect',
            'value' => (string)$page->ID,
        ];
    }
    /**
     * @return array<array<object{parameter:string,key:string,operator:string}>>
     */
    private function default_ruleset(): array {
        return [[(object)[
            'parameter' => "post_type",
            "operator" => 'is',
            "value" => 'post',
        ]]];
    }
}
