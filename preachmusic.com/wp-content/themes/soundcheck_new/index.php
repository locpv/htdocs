<?php
/**
 * The main template file.
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

<?php if ( 1 == soundcheck_option( 'carousel_multiple' ) ) soundcheck_get_image_carousel( 'multiple' ); ?>

<section id="content" role="contentinfo">
	<?php get_template_part( 'page', 'header' ); ?>
	<?php get_template_part( 'loop' ); ?>
	<?php soundcheck_pagination( 'nav-below' ); ?>
</section><!-- #content -->

<?php if ( soundcheck_has_right_sidebar() ) get_sidebar( 'secondary' ); ?>

<?php get_footer(); ?>