<?php

/**
 * Create discography custom post type
 *
 */
add_action( 'init', 'ti_discography_init' );

function ti_discography_init()  {
  
  $labels = array(
    'name'               => __( 'Albums',                   'theme-it' ),
    'singular_name'      => __( 'Album',                    'theme-it' ),
    'add_new'            => __( 'Add Album',                'theme-it' ),
    'add_new_item'       => __( 'Add Album',                'theme-it' ),
    'edit_item'          => __( 'Edit Album',               'theme-it' ),
    'new_item'           => __( 'New Album',                'theme-it' ),
    'view_item'          => __( 'View Album',               'theme-it' ),
    'search_items'       => __( 'Search Albums',            'theme-it' ),
    'not_found'          => __( 'No Albums found',          'theme-it' ),
    'not_found_in_trash' => __( 'No Albums found in Trash', 'theme-it' ), 
    'parent_item_colon'  => __( '',                         'theme-it' ),
    'menu_name'          => __( 'Discography',              'theme-it' )
  );
  
  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true, 
    'show_in_menu'       => true, 
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'album' ),
    'capability_type'    => 'post',
    'has_archive'        => 'discography', 
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'thumbnail', 'editor' ),
    'menu_position'      => 5
  );
  
  register_post_type( 'discography', $args );
  
}




/**
 * Styling for the custom post type icon
 *
 */
add_filter( 'enter_title_here', 'ti_discography_change_default_title' );

function ti_discography_change_default_title( $title ){
	$screen = get_current_screen();
 
	if ( 'discography' == $screen->post_type ) {
		$title = __( 'Enter Album Title', 'theme-it' );
	}
 
	return $title;
}




/**
 * Styling for the custom post type icon
 *
 */
add_action( 'admin_head', 'ti_discography_icons' );

function ti_discography_icons() {
?>
	<style type="text/css" media="screen">
		#menu-posts-discography .wp-menu-image {
			background: url(<?php echo ti_ADMINURL; ?>/images/post-type-icon16-discography.png) no-repeat 6px 6px !important;
		}
		
		#menu-posts-discography:hover .wp-menu-image, 
		#menu-posts-discography.wp-has-current-submenu .wp-menu-image {
			background-position: 6px -18px !important;
		}
		
		#icon-edit.icon32-posts-discography {
			background: url(<?php echo ti_ADMINURL; ?>/images/post-type-icon32-discography.gif) no-repeat;
		}
	</style>
<?php }




/**
 * Add custom columns
 *
 */
add_filter( 'manage_edit-discography_columns', 'ti_discography_edit_columns' );
 
function ti_discography_edit_columns( $columns ){
	$columns = array(
		'cb'        => '<input type="checkbox" />',
		'artwork'   => __( '', 'theme-it' ),
		'title'     => __( 'Title', 'theme-it' ),
		'date'      => __( 'Date', 'theme-it' )
	);

	return $columns;
}




/**
 * Manage/Add Columns
 *
 */
add_action( 'manage_discography_posts_custom_column', 'ti_discography_show_columns' );

function ti_discography_show_columns( $name ) {
	global $post;
	switch ( $name ) {
		case 'artwork':
			$width = absint( 60 );
			$height = $width;
			?>
			
			<style type="text/css" media="screen">
				#artwork {
					width: <?php echo $width + absint( 20 ); ?>px;
				}
				
				.column-artwork {
					text-align: center;
					width: 80px;
					padding-top: 8px !important;
					padding-bottom: 8px !important;;
				}
				
				.column-artwork img {
					width: <?php echo $width; ?>px;
					height: <?php echo $height; ?>px;
				}
				
				.column-artwork .no-artwork {
					display: block;
					padding: 20px 15px;
					margin-left: 3px;
					width: <?php echo $width - 30 ?>px;
					height: <?php echo $height - 40; ?>px;
					color: #ccc;
					background: #f5f5f5;
				}
			</style>
			
			<?php
			$artwork = get_the_post_thumbnail( $post->ID, 'theme-icon' );
			
			if ( isset( $artwork ) && $artwork ) {
			  echo $artwork;
			} else {
			  echo '<span class="no-artwork">' . __( 'None', 'theme-it' ) . '</span>';
			}
	}
}




/**
 * Register the column as sortable
 *
 */
add_filter( 'manage_edit-discography_sortable_columns', 'ti_discography_sortable_columns' );

function ti_discography_sortable_columns( $columns ) {
	$columns['artwork'] = 'artwork';
	
	return $columns;
}




/**
 * Add filters for user update messages
 *
 */
add_filter( 'post_updated_messages', 'ti_discography_messages' );

function ti_discography_messages( $messages ) {
  
  global $post, $post_ID;

  $messages['discography'] = array(
    0 => '',
    1 => sprintf( __( 'Slide updated. <a href="%s">View Slide</a>', 'theme-it' ), esc_url( get_permalink( $post_ID ) ) ),
    2 => __( 'Custom field updated.', 'theme-it' ),
    3 => __( 'Custom field deleted.', 'theme-it' ),
    4 => __( 'Slide updated.', 'theme-it' ),
    5 => isset( $_GET['revision'] ) ? sprintf( __( 'discography slide restored to revision from %s', 'theme-it' ), wp_post_revision_title( ( int ) $_GET['revision'], false ) ) : false,
    6 => sprintf( __( 'discography slide published. <a href="%s">View Slide</a>', 'theme-it' ), esc_url( get_permalink( $post_ID ) ) ),
    7 => __( 'Slide saved.', 'theme-it' ),
    8 => sprintf( __( 'Slide submitted. <a target="_blank" href="%s">Preview discography</a>', 'theme-it' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
    9 => sprintf( __( 'Slide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Slide</a>', 'theme-it' ),
      date_i18n( __( 'M j, Y @ G:i', 'theme-it' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
    10 => sprintf( __( 'Slide draft updated. <a target="_blank" href="%s">Preview Slide</a>', 'theme-it' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
  );

  return $messages;
}




/**
 * Display contextual help
 *
 */
add_action( 'contextual_help', 'ti_discography_contextual_help', 10, 3 );

function ti_discography_contextual_help( $contextual_help, $screen_id, $screen ) { 
  
  //$contextual_help .= var_dump( $screen); // use this to help determine $screen->id
  
  if ( 'discography' == $screen->id ) {
    $contextual_help =
      '<p>' . __( 'Here are some basic guidelines to help with posting content to the discography slider.', 'theme-it' ) . '</p>' .
      '<ul>' .
      	'<li>' . __( 'Images and videos for each slide should be at least 480px &times; 270px in dimension to display properly', 'theme-it' ) . '</li>' .
      '</ul>';
  } elseif ( 'edit-discography' == $screen->id ) {
    $contextual_help = 
      '<p>' . __( 'This is the help screen displaying discography Slide content.', 'theme-it' ) . '</p>' ;
  }
  
  return $contextual_help;
}




?>