<?php
/**
 * Custom Theme Styles
 *
 * Apply custom styling set via Theme Options and print in head.
 * This is called via a wp_head() filter in admin.php. This file
 * is here to help keep this rather long function out of the way.
 *
 * @package Soundcheck
 * @since 1.0
 */
function soundcheck_custom_styles() {
$color_palette = soundcheck_style( 'color_palette' );

if ( 'custom' == $color_palette ) : ?>
<style type="text/css" id="custom-theme-styles-css">
	
	<?php
	$primary_1 = soundcheck_style( 'primary_1' );
	$primary_2 = soundcheck_style( 'primary_2' );
	$primary_3 = soundcheck_style( 'primary_3' );
	$primary_4 = soundcheck_style( 'primary_4' );
	
	$text_site_info = soundcheck_style( 'text_site_info' );
	$text_color = soundcheck_style( 'text_primary' );
	$link_color = soundcheck_style( 'link_color' );
	
	$text_shadows = soundcheck_style( 'text_shadows' );
	?>
	
<?php if ( isset( $text_shadows ) ) : ?>
/* TEXT SHADOW
----------------------------------------------- */
	#primary-nav, #main, .widget, #search input, .jp-audio, #hero .edit-link, #footer, #site-info, span.comments a {
		text-shadow: none;
	}
<?php endif; ?>

/* Global
----------------------------------------------- */
	body, button, input, textarea,
	h1, h2, h3, h4, h5, h6, 
	h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}
	
	blockquote {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>;
		<?php if ( isset( $text_color ) ) print 'color: rgba(' . hex2rgb( $text_color, '0.7' ) . ')' ?>; 
	}
	
	a, a:visited {
		<?php if ( isset( $link_color ) ) print 'color: ' . $link_color; ?>; 
	}

	a:hover {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}
	
	table tr td {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}
	
	pre {
		<?php if ( isset( $primary_4 ) ) print 'color: ' . $primary_4; ?>; 
		<?php if ( isset( $primary_1 ) ) print 'background-color: ' . $primary_1; ?>; 
	}
	
	hr {
		<?php if ( isset( $primary_2 ) ) print 'border-top-color: ' . $primary_2; ?>; 
	}
	
	.primary-1 { 
		<?php if ( isset( $primary_1 ) ) print 'background-color: ' . $primary_1; ?>; 
	}
	.primary-2 { 
		<?php if ( isset( $primary_2 ) ) print 'background-color: ' . $primary_2; ?>; 
	}
	.primary-3 { 
		<?php if ( isset( $primary_3 ) ) print 'background-color: ' . $primary_3; ?>; 
	}
	.primary-4 { 
		<?php if ( isset( $primary_4 ) ) print 'background-color: ' . $primary_4; ?>; 
	}
	
   a.button,
	.button,
	.prev.button,
	.next.button,
	.entry-header .post-edit-link,
	#page-header .post-edit-link {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
		<?php if ( isset( $primary_2 ) ) print 'background-color: ' . $primary_2; ?>; 
	}
	
   a.button:hover,
	.button:hover,
	.prev.button:hover,
	.next.button:hover,
	.entry-header .post-edit-link,
	#page-header .post-edit-link {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}
	
	.wp-caption {
		<?php if ( isset( $primary_4 ) ) print 'background-color: ' . $primary_4; ?>; 
	}
	
	/* FORMS */
	.search-form .search-field,
	form input[type=button],
	form input[type=submit],
	form .button {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?> !important; 
		<?php if ( isset( $primary_2 ) ) print 'background-color: ' . $primary_2; ?>!important; 
	}
	
	.search-form .search-submit:hover {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?> !important; 
	}
	
	
/* HEADER
----------------------------------------------- */
	/* Logo Area */
	#site-title a, 
	#site-info p { 
		<?php if ( isset( $text_site_info ) ) print 'color: ' . $text_site_info; ?>; 
	}
	
	/* Primary Nav */
	.top-border,
	#primary-nav {
		<?php if ( isset( $primary_3 ) ) print 'background: ' . $primary_3; ?>;
		<?php if ( isset( $primary_3 ) ) print 'background: rgba(' . hex2rgb( $primary_3, '0.97' ) . ')' ?>; 
	}

	#primary-nav a {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
	}
	
	#primary-nav a:hover,
	#primary-nav .current-menu-item,
	#primary-nav .current_page_item a {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}
	
	#primary-nav ul ul,
	#primary-nav li:hover {
		<?php if ( isset( $primary_4 ) ) print 'background-color: ' . $primary_4; ?>; 
	}

	#primary-nav li li:hover {
		<?php if ( isset( $primary_3 ) ) print 'background-color: ' . $primary_3; ?>; 
	}
	
	
/* MAIN
----------------------------------------------- */
	/* PAGE HEADER */
	#page-header {
		<?php if ( isset( $primary_3 ) ) print 'background-color: ' . $primary_3; ?>; 
	}
	
	#page-header .page-title span {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
	}
	
	/* CONTENT */
	#content .hentry,
	#content .entry-header {
		<?php if ( isset( $primary_3 ) ) print 'background-color: ' . $primary_3; ?>; 
	}
	
	#content .entry-meta .date a,
	#content .entry-title a {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}
	
	#content .entry-meta .author,
	#content .entry-title span,
	#content .entry-title span.comments {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
	}
	
	/* Formats */
	.format-gallery .entry-gallery {
		<?php if ( isset( $primary_4 ) ) print 'background-color: ' . $primary_4; ?>; 
	}
	
	/* Image Carousel */
	#image-carousel-container .lines span {
		<?php if ( isset( $primary_3 ) ) print 'border-bottom-color: ' . $primary_3; ?>; 
	}

	.jcarousel-skin .jcarousel-item .entry-thumbnail,
	.jcarousel-skin .jcarousel-prev,
	.jcarousel-skin .jcarousel-next {
		<?php if ( isset( $primary_3 ) ) print 'background-color: ' . $primary_3; ?>; 
	}


