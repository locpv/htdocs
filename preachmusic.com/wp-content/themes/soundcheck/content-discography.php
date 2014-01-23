<?php
/**
 * The loop for displaying album info from the discography post type.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */

/* Get globals for albums custom metabox values */
global $album_info_mb;

if ( have_posts() ) : ?>

	<section id="entry-container" role="contentinfo">

		<?php while ( have_posts() ) : the_post(); ?>
			
			<?php $album_info_mb->the_meta(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ) ?> style="position: relative;">
		  	
				<?php
				/**
				 * Entry Header
				 *
				 */
				locate_template( 'includes/entry-header.php', true, false ); ?>
		  	
				<?php 
				/**
				 * Entry Content
				 *
				 */
				if ( is_single() ) : ?>
				
				  	<?php
				  	/*
				  	 * Set some variable values depending upon if the 
				  	 * audio player plugin is installed.
				  	 * function_exists( 'insert_audio_player' )
				  	 */
				  	$audio_player_plugin = ( function_exists( 'insert_audio_player' ) ) ? true : false ;
				  	$audio_player = array(
				  		'show_audio_link' => ( $audio_player_plugin ) ? 'all-track-previews-trigger show-all-track-previews' : 'hidden',
				  		'playable' => ( $audio_player_plugin ) ? 'playable' : 'hidden'
				  	); 
				  	?>
				
					<?php if ( $album_info_mb->get_the_value( 'tracks' ) ) : ?>
					
				  		<a class="<?php echo esc_attr( $audio_player['show_audio_link'] ) ?>"> <?php _e( 'Show Audio', 'themeit' ) ?></a>
					
				  		<ol class="album-tracks entry-media">
				  			<?php
				  			/**
				  			 * Album Tracks
				  			 *
				  			 */
				  			while ( $album_info_mb->have_fields_and_multi( 'tracks' ) ) : ?>
				  				
				  				<li class="album-track">
				  					
				  					<?php  
				  					$track_name = $album_info_mb->get_the_value( 'track_name' );
				  					$track_file = $album_info_mb->get_the_value( 'track_file' ) 
				  					?>
				  				
				  					<div class="track-title">
				  						<?php esc_html_e( $track_name ); ?>
										<?php if ( $audio_player_plugin && $track_file ) : ?>
											<span class="playable">♪</span>
										<?php endif; ?>
				  					</div>
				  					
				  					<?php
				  					/**
				  					 * Audio Player Plugin Check
				  					 * Show/Hide function via js/script.js
				  					 *
				  					 */
				  					if ( $audio_player_plugin && $track_file ) { ?>
				  					
				  						<?php insert_audio_player( '[audio:' . esc_url( $track_file ) . '|titles=' . esc_html__( $track_name ) . ']' ); ?>
				  						
				  					<?php } // end insert_audio_player function check ?>
				  								  
				  				</li><!-- .album-track -->
				  				
				  			<?php endwhile; // end tracks loop ?>
				  		
				  		</ol><!-- .album-tracks -->
				  	
				  	<?php endif; // end tracks check ?>
				  
					<ul class="album-details clearfix">
					  
						<li class="purchase"><?php _e( 'Purchase:', 'theme-it' ); ?></li>
					
						<?php if ( $album_info_mb->get_the_value( 'purchase_links' ) ) : ?>
					    	
					    	<li class="purchase-links">
					    						    		
					    		<?php while ( $album_info_mb->have_fields_and_multi( 'purchase_links' ) ) : ?>
					    		
					    			<?php  
					    			$product_link = $album_info_mb->get_the_value( 'product_link' );
					    			$seller_name = $album_info_mb->get_the_value( 'seller_name' );
					    			?>
					    		  
									<a class="purchase-link" href="<?php echo esc_url( $product_link ); ?>" title="<?php esc_attr_e( 'Purchase from ' . $seller_name, 'theme-it' ); ?>" target="_blank">
					    		  
										<?php esc_html_e( $seller_name ); ?>
					    		  
									</a>
					    		
					    		<?php endwhile; // end purchase links loop ?>
					    	
					    	</li>
					    
					    <?php endif; // end check for purchase links ?>
					  
					</ul><!-- .album-details -->
					
					<div class="entry-content">
				  
						<?php the_content() ?>
		  		
					</div><!-- .entry-content -->

				<?php else : // not a single page ?>
				  
					<?php
					/**
					 * Entry Formats Media (post thumbnail)
					 *
					 */
					locate_template( 'includes/entry-format.php', true, false ); ?>
		  	
				<?php endif; // end single check ?>
					
			</article><!-- #post-##-->
		
		<?php endwhile; // end post while loop ?>
	
	</section><!-- #entry-container -->
	
<?php endif; // end loop ?>
