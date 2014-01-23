<?php  
/**
 * Template Name: Discography
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
$is_page = 'template-discography'; // Used to set media embed size in includes/entry-thumbnail.php

get_header(); ?>

<section id="main" class="discography-page">
	
	<?php 
	/**
	 * Image Carousel
	 *
	 */
	$image_carousel_enable = ti_get_option( 'image_carousel_enable' );
	
	if ( $image_carousel_enable['discography'] == 1 )
		locate_template( 'includes/image-carousel.php', true ) ?>

	<?php
	/**
	 * Discography Query
	 *
	 */
	$discography_args = array(
		'posts_per_page' => -1,
		'post_type' => 'discography'
	);
	
	query_posts( $discography_args ); 
	
	get_template_part( 'content', 'discography' ); 
	
	wp_reset_query(); ?>
	
</section><!-- #main -->

<?php get_footer(); ?>

