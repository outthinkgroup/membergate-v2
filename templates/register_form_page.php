<div>
<?php
    global $post;
    get_header(); ?>
<!-- -->
<div>
	<h1><?php the_title(); ?></h1>
	<p>This is page is only for members</p>
	<p><?= do_shortcode('[mg_signup_form]'); ?></p>
</div>
<?php
get_footer();
?>
</div>

