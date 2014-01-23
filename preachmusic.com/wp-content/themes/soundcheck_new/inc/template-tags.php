<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Soundcheck
 * @since 2.3.0
 */
 
 
if ( ! function_exists( 'soundcheck_is_multiple' ) ) :
/**
 * Multiple Post Page
 *
 * Checking to see if page type may contain multiple posts
 *
 * @since 1.8
 */
function soundcheck_is_multiple() {
	
	global $wp_query;
	
	if ( is_page_template( 'template-blog.php' ) || is_search() || is_archive() || is_home() || $wp_query->is_posts_page  )
		return true;
	
	return false;
	
}
endif;


if ( ! function_exists( 'soundcheck_has_right_sidebar' ) ) :
/**
 * Right Sidebar Check
 *
 * Check to see if sidebars are active. If a sidebar is active
 * return (bool). Used by soundcheck_sidebar_body_class() to apply a body
 * class of has-sidebar or no-sidebar. Used in page templates to
 * check if sidebar should be shown.
 *
 * @return bool
 * @since 2.0
 */
function soundcheck_has_right_sidebar() {
	
	global $post;

	if ( is_single() )
		if ( soundcheck_product_type_page() )
			$has_sidebar = true; // always TRUE so the product pricing info will show.
		else
			$has_sidebar = is_active_sidebar( 'sidebar-secondary-single' ) ? true : false;
	elseif ( soundcheck_page_template( 'gallery' ) )
		$has_sidebar = false;
	elseif ( is_page_template( 'template-blog.php' ) )
		$has_sidebar = is_active_sidebar( 'sidebar-secondary-multiple' ) ? true : false;
	elseif ( is_page() && ! soundcheck_page_template() )
		$has_sidebar = is_active_sidebar( 'sidebar-secondary-page' ) ? true : false;
	elseif ( ! is_singular() )
		$has_sidebar = is_active_sidebar( 'sidebar-secondary-multiple' ) ? true : false;
	else 
		$has_sidebar = false;
	
	return $has_sidebar;
	
}
endif;


if ( ! function_exists( 'soundcheck_has_left_sidebar' ) ) :
/**
 * Left Sidebar Check
 *
 * Checks to see if the left sidebar is showing. This sidebar is known 
 * as the Primary sidebar or the left most Home page sidebar.
 *
 * @return bool
 * @since 2.0
 */
function soundcheck_has_left_sidebar() {
	
	global $post;
	
	if ( is_page_template( 'template-full.php' ) )
		$has_sidebar = false;
	elseif ( soundcheck_product_type_page() )
		$has_sidebar = is_active_sidebar( 'sidebar-primary-products' ) ? true : false;
	else
		$has_sidebar = is_active_sidebar( 'sidebar-primary' ) ? true : false;
		
	return $has_sidebar;
	
}
endif;


if ( ! function_exists( 'soundcheck_thumbnail_size' ) ) :
/**
 * Thumbnail Size
 *
 * Returns the post thumbnail size depending on page type or sidebar
 *
 * @since 1.8
 */
function soundcheck_thumbnail_size() {

	// Full width pages
	if ( ! soundcheck_has_left_sidebar() && ! soundcheck_has_right_sidebar() )
		return 'theme-full';

	// Pages with both left and right sidebars
	if ( soundcheck_has_left_sidebar() && soundcheck_has_right_sidebar() )
		return 'theme-medium';
	
	if ( soundcheck_product_type_page() )
		return 'post-thumbnail';
	
	return 'theme-large';
	
}
endif;

 
if ( ! function_exists( 'soundcheck_post_thumbnail' ) ) :
/**
 * Post Thumbnail
 *
 * Prints the image post thumbnail with Soundcheck specific markup.
 * Used in various places within theme.
 *
 * @since 2.0
 */
