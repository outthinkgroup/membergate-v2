<?php

function get_form_title(){
	global $post;
	$form_options = get_option('membergate_form_options');

	$title = check_and_return($form_options['title']);
	$title = apply_filters("membergate_form_title", $title, $post);
	if(!$title){
		$title = 'This content is for subscribers only';
	}
	return $title;
}

function get_form_instructions(){
	global $post;
	$form_options = get_option('membergate_form_options');

	$instructions = check_and_return($form_options['instructions']);
	$instructions = apply_filters("membergate_form_instructions", $instructions, $post);
	if(!$instructions){
		$instructions = 'Fill out the form below to get access';
	}
	return $instructions;
}

function get_button_label(){
	global $post;
	$form_options = get_option('membergate_form_options');

	$label = check_and_return($form_options['button_label']);
	$label = apply_filters("membergate_button_label", $label, $post);
	if(!$label){
		$label = 'Get Access';
	}
	return $label;
}



