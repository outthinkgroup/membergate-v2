<?php

namespace Membergate\Settings;

class Rules {
    public $rule_editor;
    public function __construct(RuleEditor $editor) {
        $this->rule_editor = $editor;
    }

    public function load_editor(): void {
        $this->rule_editor->enqueue_assets();
    }

    public function render_rule_settings(): void {
        $post_types = $this->rule_editor->load_post_types();
        $id = (int)isset($_GET['id']) ? $_GET['id'] : "new";
        $rules = $this->get_rules($id);
        $condition = $this->get_conditions($id);
        $protect_method = $this->get_protect_method($id);

        // TODO uncomment when we use the custom overlay editor
        // $overlay_content = $this->rule_editor->overlay_editor->get_overlay($id)['content'];
        // $overlay_editor_settings = $this->rule_editor->overlay_editor->get_overlay_editor_settings();

        $overlays = $this->rule_editor->get_overlays();
?>
        <script>
            window.membergate = <?= json_encode([
                                    'url' =>  admin_url('admin-ajax.php'),
                                    'postId' => $id,
                                    'title' => get_the_title($id),
                                    'Rules' => [
                                        'initialRuleValueOptionStore' => [
                                            'post_type' =>  $post_types,
                                        ],
                                        'ruleList' =>  $rules,
                                        'ruleCondition' =>  $condition,
                                        'protectMethod' =>  $protect_method,
                                    ],
                                    'OverlayEditor' => [
                                        'overlays' => $overlays,
                                    ],
                                ]); ?>
        </script>
<?php

    }
    /**
     * @param null|int $id
     * @return array<object>
     */
    public function get_rules($id = null): array {
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
    /**
     * @return array
     * @param mixed $id
     */
    public function get_conditions($id = null):array {
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
    /**
     * @param int|string|null $id
     */
    public function get_protect_method($id): object {
        if ($id && $id !== "new") {
            return get_post_meta($id, 'protect_method', true) ?: $this->default_protect_method();
        } elseif ($id) {
            return $this->default_protect_method();
        }
    }
    /**
     * @return object{parameter:string,key:string,operator:string}
     */
    public function default_condition(): object {
        return (object)[
            'parameter' => 'cookie',
            'key' => 'is_member',
            'operator' => 'notset',
        ];
    }
    /**
     * @return object{method:string,value:string}
     */
    public function default_protect_method(): object {
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
            'post',
        ]]];
    }
}
