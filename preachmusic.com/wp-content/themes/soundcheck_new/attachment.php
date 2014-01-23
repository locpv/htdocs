<?php
/**
 * The attachement template file.
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

<section id="content" role="contentinfo">	
	<?php while( have_posts() ) : ?>
		<?php the_post(); ?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		    <?php get_template_part( 'partials/post', 'header' ); ?>
		    <?php get_template_part( 'partials/post', 'meta' ); ?>
		    
			<div class="entry-media">
			    <figure class="entry-image">
			    	<?php $post_id = get_the_ID(); ?>
			    	<a href="<?php echo esc_url( wp_get_attachment_url( $post_id ) ); ?>" title="<?php the_title_attribute(); ?>" class="view thumbnail-icon image" rel="attachment">
			    		<?php
			    		if ( wp_attachment_is_image ( $post_id ) ) {
			    			$img_src = wp_get_attachment_image_src( $post_id, 'theme-single' );
			    			$alt_text = get_post_meta( $post_id, '_wp_attachment_image_alt', true );
			    			
			    			printf(	'<img src="%1$s" alt="%2$s">',
			    				esc_url( $img_src[0] ),
			    				esc_attr( sprintf( __( '%1$s', 'soundcheck' ), $alt_text ) )
			    			);
			    		} else {
			    			echo basename( $post->guid );
			    		}
			    		?>
			    	</a>
			    </figure>
			</div>
			
			<?php if ( $post->post_content != '' ) : ?>
				<?php get_template_part( 'partials/post', 'content' ); ?>
			<?php endif; ?>
			
			<nav class="entry-attachment-nav">
			    <ul class="paging">
			        <li class="next"><?php next_image_link( 0, __( 'Next &rarr;', 'soundcheck' ) ); ?></li>
			        <li class="return"><a href="<?php echo esc_url( get_permalink( $post->post_parent ) ); ?>"><?php _e( 'Return to gallery', 'soundcheck' ); ?></a></li>
			        <li class="prev"><?php previous_image_link( 0, __( '&larr; Previous', 'soundcheck' ) ); ?></li>
			    </ul>
			</nav>
		    
		    <?php comments_template( '', true ); ?>
		</article><!-- #post-## -->
				
	<?php endwhile; ?>
</section><!-- #content -->

<?php if( soundcheck_has_right_sidebar() ) get_sidebar( 'secondary' ); ?>

<?php get_footer(); ?>