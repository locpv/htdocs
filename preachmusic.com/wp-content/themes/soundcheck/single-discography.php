<?php  
/**
 * Page Type
 *
 * Used in functions.php ti_has_sidebar() check.
 */
$is_page = 'single-discography'; // Used to set media embed size in includes/entry-thumbnail.php

get_header(); ?>

<section id="main" class="single-discography">
	
	<?php 
	/**
	 * Image Carousel
	 *
	 */
	$image_carousel_enable = ti_get_option( 'image_carousel_enable' );
	
	if ( $image_carousel_enable['single'] == 1 )
		locate_template( 'includes/image-carousel.php', true ) ?>

	<?php
	/**
	 * Discography Loop
	 *
	 */
	get_template_part( 'content', 'discography' ); ?>
	
	<?php 
	/**
	 * Secondary Sidebar
	 *
	 */
	if ( ti_has_sidebar() )
		get_sidebar( 'secondary' ); ?>
	
</section><!-- #main -->

<?php get_footer(); ?>

