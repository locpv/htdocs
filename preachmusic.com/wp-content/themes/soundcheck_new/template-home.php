<?php
/**
 * Template Name: Home
 *
 * This page template is used for the home page seen in the theme demo.
 * This page template displays widgets in the Home Column sidebar areas.
 *
 * @package Soundcheck
 * @since 2.3.0
 */

get_header(); ?>

	<?php if ( 1 == soundcheck_option( 'carousel_home' ) ) soundcheck_get_image_carousel( 'home' ); ?>
	
	<?php if ( '' != $post->post_content ) : ?>
	<section id="content" role="contentinfo">	
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'content', 'page' ); ?>
		<?php endwhile; ?>
	</section><!-- #content -->
	<?php endif; //if ( '' != $post->post_content ) ?>
	
	<?php get_sidebar( 'template-home' ); ?>

<?php get_footer(); ?>