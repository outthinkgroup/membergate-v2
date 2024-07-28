<?php

namespace Membergate\Settings;

use Membergate\Assets\Vite;
use Membergate\DTO\Rules\ConditionDTO;

class RuleEditor {

    public function __construct(private Vite $vite, public OverlayEditor $overlay_editor) { }

    public function enqueue_assets(): void {
        $this->vite->use("assets/rule-editor.ts");
        /* TODO Uncomment this when the rule editor is ready
        $this->overlay_editor->enqueue_assets();
         */
    }


    /*╭─────────────────────────────╮*/
    /*│    [   Ajax Handlers   ]    │*/
    /*╰─────────────────────────────╯*/

    /**
     * @param mixed $req 
     * @return array 
     */
    public function load_rule_value_options($req): array {
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
    /**
     * @param mixed $req
     * @return array{message:string,redirect:string}
     */
    public function save_rules($req): array {
        $rules = $req->rules;
        $condition = $req->condition;
        $protect_method = $req->protectMethod;

        if ($req->id == "new") {
            $pid = wp_insert_post([
                'post_title' => $req->title,
                'post_type' => 'membergate_rule',
                'post_status' => 'publish',
            ]);
            if ($pid === 0) {
                return ["message" => "couldn't create the post", "redirect" => ""];
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

        update_post_meta($pid, 'condition', ConditionDTO::fromObject($condition));

        update_post_meta($pid, 'protect_method', $protect_method);

        $link = get_edit_post_link($pid, 'if you know, you know, you know?');
        return ["message" => "ok", "redirect" => $link];
    }
    /**
     * @return array<int,string>|array
     */
    public function load_post_types(): array {
        $ptypes = get_post_types(['public' => true], 'object');
        return $this->build_slug_label_map($ptypes, 'name', 'label');
    }
    /**
     * @return array<int,string>|array
     */
    public function load_posts(): array {
        $posts = get_posts(['post_type' => 'post', 'posts_per_page' => -1]);
        return $this->build_slug_label_map($posts, 'ID', 'post_title');
    }
    /**
     * @return array<int,string>|array
     */
    public function load_pages(): array {
        $pages = get_posts(['post_type' => 'page', 'posts_per_page' => -1]);
        return $this->build_slug_label_map($pages, 'ID', 'post_title');
    }
    /**
     * @return array<int,string>|array
     */
    public function load_categories(): array {
        $cats = get_categories();
        return $this->build_slug_label_map($cats, 'term_id', 'name');
    }
    /**
     * @return array<int,string>|array
     */
    public function load_tags(): array {
        $tags = get_terms(['taxonomy' => 'post_tag', 'hide_empty' => false]);
        return $this->build_slug_label_map($tags, 'term_id', 'name');
    }
    /**
     * @return array*/
    public function load_page_templates(): array {
        $temps = get_page_templates(null, 'page');
        $templates = [];
        foreach ($temps as $label => $slug) {
            $templates[$slug] = $label;
        }
        return $templates;
    }
    /**
     * @param array $inputArr
     * @param string $slug
     * @param string $label
     * @return array<int|string,string>
     */
    private function build_slug_label_map(array $inputArr, string $slug, string $label): array {
        $acc = [];
        if (count($inputArr) == 0) {
            return [0 => '--Empty--'];
        }
        foreach ($inputArr as $item) {
            $acc[$item->{$slug}] = $item->{$label};
        }
        return $acc;
    }

    public function as_css_vars(string $settings): string {
        ob_start();
        foreach ((array)$settings as $key => $value) {
            echo "--$key:$value; ";
        }
        return ob_get_clean();
    }

    /**
     * @return array<array{id:int,title:string,link:string}>
     **/
    public function get_overlays(): array {
        $overlays = get_posts(['post_type' => 'membergate_overlay', 'posts_per_page' => -1]);
        return array_map(function (\WP_Post $overlay) {
            return [
                'id' => $overlay->ID,
                'title' => $overlay->post_title,
                'link' => get_edit_post_link($overlay->ID),
            ];
        }, $overlays);
    }
}
