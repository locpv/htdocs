<?php

$options[] = array( 
	'name' => __( 'Customization Options', 'theme-it' ),
	'type' => 'heading'
);


/**
 * Logos
 */
$options[] = array( 
	'name'  => __( 'Logos', 'theme-it' ),
	'desc'  => __( 'The following options allow you to add your own custom logos.', 'theme-it' ),
	'class' => 'featured toggle-section',
	'type'  => 'info'
);

$options[] = array(
	'name'    => __( 'Miscellaneous Logo Options', 'theme-it' ),
	'desc'    => __( '', 'theme-it' ),
	'id'      => 'logo_options',
	'std'     => '',
	'type'    => 'multicheck',
	'options' => array( 
		'logo_text'        => __( 'Use a text based logo.', 'theme-it' ), 
		'site_description' => __( 'Hide site description below logo', 'theme-it' )
	)
);

$options[] = array( 
	'name' => __( 'Image Logo', 'theme-it' ),
	'desc' => __( 'Upload an image based logo for the website.', 'theme-it' ),
	'id'   => 'logo_image',
	'std'  => '',
	'type' => 'upload'
);


/**
 * Theme Styles
 */
$options[] = array( 
	'name' => __( 'Custom Theme Styles', 'theme-it' ),
	'desc' => __( 'Yes, enable custom theme styles. <strong>This option must be checked in order for the following options to take effect.</strong>', 'theme-it' ),
	'id'   => 'enable_styles',
	'std'  => 0,
	'class' => 'section-info featured',
	'type' => 'checkbox'
);


$options[] = array( 
	'name'  => __( 'NOTE:', 'theme-it' ),
	'desc'  => __( 'These Custom Theme Style options allow you to style the theme as a whole. It is not going to be perfect as there are many elements, borders, links, etc that need to be styled and accounted for. I have done my best to simplify this process as much as possible. Most of the items use the same color, as seen in the demo, and therefor have been broken down into 4 Primary Colors. Anything beyond these settings would need to be made via the stylesheet (style.css) located in the themes files. Go ahead, play around!', 'theme-it' ),
	'class' => 'section-info',
	'type'  => 'info'
);


/* Backgrounds
----------------------------------------------------------*/
$options[] = array( 
	'name'  => __( 'Background Styles', 'theme-it' ),
	'desc'  => __( 'Change background images and colors globally.', 'theme-it' ),
	'class' => 'featured toggle-section',
	'type'  => 'info'
);

$body_background_defaults = array('color' => '#3F434A', 'image' => esc_url( $imagepath ) . 'bg-lines-alpha.png', 'repeat' => 'repeat', 'position' => 'top left', 'attachment'=>'scroll');
$options[] = array(
	'name' => __( 'Background', 'theme-it' ),
	'desc' => __( 'This is the overall background color of your website. By default, a small transparent diagonal lined image overlays the background color. You can choose to upload your own image, remove this image, or keep it as is.', 'theme-it' ),
	'id'   => 'body_background',
	'std'  => $body_background_defaults,
	'type' => 'background'
);

$options[] = array( 
	'name' => __( 'Primary #1 (Lightest)', 'theme-it' ),
	'desc' => __( 'This tends to be the lightest of your Primary colors. It mainly effects links and a lighter version of the text (widget text color).', 'theme-it' ),
	'id'   => 'primary_1',
	'std'  => '#bec4cc',
	'type' => 'color'
);

$options[] = array( 
	'name' => __( 'Primary #2', 'theme-it' ),
	'desc' => __( 'Slightly darker color than Primary #1. This mainly effects borders on widget titles and the background of form input elements.', 'theme-it' ),
	'id'   => 'primary_2',
	'std'  => '#3F434A',
	'type' => 'color'
);

$options[] = array( 
	'name' => __( 'Primary #3', 'theme-it' ),
	'desc' => __( 'Slightly darker color than Primary #2. This mainly effects the main background color of the content, widgets, and navigation.', 'theme-it' ),
	'id'   => 'primary_3',
	'std'  => '#252A31',
	'type' => 'color'
);

$options[] = array( 
	'name' => __( 'Primary #4 (Darkest)', 'theme-it' ),
	'desc' => __( 'This tends to be the darkest of your Primary colors. It mainly effects the navigation hover and border colors.', 'theme-it' ),
	'id'   => 'primary_4',
	'std'  => '#191D22',
	'type' => 'color'
);


/* Text Colors
----------------------------------------------------------*/
$options[] = array( 
	'name'  => __( 'Text Styles', 'theme-it' ),
	'desc'  => __( 'Change text and link colors globally.', 'theme-it' ),
	'class' => 'featured toggle-section',
	'type'  => 'info'
);

$options[] = array( 
	'name' => __( 'Logo Text & Description Color', 'theme-it' ),
	'desc' => __( 'If the option to enable the a text based logo and/or the site description, select a color for that text.', 'theme-it' ),
	'id'   => 'text_color_site_info',
	'std'  => '#ffffff',
	'type' => 'color'
);

$options[] = array( 
	'name' => __( 'Text Color', 'theme-it' ),
	'desc' => __( 'This is the main text color of the site. Depending upon your Primary #3 color, you may want to change this to make the text stand out more.', 'theme-it' ),
	'id'   => 'text_color_primary',
	'std'  => '#ffffff',
	'type' => 'color'
);

$options[] = array( 
	'name' => __( 'Text Shadows', 'theme-it' ),
	'desc' => __( 'Remove text shadows. If you would like to remove the text shadows, check this box.', 'theme-it' ),
	'id'   => 'text_shadows',
	'std'  => 0,
	'type' => 'checkbox'
); 
