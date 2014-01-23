<?php 
/**
 * @package Soundcheck
 * @since 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php get_template_part( 'partials/post', 'header' ); ?>
    
    <?php if ( has_post_thumbnail() ) : ?>
    	<div class="entry-media">
    		<figure class="entry-thumbnail">
				<?php print get_the_post_thumbnail( get_the_ID(), soundcheck_thumbnail_size() ); ?>
			</figure>
    	</div>
    <?php endif; ?>

    <?php if ( $post->post_content != '' ) : ?>
    	<?php get_template_part( 'partials/post', 'content' ); ?>
    	
		<?php
		$args = array(
		    'before' => sprintf( '<p class="pagelinks"><span>%s</span><br />', __( 'Pages:', 'soundcheck' ) ),
		    'after' => '</p>',
		    'link_before' => '<span class="page-numbers">',
		    'link_after' => '</span>'
		);
		
		wp_link_pages( $args ); 
		?>
    <?php endif; ?>

    <?php comments_template( '', true ); ?>
</article><!-- #post-## -->
