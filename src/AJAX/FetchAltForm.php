<?php

namespace Membergate\AJAX;

use Membergate\RenderForm\MembergateFormRenderer;

class FetchAltForm implements AjaxInterface {
    private $form_renderer;
    public function __construct(MembergateFormRenderer $form_renderer) {
        $this->form_renderer = $form_renderer;
    }

    public const ACTION = 'fetch_alt_form';

    public function get_action(): string {
        return self::ACTION;
    }

    public function get_name(): string {
        return self::class;
    }

    public function handle() {
        //get stuff from $_POST
        $alt_form = $_REQUEST['current_form'] == 'SecondaryForm' ? 'PrimaryForm' : 'SecondaryForm';
        //get other form contents
        $form_contents = $this->form_renderer->return_form('form_template', $alt_form);
        exit($form_contents);
    }
}
