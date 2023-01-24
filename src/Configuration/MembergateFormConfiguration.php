<?php

namespace Membergate\Configuration;

use Membergate\DependencyInjection\Container;
use Membergate\DependencyInjection\ContainerConfigurationInterface;

class MembergateFormConfiguration implements ContainerConfigurationInterface
{
	private $form_settings;
	private $template_path;

	public function init($form_settings, $template_path)
	{
		$this->form_settings = $form_settings;
		$this->template_path = $template_path;
	}

	public function modify(Container $container)
	{
		$container['form_renderer'] = $container->service(function (Container $container) {
			$form_settings = $container['settings.forms'];
			$template_path = apply_filters("membergate_form_template_path", $container['plugin_path'] . "templates/");
			$this->init($form_settings, $template_path);
			return $this;
		});
	}

	public function get_form_title()
	{
		global $post;
		$title = $this->form_settings->get_setting('form_title');
		if ($title->has_error()) {
			$title = 'Get Access';
		} else {
			$title = $title->value;
		}

		if (!$title) {
			$title = 'This content is for subscribers only';
		}
		$title = apply_filters("membergate_form_title", $title, $post);
		return $title;
	}

	public function get_form_details()
	{
		global $post;

		$details = $this->form_settings->get_setting('form_details');
		if ($details->has_error()) {
			$details = 'Fill out the form below to get access';
		} else {
			$details = $details->value;
		}
		$details = apply_filters("membergate_form_details", $details, $post);
		return $details;
	}

	public function get_button_label()
	{
		global $post;

		$label = $this->form_settings->get_setting('form_button_label');
		if ($label->has_error()) {
			$label = 'Get Access';
		} else {
			$label = $label->value;
		}

		$label = apply_filters("membergate_form_button_label", $label, $post);
		return $label;
	}

	public function include_form($form_slug)
	{
		echo $this->return_form($form_slug);
	}

	public function return_form($form_slug)
	{
		global $post;
		$redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : "";
		$redirect_to = apply_filters("membergate_redirect_to_form_value",$redirect_to, $post);
		ob_start();
		include $this->template_path . $form_slug . ".php";
		return ob_get_clean();
	}

	public function include_form_details($form_slug)
	{
		echo $this->return_form_details($form_slug);
	}

	public function return_form_details($form_slug)
	{
		ob_start();
		include $this->template_path . $form_slug . "_details.php";
		return ob_get_clean();
	}

	public function wrap_in_wrapper(string $s)
	{
		$markup = "<div class='membergate-wrapper'>";
		$markup .= $s;
		$markup .= "</div>";
		return $markup;
	}

	public function return_full_form_markup($form_slug)
	{
		$details = $this->return_form_details($form_slug);
		$form = $this->return_form($form_slug);
		$markup = $details . $form;

		return $this->wrap_in_wrapper($markup);
	}
	public function include_full_form_markup($form_slug)
	{
		echo $this->return_full_form_markup($form_slug);
	}

	private function _modal_markup()
	{
	?>
		<div class="membergate-modal__layer">
			<div class="membergate-modal__modal">
				<header>
					<h2 data-replace-text="linkTitle"></h2>
					<button data-action="close">close</button>
				</header>
				<?= $this->return_full_form_markup("signup_form"); ?>
			</div>
		</div>
	<?php
	}

	public function return_modal_markup(){
		ob_start();
		$this->_modal_markup();
		return apply_filters("membergate_modal_markup", ob_get_clean());
	}

	public function modal_markup(){
		echo $this->return_modal_markup();
	}
	
}
