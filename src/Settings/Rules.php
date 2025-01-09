<?php

namespace Membergate\Settings;

use Membergate\DTO\Rules\ConditionDTO;
use Membergate\DTO\Rules\ProtectMethodDTO;
use Membergate\DTO\Rules\RuleDTO;
use Membergate\DTO\Rules\RuleSetDTO;

class Rules {
    public function __construct() {
    }

    /**
     * @param null|int|string $id
     * @return array<RuleSetDTO[]>|RuleSetDTO[]
     */
    public function get_rules($id = null): array {
        $get_and_validate = function (int $id): array {
            $sets = [];
            $raw_set = get_post_meta($id, 'rules', true) ?: $this->default_ruleset();
            foreach ($raw_set as $set) {
                $sets[] = $set instanceof RuleSetDTO ? $set : RuleSetDTO::fromObject($set);
            }
            return $sets;
        };

        if (!is_null($id) && is_numeric($id)) {
            /** @var RuleSetDTO[] $sets */
            return $get_and_validate((int)$id);
        } elseif (!is_null($id)) {
            return $this->default_ruleset();
        }

        /** @var \WP_Post[] $rules_post */
        $rules_post = get_posts([
            'post_type' => "membergate_rule",
            'posts_per_page' => -1,
        ]);
        $rules = [];
        foreach ($rules_post as $p) {
            $rules[] = $get_and_validate($p->ID);
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
        /** @var \WP_Post[] $rules_post */
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
    public function get_protect_method($id): ProtectMethodDTO {
        if (!is_null($id) && is_numeric($id)) {
            $pm = get_post_meta((int)$id, 'protect_method', true) ?: $this->default_protect_method();
            return $pm instanceof ProtectMethodDTO ? $pm : ProtectMethodDTO::fromObject($pm); // backwards compatibility

        } elseif (!is_null($id)) {
            return $this->default_protect_method();
        }
        throw new \UnexpectedValueException("Bad Id was given");
    }

    /**
     * @param int|string|null $id
     */
    public function get_allow_logged_in_users($id): bool {
        if (!is_null($id) && is_numeric($id)) {
            return get_post_meta((int)$id, 'allow_logged_in_users', true) ?: $this->default_allow_logged_in_users();
        }
        return $this->default_allow_logged_in_users();
    }

    public function use_default_condition(): ConditionDTO {
        return new ConditionDTO(parameter: "cookie", key: "is_member", operator: "notset");
    }

    /**
     * @return ProtectMethodDTO
     */
    public function default_protect_method(): ProtectMethodDTO {
        /** @var \WP_Post $page */
        list($page) = get_posts([
            'post_type' => "page",
            'posts_per_page' => 1,
            'order' => 'ASC',
        ]);
        return new ProtectMethodDTO('redirect', $page->ID);
    }

    /**
     * @return RuleSetDTO[]
     */
    private function default_ruleset(): array {
        return [new RuleSetDTO([
            new RuleDTO()
        ])];
    }

    private function default_allow_logged_in_users(): bool {
        return false;
    }
}