function soundcheck_post_thumbnail( $icon = '' ) {
	
	// Return early if post does not have a featured image set
	if ( ! has_post_thumbnail() )
		return; 
	
	// Display image in lightbox in a single post page, else link to post
	if ( is_single() ) {
		$image_id  = get_post_thumbnail_id();  
		$image_url = wp_get_attachment_image_src( $image_id, 'large' );  
		$image_url = $image_url[0];
		$icon .= ' view';
	} else {
		$image_url = get_permalink();
	}
	
	printf( '<figure class="entry-thumbnail"><a class="thumbnail-icon %1$s" href="%2$s" title="%3$s" rel="post-%4$d">%5$s</a></figure>',
		esc_attr( $icon ),
	    esc_url( $image_url ),
	    esc_attr( sprintf( __( '%1$s', 'soundcheck' ), the_title_attribute( array( 'echo' => 0 ) ) ) ),
	    absint( get_the_ID() ),
	    get_the_post_thumbnail( get_the_ID(), soundcheck_thumbnail_size() )
	);
	
}
endif;


if ( ! function_exists( 'soundcheck_post_format' ) ) :
/**
 * Post Format
 *
 * Prints the post format with Soundcheck specific markup.
 *
 * @since 2.0
 */
function soundcheck_post_format( $format = 'standard' ) {
	
	switch ( $format ) :
		case 'audio' :
			print do_shortcode( sprintf( '[p75_audio_player album_id="%1$s" autoplay="%2$s" playlist="%3$s"]', 
			    absint( get_the_ID() ),
			    absint( 0 ),
			    absint( 1 )
			) );
			break;
		case 'video' :
			print '<div class="entry-video"><!-- Populated via theme.js --></div>';
			break;
		default :
			soundcheck_post_thumbnail( $format );
	endswitch;
	
}
endif;


if ( ! function_exists( 'soundcheck_pagination' ) ) :
/**
 * Pagination
 *
 * @since 2.4.0
 */
function soundcheck_pagination( $nav_id ) {
	global $wp_query;
	
	if ( $wp_query->max_num_pages > 1 ) : ?>		
		<nav id="<?php echo esc_attr( $nav_id ); ?>" class="pagenavi">
			<?php
			$big     = 999999999;
			$base    = str_replace( $big, '%#%', get_pagenum_link( $big ) );
			$total   = $wp_query->max_num_pages;
			$current = max( 1, soundcheck_get_paged_query_var() );
			
		    printf( '<span class="pages">' . __( 'Page %d of %d', 'soundcheck' ) . '</span>', 
		    	number_format_i18n( $current ), 
		    	number_format_i18n( $total ) 
		    );
			
			print paginate_links( array(
			    'base'      => $base,
			    'format'    => '?paged=%#%&page_id=' . get_the_ID(),
			    'current'   => $current,
			    'total'     => $total,
			    'prev_text' => '&laquo;',
			    'next_text' => '&raquo;'
			) );
			?>
		</nav><!-- #<?php echo $nav_id; ?> -->
	<?php endif; // end if ( $wp_query->max_num_pages > 1 )
}
endif;


if ( ! function_exists( 'soundcheck_get_events' ) ) :
/**
 * Get events
 *
 * @since 2.4.0
 */
function soundcheck_get_events( $args = array() ) {
	
	// Set event category if not provided in args.
	$event_cat = ( ! isset( $args['cat'] ) || empty( $args['cat'] ) ) ? soundcheck_option( 'events_category', null ) : $args['cat'];
	
	// Default args
	$defaults = array(
		'post_status'    => 'future',
	    'order'          => 'ASC',
	    'cat'            => $event_cat,
	    'posts_per_page' => soundcheck_option( 'events_per_page', 20 ),
	);

	// Combine supplied args with defaults
	$args = wp_parse_args( (array) $args, $defaults );
	
	// Send it out. Allow args to be filtered.
	return new WP_Query( apply_filters( 'soundcheck_events_query_args', $args ) );
	
}
endif;


if ( ! function_exists( 'soundcheck_get_events_filter' ) ) :
/**
 * Get events
 *
 * @since 2.4.0
 */
