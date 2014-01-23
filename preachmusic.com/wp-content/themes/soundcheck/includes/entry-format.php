<?php  
global $is_page;

/* Get post format */
$format = get_post_format();

if ( ! $format )
	$format = ( $is_page == 'template-discography' ) ? 'audio' : 'standard';

/* Sidebar check */
if ( ti_has_sidebar() ) {
	$thumb_size = 'theme-medium';
	$media = array(
		'width'  => 440,
		'height' => 248
	);
	$gallery = array(
		'columns' => 4,
		'rows'    => 2,
		'height'  => 222,
		'size'    => 'theme-icon'
	);
} else {
	if ( isset( $is_page ) && ( $is_page == 'template-post-gallery' || $is_page == 'template-discography' )  ) {
		$thumb_size = 'post-thumbnail';
		$media = array(
			'width'  => 200,
			'height' => 113
		);
		$gallery = array(
			'columns' => 1,
			'rows'    => 1,
			'height'  => 210,
			'size'    => 'post-thumbnail'
		);
	} else {
		$thumb_size = 'theme-large';
		$media = array(
			'width'  => 680,
			'height' => 383
		);
		$gallery = array(
			'columns' => 6,
			'rows'    => 1,
			'height'  => 110,
			'size'    => 'theme-icon'
		);
	}
}

/* If page is a single page, show all photos by setting the gallery height to null */
if ( is_single() ) {
  $gallery = array(
  	'columns' => $gallery['columns'],
  	'rows' => 1,
  	'height' => null,
  	'size' => $gallery['size']
  );
}
?>

<?php 
/*
 * Image Post Format
 *
 */
if ( has_post_format( 'image' ) && has_post_thumbnail( $post->ID ) ) : ?>

	<?php
	$image_id  = get_post_thumbnail_id();  
	$image_url = wp_get_attachment_image_src( $image_id, 'large' );  
	$image_url = $image_url[0]; 
	?>
  
	<figure class="entry-thumbnail">
		
		<a class="fancybox thumbnail-icon <?php echo esc_attr( $format ) ?>" href="<?php echo esc_url( $image_url ) ?>" title="<?php ti_the_title_attribute(); ?>" rel="post-<?php the_ID() ?>"><!-- nothing to see here --></a>
		
		<?php the_post_thumbnail( $thumb_size ); ?>
	
	</figure><!-- .entry-thumbnail -->

						
<?php 
/*
 * Gallery Post Format
 *
 */
elseif ( has_post_format( 'gallery' ) ) : ?>
  
  <div class="entry-gallery-set">
  	
  	<?php
  	// action, $post_id, $columns, $rows, $gallery_height, $image_size, $preview_size, $echo
  	do_action( 'get_gallery', $post->ID, $gallery['columns'], $gallery['rows'], $gallery['height'], $gallery['size'], 'large' );	?>								
  
  </div><!-- .entry-gallery-set -->


<?php 
/*
 * Video Post Format
 *
 */
elseif ( has_post_format( 'video' ) || ( is_singular() && has_media_embed() ) ) : ?>

	<?php if ( has_post_thumbnail() && $is_page == 'template-post-gallery' ) : ?>
		
		<figure class="entry-thumbnail">
		
			<a class="fancybox thumbnail-icon <?php echo esc_attr( $format ) ?>" href="<?php echo '#video-' . absint( get_the_ID() ) ?>" title="<?php ti_the_title_attribute(); ?>"><!-- nothing to see here --></a>
			
			<?php the_post_thumbnail( $thumb_size ); ?>
		
		</figure><!-- .entry-thumbnail -->
  								
		<?php
		// Print instant view modal box
		if ( has_media_embed() ) {
			// action, $post_id, $echo
			do_action( 'get_modal_box', $post->ID, true );
		}
		?>
		
	<?php else : ?>
		
		<div class="entry-media">

			<?php
			// Allow autoplay for singular pages
			if( is_singular() && $is_page != 'template-post-page' ) {
				// action, $post_id, $width, $height, $allow_autoplay, $echo
				do_action( 'get_media', $post->ID, $media['width'], $media['height'], true );
			} else {
				// action, $post_id, $width, $height, $allow_autoplay, $echo
				do_action( 'get_media', $post->ID, $media['width'], $media['height'], false );
			}
			?>

		</div><!-- .entry-media -->
  
	<?php endif; ?>

  
<?php 
/*
 * Standard Post Format (Gallery Page Only)
 *
 */
elseif ( $is_page == 'template-post-gallery' && ( has_post_format( 'standard' ) || has_post_thumbnail() ) ) : ?>
		
	<figure class="entry-thumbnail">
	
		<a class="thumbnail-icon <?php echo esc_attr( $format ) ?>" href="<?php the_permalink() ?>" title="<?php ti_the_title_attribute(); ?>"><!-- nothing to see here --></a>
	
		<?php the_post_thumbnail( $thumb_size ); ?>
	
	</figure><!-- .entry-thumbnail -->
  							
	<?php
	// Print instant view modal box
	if ( has_media_embed() ) {
		// action, $post_id, $echo
		do_action( 'get_modal_box', $post->ID, true );
	}
	?>
  
<?php 
/*
 * Discogrophy Post Pages
 *
 */
elseif ( $is_page == 'template-discography' && ( has_post_format( 'standard' ) || has_post_thumbnail() ) ) : ?>
  
  	<figure class="entry-thumbnail">
  			
		<a href="<?php the_permalink() ?>" title="<?php ti_the_title_attribute(); ?>">
  			
			<?php the_post_thumbnail( $thumb_size ); ?>
  			
		</a>
  	
  	</figure>
  							
	<?php
	// Print instant view modal box
	if ( has_media_embed() ) {
		// action, $post_id, $echo
		do_action( 'get_modal_box', $post->ID, true );
	}
	?>

<?php endif; // end post formats check ?>
