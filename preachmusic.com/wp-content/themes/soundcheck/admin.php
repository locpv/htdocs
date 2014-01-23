<?php
/**
 * Admin Functions
 *
 * @package      WordPress
 * @subpackage   Soundcheck
 * @author       Luke McDonald <luke@celtic7.com>
 * @copyright    Copyright (c) 2011, Luke McDonald
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
 */
function ti_setup_soundcheck_admin() {
	include_once ti_ADMINPATH . '/theme-post-types.php';
	include_once ti_ADMINPATH . '/theme-widgets.php';
	
	/* WordPress Core. */
	add_action( 'admin_notices',        'ti_of_admin_notice' );
	add_action( 'admin_init',           'ti_of_nag_ignore' );
	add_filter( 'login_headertitle',    'ti_login_headertitle' );
	add_filter( 'login_headerurl',      'ti_login_headerurl' );
	add_filter( 'tiny_mce_before_init', 'ti_tiny_mce_valid_elements' );
	add_filter( 'widget_text',          'do_shortcode' );
	add_filter( 'widget_text',          'shortcode_unautop' );
}
add_action( 'after_setup_theme', 'ti_setup_soundcheck_admin' );


/**
 * Options Framework Notice
 *
 * Display a notice that can be dismissed
 *
 * @since     1.0
 */

function ti_of_admin_notice() {
	global $current_user ;
		$user_id = $current_user->ID;

	if ( ! get_user_meta($user_id, 'ti_of_ignore_notice') && ! function_exists( 'optionsframework_init' ) ) {
	
		add_thickbox();
		
		echo '<div class="updated"><p>';
		printf( __( 'The Options Framework plugin is required for this theme to function properly. <a href="%1$s" class="thickbox onclick">Install now</a> | <a href="%2$s">Hide Notice</a>' ), admin_url( 'plugin-install.php?tab=plugin-information&plugin=options-framework&TB_iframe=true&width=640&height=517' ) , '?ti_of_nag_ignore=0' );
		echo "</p></div>";
	}
}


/**
 * Options Framework Notice Ignore
 *
 * @since     1.0
 */ 
function ti_of_nag_ignore() {
	global $current_user;
	$user_id = $current_user->ID;

	if ( isset( $_GET['ti_of_nag_ignore'] ) && '0' == $_GET['ti_of_nag_ignore'] ) {
		add_user_meta( $user_id, 'ti_of_ignore_notice', 'true', true );
	}
} 


/**
 * TinyMCE iFrames
 *
 * Allow iFrames in Tiny MCE. Allows google maps, youtube iframe embeds, etc. to not be romoved from editor.
 *
 * @since     1.0
 */
function ti_tiny_mce_valid_elements( $elements ) {
	$elements['extended_valid_elements'] = 'iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]';
	return $elements;
}


/**
 * Login Logo Link
 *
 * @since     1.0
 */
function ti_login_headerurl( $url ) {
	return home_url();
}


/**
 * Login Title
 *
 * @since     1.0
 */
function ti_login_headertitle( $message ) {
	return get_bloginfo( 'name' );
}

?>