function soundcheck_get_events_category_filter( $args = array() ) {
	
	// Set event category if not provided in args.
	$event_cat = ( ! isset( $args['cat'] ) || empty( $args['cat'] ) ) ? soundcheck_option( 'events_category', null ) : $args['cat'];
	
	// Default args
	$defaults = array(
	    'child_of'     => $event_cat,
	    'title_li'     => '',
	    'echo'         => 0,
	    'hierarchical' => false,
	    'hide_empty'   => 0
	);
	
	// Combine supplied args with defaults
	$args = wp_parse_args( (array) $args, $defaults );
	
	// Send it out. Allow args to be filtered.
	return get_categories( apply_filters( 'soundcheck_events_category_filter_args', $args ) );
	
}
endif;


if ( ! function_exists( 'soundcheck_get_image_carousel_items' ) ) :
/**
 * Get image carousel items
 *
 * @since 2.4.0
 */
function soundcheck_get_image_carousel_items() {
	$args = array(
		'cat'                 => soundcheck_option( 'carousel_category', null ),
		'posts_per_page'      => soundcheck_option( 'carousel_count', 10 ),
		'ignore_sticky_posts' => 1,
		'meta_query'          => array ( 
			array (
				'key' => '_thumbnail_id' 
			)
		)
	);
	
	return new WP_Query( apply_filters( 'soundcheck_image_carousel_query_args', $args ) ); 
}
endif;


/**
 * Get Image Carousel
 *
 * Determine if image carousel should be displayed.
 *
 * @param string
 * @return contents
 *
 * @since 1.8
 */
if ( ! function_exists( 'soundcheck_get_image_carousel' ) ) :
function soundcheck_get_image_carousel( $page = '' ) {
	
	// Always display on home page to maintain layout. Return early.
	if ( 'home' == $page ) {
		get_template_part( 'content', 'carousel' );
		return;
	}
	
	// Get theme options for image carousel
	$image_carousel_enable = soundcheck_option( 'carousel_' . $page );
	
	// Display carousel if the option checked matches the current page type
	if( 1 == $image_carousel_enable ) {
		get_template_part( 'content', 'carousel' );
		return;
	}
	
	return false;
	
}
endif;


if ( ! function_exists( 'soundcheck_archive_title_descriptor' ) ) :
/**
 * Format Archive Labels
 *
 * Allow users to filter the labels for the various post formats.
 *
 * @since 2.3.0
 *
 * @param string $slug The slug name for the archive type.
 * @param string $name The name of the specialised archive type. Useful for catgories, post formats, etc. 
 * @param bool $display Optional, default is false. Whether to display or retrieve title.
 */
function soundcheck_archive_title_descriptor( $slug = null, $name = null, $display = false ) {
	// Set default slug value if not provided
	$slug = ( null === $slug ) ? 'post-type' : $slug ;
	
	// Map archive types to a descriptor string
	$descriptors = array(
	    'post-type'   => __( 'Archives', 'soundcheck' ),
	    'category'    => __( 'Category Archives', 'soundcheck' ),
	    'tag'         => __( 'Tag Archives', 'soundcheck' ),
	    'author'      => __( 'Author Archives', 'soundcheck' ),
	    'day'         => __( 'Daily Archives', 'soundcheck' ),
	    'month'       => __( 'Monthly Archives', 'soundcheck' ),
	    'year'        => __( 'Yearly Archives', 'soundcheck' ),
	    'search'      => __( 'Search For', 'soundcheck' ),
	    'post-format' => '',
	);
	
	// Allow child themes to add/customize descriptors
	$descriptors = apply_filters( 'soundcheck_archive_title_descriptors', $descriptors );
	
	// Set value for $slug_name
	if ( isset( $name ) )
		$slug_name = "$slug-$name";
	
	// Get archive descriptor by slug-name if available else fallback to slug
	if ( isset( $slug_name ) && array_key_exists( $slug_name, $descriptors ) )
	    $output = $descriptors[$slug_name];
	else
	    $output = $descriptors[$slug];
	    
	// Send it out
	if ( $display )
		print $output;
	else
		return $output;
}
endif;


