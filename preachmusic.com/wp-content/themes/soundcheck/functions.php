<?php
/**
 * Functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, ti_setup_debut(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Soundcheck
 * @since 1.0
 */
 
define( 'VERSION', '1.7.2' );

function ti_version_id() {
  if ( WP_DEBUG )
    return time();
  return VERSION;
}


/**
 * General Path/URI Functions
 *
 * @since     1.0
 */
define( 'ti_FILEPATH',  TEMPLATEPATH );
define( 'ti_DIRECTORY', get_template_directory() );
define( 'ti_URL',       get_template_directory_uri() );
define( 'ti_ADMINPATH', ti_FILEPATH .  '/admin' );
define( 'ti_ADMINDIR',  ti_DIRECTORY . '/admin' );
define( 'ti_ADMINURL',  ti_URL .       '/admin' );

/**
 * Theme Setup
 *
 * If you would like to customize the theme setup you
 * are encouraged to adopt the following process.
 *
 * <ol>
 * <li>Create a child theme with a functions.php file.</li>
 * <li>Create a new function named mythemeti_setup_soundcheck().</li>
 * <li>Hook this function into the 'after_setup_theme' action at or after 11.</li>
 * <li>call remove_filter(), remove_action() and/or remove_theme_support() as needed.</li>
 * </ol>
 *
 * @return    void
 *
 * @since     1.0
 */
function ti_setup_soundcheck() {

	global $content_width;
	if ( ! isset( $content_width ) )
		$content_width = 680;

	load_theme_textdomain( 'theme-it', get_template_directory() . '/languages' );

	add_theme_support( 'menus' );
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'video' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_editor_style( 'style-editor.css' );

	/* Image sizes. */
	set_post_thumbnail_size(        220,  220, true );
	add_image_size( 'theme-medium', 440,  248, true );
	add_image_size( 'theme-large',  680,  383, true );
	add_image_size( 'theme-full',   1600, 440, true );
	
	add_image_size( 'theme-icon',     100, 100, true );
	add_image_size( 'theme-carousel', 120, 66,  true );

	/* Navigation menus. */
	register_nav_menus( array( 'primary' => 'Primary' ) );

	/* WordPress Core. */
	add_filter( 'attachment_fields_to_edit', 'ti_additional_image_size_input_fields', 11, 2 );
	add_filter( 'body_class',                'ti_multiple_post_class' );
	add_filter( 'body_class',                'ti_sidebar_class' );
	add_filter( 'embed_defaults',            'ti_embed_defaults' );
	add_filter( 'embed_googlevideo',         'ti_oembed_dataparse', 10, 4 );
	add_filter( 'embed_oembed_html',         'ti_oembed_dataparse', 10, 4 );
	add_filter( 'embed_oembed_html',         'ti_oembed_wmode_transparent', 10, 4 );
	add_filter( 'excerpt_length',            'ti_excerpt_length' );
	add_filter( 'excerpt_more',              'ti_excerpt_more_auto' );
	add_action( 'get_page_links',            'ti_page_links', 10, 1 );
	add_filter( 'get_the_excerpt',           'ti_excerpt_more_custom' );
	add_filter( 'post_class',                'ti_has_featured_image_class' );
	add_filter( 'post_class',                'ti_has_post_format_class' );
	add_filter( 'the_content',               'ti_filter_content_for_image_format', 0 );
	add_action( 'widgets_init',              'ti_register_sidebars' );
	add_filter( 'wp_get_attachment_link',    'ti_gallery_fancybox');
	add_filter( 'wp_head',                   'ti_custom_theme_styles', 9 );
	add_filter( 'wp_title',                  'ti_wp_title' );
	add_action( 'wp_enqueue_scripts',        'ti_theme_scripts' );
	add_action( 'wp_enqueue_scripts',        'ti_theme_styles' );
	add_action( 'wp_enqueue_scripts',        'ti_localize_jplayer' );
	add_action( 'wp_enqueue_scripts',        'ti_localize_slideshow' );

	/* Custom hooks. */
	add_action( 'get_media',       'ti_get_media', 10, 5 );
	add_action( 'get_gallery',     'ti_get_gallery', 10, 7 );
	add_action( 'get_modal_box',   'ti_get_modal_box', 10, 2 );
	add_action( 'limit_string',    'ti_limit_string', 10, 4  );
	add_action( 'the_short_title', 'ti_the_short_title', 10, 4  );
	
}
add_action( 'after_setup_theme', 'ti_setup_soundcheck' );


/**
 * Include additional admin files
 *
 * @since     1.0
 */
require_once( ti_DIRECTORY . '/admin.php' );
include_once( ti_ADMINPATH . '/theme-metabox.php' ); // needs to be called here and not inside an init/setup action for some reason
include_once( ti_ADMINPATH . '/theme-styles.php' );



/**
 * Get Theme Options
 *
 * This function is based around the Options Framework Plugin.
 * Return the theme option value. If the option value
 * does not exist or is empty, return assigned default
 * value, if a default value is not set, return false.
 *
 * @param     string         The name of the option
 * @param     string         The default value if not availble
 *
 * @since     1.0
 */
if ( ! function_exists( 'ti_get_option' ) ) :
	function ti_get_option( $name, $default = false ) {
	
		$optionsframework_settings = get_option( 'optionsframework' );
	
		$option_name = $optionsframework_settings['id'];
	
		if ( get_option( $option_name ) )
			$options = get_option( $option_name );
	
		if ( isset( $options[$name] ) && !empty( $options[$name] ) )
			return $options[$name];
		else
			return $default;
	}	
