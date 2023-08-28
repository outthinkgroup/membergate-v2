<?php

namespace Membergate\Settings;

use Membergate\Assets\Vite;

class RuleEditor {
    private $vite;
    public $overlay_editor;
    public function __construct(Vite $vite, OverlayEditor $overlay_editor) {
        $this->vite = $vite;
        $this->overlay_editor = $overlay_editor;
    }

    public function enqueue_assets() {
        $this->vite->use("assets/rule-editor.ts");
        $this->overlay_editor->enqueue_assets();
    }


    /*╭─────────────────────────────╮*/
    /*│    [   Ajax Handlers   ]    │*/
    /*╰─────────────────────────────╯*/

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
            case "page_template":
                return ["page_template" => $this->load_page_templates()];
            default:
                return [];
        }
    }

    public function save_rules($req) {
        $rules = $req->rules;
        $condition = $req->condition;
        $protect_method = $req->protectMethod;
        $overlay_content = $req->overlayContent;

        if ($req->id == "new") {
            $pid = wp_insert_post([
                'post_title' => $req->title,
                'post_type' => 'membergate_rule',
                'post_status' => 'publish',
            ]);
            if ($pid === 0) {
                return ["message", "couldn't create the post"];
            }
        } else {
            $pid = intval($req->id);
            $res = wp_update_post([
                'ID' => $pid,
                'post_title' => $req->title,
                'post_status' => 'publish',
            ], true);
        }

        update_post_meta($pid, 'rules', $rules);
        update_post_meta($pid, 'condition', $condition);

        update_post_meta($pid, 'protect_method', $protect_method);
        $this->overlay_editor->save_overlay($pid, $overlay_content);

        $link = get_edit_post_link($pid, 'if you know, you know, you know?');
        return ["message" => "ok", "redirect" => $link];
    }

    public function load_post_types() {
        $ptypes = get_post_types(['public' => true], 'object');
        return $this->build_slug_label_map($ptypes, 'name', 'label');
    }

    public function load_posts() {
        $posts = get_posts(['post_type' => 'post', 'posts_per_page' => -1]);
        return $this->build_slug_label_map($posts, 'ID', 'post_title');
    }

    public function load_pages() {
        $pages = get_posts(['post_type' => 'page', 'posts_per_page' => -1]);
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
