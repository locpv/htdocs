<?php

$options[] = array( 
	'name' => __( 'Content Options', 'theme-it' ),
	'type' => 'heading'
);


/**
 * Hero Slider
 */
$options[] = array( 
	'name' => __( 'Hero Content Slider', 'theme-it' ),
	'desc' => __( 'The following options are to handle general content and functionality.', 'theme-it' ),
	'class' => 'featured toggle-section',
	'type' => 'info'
);

$options[] = array( 
	'name' => __( 'Randomize Slides', 'theme-it' ),
	'desc' => __( 'Yes, display slides in random order.', 'theme-it' ),
	'id'   => 'hero_randomize',
	'std'  => 0,
	'type' => 'checkbox'
);

$options[] = array( 
	'name' => __( 'Slide Animation', 'theme-it' ),
	'desc' => __( 'Choose to show a vertical slide or fade animation. Horizontal slide is not an option because of large image width variables.', 'theme-it' ),
	'id'   => 'hero_fx',
	'std'     => 'Select an animation:',
	'type'    => 'select',
	'options' => array(
		'scrollVert' => 'Slide (vertical)',
		'fade'  => 'Fade'
	)
);

$options[] = array( 
  'name'  => __( 'Hero Slider Speed', 'theme-it' ),
  'desc'  => __( 'Speed (in seconds) at which the slides will animate between transitions.', 'theme-it' ),
  'id'    => 'hero_speed',
  'std'   => '1',
  'class' => 'mini',
  'type'  => 'text'
);

$options[] = array( 
  'name'  => __( 'Hero Slider Timeout', 'theme-it' ),
  'desc'  => __( 'Time (in seconds) before transitioning to the next slide. Leave empty to disable.', 'theme-it' ),
  'id'    => 'hero_timeout',
  'std'   => '6',
  'class' => 'mini',
  'type'  => 'text'
);



/**
 * Featured Image Carousel
 */
$options[] = array( 
	'name' => __( 'Featured Image Carousel', 'theme-it' ),
	'desc' => __( 'The following options allow you to set and control the featured image carousel.', 'theme-it' ),
	'class' => 'featured toggle-section',
	'type' => 'info'
);

$options[] = array(
	'name'    => __( 'Featured Category', 'theme-it' ),
	'desc'    => __( 'Select which category should be shown in the image carousel. By default, all categories will be shown.', 'theme-it' ),
	'id'      => 'image_carousel_category',
	'std'     => 'Select a category:',
	'type'    => 'select',
	'options' => $options_categories
);

$options[] = array(
	'name'    => __( 'Page Locations', 'theme-it' ),
	'desc'    => __( 'Choose to show a featured image carousel above the content on the following page types:', 'theme-it' ),
	'id'      => 'image_carousel_enable',
	'std'     => array( 'home' => 'Home Page' ),
	'type'    => 'multicheck',
	'options' => array( 
		'single' => 'Single Post Pages', 
		'page' => 'Page Pages', 
		'multiple' => 'Multiple Post Pages', 
		'postpage' => 'Page Template: Custom Post Page', 
		'gallery' => 'Page Template: Custom Post Gallery', 
		'gigpress' => 'Page Template: GigPress', 
		'fullwidth' => 'Page Template: Full Width', 
		'discography' => 'Page Template: Discography' 
	)
);


/**
 * Audio Player
 */
$options[] = array( 
	'name' => __( 'Audio Player', 'theme-it' ),
	'desc' => __( 'The following options allow you to set and control the audio player.', 'theme-it' ),
	'class' => 'featured toggle-section',
	'type' => 'info'
);

$options[] = array(
	'name'    => __( 'Audio Player Featured Album', 'theme-it' ),
	'desc'    => __( 'Select an album that will be displayed in the audio player.', 'theme-it' ),
	'id'      => 'audio_player_album',
	'std'     => '',
	'type'    => 'select',
	'options' => $options_albums
);

$options[] = array( 
	'name' => __( 'Playlist', 'theme-it' ),
	'desc' => __( 'Enable playlist. By checking this box, the button to show and hide the playlist will be visible. In some cases, the desired album will have too many songs to display nicely when the playlist is visible.', 'theme-it' ),
	'id'   => 'audio_player_playlist',
	'std'  => 0,
	'type' => 'checkbox'
);

$options[] = array( 
	'name' => __( 'Auto Play', 'theme-it' ),
	'desc' => __( 'Enable auto play functionality. By checking this box, the audio play will begin playing automatically ONLY on the Home page. This is for the sake of the user, not having to pause the player on each page load, which could drive traffic away.', 'theme-it' ),
	'id'   => 'audio_player_autoplay',
	'std'  => 0,
	'type' => 'checkbox'
);



