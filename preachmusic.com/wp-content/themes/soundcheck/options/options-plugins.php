<?php

$options[] = array( 
  'name' => __( 'Plugins', 'theme-it' ),
  'type' => 'heading'
);

$options[] = array( 
  'name'  => __( 'Plugin Compatibility and Styles', 'theme-it' ),
  'desc'  => __( 'This theme comes styled for a variety of popular WordPress plugins that do a specific job nicely. Because there is no sense in recreating the wheel, I have simply included styles and configuration for the plugins below. Simply upload/install/active any one of the following plugins and the theme will do the rest.', 'theme-it' ),
  'class' => 'featured',
  'type'  => 'info'
);

$options[] = array( 
  'name' => __( 'GigPress', 'theme-it' ),
  'desc' => __( 'Soundcheck comes pre-styled for use with GigPress. GigPress is a powerful free WordPress plugin designed for musicians and other performers. Manage all of your upcoming and past performances right from within the WordPress admin, and display them on your site using simple shortcodes, PHP template tags, or the GigPress widget on your WordPress-powered website.', 'theme-it' ) . ' <a href="http://gigpress.com/" title="Get GigPress" target="_blank"><strong>' . __( 'Get Plugin', 'theme-it' ) . ' &rarr;</strong></a>',
  'class' => 'checkmark',
  'type'  => 'info'
);

$options[] = array( 
  'name' => __( 'Audio Player', 'theme-it' ),
  'desc' => __( 'Soundcheck comes equipped and ready to play your album tracks via the Audio Player Plugin. Audio Player is a highly configurable but simple mp3 player for all your audio needs. You can customize the player\'s colour scheme to match your blog. Simply install the plugin and your good to go. ', 'theme-it' ) . '<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=audio-player&TB_iframe=true&width=640&height=517' ) . '" title="Get Plugin" class="thickbox onclick"><strong>' . __( 'Get Plugin', 'theme-it' ) . ' &rarr;</strong></a>',
  'class' => 'checkmark',
  'type'  => 'info'
);

$options[] = array( 
  'name' => __( 'Gravity Forms Plugin', 'theme-it' ),
  'desc' => __( 'Contact forms for WordPress just don\'t get any easier than Gravity Forms, a premium plugin that is worth it\'s weight in platinum.', 'theme-it' ) . ' <a href="https://www.e-junkie.com/ecom/gb.php?cl=54585&c=ib&aff=115989" title="Get Gravity Forms" target="_blank"><strong>' . __( 'Get Plugin', 'theme-it' ) . ' &rarr;</strong></a>',
  'class' => 'checkmark',
  'type'  => 'info'
);

$options[] = array( 
  'name' => __( 'WP-PageNavi Plugin', 'theme-it' ),
  'desc' => __( 'Adds a more advanced paging navigation to your WordPress site.', 'theme-it' ) . ' <a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=wp-pagenavi&TB_iframe=true&width=640&height=517' ) . '" title="Get WP-PageNavi"  class="thickbox onclick"><strong>' . __( 'Get Plugin', 'theme-it' ) . ' &rarr;</strong></a>',
  'class' => 'checkmark',
  'type'  => 'info'
);

$options[] = array( 
  'name' => __( 'AJAX Thumbnail Rebuild Plugin', 'theme-it' ),
  'desc' => __( 'This is a highly recommended plugin to use when switching themes. AJAX Thumbnail Rebuild allows you to rebuild all thumbnails at once without script timeouts on your server.', 'theme-it' ) . ' <a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=ajax-thumbnail-rebuild&TB_iframe=true&width=640&height=517' ) . '" title="Get Regenerate Thumbnails Plugin" class="thickbox onclick"><strong>' . __( 'Get Plugin', 'theme-it' ) . ' &rarr;</strong></a>',
  'class' => 'checkmark',
  'type'  => 'info'
);

?>