<?php
/**
 * This file includes or removes widgets.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 *
 */


/**
 * Include Widgets
 *
 * @since     1.0
 */
function ti_register_widgets() 
{
	require_once ti_ADMINPATH . '/widgets/featured-category.php';
	require_once ti_ADMINPATH . '/widgets/latest-tweets.php';
	require_once ti_ADMINPATH . '/widgets/post-meta.php';
	require_once ti_ADMINPATH . '/widgets/social-sharing.php';
}
add_action( 'widgets_init', 'ti_register_widgets', 1 );


/**
 * Unregister Widgets
 *
 * @since     1.0
 */
function ti_unregister_widgets() 
{
	//unregister_widget( 'WP_Nav_Menu_Widget' );
	unregister_widget( 'WP_Widget_Akismet' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Calendar' );
	//unregister_widget( 'WP_Widget_Meta' );
	//unregister_widget( 'WP_Widget_Pages' );
	//unregister_widget( 'WP_Widget_Recent_Posts' );
	//unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_RSS' );
	//unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	//unregister_widget( 'WP_Widget_Text' );
}
add_action( 'widgets_init', 'ti_unregister_widgets', 1 );

?>