<?php

namespace Membergate\Settings;


class RuleEditor {
    public function load_rule_value_options($req) {
        switch ($req->param) {
            case "post_type":
                return ['post_type' => $this->load_post_types()];
            case "post":
                return ['post' => $this->load_posts()];
            case "page":
                return ['page' => $this->load_pages()];
            case "category":
                return ['category' => $this->load_categories()];
            case "tag":
                return ['tag' => $this->load_tags()];
            case "user_role":
                return ['user_role' => $this->load_user_roles()];
            case "page_template":
                return ["page_template" => $this->load_page_templates()];
            default:
                return [];
        }
    }

    public function save_rules($req){
        $rules = $req->rules;
        $condition = $req->condition;
        $protect_method = $req->protectMethod;
        $pid = intval($req->id);
        update_post_meta($pid, 'rules', $rules);
        update_post_meta($pid, 'condition', $condition);

        update_post_meta($pid, 'protect_method', $protect_method);

        $res = wp_update_post([
            'ID'=>$pid,
            'post_title'=>$req->title,
            'post_status'=>'publish',
        ],true);
        $link = get_edit_post_link($pid,'if you know, you know, you know?');
        debug($link);
        return ["message"=>"ok", "redirect"=>$link];
    }

    public function load_post_types() {
        $ptypes = get_post_types(['public' => true], 'object');
        return $this->build_slug_label_map($ptypes, 'name', 'label');
    }

    public function load_posts() {
        $posts = get_posts(['post_type' => get_post_types(['public' => true], 'names'), 'post_per_page' => -1]);
        return $this->build_slug_label_map($posts, 'ID', 'post_title');
    }

    public function load_pages() {
        $pages = get_posts(['post_type' => 'page', 'post_per_page' => -1]);
        return $this->build_slug_label_map($pages, 'ID', 'post_title');
    }

    public function load_categories() {
        $cats = get_categories();
        return $this->build_slug_label_map($cats, 'term_id', 'name');
    }

    public function load_tags() {
        $tags = get_terms(['taxonomy' => 'post_tag', 'hide_empty' => false]);
        debug($tags);
        return $this->build_slug_label_map($tags, 'term_id', 'name');
    }

    public function load_page_templates() {
        $temps = get_page_templates(null, 'page');
        $templates = [];
        foreach ($temps as $label => $slug) {
            $templates[$slug] = $label;
        }
        return $templates;
    }

    public function load_user_roles() {
        $roles = get_editable_roles();
        $user_roles = [];
        foreach ($roles as $slug => $role) {
            $user_roles[$slug] = $role['name'];
        }
        return $user_roles;
    }

    private function build_slug_label_map($inputArr, $slug, $label) {
        $acc = [];
        if (count($inputArr) == 0) {
            return [0 => '--Empty--'];
        }
        foreach ($inputArr as $item) {
            $acc[$item->{$slug}] = $item->{$label};
        }
        return $acc;
    }

}
