<?php
/**
 * The page template file.
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

<?php if ( 1 == soundcheck_option( 'carousel_pages' ) ) soundcheck_get_image_carousel( 'pages' ); ?>

<section id="content" role="contentinfo">	
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php get_template_part( 'content', 'page' ); ?>
	<?php endwhile; ?>
</section><!-- #content -->

<?php if( soundcheck_has_right_sidebar() ) get_sidebar( 'secondary' ); ?>

<?php get_footer(); ?>