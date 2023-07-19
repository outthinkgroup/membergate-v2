<?php

namespace Membergate\Settings;

class RuleEditor {
    public function load_param_value($req) {
        switch($req->param) {
            case "post_type": return ['post_type'=>$this->load_post_types()];
            case "post": return ['post'=>$this->load_posts()];
            case "page": return ['page'=>$this->load_pages()];
            case "category": return ['category'=>$this->load_categories()];
            case "tag": return ['tag'=>$this->load_tags()];
            case "user_role": return [ 'user_role'=>$this->load_user_roles()];
            case "page_template": return ["page_template"=>$this->load_page_templates()];
            default: return [];
        }
    }

    public function load_post_types() {
        $ptypes = get_post_types(['public' => true], 'object');
        return $this->build_slug_label_map($ptypes, 'name', 'label');
    }

    public function load_posts() {
        $posts = get_posts(['post_type' => get_post_types(['public'=>true], 'names'), 'post_per_page'=>-1]);
        return $this->build_slug_label_map($posts, 'ID', 'post_title');
    }

    public function load_pages() {
        $pages = get_posts(['post_type' => 'page', 'post_per_page'=>-1]);
        return $this->build_slug_label_map($pages, 'ID', 'post_title');
    }

    public function load_categories() {
        $cats = get_categories();
        return $this->build_slug_label_map($cats, 'term_id', 'name');
    }

    public function load_tags() {
        $tags = get_terms(['taxonomy'=>'post_tag', 'hide_empty'=>false]);
        debug($tags);
        return $this->build_slug_label_map($tags, 'term_id', 'name');
    }

    public function load_page_templates() {
        $temps = get_page_templates(null, 'page');
        $templates = [];
        foreach ($temps as $label=> $slug) {
            $templates[$slug]=$label;
        }
        return $templates;
    }

    public function load_user_roles() {
        $roles = get_editable_roles();
        $user_roles = [];
        foreach ($roles as $slug=>$role) {
            $user_roles[$slug]=$role['name'];
        }
        return $user_roles;
    }

    private function build_slug_label_map($inputArr, $slug, $label) {
        $acc = [];
        if (count($inputArr) == 0) {
            return [0=>'--Empty--'];
        }
        foreach ($inputArr as $item) {
            $acc[$item->{$slug}] = $item->{$label};
        }
        return $acc;
    }
}
