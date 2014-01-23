<?php
/**
 * Template Name: GigPress
 *
 * This page template is for the use with GigPress shortcodes.
 * The page eliminates the sidebar and has custom classes to
 * better help in the styling of the page.
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
$is_page = 'template-gigpress';

get_header(); ?>

<section id="main" class="gigpress-page">
	
	<?php 
	/**
	 * Image Carousel
	 *
	 */
	$image_carousel_enable = ti_get_option( 'image_carousel_enable' );
	
	if ( $image_carousel_enable['gigpress'] == 1 )
		locate_template( 'includes/image-carousel.php', true ) ?>

	<?php
	/**
	 * Singular Loop (single, page, attachment)
	 *
	 */
	get_template_part( 'content', 'singular' ); ?>
	
</section><!-- #main -->

<?php get_footer(); ?>
