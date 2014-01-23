<?php
/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since 2.3.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function soundcheck_wp_title( $title, $sep ) {

	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
		
	if ( is_tax( 'post_format' ) ) {
		$title = soundcheck_post_format_label() . " $sep " . get_bloginfo( 'name' );
	}		

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'soundcheck' ), max( $paged, $page ) );

	return $title;
	
}
add_filter( 'wp_title', 'soundcheck_wp_title', 10, 2 );


if ( ! function_exists( 'soundcheck_featured_body_class' ) ) :
/**
 * Featured Body Class
 *
 * @param array All classes for the body element.
 * @return array Modified classes for the body element.
 * @since 1.0
 */
function soundcheck_featured_body_class( $classes ) {

	global $post;

	if ( is_page_template( 'template-home.php' ) && soundcheck_option( 'featured_primary_home_sidebar' ) )
		$classes[] = 'featured-sidebar left-sidebar one'; // "one" is in reference to the column.
	elseif ( soundcheck_product_type_page() && soundcheck_option( 'featured_primary_product_sidebar' )  && is_active_sidebar( 'sidebar-primary-products' ) )
		$classes[] = 'featured-sidebar';
	elseif ( ! soundcheck_product_type_page() && ! is_page_template( 'template-full.php' ) && soundcheck_option( 'featured_primary_sidebar' ) && is_active_sidebar( 'sidebar-primary' ) )
		$classes[] = 'featured-sidebar';

	return array_unique( $classes );

}
endif;
add_filter( 'body_class', 'soundcheck_featured_body_class' );


if ( ! function_exists( 'soundcheck_gallery_layout_body_class' ) ) :
/**
 * Gallery Layout Body Class
 *
 * @param array All classes for the body element.
 * @return array Modified classes for the body element.
 * @since 1.0
 */
function soundcheck_gallery_layout_body_class( $classes ) {

	global $post;
	
	$product_category = soundcheck_option( 'products_category' );
	
	if ( $product_category && ( is_category( $product_category ) || soundcheck_is_subcategory( $product_category ) ) )
		$classes[] = 'gallery-layout';

	if ( is_page_template( 'template-discography.php' ) )
		$classes[] = 'gallery-layout';

	return array_unique( $classes );

}
endif;
add_filter( 'body_class', 'soundcheck_gallery_layout_body_class' );


if ( ! function_exists( 'soundcheck_sidebar_body_class' ) ) :
/**
 * Sidebar Class
 *
 * @param array All classes for the body element.
 * @return array Modified classes for the body element.
 * @since 1.0
 */
function soundcheck_sidebar_body_class( $classes ) {
	
	global $post;
	
	$classes[] = soundcheck_has_right_sidebar() ? 'right-sidebar' : '';
	$classes[] = soundcheck_has_left_sidebar() ? 'left-sidebar' : '';
	
	return array_unique( $classes );
	
}
endif;
add_filter( 'body_class', 'soundcheck_sidebar_body_class' );


if ( ! function_exists( 'soundcheck_embed_html' ) ) :
/**
 * Filter oEmbed HTML
 *
 * Adds a wrapper to videos from the whitelisted services and attempts to add
 * the wmode parameter to YouTube videos and flash embeds.
 *
 * @return string
 */
function soundcheck_embed_html( $html, $url = null ) {
    
    $wrapped = '<div class="wp-embed"><div class="player">' . $html . '</div></div>';
    
    if ( empty( $url ) && 'video_embed_html' == current_filter() ) { // Jetpack
        
        $html = $wrapped;
        
    } elseif ( ! empty( $url ) ) {
        
        $players = array( 'youtube', 'youtu.be', 'vimeo', 'dailymotion', 'hulu', 'blip.tv', 'wordpress.tv', 'viddler', 'revision3' );
        
        foreach ( $players as $player ) {
            if ( false !== strpos( $url, $player ) ) {
                if ( false !== strpos( $url, 'youtube' ) && false !== strpos( $html, '<iframe' ) && false === strpos( $html, 'wmode' ) ) {
                    $html = preg_replace_callback( '|https?://[^"]+|im', 'soundcheck_oembed_youtube_wmode_parameter', $html );
                }
            
                $html = $wrapped;
                break;
            }
        }
    }
    
    if ( false !== strpos( $html, '<embed' ) && false === strpos( $html, 'wmode' ) ) {
        $html = str_replace( '</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque"', $html );
    }
    
    return $html;
    
}
endif;
add_filter( 'video_embed_html', 'soundcheck_embed_html' ); // Jetpack
add_filter( 'embed_oembed_html', 'soundcheck_embed_html', 10, 2 );


