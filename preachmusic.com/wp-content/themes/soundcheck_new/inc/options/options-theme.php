<?php
/**
 * Theme Options
 *
 */
global $theme_options;

/* Setup Menu Item */
$theme_options = new Struts_Options( 'soundcheck_options', 'soundcheck_options', 'Theme Options' );

/* Setup Sections */
$theme_options->add_section( 'logo_section', __( 'Logo', 'soundcheck' ) );
$theme_options->add_section( 'general_section', __( 'General', 'soundcheck' ) );
$theme_options->add_section( 'hero_section', __( 'Hero Slider', 'soundcheck' ) );
$theme_options->add_section( 'carousel_section', __( 'Thumbnail Carousel', 'soundcheck' ) );
$theme_options->add_section( 'events_section', __( 'Events', 'soundcheck' ) );
$theme_options->add_section( 'audio_section', __( 'Audio Player', 'soundcheck' ) );
$theme_options->add_section( 'social_section', __( 'Social Media', 'soundcheck' ) );
$theme_options->add_section( 'footer_section', __( 'Footer', 'soundcheck' ) );

/* Setup Common Variables */
$categories = soundcheck_get_category_list();	


/* Setup Options */
// LOGO
$theme_options->add_option( 'logo_url', 'image', 'logo_section' )
    ->label( __( 'Logo URL:', 'soundcheck' ) )
    ->description( __( 'Your image can be any width and height.', 'soundcheck' ) );
    
$theme_options->add_option( 'text_logo_desc', 'checkbox', 'logo_section' )
    ->label( __( 'Enable Site Tagline', 'soundcheck' ) )
    ->description( __( 'Display your site tagline beneath your text/image based logo.', 'soundcheck' ) );


// General Section
$theme_options->add_option( 'blog_category', 'select', 'general_section' )
    ->label( __( 'Blog Category', 'soundcheck' ) )
    ->description( __( 'Select a category to be used for the blog.', 'soundcheck' ) )
    ->valid_values( $categories );

$theme_options->add_option( 'featured_primary_home_sidebar', 'checkbox', 'general_section' )
    ->label( __( 'Featured Sidebar - Home Col. 1', 'soundcheck' ) )
    ->description( __( 'This option pulls the first home page widget column up over the hero area.', 'soundcheck' ) );
    
$theme_options->add_option( 'featured_primary_sidebar', 'checkbox', 'general_section' )
    ->label( __( 'Featured Sidebar - Primary', 'soundcheck' ) )
    ->description( __( 'This option pulls the primary sidebar widgets up over the hero area', 'soundcheck' ) );

$theme_options->add_option( 'featured_primary_product_sidebar', 'checkbox', 'general_section' )
    ->label( __( 'Featured Sidebar - Primary Products ', 'soundcheck' ) )
    ->description( __( 'This option pulls the Primary Products sidebar widgets up over the hero area.', 'soundcheck' ) );


  
// Hero Slider Section
$default_hero_slide = get_cat_ID( 'hero-slides' );
$theme_options->add_option( 'hero_category', 'select', 'hero_section' )
    ->label( __( 'Category', 'soundcheck' ) )
    ->description( __( 'Select a category to be used for the Hero slides.', 'soundcheck' ) )
    ->default_value( $default_hero_slide )
    ->valid_values( $categories );
    
$theme_options->add_option( 'hero_count', 'select', 'hero_section' )
    ->label( __( 'Max Slide Count', 'soundcheck' ) )
    ->description( __( 'Max Number of slides to display in the carousel.', 'soundcheck' ) )
    ->default_value( '5' )
    ->valid_values( array(
        '1' => __( '1', 'soundcheck' ),
        '2' => __( '2', 'soundcheck' ),
        '3' => __( '3', 'soundcheck' ),
        '4' => __( '4', 'soundcheck' ),
        '5' => __( '5', 'soundcheck' ),
        '6' => __( '6', 'soundcheck' ),
        '7' => __( '7', 'soundcheck' ),
        '8' => __( '8', 'soundcheck' ),
        '9' => __( '9', 'soundcheck' ),
        '10' => __( '10', 'soundcheck' )
    ));
        
$theme_options->add_option( 'hero_randomize', 'checkbox', 'hero_section' )
    ->label( __( 'Randomize Slides', 'soundcheck' ) )
    ->description( __( 'Yes, display slides in random order.', 'soundcheck' ) );

$theme_options->add_option( 'hero_fx', 'select', 'hero_section' )
    ->label( __( 'Slide Animation', 'soundcheck' ) )
    ->description( __( 'Choose a type of animation for each slide transition.', 'soundcheck' ) )
    ->default_value( 'scrollVert' )
    ->valid_values( array(
        'scrollVert' => __( 'Slide (vertical)', 'soundcheck' ),
        'fade' => __( 'Fade', 'soundcheck' ) 
    ));

$theme_options->add_option( 'hero_speed', 'text', 'hero_section' )
    ->label( __( 'Hero Slider Speed', 'soundcheck' ) )
    ->description( __( 'Speed (in seconds) at which the slides will animate between transitions.', 'soundcheck' ) )
    ->default_value( 1 );

$theme_options->add_option( 'hero_timeout', 'text', 'hero_section' )
    ->label( __( 'Hero Slider Timeout', 'soundcheck' ) )
    ->description( __( 'Time (in seconds) before transitioning to the next slide. Leave empty to disable.', 'soundcheck' ) )
    ->default_value( 6 );  


// Featured Image Carousel Section
$theme_options->add_option( 'carousel_category', 'select', 'carousel_section' )
    ->label( __( 'Thumbnail Carousel Category', 'soundcheck' ) )
    ->description( __( 'Select which category should be shown in the image carousel. By default, all categories will be used.', 'soundcheck' ) )
    ->valid_values( $categories );

