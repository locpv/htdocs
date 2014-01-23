<?php

// Get link to audio player album in theme options
$audio_player_album_id = ti_get_option( 'audio_player_album' );
$audio_player_album_link = ( $audio_player_album_id ) ? get_post_permalink( $audio_player_album_id ) : 0;

// If theme options does not have a default album selected or is not installed,
// the player will use the first album in the Discography. Get that albums link.
if( 0 === $audio_player_album_link ) {
	$albums_args = array (
	    'posts_per_page' => 1,
	    'post_type'      => 'discography'
	);
	
	$albums_query = new WP_Query( $albums_args );
	
	$albums_query->the_post();
	
	$audio_player_album_link = get_permalink();
	
	wp_reset_query();
}
?>

<aside class="widget ti-media-player clearfix">

	<div id="jquery_jplayer_N" class="jp-jplayer"></div>
	
	<div id="jp_container_N" class="jp-audio">
		
		<?php  
		/**
		 * Interface / GUI
		 *
		 */		
		?>
		<div class="controls jp-interface jp-gui">
			<?php  
			/**
			 * Album Art
			 *
			 */		
			?>
			<figure class="jp-current-poster">
				<img src="<?php echo get_template_directory_uri() . '/images/default-album-artwork.png'; ?>" class="preloading" alt="Album cover" />
			</figure>
		
			<?php  
			/**
			 * Controls
			 *
			 */		
			?>
			<nav class="jp-controls-wrap">
		    	<div class="jp-controls">
  		    		<a href="javascript:;" class="jp-previous" tabindex="1"><span><?php _e( 'Previous', 'theme-it' ); ?></span></a>
  		    		<a href="javascript:;" class="jp-play" tabindex="1"><span><?php _e( 'Play', 'theme-it' ); ?></span></a>
  		    		<a href="javascript:;" class="jp-pause" tabindex="1"><span><?php _e( 'Pause', 'theme-it' ); ?></span></a>
  		    		<a href="javascript:;" class="jp-next" tabindex="1"><span><?php _e( 'Next', 'theme-it' ); ?></span></a>
		    	</div><!-- .jp-controls -->
			</nav>
  		</div><!-- .jp-interface -->
	
	
	
	
		<?php  
		/**
		 * Player Content
		 *
		 */		
		?>
		<div class="jp-player-content preloading">
			
			<?php  
			/**
			 * Current Track Info
			 *
			 */		
			?>
		    <div class="jp-current-item">
  		    	<span class="jp-current-track"><!-- populated by updateCurrentTrackInfo() via js/jquery.jplayer.application.js --></span>
				<a href="<?php echo $audio_player_album_link ?>" title="View album details"><span class="jp-current-artist"><!-- populated by updateCurrentTrackInfo() via js/jquery.jplayer.application.js --></span></a>
				<a href="<?php echo $audio_player_album_link ?>" title="View album details"><span class="jp-current-album"><!-- populated by updateCurrentTrackInfo() via js/jquery.jplayer.application.js --></span></a>
		    </div><!-- .jp-current-item -->
  		  
  		  
			<?php  
			/**
			 * Notifications
			 *
			 */		
			?>
		    <div class="jp-notification jp-loading">
		    	<span class="jp-notification-title"><?php _e( 'Loading audio...', 'theme-it' ); ?></span>
  		  		<span class="jp-notification-description"><?php _e( 'Please wait while albums and tracks are being loaded.', 'theme-it' ) ?></a>.</span>
		    </div><!-- .jp-no-solution -->
  		  
		    <div class="jp-notification jp-no-solution">
  		  		<span class="jp-notification-title"><?php _e( 'Update Required To Play Media', 'theme-it' ); ?></span>
  		  		<span class="jp-notification-description"><?php _e( 'Update your browser to a recent version or update your ', 'theme-it') ?> <a href="http://get.adobe.com/flashplayer/" target="_blank"><?php _e( 'Flash plugin', 'theme-it' ) ?></a>.</span>
		    </div><!-- .jp-no-solution -->
		    
		    
			<?php  
			/**
			 * Progress Bar
			 *
			 */		
			?>
			<div class="jp-progress-wrap">
			    <div class="jp-progress">
			    	<div class="jp-seek-bar">
			    		<div class="jp-play-bar"></div>
			    	</div>
			    </div>
			</div><!-- .jp-progress-wrap -->
			
			
			<?php  
			/**
			 * Time
			 *
			 */		
			?>
			<div class="jp-current-time"></div>
  		
  		</div><!-- .jp-player-content -->
  		
  		
  		
  		
		<?php  
		/**
		 * Playlist
		 *
		 */		
		?>
		
		<?php if ( ti_get_option( 'audio_player_playlist' ) == 1 ) : ?>
		    <h4 class="jp-playlist-trigger">
		        <a href="#" class="tooltip" title="Show Playlist"><?php _e( 'Toggle Playlist', 'theme-it' ); ?></a>
		    </h4>
		<?php endif; ?>
		
		<div class="jp-type-playlist">
		    <div class="jp-playlist">
		    	<ul class="tracks">
		    		<li></li>
		    	</ul>
		    </div><!-- .jp-playlist -->
		</div><!-- .jp-type-playlist -->
		
	</div><!-- #jp_container_N -->

</aside><!-- .ti-media-player -->
