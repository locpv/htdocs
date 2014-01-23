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
	 * Image Carousel
	 *
	 */
	$image_carousel_enable = ti_get_option( 'image_carousel_enable' );
	
	if ( $image_carousel_enable['page'] == 1 )
		locate_template( 'includes/image-carousel.php', true ) ?>

	<?php
	/**
	 * Singular Loop (single, page, attachment)
	 *
	 */
	get_template_part( 'content', 'singular' ); // content-singular.php ?>
	
	<?php 
	/**
	 * Home Sidebar
	 *
	 */
	if ( ti_has_sidebar() )
		get_sidebar( 'secondary' ); ?>
					
</section><!-- #main -->

<?php get_footer(); ?>