if ( ! function_exists( 'soundcheck_post_format_label' ) ) :
/**
 * Post format label
 *
 * Display or retrieve plural post format label.
 *
 * @since 2.3.0
 *
 * @param string $format Optional, default is null. If null, use the current post format.
 * @param bool $display Optional, default is false. Whether to display or retrieve title.
 * @return string|null String on retrieve, null when displaying.
 */
function soundcheck_post_format_label( $format = null, $display = false ) {
	// Get current format if not provided
	$format = ( null === $format ) ? get_post_format() : $format;
	
	// Map formats to their corresponsing plural string
	$labels = array(
	    'aside'   => _x( 'Asides', 'post-format-archive-label', 'soundcheck' ),
	    'link'    => _x( 'Links', 'post-format-archive-label', 'soundcheck' ),
	    'image'   => _x( 'Images', 'post-format-archive-label', 'soundcheck' ),
	    'quote'   => _x( 'Quotes', 'post-format-archive-label', 'soundcheck' ),
	    'video'   => _x( 'Videos', 'post-format-archive-label', 'soundcheck' ),
	    'gallery' => _x( 'Galleries', 'post-format-archive-label', 'soundcheck' ),
		'status'  => _x( 'Statuses', 'post-format-archive-label', 'soundcheck' ),
		'audio'   => _x( 'Audios', 'post-format-archive-label', 'soundcheck' ),
		'chat'    => _x( 'Chats', 'post-format-archive-label', 'soundcheck' ),
	);
	
	// Allow child themes to add/customize labels
	$labels = apply_filters( 'soundcheck_post_format_labels', $labels );
	
	// Send it out
	if ( $display )
		print $labels[$format];
	else
		return $labels[$format];
}
endif;


if ( ! function_exists( 'soundcheck_discography_query' ) ) :
/**
 * Discography Query
 *
 * Here we will query the audio format posts.
 * Before we do that, we'll check to see if we have
 * done this previously by checking if a particular
 * transient has been set. If not, we'll run the query
 * and set the $tracks for the audio players.
 *
 * Localize audio files found in post's gallery
 *
 * @return void
 * @since 2.0
 */
function soundcheck_discography_query() {
	
	if ( false === ( $tracks = get_transient( 'soundcheck_audio_tracks' ) ) ) {
		/* Create playlist object array */
		$playlist = array();
		
		/* Set arguements to query audio post formats */
		$args = array(
		    'posts_per_page' => 999,
		    'post_status' => 'publish',
		    'tax_query' => array(
		    	array (
		    		'taxonomy' => 'post_format',
		    		'field' => 'slug',
		    		'terms' => 'post-format-audio'
		    	)
		  	)
		);
		
		/* Create new query from $args */
		$audio_query = new WP_Query( apply_filters( 'soundcheck_discography_query_args', $args ) );
		
		/* Include audio class used to create and setup tracks */
		locate_template( 'inc/class-audio-tracks.php', true );
		
		/* Loop through posts and add tracks to the $playlist array */
		while ( $audio_query->have_posts() ) : 
			$audio_query->the_post();
			$post_id = get_the_ID();
			$audio = new Soundcheck_Audio( $post_id );
			$playlist['playlist'][$post_id] = $audio->tracks();
		endwhile;
		
		/* As it says… */
		wp_reset_postdata();
				
		/* JSON encode playlist */
		$tracks = json_encode( $playlist );
		
		/* Set transient with the $tracks data! */
		set_transient( 'soundcheck_audio_tracks', $tracks );
	}
	
	return $tracks;
	
}
endif;


if ( ! function_exists( 'soundcheck_product_type_page' ) ) :
/**
 * Product Page Type Check
 *
 * Basically this allows the theme to check if the page being viewed
 * is associated with any products (store) functioanlity. This can be
 * a page template or category that displays products.
 *
 * @return array
 * @since 2.0
 */