if ( ! function_exists( 'soundcheck_oembed_youtube_wmode_parameter' ) ) :
/**
 * YouTube Wmode
 *
 * Add wmode=transparent to YouTube videos to fix z-indexing issue
 *
 * @since 2.1.0
 */
function soundcheck_oembed_youtube_wmode_parameter( $matches ) {

	return add_query_arg( 'wmode', 'transparent', $matches[0] );
	
}
endif;


if ( ! function_exists( 'soundcheck_embed_defaults' ) ) :
/**
 * Embded Default Size
 * 
 * Set the defalut size for embed options
 *
 * @return array
 * @since 1.0
 */
function soundcheck_embed_defaults( $embed_size ) {
	
	$embed_size['width'] = 480;
	$embed_size['height'] = 270;
	
	return $embed_size;
	
}
endif;
add_filter( 'embed_defaults', 'soundcheck_embed_defaults' );



if ( ! function_exists( 'soundcheck_excerpt_more_auto' ) ) :
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
 * in the soundcheck_setup_soundcheck() function.
 *
 * @return string An ellipsis followed by a link to the single post.
 * @since 1.0
 */
function soundcheck_excerpt_more_auto( $more ) {
	
	return ' &hellip;';

}
endif;
add_filter( 'excerpt_more', 'soundcheck_excerpt_more_auto' );


/**
 * Delete Audio Tracks Transient
 *
 * Deletes audio tracks transient option when a post
 * is updated, edited, or published. This ensures that
 * if a new post was created or was updated
 * to be an Audio Post Format, it will be included in
 * in the results.
 *
 * @see soundcheck_localize_audio()
 * @return void
 * @since 1.0
 */
function soundcheck_audio_tracks_flusher() {
    
    delete_transient( 'soundcheck_audio_tracks' );

}
add_action( 'publish_post', 'soundcheck_audio_tracks_flusher' );
add_action( 'edit_post', 'soundcheck_audio_tracks_flusher' );


/**
 * Delete Gallery Format Query Transient
 *
 * Deletes the gallery sets transient option when a post
 * is updated, edited, or published. This ensures that
 * if a new post was created or was updated
 * to be an Gallery Post Format, it will be included in
 * in the results.
 *
 * @see soundcheck_localize_view()
 * @return void
 * @since 1.0
 */
function soundcheck_gallery_format_query_flusher() {
   
	delete_transient( 'soundcheck_gallery_format_query' );

}
add_action( 'publish_post', 'soundcheck_gallery_format_query_flusher' );
add_action( 'edit_post', 'soundcheck_gallery_format_query_flusher' );


/**
 * Comment Form Defaults
 *
 * @since 1.0
 */
function soundcheck_comment_form_defaults() {

	$req = get_option( 'require_name_email' );
	
	$field = '<p class="comment-form-%1$s"><label for="%1$s" class="comment-field">%2$s</label><input class="text-input" type="text" name="%1$s" id="%1$s" size="22" tabindex="%4$d"/><span class="field-note">%3$s</span></p>';
	
	$fields = array(
		'author' => sprintf( $field, 'author', ( $req ? __( 'Name <span>*</span>', 'soundcheck' ) : __( 'Name', 'soundcheck' ) ), '', 5 ),
		'email'  => sprintf( $field, 'email', ( $req ? __( 'Email <span>*</span>', 'soundcheck' ) : __( 'Email', 'soundcheck' ) ), __( '(Never published)', 'soundcheck' ), 6 ),
		'url'    => sprintf( $field, 'url', __( 'Website', 'soundcheck' ), '', 7 ),
	);
	
	$defaults = array(
		'id_form' => 'commentform',
		'id_submit' => 'submit',
		'label_submit' => __( 'Post Comment', 'soundcheck' ),
		'comment_field' => sprintf( 
			'<p class="comment-form-comment"><textarea id="comment" name="comment" rows="10" aria-required="true" tabindex="8"></textarea><label for="comment" class="comment-field">%1$s</label></p>',
			_x( 'Comment:', 'noun', 'soundcheck' )
		),
		'comment_notes_before' => '',
		'comment_notes_after' => sprintf(
			'<p class="comments-rss"><a href="%1$s"><span>%3$s</span> %2$s</a></p>',
			esc_attr( get_post_comments_feed_link() ),
			__( 'Subscribe To Comment Feed', 'soundcheck' ),
			__( 'RSS', 'soundcheck' )
			
		),
		'logged_in_as' => '',
		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		'cancel_reply_link' => '<div class="cancel-comment-reply">' . __( 'Cancel Reply', 'soundcheck' ) . '</div>',
		'title_reply' => __( 'Leave a Reply', 'soundcheck' ),
		'title_reply_to' => __( 'Leave a comment to %s', 'soundcheck' ),
	);

	return $defaults;
	
}
add_filter( 'comment_form_defaults', 'soundcheck_comment_form_defaults' );