/* WIDGETS
----------------------------------------------- */
	.widget {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
		<?php if ( isset( $primary_3 ) ) print 'background-color: ' . $primary_3; ?>; 
	}
	
	.widget ul li li:before {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
	}
	
	.soundcheck_events_widget .event-title a,
	#events-date-list .post-edit-link,
	.soundcheck_latest_tweets_widget .name,
	.soundcheck_latest_tweets_widget li a,
	.soundcheck_featured_category_widget .entry-title a,
	.soundcheck_featured_category_widget .entry-title a:hover {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}

	.event,
	.soundcheck_latest_tweets_widget .username,
	.soundcheck_featured_category_widget .entry-date,
	#col-2 .soundcheck_featured_category_widget .widget-title span {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
	}
	

/* AUDIO PLAYER
----------------------------------------------- */
	.jp-content-view:hover,
	.jp-playlist-view:hover,
	.jp-content-view.open,
	.jp-playlist-view.open,
	.jp-current-track,
	.jp-notification-title,
	.jp-playlist a:hover,
	.jp-playlist li.jp-playlist-current,
	.jp-playlist li.jp-playlist-current a.jp-playlist-item {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}
	
	.jp-current-album,
	.jp-notification-description,
	.jp-current-time,
	.jp-playlist a {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
	}
	
	.jp-content-view:hover span,
	.jp-playlist-view:hover span,
	.jp-content-view.open span,
	.jp-playlist-view.open span {
		<?php if ( isset( $text_color ) ) print 'background-color: ' . $text_color; ?>; 
	}
	
	.jp-playlist-view span {
		<?php if ( isset( $primary_1 ) ) print 'background-color: ' . $primary_1; ?>; 
	}

	.jp-seek-bar {
		<?php if ( isset( $primary_2 ) ) print 'background-color: ' . $primary_2; ?>; 
	}
	
	.entry-media .jp-progress,
	.widget .jp-audio,
	.widget .jp-playlist,
	.widget .jp-progress-wrap .jp-play-bar {
		<?php if ( isset( $primary_3 ) ) print 'background-color: ' . $primary_3; ?>; 
	}
	
	.jp-play-bar,
	.widget .jp-progress-wrap .jp-progress,
	.widget .jp-progress-wrap .jp-seek-bar {
		<?php if ( isset( $primary_4 ) ) print 'background-color: ' . $primary_4; ?>; 
	}
	
/* COMMENTS
----------------------------------------------- */
	.children .comment-meta:before,
	#comments .comment-meta,
	#comments .comment-meta a,
	.leave-comment-link,
	.comments-rss a {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
	}
	
	#comments .comment-meta .comment-author-name,
	#comments .comment-meta .comment-author-name a,
	#comments .comment-moderation,
	#comments .comment-pagination a,
	#comments .comment-pagination a:hover,
	#comments .comment-pagination .current,
	#comments .comment-pagination .total {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}
	
	#respond .comments-rss a {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}
	
/* PAGINATION
----------------------------------------------- */
	.pagenavi {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
		<?php if ( isset( $primary_3 ) ) print 'background-color: ' . $primary_3; ?>; 
	}
	
	.pagenavi .page-numbers {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
		<?php if ( isset( $primary_2 ) ) print 'background-color: ' . $primary_2; ?>; 
	}
	
	.pagenavi .current {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
		<?php print 'background-color: rgba(0,0,0,0.2)'; ?>; 
	}
	
	.page-link {
		<?php if ( isset( $primary_1 ) ) print 'background-color: ' . $primary_1; ?>; 
	}
	
/* FOOTER
----------------------------------------------- */
	#footer {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
		<?php if ( isset( $primary_3 ) ) print 'background-color: ' . $primary_3; ?>; 
	}
	
	#footer a {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}
	
</style>
<?php endif; // end custom theme styles
}
add_action( 'wp_head', 'soundcheck_custom_styles' );


/**
 * HEX to RGB
 *
 * $rgb = hex2rgb( '#cc0' );
 * print_r( $rgb ); 
 *
 * @param $hex Hexidecimal string, 3 or 6 characters
 * @param $return format to return, string or array
 * @return string or array
 * @since 1.0
 */
function hex2rgb( $hex = '', $opacity = '', $return = 'string' ) {
	$hex = str_replace( '#', '', $hex );
	
	if(strlen($hex) == 3) {
	   $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
	   $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
	   $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
	   $r = hexdec( substr( $hex, 0, 2 ) );
	   $g = hexdec( substr( $hex, 2, 2 ) );
	   $b = hexdec( substr( $hex, 4, 2 ) );
	}
	
	$rgb = array( $r, $g, $b );
	
	if( ! empty( $opacity ) ) {
		$rgb = array( $r, $g, $b, number_format( $opacity, 2 ) );
	}
   
	switch ( $return ) {
   		case 'array':
			return $rgb; // returns the rgb values separated by commas
			break;
   		default:
			return implode( ',', $rgb ); // returns the rgb values separated by commas
			break;
	}
}