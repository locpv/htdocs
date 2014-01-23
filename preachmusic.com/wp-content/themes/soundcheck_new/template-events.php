<?php
/*
Template Name: Events
*/
?>

<?php get_header(); ?>

<?php if ( 1 == soundcheck_option( 'carousel_events' ) ) soundcheck_get_image_carousel( 'events' ); ?>

<section id="content" role="contentinfo">	

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    <?php get_template_part( 'partials/post', 'header' ); ?>

	    <?php if ( $post->post_content != '' ) : ?>
	    	<?php get_template_part( 'partials/post', 'content' ); ?>
	    <?php endif; ?>
	    
	    <div id="events-list">
			<?php get_template_part( 'loop', 'events' ); ?>
	    </div>
	
	    <?php comments_template( '', true ); ?>
	</article><!-- #post-## -->
	
	<?php soundcheck_pagination( 'nav-below' ); ?>
	
</section><!-- #content -->

<?php get_footer(); ?>