/**
 * Remove default gallery style
 *
 * Removes inline styles printed when the 
 * gallery shortcode is used.
 *
 * @since 1.0
 */
add_filter( 'use_default_gallery_style', '__return_false' );


if ( ! function_exists( 'soundcheck_gallery_display' ) ) :
/**
 * Gallery Display
 *
 * Changes output of [gallery] shortcode in gallery-format posts to use FlexSlider.
 * Also will change output to use FlexSlider if [gallery slider="true"] is used on non-gallery-format post.
 *
 * @since 1.0
 */
function soundcheck_gallery_display( $output, $attr ) {
	
	global $post;
	
	static $gallery_instance = 0;
	$gallery_instance++;
	
	/* Ignore feed */
	if ( is_feed() )
		return $output;
		
	/* Orderby */
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		
		if ( ! $attr['orderby'] )
			unset( $attr['orderby'] );
	}
	
	/* Get Post ID */
	$post_id = isset( $attr['id'] ) ? $attr['id'] : get_the_ID();
	
	/* Default gallery settings. */
	$defaults = array(
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
		'id' => get_the_ID(),
		'link' => '',
		'itemtag' => 'dl',
		'icontag' => 'dt',
		'captiontag' => 'dd',
		'columns' => 3,
		'size' => 'thumbnail',
		'include' => '',
		'exclude' => '',
		'numberposts' => -1,
		'offset' => '',
		'slider' => false, // theme specific for flexslider integration
		'featured' => false // theme specific to feature at top of post
	);
	
	/* Merge the defaults with user input. Make sure $id is an integer. */
	$attr = shortcode_atts( $defaults, $attr );
	extract( $attr );
	$id = intval( $id );
	
	// Check if $numberposts is still equal to default and
	// Check if the post is in the soundcheck_hero category.
	if ( -1 == $numberposts && in_category( soundcheck_option( 'hero_category' ) ) ) {

	    // Set the max number of columns to 5. This avoids breaking the layout.
	    if ( $columns >= 5 ) {
	    	$columns = 5;
	    }
	    
	    // Set number of posts to the number of columns X 3 (rows)
	    // We do this because the hero slider only has so much height room.
	    // This also excludes grabbing more images than necessary to fill
	    // the maximum viewing area.
	    $numberposts = $columns * 3;
	}
	
	/* Get image attachments.*/
	if ( $attr['include'] ) {
		$includes = explode( ',', $attr['include'] );
		foreach ( $includes as $include ) :
			$attachments[$include] = (object) array(
				'ID' => $include,
				'post_parent' => $attr['id'],
				'post_content' => '',
				'post_date' => '',
				'post_author' => '',
			);
		endforeach;		
	} else {
		$attachments = get_children( array(
			'post_parent' => $attr['id'],
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => $attr['order'],
			'orderby' => $attr['orderby'],
			'exclude' => $attr['exclude'],
			'include' => $attr['include'],
			'numberposts' => $attr['numberposts'],
			'offset' => $attr['offset'],
		) );
	}

	if ( empty( $attachments ) )
		return '';

	/* Properly escape the gallery tags. */
	$itemtag = tag_escape( $itemtag );
	$icontag = tag_escape( $icontag );
	$captiontag = tag_escape( $captiontag );
	$i = 0; // Counter for columns

	/* Count the number of attachments returned. */
	$attachment_count = count( $attachments );
	
	// Allow developers to overwrite the number of columns.  
	// This can be useful for reducing columns with with fewer images than number of columns.
	$columns = apply_filters( 'soundcheck_gallery_columns', absint( $columns ), $attachment_count, $attr );
	
	/* Open the gallery <div>. */
	$output = sprintf( '<div id="gallery-%1$s" class="gallery galleryid-%2$s gallery-columns-%3$s gallery-size-%4$s">',
	    esc_attr( absint( $gallery_instance ) ),
	    esc_attr( absint( $id ) ),
	    esc_attr( absint( $columns ) ),
	    esc_attr( $size )
	);
	
	/* Loop through each attachment. */
	foreach( (array) $attachments as $id => $attachment ) {
	    /* Add clearfix to each row */
	    $clearfix = ( $columns > 0 && $i % $columns == 0 ) ? 'clearfix' : '';
	    
	    /* Open each gallery item. */
	    $output .= sprintf( '<%1$s class="gallery-item col-%2$s %3$s">', strip_tags( $itemtag ), esc_attr( $columns ), esc_attr( $clearfix ) );
	    	
	    /* Open the element to wrap the image. */
	    $output .= sprintf( '<%1$s class="gallery-icon">', strip_tags( $icontag ) );
	    
	    /* Add the image. */
	    $image = ( ( isset( $attr['link'] ) && 'file' == $attr['link'] ) ? wp_get_attachment_link( $id, $size, false, false ) : wp_get_attachment_link( $id, $size, true, false ) );
	    $output .= apply_filters( 'soundcheck_gallery_image', $image, $id, $attr, $gallery_instance );
	    
	    /* Close the image wrapper. */
	    $output .= sprintf( '</%1$s>', strip_tags( $icontag ) );
	    
	    /* Get the caption. */
	    $caption = apply_filters( 'soundcheck_gallery_caption', wptexturize( esc_html( $attachment->post_excerpt ) ), $id, $attr, $gallery_instance );
	
	    /* If image caption is set. */
	    if ( !empty( $caption ) )
	    	$output .= sprintf( '<%1$s class="wp-caption-text gallery-caption">%2$s<%1$s>', esc_attr( $captiontag ), esc_html( $caption ) );
	
	    /* Close individual gallery item. */
	    $output .= sprintf( '</%1$s>', strip_tags( $itemtag ) );
	    
	    ++$i;
	}
	
	/* Close the gallery <div>. */
	$output .= "</div><!-- .gallery -->";
	
	return $output;
	
}
endif;
add_filter( 'post_gallery', 'soundcheck_gallery_display', 10, 2 ); // Filter [gallery] display