endif; // End ti_get_option check


/**
 * Fileter WP Title 
 *
 * Filter the title depending upon the page.
 *
 * @since     1.0
 */
function ti_wp_title() {
	$title = '';

	if ( is_home() )
		$title = get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' ); 
	
	elseif ( is_search() )
		$title = get_bloginfo( 'name' ) . ' | ' . __( 'Search Results', 'theme-it' );
	
	elseif ( is_author() )
		$title = get_bloginfo( 'name' ) . ' | ' . __( 'Author Archives', 'theme-it' ); 
	
	elseif ( is_single() )
		$title = the_title( '', '', false ) . ' | ' . get_bloginfo( 'name' );
	
	elseif ( is_page() )
		$title = get_bloginfo( 'name' ) . ' | ' . the_title( '', '', false );
	
	elseif ( is_category() )
		$title = get_bloginfo( 'name' ) . ' | ' . __( 'Archive', 'theme-it' ) . ' | ' . single_cat_title( '', false );
	
	elseif ( is_month() )
		$title = get_bloginfo( 'name' ) . ' | ' . __( 'Archive', 'theme-it' ) . ' | ' . the_time( 'F' );
	
	elseif ( is_tag() )
		$title = get_bloginfo( 'name' ) . ' | ' . __( 'Tag Archive', 'theme-it' ) . ' | ' . single_tag_title( '', false );
	
	print $title;
}




/**
 * Determine page header
 *
 * Menus Behind Embedded Video Fix. Adds wmode=transparent to embed objects
 *
 * @since 1.0
 */
function ti_get_page_title( $content = '' ) {
	$title = array();
	
	if ( is_category() ) :
		$title = array(
			'title' => single_cat_title( '', false ),
			'misc'  => __( 'Browsing Category', 'tuneage' )
		);
	elseif( is_tag() ) :
		$title = array(
			'title' => single_tag_title( '', false ),
			'misc'  => __( 'Browsing Tags', 'tuneage' )
		);
	elseif( is_day() ) :
		$title = array(
			'title' => get_the_time( 'F jS, Y' ),
			'misc'  => __( 'Browsing', 'tuneage' )
		);
	elseif( is_month() ) :
		$title = array(
			'title' => get_the_time( 'F, Y' ),
			'misc'  => __( 'Browsing', 'tuneage' )
		);
	elseif( is_year() ) :
		$title = array(
			'title' => get_the_time( 'Y' ),
			'misc'  => __( 'Browsing', 'tuneage' )
		);
	elseif( is_search() ) :
		$title = array(
			'title' => get_search_query(),
			'misc'  => __( 'Search for', 'tuneage' )
		);
	elseif( is_author() ) :
		$title = array(
			'title' => __( 'Author Archives', 'tuneage' ),
			'misc'  => __( 'Browsing', 'tuneage' )
		);
	elseif( isset( $_GET['paged'] ) && !empty( $_GET['paged'] ) ) :
		$title = array(
			'title' => __( 'Blog Archives', 'tuneage' ),
			'misc'  => __( 'Browsing', 'tuneage' )
		);
	elseif( is_404() ) :
		$title = array(
			'title' => __( 'Sorry, nothing here!s', 'tuneage' ),
			'misc'  => __( 'Whoopsy Daisy!', 'tuneage' )
		);
	elseif( is_home() ) :
		$title = array(
			'title' => __( 'Blog', 'tuneage' ),
			'misc'  => __( 'multiple posts', 'tuneage' )
		);
	else :
		$title = array(
			'title' => false,
			'misc'  => false
		);
	endif;
	
	
	if( array_key_exists( $content, $title ) )
		$title = $title[$content];
	
	return $title;
}




/**
 * WP Page Links Modifcation
 *
 * Modification of wp_link_pages() with an extra element to highlight the current page.
 * {@link http://wordpress.stackexchange.com/questions/14406/how-to-style-current-page-number-wp-link-pages }
 *
 * @since     1.0
 */
function ti_page_links( $args = array () ) {
	$defaults = array(
	  'before'      => '<div class="pagenavi page-links"><span class="pages">' . __( 'Pages:', 'theme-it' ) . '</span>',
	  'after'       => '</div>',
	  'link_before' => '',
	  'link_after'  => '',
	  'pagelink'    => '%',
	  'echo'        => 1,	// element for the current page
	  'highlight'   => 'span'
	);
	
	$page_links = wp_parse_args( $args, $defaults );
	
	$page_links = apply_filters( 'wp_link_pages_args', $page_links );
	
	extract( $page_links, EXTR_SKIP );
	
	global $page, $numpages, $multipage, $more, $pagenow;
	
	if ( ! $multipage )
	  return;
	
	$output = $before;
	
	for ( $i = 1; $i < ( $numpages + 1 ); $i++ ) {
	  $j       = str_replace( '%', $i, $pagelink );
	  $output .= ' ';
	  
	  if ( $i != $page || ( ! $more && 1 == $page ) )	
			$output .= _wp_link_page( $i ) . "{$link_before}{$j}{$link_after}</a>";
	  else 
	  	$output .= "<$highlight class='current'>{$link_before}{$j}{$link_after}</$highlight>";
	}

	print $output . $after;
}


