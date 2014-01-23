<?php
/**
 * @package Soundcheck
 * @since 1.0
 */

/* Set Format */
$supported_formats = get_theme_support( 'post-formats' );
$format = get_post_format();

if ( ! $format )
	$format = is_page_template( 'template-discography.php' ) ? 'audio' : 'standard';
else
	$format = in_array( $format, $supported_formats[0] ) ? $format : 'standard';
	

/* Set Class Names */
$class = '';

switch ( $format ) {
	case 'audio' :
		if ( soundcheck_page_template( 'gallery' ) )
			$class = 'widget soundcheck_audio_player_widget';
		else
			$class = 'entry-media';
		break;
	
	case 'standard' :
		if ( has_post_thumbnail() )
			$class = 'entry-media';
		break;
	
	case 'gallery' :
		if ( has_post_thumbnail() )
			$class = 'entry-media';
		break;
		
	case 'image' :
		if ( has_post_thumbnail() )
			$class = 'entry-media';
		break;
		
	case 'video' :
		$class = 'video entry-media';
		break;
	
}

?>

<div class="<?php echo esc_attr( $class ) ?>">
	<?php soundcheck_post_format( $format ); ?>
</div>