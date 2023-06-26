<?php

namespace Membergate\AJAX;

use Membergate\RenderForm\MembergateFormRenderer;
use Membergate\Settings\FormSettings;

class FetchAltForm implements AjaxInterface {
    private $form_renderer;
    private $form_settings;
    public function __construct(MembergateFormRenderer $form_renderer, FormSettings $form_settings){
        $this->form_renderer= $form_renderer;
        $this->form_settings = $form_settings;
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