function soundcheck_product_type_page() {
	
	// Return early if Cart66 is not installed
	if ( ! soundcheck_plugin_active( 'cart66' ) )
		return false;
	
	// If one of these page templates is being display, retrun true
	if ( soundcheck_page_template( 'products' ) )
		return true;
	
	// If the products_category Theme Option is set, we may consider
	if ( ( $products_category = soundcheck_option( 'products_category' ) ) ) {
		if ( is_single() && in_category( $products_category ) ) {
			return true;
		}
		
		if ( is_category( $products_category ) || soundcheck_is_subcategory( $products_category ) ) {
			return true;
		}
	}
	
	// Not a product type page
	return false;
	
}
endif;


if ( ! function_exists( 'soundcheck_page_template' ) ) :
/**
 * Page Template Check
 *
 * Checks to see if a current page template is being used.
 *
 * @return bool
 * @since 1.8
 */
function soundcheck_page_template( $type = '' ) {
	
	$template_files = soundcheck_page_template_files( $type );
	
	foreach( $template_files as $template ) {
		if ( is_page_template( $template ) ) {
			return true;
		}
	}
	
	return false;
	
}
endif;


if ( ! function_exists( 'soundcheck_page_template_files' ) ) :
/**
 * Page Tempalte Files
 *
 * Returns a list of page template files inlcuded with the theme.
 * Each file has a "type" associated with it. This allows the theme to
 * check and display content based on an intended type of content that
 * should be displayed by the theme.
 *
 * The $type here is mainly in reference to layout.
 *
 * @return array
 * @since 1.8
 */
function soundcheck_page_template_files( $type = '' ) {
	
	$gallery = array(
		'template-cart.php',
		'template-discography.php',
		'template-products.php'
	);
	
	$products = array(
		'template-cart.php',
		'template-checkout.php',
		'template-products.php'
	);
	
	$standard = array(
		'template-full.php',
		'template-gigpress.php',
		'template-events.php',
		'template-blog.php'
	);
	
	if ( 'gallery' == $type ) {
		return $gallery;
	}
	
	if ( 'products' == $type ) {
		return $products;
	}
	
	if ( 'standard' == $type ) {
		return $standard;
	}
		
	return wp_parse_args( $gallery, $standard );
	
}
endif;


if ( ! function_exists( 'soundcheck_the_title_attribute' ) ) :
/**
 * Title Attribute.
 *
 * @since 1.0
 */
function soundcheck_the_title_attribute() {
    
    return esc_attr( sprintf( __( 'Permalink to %s', 'soundcheck' ), the_title_attribute( 'echo=0' ) ) );

}
endif;


if ( ! function_exists( 'soundcheck_pings_callback' ) ) :
/**
 * Pings Callback Setup
 *
 * @since 1.0
 */
function soundcheck_pings_callback( $comment, $args, $depth ) {
	
	$GLOBALS['comment'] = $comment; ?>
	
	<li class="ping" id="li-comment-<?php comment_ID(); ?>">
		<div class="seperation-border"></div>
		<?php comment_author_link(); ?>
	
	<?php
}
endif;


if ( ! function_exists( 'soundcheck_comment_callback' ) ) :
/**
 * Comment Callback Setup
 *
 * @since 1.0
 */
