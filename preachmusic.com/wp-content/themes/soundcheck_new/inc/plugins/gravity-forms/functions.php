<?php
define( 'SOUNDCHECK_GFORMS_DIR', get_template_directory() . '/inc/plugins/gravity-forms'  );
define( 'SOUNDCHECK_GFORMS_DIR_URI', get_template_directory_uri() . '/inc/plugins/gravity-forms'  );


if ( ! function_exists( 'soundcheck_gforms_setup' ) ) :
/**
 * Sets up plugin defaults and registers support for various WordPress features.
 *
 * @since 2.1.0
 */
function soundcheck_gforms_setup() {
	
	/**
	 * Include custom styles
	 */
	require( SOUNDCHECK_GFORMS_DIR . '/inc/custom-styles.php' );
	
}
endif;
add_action( 'after_setup_theme', 'soundcheck_gforms_setup' );


if ( ! function_exists( 'soundcheck_gforms_scripts' ) ) :
/**
 * Enqueue scripts
 *
 * @since 2.1.0
 */
function soundcheck_gforms_scripts() {

	wp_enqueue_style( 'soundcheck-gforms', SOUNDCHECK_GFORMS_DIR_URI . '/css/theme-gforms.css', array( 'gforms_css' ), soundcheck_version_id() );

}
endif;
add_action( 'wp_enqueue_scripts', 'soundcheck_gforms_scripts' );