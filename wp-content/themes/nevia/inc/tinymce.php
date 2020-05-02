<?php

add_action('init', 'pptinymce_buttons');
function pptinymce_buttons() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
		return;
	}
	if ( get_user_option('rich_editing') == 'true' ) {
		add_filter( 'mce_external_plugins', 'add_plugin' );
		add_filter( 'mce_buttons_3', 'register_button' );
	}
}
/**
Register Button
*/

function register_button( $buttons ) {
	array_push( $buttons, 'columns',"headline","dropcaps", "pptooltip", "list", 'ppiconbox', "ppcolumns", "ppnotice", "ppaccordion", "ppbutton",  "pptabs", "pptoggle", "ppboxes", 'skillbox','recent','pptestimonials','ppteam' );
	return $buttons;
}
/**
Register TinyMCE Plugin
*/

function add_plugin( $plugin_array ) {
	$plugin_array['purethemesmce'] = get_template_directory_uri() . '/inc/tinymcebuttons.js';
	return $plugin_array;
}
?>