<?php
if(!defined('ABSPATH')) {
    exit;
}

/*
 * This template is called from the MembergateFormRender class.
 *
 * $this refers to MembergateFormRender becuase this file is included in
 * one of its methods giving the file access to its methods
 */

$fields = $this->fields($form_key);
?>
<div class='membergate-wrapper'>

	<h3 class="membergate-form__heading"><?= $this->headingText($form_key); ?></h3>
	<p class="membergate-form__description"><?= $this->descriptionText($form_key); ?></p>

	<?php if ($this->hasError()) : ?>
		<div class="errors">
			<?php foreach ($this->errors() as $error) : ?>
				<p><?= $error; ?></p>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>


	<form class="membergate-form__form" method="POST" >
		<div class="membergate-form__fields">
			<?php foreach ($fields as ['type' => $f_type, 'markup' => $markup]) : ?>
				<div class="membergate-form__field">
					<?= $markup; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<button name="membergate_form" value="<?= $this->get_form_action($form_key); ?>"><?= $this->submitText($form_key); ?></button>
		<input type="hidden" data-replace-value="linkHref" name="redirect_to" value="<?= $this->redirect_to(); ?>" />
        <input type="hidden" data-replace-value="linkTitle" name="content_title" value="<?= $this->content_title();?>" />
        <input type="hidden" value="<?= $form_key; ?>" name="mg_form_key" />
	</form>
    <?php if($this->isAltFormEnabled()): ?>
        <button data-action="switch-form" type="button" data-current-form="<?=$form_key;?>" ><?= $this->altFormLinkText($form_key); ?></button>
    <?php endif; ?>
</div>