function soundcheck_comment_callback( $comment, $args, $depth ) {
	
	$GLOBALS['comment'] = $comment;	?>
	
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
		
			<div class="seperation-border"></div>
		
			<div class="comment-head">
				<figure class="comment-author-avatar">
					<?php 
					$comment_author_url = get_comment_author_url(); 
					if ( ! empty( $comment_author_url ) ) {
						printf( 
							'<a href="%1$s" title="%2$s" target="_blank" rel="external nofollow">%3$s</a>',
							esc_url( $comment_author_url ),
							esc_attr( sprintf(
								'%1$s %2$s',
								__( 'Link to', 'soundcheck' ),
								get_comment_author()
							) ),
							get_avatar( $comment, '35' )
						);
					} else {
						echo get_avatar( $comment, '35' );
					}
					?>
	       			<?php  ?>
				</figure>
				<div class="comment-meta">
	       			<cite class="comment-author-name"><?php echo get_comment_author_link() ?></cite>
					<time class="comment-date" pubdate="<?php echo esc_attr( get_comment_date( 'Y-m-d' ) ) ?>"><?php echo get_comment_date() ?></time>
					<?php 
					comment_reply_link( array_merge( $args, 
						array( 
							'depth' => $depth, 
							'max_depth' => $args['max_depth'],
							'before' => __( ' &middot; ', 'soundcheck' ),
							'reply_text' => __( ' Reply ', 'soundcheck' ),
						) 
					) );
					?>
					<?php echo edit_comment_link( __( ' Edit ', 'soundcheck' ), ' &middot; ' ); ?>
				</div>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="comment-moderation"><em><?php _e( 'Your comment is awaiting moderation.', 'soundcheck' ); ?></em></p>
				<?php endif; ?>
			</div>

			<div class="comment-body">
				<?php comment_text(); ?>
				<?php comment_type( ( '' ), ( 'Trackback' ), ( 'Pingback' ) ); ?>
			</div>
		</div>
		
<?php }
endif;


if ( ! function_exists( 'soundcheck_is_subcategory' ) ) :
/**
 * Is Subcategory
 *
 * Check if current category is a decendent of a parent category.
 * Currently used to check if category is in the store category tree.
 *
 * @param $parent_cat_id ID of category parent to check current category against.
 * @since 2.0
 */
function soundcheck_is_subcategory( $parent_cat_id = null ) {
	
	if ( ! is_category() )
	 	return;
	
	$cat = get_query_var( 'cat' );
    $category = get_category( $cat );
	
	if ( null === $parent_cat_id ) {
		return ( $category->parent == '0' ) ? false : true;
	} else {
		return ( $category->parent != $parent_cat_id ) ? false : true;
	}
	
}
endif;


if ( ! function_exists( 'soundcheck_array_to_select' ) ) :
/**
 * Create select options from array.
 *
 * This function takes an array and returns a set of options
 * to be used inside a select box.
 *
 * Used in the creation of some widget options.
 *
 * @return Array
 * @since 2.0
 */
function soundcheck_array_to_select( $option = array(), $selected = '', $optgroup = NULL ) {
	
	$select_options = '';

	$option_markup = '<option value="%1$s" %3$s>%2$s</option>';
	
	if ( $selected == '' ) {
		$select_options .= sprintf( $option_markup,	'', __( 'Select one...', 'soundcheck' ), 'selected="selected"' );
	}
	
	foreach ( $option as $key => $value ) {
	    if ( $key == $selected ) {
	    	$select_options .= sprintf( $option_markup,	esc_attr( $key ), esc_html( sprintf( __( '%s', 'soundcheck' ), $value ) ), 'selected="selected"' );
	    } else {
	    	$select_options .= sprintf( $option_markup,	esc_attr( $key ), esc_html( sprintf( __( '%s', 'soundcheck' ), $value ) ), '' );
	    }
	}
	
    return $select_options;
    
}
endif;


if ( ! function_exists( 'soundcheck_update_post_meta_field' ) ) :
/**
 * Update Metabox Post Meta
 *
 * @since soundcheck 2.4.0
 */
function soundcheck_update_post_meta_field( $fields, $post_id ) {
	
	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) && ! empty( $_POST[ $field ] ) ) {
			if ( is_string( $_POST[$field] ) ) {
				$new = esc_attr( $_POST[$field] );
			} elseif ( is_array( $_POST[$field] ) ) {
				$new = implode( ',', $_POST[$field] );
			} else {
				$new = $_POST[ $field ];
			}

			$new = apply_filters( 'soundcheck_metabox_save_' . $field, $new );
			
			update_post_meta( $post_id, $field, $new );
		} else {
			delete_post_meta( $post_id, $field );
		}
	}
	
}
endif;


if ( ! function_exists( 'soundcheck_get_random_number' ) ) :
/**
 * Generate random number
 *
 * Creates a 4 digit random number for used
 * mostly for unique ID creation. 
 *
 * @since 1.0
 */
