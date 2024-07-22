<?php

namespace Membergate\Settings;

class OverlayEditor {
    public $plugin_url;
    public $plugin_path;
    public function __construct($plugin_url, $plugin_path) {
        $this->plugin_url = $plugin_url;
        $this->plugin_path = $plugin_path;
    }

    public function rule_id() {
        return isset($_GET['id']) ? (int)$_GET['id'] : 1;
    }

    public function enqueue_assets() {
        \do_action('enqueue_block_editor_assets');
        $asset = include $this->plugin_path . "/assets/modal-editor/build/index.asset.php";
        wp_enqueue_style(
            "modal-styles",
            $this->plugin_url . "/assets/modal-editor/build/index.css",
            [],
            filemtime($this->plugin_path . '/assets/modal-editor/build/index.css')
        );
        wp_enqueue_script("modal-scripts", $this->plugin_url . "/assets/modal-editor/build/index.js", $asset['dependencies'], $asset['version'], false);
        wp_enqueue_script('wp-format-library');
        wp_enqueue_style('wp-format-library');
        wp_enqueue_registered_block_scripts_and_styles();
        wp_enqueue_global_styles_custom_css();
        wp_enqueue_editor_format_library_assets();

        // load editor assets

        wp_add_inline_script(
            'wp-blocks',
            'wp.blocks.unstable__bootstrapServerSideBlockDefinitions(' . wp_json_encode($this->get_overlay_editor_settings()) . ');'
        );
    }

    public function get_overlay_editor_settings() {
        $instance =  \WP_Block_Type_Registry::get_instance();
        $blocks = (array) $instance->get_all_registered();
        $blocks_with_color = array_reduce(array_keys($blocks), function ($acc, $blockname) use ($blocks) {
            if (property_exists($blocks[$blockname], "supports") && !is_null($blocks[$blockname]->supports) && in_array('color', $blocks[$blockname]->supports)) {
                $acc[] = $blockname;
            }
            return $acc;
        }, []);

        $settings = array(
            'disableCustomColors'    => get_theme_support('disable-custom-colors'),
            'disableCustomFontSizes' => get_theme_support('disable-custom-font-sizes'),
            // 'imageSizes'             => $available_image_sizes,
            'isRTL'                  => is_rtl(),
            // 'maxUploadFileSize'      => $max_upload_size,
            '__experimentalBlockPatterns' => [],
            '__experimentalFeatures' => [
                'blocks' => [
                    'core/button' => [
                        'border' => [
                            'customRadius' => true
                        ]
                    ]
                ]
            ]
        );
        foreach ($blocks_with_color as $bwc) {
            $settings['__experimentalFeatures']['blocks'][$bwc] = ['color' => ['text' => true, 'background' => true]];
        }

        list($color_palette,) = (array) get_theme_support('editor-color-palette');
        list($font_sizes,)    = (array) get_theme_support('editor-font-sizes');
        if (false !== $color_palette) {
            $settings['colors'] = $color_palette;
        }

        if (false !== $font_sizes) {
            $settings['fontSizes'] = $font_sizes;
        }

        include_once ABSPATH . 'wp-admin/wp-includes/block-editor.php';
        return get_block_editor_settings([], new \WP_Block_Editor_Context([]));
        // return $settings;
    }

    public function on_current_screen($current_screen) {
        $current_screen->is_block_editor(true);
        return $current_screen;
    }

    /*╭─────────────────────────────╮*/
    /*│    [   Data Handlers   ]    │*/
    /*╰─────────────────────────────╯*/

    public function save_overlay($id, $content) {
        $res = (bool)update_post_meta($id, "membergate_overlay_content", $content);
    }

    public function get_overlay($post_id) {
        return [
            'content' => get_post_meta($post_id, "membergate_overlay_content", true) ?: [],
        ];
    }
    public function save_overlay_settings($post_id, $settings) {
        $res = (bool)update_post_meta($post_id, "membergate_overlay_settings", $settings);
    }

    public function get_overlay_settings($post_id) {
        $settings = get_post_meta($post_id, "membergate_overlay_settings", true) ?: [
            'bgColor' => "#ffffff",
            "textColor" => "#000000",
            "maxWidth" => ["value" => 900, "unit" => 'px'],
            "padding" => [
                'top' => ["value" => 20, "unit" => 'px'],
                'right' => ["value" => 20, "unit" => 'px'],
                'bottom' => ["value" => 20, "unit" => 'px'],
                'left' => ["value" => 20, "unit" => 'px'],
            ],
        ];
        return [
            'settings' => $settings,
        ];
    }
}