/**
 * Continue Reading Link.
 *
 * Get a link to the global post's single view
 * with the phraze "Continue Reading".
 *
 * @return    string         Permalink with the text "Continue Reading".
 *
 * @since     1.0
 */
function ti_continue_reading_link() {
	$text = __( 'Continue reading', 'theme-it' );
	
	if ( 'gallery' == get_post_format() ) 
		$text = __( 'View this gallery', 'theme-it' );
	
	if ( 'image' == get_post_format() ) 
		$text = __( 'View this image', 'theme-it' );
	
	if ( 'video' == get_post_format() ) 
		$text = __( 'View this video', 'theme-it' );

	return ' <a class="more-link" href="'. esc_url( get_permalink() ) . '">' . esc_html( $text ) . '</a>';
}


/**
 * Remove default gallery style
 *
 * Removes inline styles printed when the 
 * gallery shortcode is used.
 *
 * @since     1.0
 */
add_filter( 'use_default_gallery_style', '__return_false' );


/**
 * Title Attribute.
 *
 * @since     1.0
 */
if ( ! function_exists( 'ti_the_title_attribute' ) ) :
	function ti_the_title_attribute() {
		printf( esc_attr__( 'Permalink to %s', 'theme-it' ), the_title_attribute( 'echo=0' ) );
	}
endif;


/**
 * Comment Setup
 *
 * @since     1.0
 */
if ( ! function_exists( 'ti_comment' ) ) :
	function ti_comment($comment, $args, $depth) 
	{
		$GLOBALS['comment'] = $comment; ?>
		
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			
			<div id="comment-<?php comment_ID(); ?>">
				
				<div class="comment-border"><!-- nothing to see here --></div>
				
				<div class="comment-author vcard">
	         
	         <?php echo get_avatar( $comment, $size='35', $default='<path_to_url>' ); ?>
	
	         <?php printf( '<cite class="fn">' . __( '%s', 'theme-it' ) . '</cite>', get_comment_author_link() ) ?>
	      
				</div><!-- .comment-author -->
	      
				<?php if ($comment->comment_approved == '0') : ?>
	         
					<em><?php _e( 'Your comment is awaiting moderation.', 'theme-it' ) ?></em><br />
	         
				<?php endif; ?>
	
				<div class="comment-meta commentmetadata">
	      
					<span class="comment-date"><?php printf( __( '%1$s', 'theme-it' ), get_comment_date() ) ?></span>
	      		
					<span class="comment-reply-link-wrap">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => 'Reply' ) ) ) ?>
					</span>
					
			  	<?php echo edit_comment_link( 'edit', '<span>(', ')</span>' ); ?>
	      
				</div><!-- .comment-meta -->
				
				<div class="comment-body">
				
					<?php comment_text(); ?>
				
				</div><!-- .comment-body -->
	
			</div><!-- #comment-## -->
			
	<?php
	}
endif;


/**
 * Has Media Embed
 *
 * This function was created to check if the Media Embed
 * metabox has a value or not.
 *
 * @return    bool
 *
 * @since     1.0
 */
function has_media_embed( $post_id = null ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	
	/* Get global values */
	global $media_embed_mb;
	
	/* Get media embed metabox options */
	$media_embed_mb->the_meta( $post_id ); 
	$media_source     = $media_embed_mb->get_the_value( 'media_source' );
	$media_embed_code = $media_embed_mb->get_the_value( 'media_embed_code' );
	
	$media_embed = ( $media_source || $media_embed_code ) ? true : false;
	
	return $media_embed;
}


/**
 * Generate random number
 *
 * Creates a 4 digit random number for used
 * mostly for unique ID creation. 
 *
 * @since     1.0
 */
function ti_get_random_number() {
	return substr( md5( uniqid( rand(), true) ), 0, 4 );
}



/**
 * YouTube Player
 *
 * Creates the necessary iframe structure for YouTube
 * Gets custom theme options and adds to iframe src.
 *
 * @return    string
 * @since     1.0	
 */
