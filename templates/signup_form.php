<?php

?>
<div id="membergate-signup" class="membergate-signup">
	<h3><?= get_form_title(); ?></h3>
	<p><?= get_form_instructions(); ?></p>
	<form method="POST">
		<label for="name">	
			<span>Name</span>
			<input name="user_name" id="name" type="text">
		</label>
		<label for="email">
			<span>Email</span>
			<input name="email" id="email" type="email">
		</label>
		<button name="membergate_form" value="add_subscriber_to_service"><?= get_button_label(); ?></button>
	</form>
</div>
