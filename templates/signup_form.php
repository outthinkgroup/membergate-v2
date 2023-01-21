<form class="membergate-signup-form" method="POST">
	<div class="main-inputs">
		<label for="name">	
			<span>Name</span>
			<input name="user_name" id="name" type="text">
		</label>
		<label for="email">
			<span>Email</span>
			<input name="email" id="email" type="email">
		</label>
	</div>
	<?php do_action("membergate_signup_form_additional_fields"); ?>
	<button name="membergate_form" value="add_subscriber_to_service"><?= $this->get_button_label(); ?></button>
</form>
