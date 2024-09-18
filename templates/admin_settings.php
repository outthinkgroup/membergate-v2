<div class="tailwind">
	<div class="max-w-screen-lg mx-auto p-8 ">
		<h1 class="text-2xl font-medium"><?= $this->get_menu_title(); ?></h1>
        <div class="" id="svelte-root" data-page-data='<?= $this->ssrData(); ?>'>
			<!-- Once JS Loads the app will be placed right here -->
		</div>
	</div>
</div>
