<?php

namespace Membergate\Shortcode;

use Membergate\RenderForm\MembergateFormRenderer;

class SignupShortcode implements ShortcodeInterface {
    private MembergateFormRenderer $form_renderer;

    public function __construct($deps) {
        ['form_renderer' => $form_renderer] = $deps;
        $this->form_renderer = $form_renderer;
    }

    public static function get_dependencies(): array {
        return ['form_renderer'];
    }

    public function run($atts): string {
        $form = '';

        // if ($atts['title'] != false) {
        //     if (is_bool($atts['title'])) {
        //         $form .= "<h3>{$this->form_renderer->get_form_title()}</h3>";
        //     } elseif (is_string($atts['title'])) {
        //         $form .= "<h3>{$atts['title']}</h3>";
        //     }
        // }
        //
        // if ($atts['details'] != false) {
        //     if (is_bool($atts['details'])) {
        //         $form .= "<p>{$this->form_renderer->get_form_details()}</p>";
        //     } elseif (is_string($atts['details'])) {
        //         $form .= "<p>{$atts['details']}</p>";
        //     }
        // }

        $form .= $this->form_renderer->return_form('form_template');

        // if ($atts['title'] != false || $atts['details'] != false) {
        //     $form = $this->form_renderer->wrap_in_wrapper($form);
        // }

        return $form;
    }

    public function get_default_args(): array {
        return [
            'title' => true,
            'details' => true,
        ];
    }
}
