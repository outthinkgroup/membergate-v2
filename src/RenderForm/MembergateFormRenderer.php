<?php

namespace Membergate\RenderForm;

class MembergateFormRenderer {
    private $form_settings;
    private $template_path;
    private $errors = [];

    public function __construct($form_settings, $template_path) {
        $this->form_settings = $form_settings->get_all();
        $this->template_path = $template_path;
    }

    /*
     * TEMPLATE HELPERS
     * Used to get out the forms settings
     * ? Why CamelCase: Template Helpers will be CamelCase to more closely match the key name
     *
     */
    public function hasError() {
        return count($this->errors) > 0;
    }

    public function errors() {
        return $this->errors;
    }

    public function headingText($form_key = "PrimaryForm"): string {
        global $post;
        return $this->modifiable('headingText', $this->form_settings[$form_key]['headingText'], $post, $form_key);
    }

    public function descriptionText($form_key = "PrimaryForm"): string {
        global $post;
        return $this->modifiable('descriptionText', $this->form_settings[$form_key]['descriptionText'], $post, $form_key);
    }

    public function fields($form_key = "PrimaryForm"): array {
        return (new FieldRender($this->form_settings[$form_key]['fields']))->build_fields();
    }

    public function submitText($form_key = "PrimaryForm"): string {
        global $post;
        return $this->modifiable('submitText', $this->form_settings[$form_key]['submit']['text'], $post, $form_key);
    }

    public function altFormLinkText($form_key = "PrimaryForm"): string {
        global $post;
        $link_text = $this->modifiable('altFormLinkText', $this->form_settings[$form_key]['altFormLink']['text'], $post, $form_key);
        return $link_text;
    }

    public function isAltFormEnabled($form_key="PrimaryForm") {
        if ($form_key == "SecondaryForm") {
            return true;
        }//Primary Form is always enabled

        $primary_action = $this->form_settings['PrimaryForm']['action'];
        $is_secondary_enabled = isset($this->form_settings['SecondaryForm']['isEnabled']) && $this->form_settings['SecondaryForm']['isEnabled'];
        if ($primary_action == 'REGISTER' || !$is_secondary_enabled) {
            return false;
        }

        return true; //default behavior
    }

    public function get_form_action($form_key = "PrimaryForm"): string {
        $action_in_settings = $this->form_settings[$form_key]['action'];
        $action = $action_in_settings == "LOGIN" ? "check_if_subscriber" : "add_subscriber_to_service";
        return $action;
    }

    public function redirect_to() {
        global $post;
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';
        return $this->modifiable("redirect_to", $redirect_to, $post);
    }

    public function content_title() {
        return isset($_REQUEST['content_title']) ? $_REQUEST['content_title'] : "";
    }

    private function modifiable($name, $initial, $post = null, $form = null) {
        return apply_filters("membergate_form_$name", $initial, $post, $form);
    }

    public function add_error($msg) {
        $this->errors[] = $msg;
    }


    //TODO: Refactor below here. Alot of these should be pulled out
    // and this class should just be concerned with the
    // form itself not modals or outputting the contents
    public function include_form($form_slug) {
        error_log(__METHOD__);
        echo $this->return_form($form_slug);
    }

    public function return_form($form_slug = 'form_template', $form_key=null) {
        error_log(__METHOD__);

        //this will be used in the included template
        if (!$form_key && isset($_REQUEST['mg_form_key']) && in_array($_REQUEST['mg_form_key'], ['SecondaryForm', 'PrimaryForm'])) {
            $form_key = $_REQUEST['mg_form_key'];
        }
        if (!$form_key) {
            $form_key = 'PrimaryForm';
        }

        global $post;
        $redirect_to = $this->redirect_to();
        ob_start();
        include $this->template_path . $form_slug . '.php';
        return ob_get_clean();
    }


    public function return_full_form_markup($form_slug) {
        $form = $this->return_form($form_slug);
        return $form;
    }

    public function include_full_form_markup($form_slug) {
        echo $this->return_full_form_markup($form_slug);
    }

    private function _modal_markup() {
        ?>
        <div class="membergate-modal__layer">
            <div class="membergate-modal__modal membergate-parent">
                <header>
                    <h2 data-replace-text="linkTitle"></h2>
                    <button data-action="close">close</button>
                </header>
                <?= $this->return_full_form_markup('form_template'); ?>
            </div>
        </div>
<?php
    }

    public function return_modal_markup() {
        ob_start();
        $this->_modal_markup();
        return apply_filters('membergate_modal_markup', ob_get_clean());
    }

    public function modal_markup() {
        echo $this->return_modal_markup();
    }
}
