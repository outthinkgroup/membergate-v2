<?php

namespace Membergate\Settings;

class Rules {
    public $rule_editor;
    public $overlay_editor;
    public function __construct(RuleEditor $editor, OverlayEditor $overlay_editor) {
        $this->rule_editor = $editor;
        $this->overlay_editor = $overlay_editor;
    }

    public function load_editor() {
        $this->rule_editor->enqueue_assets();
        $this->overlay_editor->enqueue_assets();
    }

    public function get_rules($id = null) {
        if ($id && $id !== "new") {
            return get_post_meta($id, 'rules', true) ?: $this->default_ruleset();
        } elseif ($id) {
            return $this->default_ruleset();
        }

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

    public function get_conditions($id = null) {
        if ($id && $id !== "new") {
            return get_post_meta($id, 'condition', true) ?: $this->default_condition();
        } elseif ($id) {
            return $this->default_condition();
        }

        $rules_post = get_posts([
            'post_type' => "membergate_rule",
            'posts_per_page' => -1,
        ]);
        $conditions = [];
        foreach ($rules_post as $p) {
            $condition = get_post_meta($p->ID, 'condition', true);
            if ($condition) {
                $conditions[$p->ID] = $condition;
            }
        }
        return $conditions;
    }

    public function get_protect_method($id) {
        if ($id && $id !== "new") {
            return get_post_meta($id, 'protect_method', true) ?: $this->default_protect_method();
        } elseif ($id) {
            return $this->default_protect_method();
        }
    }

    public function default_condition() {
        return [
            'parameter' => 'cookie',
            'key' => 'is_member',
            'operator' => 'notset',
        ];
    }

    public function default_protect_method() {
        list($page) = get_posts([
            'post_type' => "page",
            'posts_per_page' => 1,
            'order' => 'ASC',
        ]);
        debug($page);
        return [
            'method' => 'redirect',
            'value' => (string)$page->ID,
        ];
    }

    private function default_ruleset() {
        return [[[
            'parameter' => "post_type",
            "operator" => 'is',
            'post',
        ]]];
    }
}
