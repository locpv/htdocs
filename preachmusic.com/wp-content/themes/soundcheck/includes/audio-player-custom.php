<?php
/**
 * This file gets and sets up the audio tracks for the audio player.
 * The results are then returned to a function to localize the results
 * for use in javascript.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.5
 */

function ti_audio_player_setup_custom() {
	
	// Create args for custom loop
	$albums_args = array (
		'p'              => ti_get_option( 'audio_player_album', null ),
		'posts_per_page' => 1,
		'post_type'      => 'discography'
	);
	
	$albums_query = new WP_Query( $albums_args );
	
	
	if( ! $albums_query->have_posts() )
	    return ti_audio_player_setup_notice();
		
	// Get post info
	$albums_query->the_post();
	    
	// Get album metabox global meta data
	global $album_info_mb;
	$album_info_mb->the_meta(); 
	
	// Get post thumbnail
	if ( has_post_thumbnail() ) {
	    $artwork_image_source = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
	    $artwork_image_source = $artwork_image_source[0];
	} else {
		$artwork_image_source = '';
	}
	
	// Setup variables for easy use and count calculation
	$artist_name = $album_info_mb->get_the_value( 'artist_name' );
	$album_name = $album_info_mb->get_the_value( 'album_name' );
	
	// Track Count for playlist numbering
	$track_count = 0;
	
	// Create clean default disc array
	$default_disc_args = array();
	
	// Loop through tracks and create entry to be used in JS. Tracks must have title and file source
	while ( $album_info_mb->have_fields_and_multi( 'tracks' ) ) {
	    
	    // Track must have title and file
	    if ( $album_info_mb->get_the_value( 'track_name' ) && $album_info_mb->get_the_value( 'track_file' ) ) { 
	    
	    	// Increment track count
	    	$track_count++;
	    	
	    	// Add tracks to default disc array
	    	$default_disc_args[] = ti_get_track_info( 
	    		$track_count, 
	    		$album_info_mb->get_the_value( 'track_name' ),
	    		$artist_name, 
	    		$album_name, 
	    		$artwork_image_source, 
	    		$album_info_mb->get_the_value( 'track_file' )
	    	);
	    }
	}
	
	// Create args to return for json_encode
	$audio_player_args = array( $default_disc_args );
		
	// Reset Query
	wp_reset_query();

	return $audio_player_args;
}



?>