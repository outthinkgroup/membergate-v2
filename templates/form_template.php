<?php
/*
 * This template is called from the MembergateFormRender class 
 */
$fields = $this->fields();
?>
<div class='membergate-wrapper'>

	<h3 class="membergate-form__heading"><?= $this->headingText(); ?></h3>
	<p class="membergate-form__description"><?= $this->descriptionText(); ?></p>

	<form class="membergate-form__form" method="POST">
		<div class="membergate-form__fields">
		<?php foreach($fields as ['type'=>$f_type, 'markup'=>$markup]): ?>
			<div class="membergate-form__field">
				<?= $markup; ?>
			</div>
		<?php endforeach; ?>
		</div>
		<button name="membergate_form" value="add_subscriber_to_service"><?= $this->submitText(); ?></button>
		<input type="hidden" data-replace-value="linkHref" name="redirect_to" value="<?= $this->redirect_to(); ?>" />
	</form>
	<a><?= $this->altFormLinkText(); ?></a>
</div>
