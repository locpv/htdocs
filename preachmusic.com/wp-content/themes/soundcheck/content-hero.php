<?php global $post ?>

<div id="hero">

    <div class="slides">
    
    	<?php
    	/**
    	 * Hero Slider
    	 *
    	 */
    	$hero_randomize = ( ti_get_option( 'hero_randomize' ) == 1 ) ? 'rand' : 'date';
    	
    	$hero_args = array( 
    	  'post_type' => 'hero',
    	  'orderby' => $hero_randomize
    	);
    	
    	$hero_query = new WP_Query( $hero_args ); ?>
    	
    	<?php if ( $hero_query->have_posts() ) : while ( $hero_query->have_posts() ) : $hero_query->the_post()  ?>
    	
    		<?php $attachment_image_src = ( has_post_thumbnail() ) ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'theme-full' ) : false ?>
    		
    		<?php $post_ID = 'post-' . get_the_ID() ?>
    		
    		<div <?php post_class( "slide $post_ID" ) ?> style="background: <?php echo get_post_meta( get_the_ID(), 'background_color', true ) ?> url(<?php echo esc_url( $attachment_image_src[0] ) ?>) 50% 0 no-repeat;">
    			
    			<div class="slide-content-container">
    			
    				<?php if ( $post->post_content != '' || get_post_format() ) : ?>
    				
    					<article class="slide-content">
    						
    						<?php 
    						/*
    						 * Hero Image Post Format
    						 *
    						 */
    						if ( has_post_format( 'image' ) ) :
    							echo '<div class="entry-content">';
    							the_content();
    							echo '</div>'; ?>
    														
    						<?php 
    						/*
    						 * Hero Gallery Post Format
    						 *
    						 */
    						elseif ( has_post_format( 'gallery' ) ) :
    							/* $post_id, $columns, $rows, $row_height, $image_size, $preview_size, $echo */
    							apply_filters( 'get_gallery', $post->ID, 5, 3, 290, 'theme-icon', 'large', true ); ?>								
    						
    						<?php 
    						/*
    						 * Hero Video Post Format
    						 *
    						 */
    						elseif ( has_post_format( 'video' ) ) : ?>
    							<div class="embed">
									<?php 
									// action, id, width, height, allow_autoplay, echo 
									do_action( 'get_media', $post->ID, 480, 270, false ); ?>
    							</div>
    						
    						<?php 
    						/*
    						 * Hero Standard Post Format
    						 *
    						 */
    						else :
    							echo '<div class="entry-content">';
    							the_content();
    							echo '</div>'; ?>
    							
    						<?php endif; // end post format type check ?>								
    						
    					</article><!-- .slide-content -->
    				
    				<?php endif; // end content and post format check ?>
    				
    				<?php edit_post_link( 'Edit Slide', '<div class="edit-link">', '</div>' ); ?>
    			
    			</div><!-- .slide-content-container -->
    			
    		</div><!-- .slide -->
    		
    	<?php endwhile; // end hero slides loop ?>
    	
    	<?php else : // no hero slide available, show default notice ?>
    	
    		<div class="slide default-notice" <?php post_class( 'slide' ) ?> style="background: url(<?php echo get_template_directory_uri() ?>/images/default-hero-image.jpg ) 50% 0 no-repeat;">
    			<article class="slide-content">
    				<div class="entry-content">
    					<h3><?php _e( 'Hero Slide Setup', 'theme-it' ); ?></h3>
    					<p><?php _e( 'It looks like there have not been any Here slides setup.', 'theme-it' ) ?> <br /> 
    					<?php _e( 'Add a new', 'theme-it' ) ?> <a href="<?php echo esc_url( get_admin_url() ) ?>/edit.php?post_type=hero"><?php _e( 'Hero slide', 'theme-it' ); ?></a> <?php _e( 'and get things moving.', 'theme-it' ); ?></p>
    				</div>
    			</article>
    		</div><!-- .default-notice -->

    	<?php endif; // end hero slides check ?>
    	
    	<?php wp_reset_postdata(); ?>
    	
    </div><!-- .slides -->
    
    <div class="controls">
    	<a href="#" class="prev ir" title="Previous"><?php _e( 'Previous', 'theme-it' ); ?></a>
    	<a href="#" class="next ir" title="Next"><?php _e( 'Next', 'theme-it' ); ?></a>
    </div><!-- .controls -->

</div><!-- #hero -->
