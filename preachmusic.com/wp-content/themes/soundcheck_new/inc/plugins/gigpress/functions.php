<?php
define( 'SOUNDCHECK_GIGPRESS_DIR', get_template_directory() . '/inc/plugins/gigpress'  );
define( 'SOUNDCHECK_GIGPRESS_DIR_URI', get_template_directory_uri() . '/inc/plugins/gigpress'  );


if ( ! function_exists( 'soundcheck_gigpress_setup' ) ) :
/**
 * Sets up plugin defaults and registers support for various WordPress features.
 *
 * @since 2.1.0
 */
function soundcheck_gigpress_setup() {
	
	/**
	 * Include custom styles
	 */
	require( SOUNDCHECK_GIGPRESS_DIR . '/inc/custom-styles.php' );
	
}
endif;
add_action( 'after_setup_theme', 'soundcheck_gigpress_setup' );


if ( ! function_exists( 'soundcheck_gigpress_scripts' ) ) :
/**
 * Enqueue scripts
 *
 * @since 2.1.0
 */
function soundcheck_gigpress_scripts() {
	
	wp_enqueue_style( 'soundcheck-gigpress', SOUNDCHECK_GIGPRESS_DIR_URI . '/css/theme-gigpress.css', false, soundcheck_version_id() );
	wp_enqueue_script( 'soundcheck-gigpress', SOUNDCHECK_GIGPRESS_DIR_URI . '/js/theme-gigpress.js', array( 'jquery' ), soundcheck_version_id(), true );
	
}
endif;
add_action( 'wp_enqueue_scripts', 'soundcheck_gigpress_scripts' );