<?php

namespace Membergate\Shortcode;

use Membergate\RenderForm\MembergateFormRenderer;

class SignupShortcode implements ShortcodeInterface {
    private MembergateFormRenderer $form_renderer;

    public function __construct(MembergateFormRenderer $form_renderer) {
        $this->form_renderer = $form_renderer;
    }

    public static function get_dependencies(): array {
        return ['form_renderer'];
    }

    public function run($atts): string {
        $form = '<div class="membergate-parent">';
        $form .= $this->form_renderer->return_form('form_template', 'PrimaryForm');
        $form .= "</div>";
        return $form;
    }

    public function get_default_args(): array {
        return [
            'title' => true,
            'details' => true,
        ];
    }
}
