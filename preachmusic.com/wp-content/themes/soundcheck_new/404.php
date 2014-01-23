<?php
/**
 * The main template file.
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

<section id="content" role="contentinfo">
	<?php get_template_part( 'page', 'header' ); ?>
	<?php get_template_part( 'no-results', '404' ); ?>
</section><!-- #content -->

<?php if ( soundcheck_has_right_sidebar() ) get_sidebar( 'secondary' ); ?>

<?php get_footer(); ?>