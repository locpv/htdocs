<?php
define( 'VERSION', '2.4.1' );

function soundcheck_version_id() {
	
	if ( WP_DEBUG )
		return time();
	
	return VERSION;
	
}


/**
 * Theme Setup
 *
 * If you would like to customize the theme setup you
 * are encouraged to adopt the following process.
 *
 * <ol>
 * <li>Create a child theme with a functions.php file.</li>
 * <li>Create a new function named mythemesoundcheck_setup_soundcheck().</li>
 * <li>Hook this function into the 'after_setup_theme' action at or after 11.</li>
 * <li>call remove_filter(), remove_action() and/or remove_theme_support() as needed.</li>
 * </ol>
 *
 * @return void
 *
 * @since 1.0
 */
function soundcheck_setup_theme() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	
	// Text domain setup
	load_theme_textdomain( 'soundcheck', get_template_directory() . '/lang' );
	
	// Add editor styles
	add_editor_style( 'css/theme-editor.css' );
	
	// Add page excrpt
	add_post_type_support( 'page', 'excerpt' );
	
	// Add automatic feed links in header
	add_theme_support( 'automatic-feed-links' );
				
	// Add support for post formats
	add_theme_support( 'post-formats', array( 'audio', 'gallery', 'image', 'video' ) );
	
	// Post Thumbnail Image sizes and support
	add_theme_support( 'post-thumbnails' );
	
	// Set post thumbnail size
	set_post_thumbnail_size(        220,  220, true );
	
	// Add themes custom image sizes
	add_image_size( 'theme-medium',   440,  248, true );
	add_image_size( 'theme-large',    680,  383, true );
	add_image_size( 'theme-full',     910,  511, true );
	add_image_size( 'theme-hero',     1600, 440, true );
	add_image_size( 'theme-icon',     100, 100, true );
	add_image_size( 'theme-carousel', 120, 66,  true );

	// Add support for navigation menus
	add_theme_support( 'menus' );

	// Register navigation menus.
	register_nav_menus( array( 'primary' => 'Primary' ) );

	// Audio Track Details
	locate_template( 'inc/audio-track-details.php', true );

	// Load custom metaboxes
	locate_template( 'inc/metaboxes/metabox-setup.php', true );

	// Load custom shortcodes
	locate_template( 'inc/shortcodes/audio-player.php', true );

	// Load custom widgets
	locate_template( 'inc/widgets/audio-player.php', true );
	locate_template( 'inc/widgets/events.php', true );
	locate_template( 'inc/widgets/featured-category.php', true );
	locate_template( 'inc/widgets/featured-post.php', true );
	locate_template( 'inc/widgets/latest-tweets.php', true );
	locate_template( 'inc/widgets/social-sharing.php', true );

	// Initialize theme options
	locate_template( 'inc/options/options-setup.php', true );
	soundcheck_options_init();

}
add_action( 'after_setup_theme', 'soundcheck_setup_theme' );


/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Width based on a page with a left or right sidebar being displayed.
 *
 * @since 1.0.0
 */
if ( ! isset( $content_width ) )
	$content_width = 680; /* pixels */


/**
 * Adjust the content width on pages without sidebars or 
 * with both left and right sidebars showing.
 *
 * @since 2.0.3
 */
function soundcheck_set_content_width() {
	
	global $content_width;
	
	// full width pages
	if ( ! soundcheck_has_left_sidebar() && ! soundcheck_has_right_sidebar() )
		$content_width = 910; /* pixels */

	// pages with both left and right sidebars
	if ( soundcheck_has_left_sidebar() && soundcheck_has_right_sidebar() )
		$content_width = 440; /* pixels */
		
}
add_action( 'template_redirect', 'soundcheck_set_content_width' );


/**
 * Implement the Custom Background feature
 *
 * @since 1.0.0
 */
require( get_template_directory() . '/inc/custom-background.php' );


/**
 * Include custom styles setup
 *
 * @since 1.0.0
 */
require( get_template_directory() . '/inc/custom-styles.php' );


/**
 * Include Supported Plugin Functionality
 *
 * @since 2.1.0
 */
function soundcheck_supported_plugins_init() {
	$supported_plugins = soundcheck_supported_plugins();
	$supported_plugins_path = apply_filters( 'soundcheck_supported_plugins_path', 'inc/plugins' );
	
	foreach( (array) $supported_plugins as $plugin => $value ) {
		if ( soundcheck_plugin_active( $plugin ) ) 
			locate_template( "$supported_plugins_path/$plugin/functions.php", true );
	}
}
soundcheck_supported_plugins_init();


