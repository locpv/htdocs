<?php
/**
 * Setup the WordPress core custom header feature.
 *
 * @package Soundcheck
 */
function soundcheck_custom_background_setup() {

	$args = array(
		'default-color' => '5F6671',
		'default-image' => get_template_directory_uri() . '/images/bg-lines-alpha.png'
	);	

	add_theme_support( 'custom-background', apply_filters( 'soundcheck_custom_background_args', $args ) );
	
}
add_action( 'after_setup_theme', 'soundcheck_custom_background_setup' );