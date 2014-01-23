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
	 * Page Header
	 *
	 */
	locate_template( 'includes/page-header.php', true ); ?>
	
	<?php
	/**
	 * Archives
	 *
	 */
	get_template_part( 'content', 'archives' ); // content-archives.php ?>
	
	<?php 
	/**
	 * Home Sidebar
	 *
	 */
	if ( ti_has_sidebar() )
		get_sidebar( 'secondary' ); ?>
					
</section><!-- #main -->

<?php get_footer(); ?>