/**
 * Gallery Image
 *
 * Modifies gallery images based on user-selected settings.
 *
 * @since 1.0
 */
function soundcheck_gallery_image( $image, $id, $attr, $instance ) {
	
	/* If the image should link to nothing, remove the image link. */
	if ( 'none' == $attr['link'] ) {
		$image = preg_replace( '/<a.*?>(.*?)<\/a>/', '$1', $image );
	}

	/* If the image should link to the 'file' (full-size image), add in extra link attributes. */
	elseif ( 'file' == $attr['link'] ) {		
		$image = str_replace( '<a href=', sprintf( '<a %s href=', soundcheck_gallery_lightbox_attributes( $instance ) ), $image );
	}

	/* If the image should link to an intermediate-sized image, change the link attributes. */
	elseif ( in_array( $attr['link'], get_intermediate_image_sizes() ) ) {
		$post = get_post( $id );
		$image_src = wp_get_attachment_image_src( $id, $attr['link'] );

		$attributes = soundcheck_gallery_lightbox_attributes( $instance );
		$attributes .= sprintf( ' href="%s"', esc_url( $image_src[0] ) );
		$attributes .= sprintf( ' title="%s"', esc_attr( $post->post_title ) );

		$image = preg_replace( '/<a.*?>(.*?)<\/a>/', "<a{$attributes}>$1</a>", $image );
	}

	/* Return the formatted image. */
	return $image;
	
}
add_filter( 'soundcheck_gallery_image','soundcheck_gallery_image', 10, 4 );


/**
 * Gallery Lightbox Attributes
 *
 * Add "view" class to enable view.js to function.
 * Also adds a unique rel attribute to associate
 * related iamges to display in view.js
 *
 * @see soundcheck_gallery_image()
 */
function soundcheck_gallery_lightbox_attributes( $instance ) {
	
	return sprintf( 'class="view thumbnail-icon gallery" rel="gallery-%s"', esc_attr( $instance ) );

}

