<?php
/**
 * Template Name: Cart66 Cart
 *
 * This template will display all posts that have been set to use a
 * Cart66 product. This option is set via the Products custom metabox.
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

<section id="content" role="contentinfo">	
	<?php get_template_part( 'page', 'header' ); ?>
	<?php get_template_part( 'inc/plugins/cart66/loop', 'product' ); ?>
</section><!-- #content -->
    
<?php get_footer(); ?>