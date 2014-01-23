<?php
/**
 * Template Name: Full Width
 *
 * The full width template page. Page width is adjusted via CSS.
 * The CSS class is provided via the WordPress body_class() function.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */

/**
 * Page Type
 *
 * Used in functions.php ti_has_sidebar() check.
 */
$is_page = 'template-full'; // Used to set media embed size in includes/entry-thumbnail.php

get_header(); ?>

<section id="main" class="full-page">
	
	<?php 
	/**
	 * Image Carousel
	 *
	 */
	$image_carousel_enable = ti_get_option( 'image_carousel_enable' );
	
	if ( $image_carousel_enable['fullwidth'] == 1 )
		locate_template( 'includes/image-carousel.php', true ) ?>

	<?php
	/**
	 * Singular Loop (single, page, attachment)
	 *
	 */
	get_template_part( 'content', 'singular' ); // content-singular.php  ?>
	
</section><!-- #main -->

<?php get_footer(); ?>
