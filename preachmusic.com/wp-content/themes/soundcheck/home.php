<?php
/**
 * The main template file.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */

get_header(); ?>

<section id="main" role="main">
	
	<?php 
	/**
	 * Image Carousel
	 *
	 */
	locate_template( 'includes/image-carousel.php', true ) ?>

	<?php 
	/**
	 * Home Page Widgets
	 *
	 */
	get_sidebar( 'home' ) ?>
	
</section><!-- #main -->

<?php get_footer(); ?>