function ti_create_youtube_player( $media_source = '', $width = 640, $height = 360, $allow_autoplay = 1 ) {
	if( preg_match('%(?:youtube\.com/(?:user/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $media_source, $matches ) ) {
		/* Give player a unique ID */
		$player_id = 'ytplayer_' . $matches[1] . '_' . ti_get_random_number();
		
		$defaults = array(
		  'wmode' => 'transparent',
		  'enablejsapi' => 1,
		  'playerapiid' => 'ytplayer',
		  'origin' => esc_url( home_url() ),
		  'color' => null,
		  'theme' => null,
		  'fs' => null,
		  'loop' => null,
		  'rel' => null,
		  'showinfo' => null,
		  'autoplay' => null
		);
		
		$params = wp_parse_args( parse_url( $media_source, PHP_URL_QUERY), $defaults );
		
		// Stop autoplay from possibly autoplaying on pages with multiple posts and videos
		if( 0 == $allow_autoplay || ! is_singular() )
			$params['autoplay'] = 0;
		
		$url = 'http://www.youtube.com/embed/' . $matches[1] . '/?' . http_build_query( array_filter( $params ), '', '&' );
		
		$output = '<iframe width="' . $width . '" height="' . $height . '" src="' . $url . '" id="' . $player_id . '" class="youtube-player" frameborder="0" wmode="Opaque" allowfullscreen></iframe>';
	} else {
		$output = __( 'Sorry that seems to be an invalid <strong>YouTube</strong> URL. Please check it again.', 'tuneage' );
	}
	
	return $output;
}


/**
 * Vimeo Player
 *
 * Creates the necessary iframe structure for Vimeo
 * Gets custom theme options and adds to iframe src.
 *
 * @since     1.0
 */
function ti_create_vimeo_player( $media_source = '', $width = 640, $height = 360, $allow_autoplay = 1 ) {
	if( preg_match( '~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $media_source, $matches ) ) {
		/* Give player a unique ID */
		$player_id = 'player_' . $matches[1] . '_' . ti_get_random_number();
		$color = ti_get_option( 'primary_2' );
		$video_color = ( 1 == ti_get_option( 'enable_styles' ) && $color ) ? ltrim( $color, '#' ) : '252A31';
		
		$defaults = array(
		  'wmode' => 'transparent',
		  'api' => 1,
		  'player_id' => $player_id,
		  'title' => 0,
		  'byline' => 0,
		  'portrait' => 0,
		  'autoplay' => null,
		  'loop' => null,
		  'rel' => null,
		  'color' => $video_color
		);
		
		$params = wp_parse_args( parse_url( $media_source, PHP_URL_QUERY ), $defaults );
		
		if( 0 == $allow_autoplay || ! is_singular() )
			$params['autoplay'] = 0;
		
		$url = 'http://player.vimeo.com/video/' . $matches[1] . '/?' . http_build_query( array_filter( $params ), '', '&' );

		$output = '<iframe width="' . $width . '" height="' . $height . '" src="' . $url . '" id="' . $player_id . '" class="vimeo-player" frameborder="0" data-playcount="0" webkitAllowFullScreen allowFullScreen></iframe>';
		
	} else {
		$output = __( 'Sorry that seems to be an invalid <strong>Vimeo</strong> URL. Please check it again. Make sure there is a string of numbers at the end (e.g. http://vimeo.com/2104600).', 'tuneage' );
	}
	return $output;
}


/**
 * Create WP Embed
 *
 * Creates the necessary iframe structure for available
 * sites using the default WP embed shortcode. If a video
 * address is one of the accepted sites that can use the
 * URL and oembed, aside from Vimeo and Youtube, this function
 * will be called. Vimeo and YouTube url's use a custom
 * function of ti_create_vimeo_player() or ti_create_youtube_player()
 *
 * @since     3.0
 */
function ti_create_wp_embed_player( $media_source = '', $width = 640, $height = 360, $allow_autoplay = 1 ) {
	$wp_embed = new WP_Embed();
	$output = $wp_embed->run_shortcode( '[embed width=' . $width . ' height=' . $height . ']' . $media_source . '[/embed]' );
	return $output;
}


/**
 * Get Media (Video)
 *
 * Gets media source and decides how it should be displayed.
 * The function first check to see if its a url, if not we
 * assume they have provided an embed code.
 *
 * If it is a url, we'll check to see if it matches  
 * set in functions/theme-metabox.php
 *
 * @since     1.0
 */
function ti_get_media( $post_id = null, $width = 640, $height = 360, $allow_autoplay = 1, $echo = true  ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$media = get_post_meta( $post_id, 'featured-video', true );
	
	// START Soundcheck specific
	if ( ! has_media_embed( $post_id ) )
		return;
	
	global $media_embed_mb;
	if ( $media_embed_mb->the_meta( $post_id ) ) {
		$media_source = $media_embed_mb->get_the_value( 'media_source' );
		$media_embed_code = $media_embed_mb->get_the_value( 'media_embed_code' );
		$media = ( trim( $media_embed_code ) == '' ) ? $media_source : $media_embed_code;
	}
	// END Soundcheck specific
	 
	
	// If media is not provided, return
	if( ! $media )
		return;
	
	// If media string does not start with "http", return it's value, assuming it's an embed code
	if( 0 !== strpos( $media, "http" ) ) {
		$output = stripslashes( htmlspecialchars_decode( $media ) );
		if ( $echo ) {
		  echo $output;
		  return;
		} else {
		  return $output;
		}
	}
	
	// Media appears to be a valid url starting with http, so we'll get some info abou the url
	$media = array(
	    'url'    => $media,
	    'host'   => parse_url( $media, PHP_URL_HOST )
	);
	
	// List of media players methods. Some players we build instead of usine WP embed code.
	$players = array(
	    'youtube'  => ( 'youtube.com' == $media['host'] || 'youtu.be' == $media['host'] ) ? 1 : 0,
	    'vimeo'    => ( 'vimeo.com' == $media['host'] ) ? 1 : 0
	);
	
	// Set output to use WP embed shortcode function by default
	$output = ti_create_wp_embed_player( $media['url'], $width, $height, $allow_autoplay );
	
	// Check URL to see if it matches a cusotm player the them builds manually
	foreach( $players as $player => $source ) {
	    if( 1 === $source ) {
	    	// Create a function based off of matched player key
	    	$function = 'ti_create_' . $player . '_player';
	    	$output = $function( $media['url'], $width, $height, $allow_autoplay );
	    	break;
	    }
	}
	
	if ( $echo )
	  echo $output;
	else
	  return $output;
}


/**
 * Get Gallery
 *
 * Gets the option value from the custom video metabox set in functions/theme-metabox.php
 *
 * @since     1.0
 */
function ti_get_gallery( $post_id, $columns, $rows, $gallery_height, $image_size, $preview_size, $echo = true ) {
	global $post;
		
	/* Arguments for get_children(). */
	$children = array(
		'post_parent'    => absint( $post_id ),
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order'
	);	

	/* Get image attachments. If none, return. */
	$attachments = get_children( $children );
	
	if ( empty( $attachments ) )
		return '';

	/* If is feed, leave the default WP settings. We're only worried about on-site presentation. */
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link( $id, $image_size, true ) . "\n";
		return $output;
	}
	
	/* Hide rows that extend past the set height */
	//if ( isset( $gallery_height ) )
		//$gallery_overflow = $rows * $row_height;
	
	/* Setup entry gallery output */
	$gallery = '<ul class="entry-gallery" style="height: ' . $gallery_height . 'px; overflow: hidden;">';
	
	/* Create variable to count columns with */
	$column_count = 0;
	
	// Create random number to give gallery a more unique id for fancybox grouping
	$random_num = ti_get_random_number();
	
	foreach ( $attachments as $attachment ) {
		
		/* Add one to column count */
		$column_count++;
		
		/* Get the image attributes of a particular image size to set up image thumbnail */
		$image_attributes = wp_get_attachment_image_src( $attachment->ID, $image_size ); // returns an array
		
		/* Get the image attributes of a particular image size to setup preview image link */
		$preview_image_attributes = wp_get_attachment_image_src( $attachment->ID, $preview_size ); // returns an array
		
		/* Add to counter, apply class of "last" if counter has reached the desired $column count */
		$column_class = ( $column_count % $columns == 0 ) ? ' last' : '';
		
		/* Setup gallery item output */
		$gallery .= '<li style="position: relative" class="gallery-item' . esc_attr( $column_class ) . '">';
		$gallery .= '<a href="' . esc_url( $preview_image_attributes[0] ) . '" class="fancybox tooltip thumbnail-icon gallery" title="' . __( 'View Gallery Images (', 'theme-it' ) . count( $attachments ) . __( ')', 'theme-it' ) . '"  rel="gallery-' . $post_id . '-' . $random_num . '">';
		$gallery .= '<!-- nothing to see here -->';
		$gallery .= '</a>';
		$gallery .= '<img src="' . esc_url( $image_attributes[0] ) . '" width="' . absint( $image_attributes[1] ) . '" height="' . absint( $image_attributes[2] ) . '" />';
		$gallery .= '</li><!-- .gallery-item -->';
	}
	
	/* Add a clearfix entry item and close other entry gallery setup */
	$gallery .= '<li class="clearfix"></li></ul><!-- .gallery -->';
	
	if ( $echo )
	  echo $gallery;
	else
	  return $gallery;
}



/**
 * Get Modal Box
 *
 * This function is called to create the necessary
 * HTML elements needed for FancyBox. When Instant
 * View is enabled via Theme Options, the video will
 * then be played using FancyBox.
 *
 * @since 1.0
 */
function ti_get_modal_box( $post_id, $echo = true ) {
	/* Set post id */
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	
	/* Check if it has media set */
	if ( ! has_media_embed( $post_id ) )
		return;
	
	/* Get theme options */
	$instant_size  = ti_get_option( 'instant_size', '640x360' );
	list( $width, $height ) = split( '[x]', $instant_size );
	
	$instant  = '<div class="instant"><div id="video-' . absint( $post_id ) . '" class="instant-view" >';
	$instant .= apply_filters( 'get_media', absint( $post_id ), absint( $width ), absint( $height ), 0, false );
	$instant .= '</div></div>';
	  	
	if ( $echo )
	  echo $instant;
	else
	  return $instant;
}




/**
 * Short Title
 *
 * @since     1.0
 */
function ti_the_short_title( $before = '', $after = '', $echo = true, $length = false ) {
	$title = get_the_title();
	
	if ( $length && is_numeric( $length ) )
		$title = substr( $title, 0, $length );
	
	if ( strlen( $title ) > 0 ) {
		if (strlen( $title ) < $length )
			$title = apply_filters( 'the_short_title', $before . $title, $before, $after );
		else
			$title = apply_filters( 'the_short_title', $before . $title . $after, $before, $after );
		
		if ( $echo )
			echo $title;
		else
			return $title;
	}
}


/**
 * Limit String
 *
 * @since     1.0
 */
function ti_limit_string( $string, $length = false, $echo = true, $more = '&hellip;'  ) {
	if ( absint( $length ) )
		$string = substr( $string, 0, $length );
		
	if ( strlen( $string ) < $length )
	  $string = apply_filters( 'ti_limit_string', $string );
	else
	  $string = apply_filters( 'ti_limit_string', $string . $more );
	
	if ( strlen( $string ) > 0 ) {
		if ( $echo )
			echo $string;
		else
			return $string;
	}
}


/**
 * Sidebar Check
 *
 * Check to see if sidebars are active. If a sidebar is active
 * return (bool). Used by ti_sidebar_class() to apply a body
 * class of has-sidebar or no-sidebar. Used in page templates to
 * check if sidebar should be shown.
 *
 * @return    bool
 *
 * @since     2.7
 */
function ti_has_sidebar() {
	global $post, $is_page;
	
	if ( is_single() )
	  $has_sidebar =  ( is_active_sidebar( 'sidebar-single' ) ) ? true : false;
	
	elseif ( isset( $is_page ) && ( $is_page == 'template-post-gallery' || $is_page == 'template-discography' ) )
		$has_sidebar = false;
	
	elseif ( isset( $is_page ) && $is_page == 'template-post-page' )
	  $has_sidebar =  ( is_active_sidebar( 'sidebar-multiple' ) ) ? true : false;
	
	elseif ( is_page() && ! isset( $is_page ) )
	  $has_sidebar =  ( is_active_sidebar( 'sidebar-page' ) ) ? true : false;
	
	elseif ( ! is_singular() )
	  $has_sidebar =  ( is_active_sidebar( 'sidebar-multiple' ) ) ? true : false;
	
	else 
		$has_sidebar = false;
	
	return $has_sidebar;
}


/* 
 * Add Lightbox to Post Attachments
 * 
 * @since     1.0
 */
function ti_gallery_fancybox ($content) {
	return str_replace( '<a', '<a class="fancybox" rel="' . get_the_ID() . '"', $content);
}


/* 
 * Image Format Filter
 * 
 * {@link http://wordpress.mfields.org/2010/image-post-format-url-auto-discovery/ Snippet by Michael Fields }
 *
 * @since     1.0
 */
function ti_filter_content_for_image_format( $content ) {
	if ( 'image' == get_post_format() ) {
		$src = esc_url( $content );
		if ( ! empty( $src ) ) 
			$gis = @getimagesize( $src );
	  
	  if ( ! empty( $src ) && is_array( $gis ) ) {
	  	$attributes = array();
	  	$post_id = get_the_ID();
	  	$title = get_the_title();
	  	$defaults = array(
	  		'alt'    => get_post_meta( $post_id, 'ti_alt', true ),
	  		'width'  => $gis[0],
	  		'height' => $gis[1]
	  	);
	  	
	  	if ( ! empty( $title ) ) 
	  		$defaults['title'] = $title;
	  	
	  	$filtered = apply_filters( 'ti-image-format-attributes', $defaults, $src, $gis );
	  	$atts = array_merge( $defaults, $filtered );
	  	
	  	foreach( $atts as $name => $value ) {
	  		if ( in_array( $name, array( 'id', 'class', 'alt', 'title', 'height', 'width', 'longdesc', 'style' ) ) ) {
	  			if ( 'class' == $name && is_array( $value ) ) 
	  				$value = implode( ' ', $value );

	  			$attributes[] = $name . '="' . esc_attr( $value ) . '"';
	  		}
	  	}
	  	$content = '<img src="' . $src . '" ' . implode( ' ', $attributes ) . '>';
	  }
	}
	
	return $content;
}


/**
 * Load Required Theme Styles
 *
 * @since     1.0
 */
function ti_theme_styles() {
	if ( is_admin() ) return;
	
	wp_enqueue_style( 'ti_gfont_oswald', 'http://fonts.googleapis.com/css?family=Oswald',                   false, ti_version_id() );
	wp_enqueue_style( 'ti_fancybox',     get_template_directory_uri() . '/js/fancybox/jquery.fancybox.css', false, ti_version_id() );
	
	if ( function_exists( 'gigpress_admin_menu' ) ) {
		wp_enqueue_style( 'ti_gigpress', get_template_directory_uri() . '/style-gigpress.css', false, ti_version_id() );
	}
}


/**
 * Load Required Theme Scripts
 *
 * @since     1.0
 */
function ti_theme_scripts() {
	if ( is_admin() ) return;
	
	wp_enqueue_script( 'ti_modernizr',        get_template_directory_uri() . '/js/modernizr.js' );				   
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'ti_jplayer',          get_template_directory_uri() . '/js/jquery.jplayer.js',           'jquery', ti_version_id(), true );
	wp_enqueue_script( 'ti_jplayer_playlist', get_template_directory_uri() . '/js/jquery.jplayer.playlist.js',  'jquery', ti_version_id(), true );	
	wp_enqueue_script( 'ti_jcarousel',        get_template_directory_uri() . '/js/jquery.jcarousel.min.js',     'jquery', ti_version_id(), true );
	wp_enqueue_script( 'ti_heroslider',       get_template_directory_uri() . '/js/jquery.heroslider.js',        'jquery', ti_version_id(), true );
	wp_enqueue_script( 'ti_vimeoapi',         get_template_directory_uri() . '/js/video-players.js',            'jquery', ti_version_id(), true );
	wp_enqueue_script( 'ti_fancybox',         get_template_directory_uri() . '/js/fancybox/jquery.fancybox.js', 'jquery', ti_version_id(), true );
	wp_enqueue_script( 'ti_script',           get_template_directory_uri() . '/js/script.js',                   'jquery', ti_version_id(), true );
	
	if ( is_singular() ) {
		if ( comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}



/**
 * Localize hero slider. 
 * 
 * Localize values from theme options for use in javascript
 *
 * @since 2.0
 */
function ti_localize_slideshow() {
	
	$hero_fx = ti_get_option( 'hero_fx', 'scrollVert' );
	$hero_speed = ti_get_option( 'hero_speed', 1 );
	$hero_timeout = ti_get_option( 'hero_timeout' );
	
	$hero_options = array(
		'hero_fx'      => esc_html( $hero_fx ),
		'hero_speed'   => absint( $hero_speed ) * 1000,
		'hero_timeout' => ( 0 == $hero_timeout || empty( $hero_timeout ) ) ? 0 : absint( ti_get_option( 'hero_timeout', 6 ) ) * 1000
	);
	
	wp_localize_script( 'ti_heroslider', 'hero_options', $hero_options );
}


/**
 * Default Playlist - Tracks
 *
 * @since 1.0
 */
function ti_localize_jplayer() {
	if ( is_admin() ) return;
	
	// Get Audio Source from theme options
	$audio_source = ti_get_option( 'audio_source', 'custom' );
	
	// Get Audio Player Playist Information
	$audio_player_args = array();
	
	if( 'custom' == $audio_source ) {
		// Include Bandcamp Functionality & Files
		require_once( ti_DIRECTORY . '/includes/audio-player-custom.php' );
		// Set audio player args/tracks
		$audio_player_args = ti_audio_player_setup_custom();
	} else {
		$audio_player_args = ti_audio_player_setup_notice();
	}
	
	list( $default_disc_args ) = $audio_player_args;
	
	// JSON Encode Default Disc
	$default_disc = json_encode( $default_disc_args );
	
	// Set up param object for localization
	$params = array(
		'get_template_directory_uri' => get_template_directory_uri(),
    	'default_playlist' => $default_disc,
    	'autoplay' => ti_get_option( 'audio_player_autoplay', 0 ),
    	'is_home' => ( is_home() ) ? 1 : 0
	);
	
	// Localize params to be used in JS
	wp_localize_script(	'ti_jplayer_playlist', 'php_params', $params );
}


/**
 * Create Track Item Array
 *
 * @since 1.0
 */
function ti_get_track_info( $number = '', $title = '', $artist = '', $album = '', $poster = '', $mp3 = '' ) {
	$track = array(
	    'number' => absint( $number ),
	    'title' => str_replace( "\0", "\\u0000", addcslashes( $title, "\t\r\n\"\\" ) ),
	    'artist' => str_replace( "\0", "\\u0000", addcslashes( $artist, "\t\r\n\"\\" ) ),
	    'album' => str_replace( "\0", "\\u0000", addcslashes( $album, "\t\r\n\"\\" ) ),
	    'poster' => esc_url( $poster ),
	    'mp3' => esc_url( $mp3 )
	);
	
	return $track;
}


/**
 * Audio Player Setup Notice
 *
 * If a user has not setup any albums or chosen a service
 * in which to pull the data into the audio player, this
 * notice function is called. 
 * 
 * This function returns default array values in place
 * of album and track information with a notice "warning".
 *
 * @since 1.0
 */
function ti_audio_player_setup_notice() {

	$track = array(
		'number' => 404,
		'title' => __( 'Audio Player Setup', 'theme-it' ), 
		'artist' => esc_html__( 'Soundcheck', 'theme-it' ), 
		'album' =>  __( 'Version ', 'theme-it' ) . esc_html__( VERSION, 'theme-it' ), 
		'poster' => get_template_directory_uri() . '/images/default-album-artwork.png',
		'mp3' => esc_url( get_template_directory_uri() . '/images/default-album-audio.mp3' )
	);

	// Set default args initial values
	$default_disc_args[] = $track;
	
	// Create args to return for json_encode
	$player_args = array(
		$default_disc_args
	);
	
	return $player_args;
}


/**
 * Enclose embedded media in a div.
 *
 * Wrapping all flash embeds in a div allows for easier
 * styling with CSS media queries.
 *
 * @todo      Document parameters.
 *
 * @since     1.0
 */
function ti_oembed_dataparse( $cache, $url, $attr = '', $post_ID = '' ) {
	return '<div id="entry-embed-' . get_the_ID() . '" class="entry-embed">' . $cache . '</div>';
}


/**
 * Video Embed Fix
 *
 * Menus Behind Embedded Video Fix. Adds wmode=transparent to embed objects
 *
 * @since     1.0
 */
function ti_oembed_wmode_transparent( $html, $url, $attr = '', $post_ID = '' ) {
	if ( strpos( $html, "<embed src=" ) !== false )
		$html = str_replace( '</param><embed', '</param><param name="wmode" value="transparent"></param><embed wmode="transparent"', $html );
	
	return $html;
}


/**
 * Embed Defaults
 *
 * Set the defalut size for embed options
 *
 * @since     1.0
 */
function ti_embed_defaults( $embed_size ) {
	$embed_size['width'] = 480;
	$embed_size['height'] = 480;

	return esc_html( $embed_size );
}


/**
 * Excerpt More (auto).
 *
 * In cases where a post does not have an excerpt defined
 * WordPress will append the string "[...]" to a shortened
 * version of the post_content field. Soundcheck will replace
 * this string with an ellipsis followed by a link to the
 * full post.
 *
 * This filter is attached to the 'excerpt_more' hook
 * in the ti_setup_soundcheck() function.
 *
 * @return    string         An ellipsis followed by a link to the single post.
 *
 * @since     1.0
 */
function ti_excerpt_more_auto( $more ) {
	if ( is_search() ) 
		return ' &hellip;';
	else 
		return ' &hellip; ' . ti_continue_reading_link();
}

/**
 * Custom Excerpt Length
 *
 * @since     1.0
 */
function ti_excerpt_length( $length ) {
	return 55;
}

/**
 * Excerpt More (custom).
 *
 * For posts that have a custom excerpt defined, WordPress
 * will show this excerpt instead of shortening the post_content.
 * Soundcheck will append a link to the post's single view to the excerpt.
 *
 * This filter is attached to the 'get_the_excerpt' hook
 * in the ti_setup_soundcheck() function.
 *
 * @return    string         Excerpt with a link to the post's single view.
 *
 * @since     1.0
 */
function ti_excerpt_more_custom( $excerpt ) {
	if ( has_excerpt() && ! is_search() && ! is_attachment() && ! is_singular() ) 
		$excerpt .= "\n" . ti_continue_reading_link();
	return $excerpt;
}


/**
 * Get additional image sizes
 *
 * @return    array Custom image sizes
 *
 * @since     1.0
 */
function ti_get_additional_image_sizes() {
	$sizes = array();
	global $_wp_additional_image_sizes;
	if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
		$sizes = apply_filters( 'intermediate_image_sizes', $_wp_additional_image_sizes );
		$sizes = apply_filters( 'ti_get_additional_image_sizes', $_wp_additional_image_sizes );
	}

	return $sizes;
}


/**
 * Insert additional image sizes into the existing image sizes radio list
 *
 * @uses      apply_filters() Calls 'ti_image_size_name' on image size name
 *
 * @param     array       $fields Current attachment fields.
 * @param     object      $post Post object.
 * @return    array       Modified $fields.
 *
 * @since     1.0
 */
function ti_additional_image_size_input_fields( $fields, $post ) {
	if ( !isset( $fields['image-size']['html'] ) || substr( $post->post_mime_type, 0, 5 ) != 'image' )
		return $fields;

	$sizes = ti_get_additional_image_sizes();
	if ( ! count( $sizes ) )
		return $fields;

	$items = array();
	foreach ( array_keys( $sizes ) as $size ) {
		$downsize = image_downsize( $post->ID, $size );
		$enabled = $downsize[3];
		$css_id = "image-size-{$size}-{$post->ID}";
		$label = apply_filters( 'ti_image_size_name', $size );

		$html  = "<div class='image-size-item'>\n";
		$html .= "\t<input type='radio' " . disabled( $enabled, false, false ) . "name='attachments[{$post->ID}][image-size]' id='{$css_id}' value='{$size}' />\n";
		$html .= "\t<label for='{$css_id}'>{$label}</label>\n";
		if ( $enabled )
			$html .= "\t<label for='{$css_id}' class='help'>" . sprintf( "(%d&nbsp;&times;&nbsp;%d)", $downsize[1], $downsize[2] ). "</label>\n";
		$html .= "</div>";

		$items[] = $html;
	}

	$items = join( "\n", $items );
	$fields['image-size']['html'] = "{$fields['image-size']['html']}\n{$items}";

	return $fields;
}


/**
 * Post Classes.
 *
 * @param     array     All classes for the post container.
 * @return    array     Modified classes for the post container.
 *
 * @since     1.0
 */
function ti_has_featured_image_class( $classes ) {
	$featured_image = get_the_post_thumbnail();
	if ( ! empty( $featured_image ) )
		$classes[] = 'has-featured-image';
	return array_unique( $classes );
}


/**
 * Post Format Body Class
 *
 * Adds class to body if post has a format selected.
 *
 * @param     array     All classes for the body element.
 * @return    array     Modified classes for the body element.
 *
 * @since     1.0
 */
function ti_has_post_format_class( $classes ) {
	global $post;
	$formats = array( 'image', 'gallery', 'video' );
	foreach ( $formats as $format ) {
		if ( has_post_format( $format ) )
			$classes[] = 'has-format';
	}
	return array_unique( $classes );
}


/**
 * Sidebar Class
 *
 * @param     array     All classes for the body element.
 * @return    array     Modified classes for the body element.
 *
 * @since     1.0
 */
function ti_sidebar_class( $classes ) {
	global $post;
	$output = ( ti_has_sidebar() ) ? 'has-sidebar' : 'no-sidebar';
	$classes[] = $output;
	return array_unique( $classes );
}


/**
 * Multiple Page Class
 *
 * Add a class to pages that display multiple posts
 *
 * @param     array     All classes for the body element.
 * @return    array     Modified classes for the body element.
 *
 * @since     1.0
 */
function ti_multiple_post_class( $classes ) {
	global $post;
	if ( ! is_singular() || is_page_template( 'template-post-page.php' ) )
		$classes[] = 'multiple';
	return array_unique( $classes );
}


/**
 * Register Sidebars
 *
 * @since     1.0
 */
function ti_register_sidebars() {
	register_sidebar( array(
		'id'            => 'sidebar-home',
		'name'          => __( 'Home Page Widgets', 'theme-it' ),
		'description'   => __( 'Shown on home page.', 'theme-it' ),
		'before_widget' => '<li><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-primary',
		'name'          => __( 'Primary Sidebar', 'theme-it' ),
		'description'   => __( 'Shown on all pages in left sidebar.', 'theme-it' ),
		'before_widget' => '<li><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
		
	register_sidebar( array(
		'id'            => 'sidebar-single',
		'name'          => __( 'Secondary Sidebar - Single', 'theme-it' ),
		'description'   => __( 'Shown on single post pages.', 'theme-it' ),
		'before_widget' => '<li><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-page',
		'name'          => __( 'Secondary Sidebar - Page', 'theme-it' ),
		'description'   => __( 'Shown on page type pages.', 'theme-it' ),
		'before_widget' => '<li><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-multiple',
		'name'          => __( 'Secondary Sidebar - Multiple', 'theme-it' ),
		'description'   => __( 'Shown on pages with multiple posts.', 'theme-it' ),
		'before_widget' => '<li><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
}





?>