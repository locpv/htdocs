<?php
/**
 * Template Name: Blog
 *
 * This template will display all posts as a blog.
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

<?php if ( 1 == soundcheck_option( 'carousel_multiple' ) ) soundcheck_get_image_carousel( 'multiple' ); ?>

<section id="content" role="contentinfo">
	<?php get_template_part( 'loop', 'blog' ); ?>
	<?php soundcheck_pagination( 'nav-below' ); ?>
</section><!-- #content -->

<?php get_sidebar( 'secondary' ); ?>
    
<?php get_footer(); ?>