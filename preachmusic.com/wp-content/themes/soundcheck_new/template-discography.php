<?php  
/**
 * Template Name: Discography
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

<?php if ( 1 == soundcheck_option( 'carousel_discography' ) ) soundcheck_get_image_carousel( 'discography' ); ?>

<section id="content" role="contentinfo">	
	<?php	
	$soundcheck_query = new WP_Query( array(
	    'posts_per_page'   => -1,
	    'tax_query'        => array(
	    	array (
	    		'taxonomy' => 'post_format',
	    		'field'    => 'slug',
	    		'terms'    => 'post-format-audio',
	    	)
	  	)
	) );
	?>
	
	<?php if ( $soundcheck_query->have_posts() ) : ?>
	    <?php while ( $soundcheck_query->have_posts() ) : ?>
	    	<?php $soundcheck_query->the_post(); ?>
	    	
	    	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			    <?php get_template_part( 'partials/post', 'format' ); ?>
			</article><!-- #post-##-->
	    	
	    <?php endwhile; ?>
	    <?php wp_reset_postdata(); ?>
	<?php endif; ?>
</section><!-- #content -->

<?php get_footer(); ?>