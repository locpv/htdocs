<?php
/**
 * Template Name: GigPress
 *
 * This page template is for the use with GigPress shortcodes.
 * The page eliminates the sidebar and has custom classes to
 * better help in the styling of the page.
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

<?php if ( 1 == soundcheck_option( 'carousel_events' ) ) soundcheck_get_image_carousel( 'events' ); ?>

<section id="content" role="contentinfo">	
	<?php get_template_part( 'content', 'page' ); ?>
</section><!-- #content -->

<?php get_footer(); ?>