$theme_options->add_option( 'carousel_count', 'text', 'carousel_section' )
    ->label( __( 'Thumbnail Count', 'soundcheck' ) )
    ->description( __( 'Max Number of thumbnails to display in the carousel.', 'soundcheck' ) )
    ->default_value( 10 );  

$theme_options->add_option( 'carousel_home', 'checkbox', 'carousel_section' )
    ->label( __( 'Home Page', 'soundcheck' ) )
    ->description( __( 'Enable carousel on the home page?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_multiple', 'checkbox', 'carousel_section' )
    ->label( __( 'Multiple Post Page', 'soundcheck' ) )
    ->description( __( 'Enable carousel on  multiple post page?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_single', 'checkbox', 'carousel_section' )
    ->label( __( 'Single Post Pages', 'soundcheck' ) )
    ->description( __( 'Enable carousel on single post page?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_pages', 'checkbox', 'carousel_section' )
    ->label( __( 'Page - Regular', 'soundcheck' ) )
    ->description( __( 'Enable carousel on regular pages?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_product', 'checkbox', 'carousel_section' )
    ->label( __( 'Page - Product', 'soundcheck' ) )
    ->description( __( 'Enable carousel on product type pages? Requires Cart66 Plugin.', 'soundcheck' ) );

$theme_options->add_option( 'carousel_discography', 'checkbox', 'carousel_section' )
    ->label( __( 'Page - Discography', 'soundcheck' ) )
    ->description( __( 'Enable carousel on the discography page?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_events', 'checkbox', 'carousel_section' )
    ->label( __( 'Page - Events', 'soundcheck' ) )
    ->description( __( 'Enable carousel on Event type pages?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_full', 'checkbox', 'carousel_section' )
    ->label( __( 'Page - Full Width', 'soundcheck' ) )
    ->description( __( 'Enable carousel on the full width type pages?', 'soundcheck' ) );


// Events Section
$theme_options->add_option( 'events_category', 'select', 'events_section' )
    ->label( __( 'Events Category', 'soundcheck' ) )
    ->description( __( 'Select a category to be used for the events.', 'soundcheck' ) )
    ->valid_values( soundcheck_get_category_list( true ) );

$theme_options->add_option( 'events_per_page', 'text', 'events_section' )
    ->label( __( 'Events Per Page', 'soundcheck' ) )
    ->description( __( 'Max Number of events to display per page.', 'soundcheck' ) )
    ->default_value( 20 );  

    
// Audio Section
$theme_options->add_option( 'audio_single_playlist', 'checkbox', 'audio_section' )
    ->label( __( 'Single Pages - Display Playlist', 'soundcheck' ) )
    ->description( __( 'Display playlist by default on single audio post pages.', 'soundcheck' ) );

$theme_options->add_option( 'audio_single_autoplay', 'checkbox', 'audio_section' )
    ->label( __( 'Single Pages - Autoplay Audio?', 'soundcheck' ) )
    ->description( __( 'Autoplay audio by default on single audio post pages.', 'soundcheck' ) );

$theme_options->add_option( 'audio_discography_content', 'checkbox', 'audio_section' )
    ->label( __( 'Discography Template - Display Content', 'soundcheck' ) )
    ->description( __( 'Display current track content for audio players on the Discography Page template.', 'soundcheck' ) );
    
$theme_options->add_option( 'audio_discography_playlist', 'checkbox', 'audio_section' )
    ->label( __( 'Discography Template - Display Playlist Button', 'soundcheck' ) )
    ->description( __( 'Display the playlist button for audio players on the Discography Page template.', 'soundcheck' ) );


// Social Media Section
$theme_options->add_option( 'social_rss', 'checkbox', 'social_section' )
    ->label( __( 'RSS', 'soundcheck' ) )
    ->description( __( 'Display RSS Icon', 'soundcheck' ) );
    
$theme_options->add_option( 'feedburner_url', 'text', 'social_section' )
    ->label( __( 'FeedBurner', 'soundcheck' ) )
    ->description( __( 'Provide your <a href="http://feedburner.google.com" title="Go to FeedBurner" target="_blank">FeedBurner</a> feed to enable this functionality. The RSS icon must be enabled above.', 'soundcheck' ) );    


// Social Media Section
$social_media = array(
	'amazon'     => __( 'Amazon', 'soundcheck' ),
	'bandcamp'   => __( 'Bandcamp', 'soundcheck' ),
	'facebook'   => __( 'Facebook', 'soundcheck' ),
	'flickr'     => __( 'Flickr', 'soundcheck' ),
	'itunes'     => __( 'iTunes', 'soundcheck' ),
	'lastfm'     => __( 'Last.fm', 'soundcheck' ),
	'myspace'    => __( 'MySpace', 'soundcheck' ),
	'soundcloud' => __( 'SoundCloud', 'soundcheck' ),
	'twitter'    => __( 'Twitter', 'soundcheck' ),
	'vimeo'      => __( 'Vimeo', 'soundcheck' ),
	'youtube'    => __( 'YouTube', 'soundcheck' )
);

foreach( $social_media as $key => $value ) :
	$theme_options->add_option( "social_$key", 'text', 'social_section' )
    ->label( esc_html( $value ) )
    ->description( __( 'Provide URL including http://', 'soundcheck' ) );
endforeach;


// Footer
$theme_options->add_option( 'footer_copyright', 'textarea', 'footer_section' )
    ->label( __( 'Footer Text', 'soundcheck' ) )
    ->description( __( 'Set the text to be displayed in the footer.', 'soundcheck' ) );


/* Initialize Options */
$theme_options->initialize();

?>