/**
 * Social Media
 */
$options[] = array( 
	'name' => __( 'Social Media', 'theme-it' ),
	'desc' => __( 'The following options allow you to enter info for a few social media networks available.', 'theme-it' ),
	'class' => 'featured toggle-section',
	'type' => 'info'
);

$options[] = array( 
	'name' => __( 'RSS Icon', 'theme-it' ),
	'desc' => __( 'Enable RSS Icon', 'theme-it' ),
	'id'   => 'social_rss',
	'std'  => 1,
	'type' => 'checkbox'
);

$options[] = array( 
	'name' => __( 'FeedBurner', 'theme-it' ),
	'desc' => __( 'Provide your <a href="http://feedburner.google.com" title="Go to FeedBurner" target="_blank">FeedBurner</a> feed name to enable this functionality. The RSS icon must be enabled above.', 'theme-it' ),
	'id'   => 'feedburner_url',
	'std'  => '',
	'type' => 'text'
);

$options[] = array( 
	'name' => __( 'Amazon', 'theme-it' ),
	'desc' => __( 'Provide the full link to your Amazon page.', 'theme-it' ),
	'id'   => 'social_amazon',
	'std'  => '',
	'type' => 'text'
);

$options[] = array( 
	'name' => __( 'iTunes', 'theme-it' ),
	'desc' => __( 'Provide the full link to your iTunes page.', 'theme-it' ),
	'id'   => 'social_itunes',
	'std'  => '',
	'type' => 'text'
);

$options[] = array( 
	'name' => __( 'SoundCloud', 'theme-it' ),
	'desc' => __( 'Provide your username.', 'theme-it' ),
	'id'   => 'social_soundcloud',
	'std'  => '',
	'type' => 'text'
);

$options[] = array( 
	'name' => __( 'Bandcamp', 'theme-it' ),
	'desc' => __( 'Provide your username.', 'theme-it' ),
	'id'   => 'social_bandcamp',
	'std'  => '',
	'type' => 'text'
);

$options[] = array( 
	'name' => __( 'MySpace', 'theme-it' ),
	'desc' => __( 'Provide your username.', 'theme-it' ),
	'id'   => 'social_myspace',
	'std'  => '',
	'type' => 'text'
);

$options[] = array( 
	'name' => __( 'Last.fm', 'theme-it' ),
	'desc' => __( 'If a user, enter "user/your_username. If a musician, enter "music/musician+name', 'theme-it' ),
	'id'   => 'social_lastfm',
	'std'  => '',
	'type' => 'text'
);

$options[] = array( 
	'name' => __( 'Twitter', 'theme-it' ),
	'desc' => __( 'Provide your username.', 'theme-it' ),
	'id'   => 'social_twitter',
	'std'  => '',
	'type' => 'text'
);

$options[] = array( 
	'name' => __( 'Facebook', 'theme-it' ),
	'desc' => __( 'Provide your username.', 'theme-it' ),
	'id'   => 'social_facebook',
	'std'  => '',
	'type' => 'text'
);

$options[] = array( 
	'name' => __( 'Vimeo', 'theme-it' ),
	'desc' => __( 'Provide your username.', 'theme-it' ),
	'id'   => 'social_vimeo',
	'std'  => '',
	'type' => 'text'
);

$options[] = array( 
	'name' => __( 'YouTube', 'theme-it' ),
	'desc' => __( 'Provide your username.', 'theme-it' ),
	'id'   => 'social_youtube',
	'std'  => '',
	'type' => 'text'
);

$options[] = array( 
	'name' => __( 'Flickr', 'theme-it' ),
	'desc' => __( 'Provide your username.', 'theme-it' ),
	'id'   => 'social_flickr',
	'std'  => '',
	'type' => 'text'
);


/**
 * Footer
 */
$options[] = array( 
	'name' => __( 'Footer Text', 'theme-it' ),
	'desc' => __( 'The following options updated the text in the footer at the bottom of each page.', 'theme-it' ),
	'class' => 'featured toggle-section',
	'type' => 'info'
);

$options[] = array( 
	'name' => __( 'Copyright Text', 'theme-it' ),
	'desc' => __( 'Enable "Copyright" text by entering your business name.', 'theme-it' ),
	'id'   => 'footer_copyright',
	'std'  => '',
	'type' => 'text'
);


