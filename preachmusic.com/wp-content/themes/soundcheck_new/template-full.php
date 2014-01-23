<?php
/**
 * Template Name: Full Width
 *
 * The full width template page. Page width is adjusted via CSS.
 * The CSS class is provided via the WordPress body_class() function.
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

<?php if ( 1 == soundcheck_option( 'carousel_full' ) ) soundcheck_get_image_carousel( 'full' ); ?>

<section id="content" role="contentinfo">	
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content', 'page' ); ?>
	<?php endwhile; ?>
</section><!-- #content -->

<?php get_footer(); ?>
