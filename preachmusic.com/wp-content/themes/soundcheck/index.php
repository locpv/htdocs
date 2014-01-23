<?php
/**
 * The main template file.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */

get_header(); ?>

<section id="main">

	<?php 
	/**
	 * Index Loop (default)
	 *
	 */
	get_template_part( 'content', 'multi' ); // loop.php ?>
	
	<?php
	/**
	 * Sidebar
	 *
	 */
	if ( ti_has_sidebar() )
		get_sidebar( 'secondary' ); ?>
	
</section><!-- #main -->

<?php get_footer(); ?>