function soundcheck_get_random_number() {
	
	return substr( md5( uniqid( rand(), true ) ), 0, 4 );

}
endif;


if ( ! function_exists( 'soundcheck_limit_string' ) ) :
/**
 * Limit String
 *
 * @since 1.0
 */
function soundcheck_limit_string( $phrase, $max_characters ) {

	$phrase = trim( $phrase );

	if ( strlen( $phrase ) > $max_characters ) {

		// Truncate $phrase to $max_characters + 1
		$phrase = substr( $phrase, 0, $max_characters + 1 );

		// Truncate to the last space in the truncated string.
		$phrase = trim( substr( $phrase, 0, strrpos( $phrase, ' ' ) ) );
		
		$phrase .= '&hellip;';
	}

	return $phrase;
	
}
endif;


if ( ! function_exists( 'soundcheck_tweet_linkify' ) ) :
/**
 * This function takes the content of a tweet, detects @replies,
 * #hashtags, and http://links, and links them appropriately.
 *
 * @author Snipe.net
 * @link http://www.snipe.net/2009/09/php-twitter-clickable-links/
 *
 * @param string $tweet A string representing the content of a tweet
 *
 * @return string
 *
 * @since 2.0
 */
function soundcheck_tweet_linkify( $tweet ) {

	$tweet = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $tweet);
	$tweet = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $tweet);
	$tweet = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $tweet);
	$tweet = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $tweet);

	return $tweet;

}
endif;


if ( ! function_exists( 'soundcheck_get_paged_query_var' ) ) :
/**
 * Page Query Var
 *
 * The below functionality is used because the query is set
 * in a page template, the "paged" variable is available. However,
 * if the query is on a page template that is set as the websites
 * static posts page, "paged" is always set at 0. In this case, we
 * have another variable to work with called "page", which increments
 * the pagination properly.
 * 
 * Hat Tip: @nathanrice
 * 
 * @link http://wordpress.org/support/topic/wp-30-bug-with-pagination-when-using-static-page-as-homepage-1
 * @since 1.0
 */
function soundcheck_get_paged_query_var() {
	
	if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	} else {
		$paged = 1;
	}
	
	return $paged;
	
}
endif;


/**
 * Get Default Notices
 *
 * Returns html markup with the type of notice messages requested.
 *
 * @param $type Type of default notice to display
 * @return string
 * @since 2.0
 */
function soundcheck_get_default_notice( $type = '' ) {

	$notice = '<p class="default-notice">%1$s</p>';
	
	switch ( $type ) :
		case 'hero' :
			return sprintf( $notice,
				sprintf( __( 'It looks like a category has not been assigned for the Hero slides.<br /> %1$s', 'soundcheck' ),
					sprintf( '<a href="%1$s">%2$s</a>',
						esc_url( admin_url( 'themes.php?page=soundcheck_options&section=hero_section' ) ),
						esc_html__( 'Configure Hero Slide Options  &rarr;', 'soundcheck' )
					) 
				)
			);
			break;	
			
		case 'home-widgets' :
			return sprintf( $notice,
				sprintf( __( 'You have not setup any widgets for this Home page widget column.<br /> %1$s', 'soundcheck' ),
					sprintf( '<a href="%1$s">%2$s</a>',
						esc_url( admin_url( 'widgets.php' ) ),
						esc_html__( 'Configure Home Widgets &rarr;', 'soundcheck' )
					) 
				)
			);
			break;
			
		case 'events' :
			return sprintf( $notice, 
				sprintf( __( 'It looks like a category has not been assigned for the Events functionality.<br /> %1$s', 'soundcheck' ),
					sprintf( '<a href="%1$s">%2$s</a>',
						esc_url( admin_url( 'themes.php?page=soundcheck_options&section=events_section' ) ),
						esc_html__( 'Configure Events Options &rarr;', 'soundcheck' )
					) 
				)
			);
			break;
		
		default :
			return;
	
	endswitch;
	
}