/**
 * Supported Plugins
 *
 * An array of plugin names and their plugin folder and init file names.
 * This is used by soundcheck_plugin_active(), which in return uses
 * is_plugin_active(), which requires the plugin location and a file.
 *
 * @returns array
 * @since 2.1.0
 */
function soundcheck_supported_plugins() {

	$plugins = array( 
		'cart66'        => 'cart66/cart66.php', 
		'cart66-lite'   => 'cart66-lite/cart66.php', 
		'gigpress'      => 'gigpress/gigpress.php', 
		'gravity-forms' => 'gravityforms/gravityforms.php'
	);
	
	return apply_filters( 'soundcheck_supported_plugins', $plugins );
	
}


/**
 * Plugin Active Check
 *
 * Check to see if a given plugin is supported
 * and active. 
 *
 * @param string $plugin Name of the plugin to check
 * @since 2.1.0
 */
function soundcheck_plugin_active( $plugin ) {

	$supported = soundcheck_supported_plugins();
	
	if ( ! array_key_exists( $plugin, $supported ) )
		return false;
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
	foreach( (array) $supported as $slug => $file ) :
		if ( $slug == 'cart66-lite' )
			$slug = 'cart66';

		if ( $plugin == $slug && is_plugin_active( $file ) )
			return true;
	endforeach;
	
	return false;

}


if ( ! function_exists( 'soundcheck_theme_styles' ) ) :
/**
 * Load Required Theme Styles
 *
 * @since 1.0
 */
function soundcheck_theme_styles() {

	wp_enqueue_style( 'soundcheck_style', get_stylesheet_uri(), array(), soundcheck_version_id() );
	wp_enqueue_style( 'soundcheck_gfont_oswald', 'http://fonts.googleapis.com/css?family=Oswald', false, '' );

}
endif;
add_action( 'wp_enqueue_scripts', 'soundcheck_theme_styles' );


/**
 * Load Required Theme Scripts
 *
 * @since 1.0
 */
