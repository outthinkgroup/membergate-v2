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
        global $current_screen;
        $current_screen->is_block_editor(true);

        $asset = include $this->plugin_path . "/assets/modal-editor/build/index.asset.php";
        wp_enqueue_style(
            "modal-styles",
            $this->plugin_url . "/assets/modal-editor/build/index.css",
            array('wp-edit-blocks'),
            filemtime($this->plugin_path . '/assets/modal-editor/build/index.css')
        );

        $settings = $this->get_overlay_editor_settings();
        wp_enqueue_script("modal-scripts", $this->plugin_url . "/assets/modal-editor/build/index.js", $asset['dependencies'], $asset['version'], false);

        wp_add_inline_script("modal-scripts", "window.initialBlocks = " . wp_json_encode(get_post_meta($this->rule_id(), "wp_overlay_content", true) ?: []));
        wp_add_inline_script("modal-scripts", 'window.overlayEditorSettings = ' . wp_json_encode($settings) . ';');
        wp_add_inline_script(
            'wp-blocks',
            'wp.blocks.unstable__bootstrapServerSideBlockDefinitions(' . wp_json_encode($this->get_overlay_editor_settings()) . ');'
        );

        wp_enqueue_script('wp-format-library');
        wp_enqueue_style('wp-format-library');

        // load editor assets
        \do_action('enqueue_block_assets');
    }

    function get_overlay_editor_settings() {
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

        return $settings;
    }

    /*╭─────────────────────────────╮*/
    /*│    [   Ajax Handlers   ]    │*/
    /*╰─────────────────────────────╯*/

    public function save_overlay($body) {
        $post_id = (int)$body->postId;
        $content = $body->content;
        $res = (bool)update_post_meta($post_id, "wp_overlay_content", $content);
        return ['saved' => $res];
    }
}