if ( ! function_exists( 'soundcheck_theme_scripts' ) ) :
function soundcheck_theme_scripts() {
	
	wp_enqueue_script( 'soundcheck_modernizr', get_template_directory_uri() . '/js/modernizr.js' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'soundcheck_theme', get_template_directory_uri() . '/js/theme.js', 'jquery', soundcheck_version_id(), true );
	wp_enqueue_script( 'soundcheck_view', get_template_directory_uri() . '/js/view.js', array( 'jquery' ), soundcheck_version_id() . '&view', true );

	if ( is_singular() ) {
		if ( comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	
}
endif;
add_action( 'wp_enqueue_scripts', 'soundcheck_theme_scripts' );


if ( ! function_exists( 'soundcheck_localize_hero' ) ) :
/**
 * Localize Hero Slider Options
 * 
 * Localize values from theme options for use in javascript
 *
 * @since 2.0
 */
function soundcheck_localize_hero() {
	
	$hero_fx      = soundcheck_option( 'hero_fx', 'scrollVert' );
	$hero_speed   = soundcheck_option( 'hero_speed', 1 );
	$hero_timeout = soundcheck_option( 'hero_timeout' );

	$hero_options = array(
		'hero_fx'      => esc_html( $hero_fx ),
		'hero_speed'   => absint( $hero_speed ) * 1000,
		'hero_timeout' => ( 0 == $hero_timeout || empty( $hero_timeout ) ) ? 0 : absint( soundcheck_option( 'hero_timeout', 6 ) ) * 1000
	);
	
	wp_localize_script( 'soundcheck_theme', 'hero_options', $hero_options );
	
}
endif;
add_action( 'wp_enqueue_scripts', 'soundcheck_localize_hero' );


if ( ! function_exists( 'soundcheck_localize_audio' ) ) :
/**
 * Localize jPlayer (audio)
 * 
 * Localize audio files found in post's gallery
 *
 * @return void
 * @since 1.0
 */
function soundcheck_localize_audio() {

	/* Default options */
	$defaults = array(
		'enable_autoplay' => 0,
		'enable_playlist' => 0
	);
	
	$options = array();
	
	if ( is_single() ) :
		$options = array(
			'enable_autoplay' => soundcheck_option( 'audio_single_autoplay' ) ? 1 : 0,
			'enable_playlist' => soundcheck_option( 'audio_single_playlist' ) ? 1 : 0
		);
	endif;
	
	/* Merge audio options */
	$options = wp_parse_args( $options, $defaults );
	
	$tracks = soundcheck_discography_query();
	
	/* Set up param object for localization */
	$params = array(
	    'get_template_directory_uri' => get_template_directory_uri(),
	    'options' => $options,
        'format_audio' => $tracks
	);
	    
	/* Localize params to be used in JS */
	wp_localize_script(	'soundcheck_theme', 'jplayer_params', $params );
	
}
endif;
add_action( 'wp_enqueue_scripts', 'soundcheck_localize_audio' );


if ( ! function_exists( 'soundcheck_localize_view' ) ) :
/**
 * Localize View.js (gallery lightbox). 
 * 
 * Localize gallery images for use in view.js
 *
 * @return void
 * @since 1.0
 */
function soundcheck_localize_view() {
	
	$gallery_sets = array();
	
	if ( has_post_format( 'gallery' ) ) {
		if ( false === ( $galleries = get_transient( 'soundcheck_gallery_format_query' ) ) ) {
			$args = array(
			    'posts_per_page' => -1,
			    'tax_query' => array(
			    	array (
			    		'taxonomy' => 'post_format',
			    		'field' => 'slug',
			    		'terms' => 'post-format-gallery'
			    	)
			  	)
			);
			
    		$galleries = get_posts( $args );
    		
			/* Set transient with the $tracks data! */
			set_transient( 'soundcheck_gallery_format_query', $galleries );
    	} // end transient check

		global $post;
		
		
    	foreach( $galleries as $post ) : 
    	    setup_postdata( $post );    	
		    
		    /** Get images for post and add theme to $gallery */
		    if ( $images = get_children( array(
		    	'post_parent'    => get_the_ID(),
		    	'post_type'      => 'attachment',
		    	'numberposts'    => -1,
		    	'post_status'    => null,
		    	'post_mime_type' => 'image',
		    	'order'          => 'ASC',
		    	'orderby'        => 'menu_order'
		    ) ) ) {
		    	$gallery = array();
		    	
		    	foreach( (array) $images as $image ) {
		    		$image_src = wp_get_attachment_image_src( $image->ID, 'large' );
		    		
		    		$gallery[] = array(
		    			'src' => $image_src[0],
		    			'caption' => apply_filters( 'the_title', $image->post_title )
		    		);
		    	}
		    	
		    	$gallery_sets[get_the_ID()] = $gallery;
		    }		
    	endforeach;
    	
    	wp_reset_postdata();
	} // end page template check
	
	// JSON encode playlist
	$gallery_sets = json_encode( $gallery_sets );
	
	// Set up param object for localization
	$params = array(
        'gallery_views' => $gallery_sets
	);
	
	// Localize params to be used in JS
	wp_localize_script(	'soundcheck_view', 'gallery_params', $params );
	
}
endif;
add_action( 'wp_enqueue_scripts', 'soundcheck_localize_view' ); // Get images for view.js lightbox


if ( ! function_exists( 'soundcheck_main_query_pre_get_posts' ) ) :
/**
 * Main Query - Pre Get Posts
 *
 * Modify main query to show Category set in Theme Options if set.
 *
 * @param WP_Query $query
 * @return WP_Query
 * @since 2.0
 */
function soundcheck_main_query_pre_get_posts( $query ) {
	
	// Bail if not home, not a query, not main query
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() )
		return;
		
	$query->set( 'cat', soundcheck_option( 'blog_category', null ) );
	$query->set( 'paged', soundcheck_get_paged_query_var() );
	
}
endif;
add_action( 'pre_get_posts', 'soundcheck_main_query_pre_get_posts' );


if ( ! function_exists( 'soundcheck_register_sidebars' ) ) :
/**
 * Register Sidebars
 *
 * @since 1.0
 */
function soundcheck_register_sidebars() {
	
	register_sidebar( array(
		'id'            => 'home-column-1',
		'name'          => __( 'Home Column 1', 'soundcheck' ),
		'description'   => __( 'Shown in first column of home page.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'home-column-2',
		'name'          => __( 'Home Column 2', 'soundcheck' ),
		'description'   => __( 'Shown in second column of home page.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'home-column-3',
		'name'          => __( 'Home Column 3', 'soundcheck' ),
		'description'   => __( 'Shown in third column of home page.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-primary',
		'name'          => __( 'Primary Sidebar - All Pages', 'soundcheck' ),
		'description'   => __( 'Shown on all pages in left sidebar.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-secondary-single',
		'name'          => __( 'Secondary Sidebar - Single', 'soundcheck' ),
		'description'   => __( 'Shown on single post pages.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-secondary-page',
		'name'          => __( 'Secondary Sidebar - Page', 'soundcheck' ),
		'description'   => __( 'Shown on page type pages.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-secondary-multiple',
		'name'          => __( 'Secondary Sidebar - Multiple', 'soundcheck' ),
		'description'   => __( 'Shown on pages with multiple posts.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
			
}
endif;
add_action( 'widgets_init', 'soundcheck_register_sidebars' );
