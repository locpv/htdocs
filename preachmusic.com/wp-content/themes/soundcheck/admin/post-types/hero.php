<?php

/*-----------------------------------------------------------------------------------*/
/* Create Hero custom post type
/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'ti_hero_init' );

function ti_hero_init()  {
  $labels = array(
    'name'               => __( 'Hero Slides',              'theme-it' ),
    'singular_name'      => __( 'Hero Slide',               'theme-it' ),
    'add_new'            => __( 'Add Slide',                'theme-it' ),
    'add_new_item'       => __( 'Add Slide',                'theme-it' ),
    'edit_item'          => __( 'Edit Slide',               'theme-it' ),
    'new_item'           => __( 'New Slide',                'theme-it' ),
    'view_item'          => __( 'View Slide',               'theme-it' ),
    'search_items'       => __( 'Search Slides',            'theme-it' ),
    'not_found'          => __( 'No Slides found',          'theme-it' ),
    'not_found_in_trash' => __( 'No Slides found in Trash', 'theme-it' ), 
    'parent_item_colon'  => __( '',                         'theme-it' ),
    'menu_name'          => __( 'Hero',                     'theme-it' )
  );
  
  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true, 
    'show_in_menu'       => true, 
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'hero' ),
    'capability_type'    => 'post',
    'has_archive'        => 'hero', 
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'thumbnail', 'editor', 'post-formats', 'custom-fields' ),
    'menu_position'      => 5
  );
  
  register_post_type( 'hero', $args );
  
}
 



/*-----------------------------------------------------------------------------------*/
/* Styling for the custom post type icon
/*-----------------------------------------------------------------------------------*/

add_filter( 'enter_title_here', 'ti_hero_change_default_title' );

function ti_hero_change_default_title( $title ){
	$screen = get_current_screen();
 
	if ( 'hero' == $screen->post_type ) {
		$title = __( 'Enter Slide Title', 'theme-it' );
	}
 
	return $title;
}




/*-----------------------------------------------------------------------------------*/
/* Styling for the custom post type icon
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_head', 'ti_hero_icons' );

function ti_hero_icons() {
?>
	<style type="text/css" media="screen">
		#menu-posts-hero .wp-menu-image {
			background: url(<?php echo ti_ADMINURL; ?>/images/post-type-icon16-hero.png) no-repeat 6px 6px !important;
		}
		
		#menu-posts-hero:hover .wp-menu-image, 
		#menu-posts-hero.wp-has-current-submenu .wp-menu-image {
			background-position: 6px -18px !important;
		}
		
		#icon-edit.icon32-posts-hero {
			background: url(<?php echo ti_ADMINURL; ?>/images/post-type-icon32-hero.png) no-repeat;
		}
	</style>
<?php }




/*-----------------------------------------------------------------------------------*/
/* Add custom columns
/*-----------------------------------------------------------------------------------*/

add_filter( 'manage_edit-hero_columns', 'ti_hero_edit_columns' );
 
function ti_hero_edit_columns( $columns ){
	$columns = array(
		'cb'        => '<input type="checkbox" />',
		'thumbnail' => __( '', 'theme-it' ),
		'title'     => __( 'Title', 'theme-it' ),
		'the_excerpt'   => __( 'Excerpt', 'theme-it' ),
		'date'      => __( 'Date', 'theme-it' )
	);

	return $columns;
}


/*-----------------------------------------------------------------------------------*/
/* Manage/Add Columns
/*-----------------------------------------------------------------------------------*/

add_action( 'manage_hero_posts_custom_column', 'ti_hero_show_columns' );

function ti_hero_show_columns( $name ) {
	global $post;
	switch ( $name ) {
		case 'thumbnail':
			$width = absint( 60 );
			$height = $width;
			?>
			
			<style type="text/css" media="screen">
				#thumbnail {
					width: <?php echo $width + absint( 20 ); ?>px;
				}
				
				.column-thumbnail {
					text-align: center;
					width: 80px;
					padding-top: 8px !important;
					padding-bottom: 8px !important;;
				}
				
				.column-thumbnail img {
					width: <?php echo $width; ?>px;
					height: <?php echo $height; ?>px;
				}
				
				.column-thumbnail .no-thumbnail {
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
			$thumbnail = get_the_post_thumbnail( $post->ID, 'theme-icon' );
			
			if ( isset( $thumbnail ) && $thumbnail ) {
			  echo $thumbnail;
			} else {
			  echo '<span class="no-thumbnail">' . __( 'None', 'theme-it' ) . '</span>';
			}
		break;
		
		case 'the_excerpt':
			$the_excerpt = the_excerpt_rss();
			echo $the_excerpt;
		break;
	}
}


/*-----------------------------------------------------------------------------------*/
/* Register the column as sortable
/*-----------------------------------------------------------------------------------*/

add_filter( 'manage_edit-hero_sortable_columns', 'ti_hero_sortable_columns' );

function ti_hero_sortable_columns( $columns ) {
	$columns['thumbnail'] = 'thumbnail';
	
	return $columns;
}


/*-----------------------------------------------------------------------------------*/
/* Add filters for user update messages
/*-----------------------------------------------------------------------------------*/

add_filter( 'post_updated_messages', 'ti_hero_messages' );

function ti_hero_messages( $messages ) {
  
  global $post, $post_ID;

  $messages['wrestler'] = array(
    0 => '',
    1 => sprintf( __( 'Slide updated. <a href="%s">View Slide</a>', 'theme-it' ), esc_url( get_permalink( $post_ID ) ) ),
    2 => __( 'Custom field updated.', 'theme-it' ),
    3 => __( 'Custom field deleted.', 'theme-it' ),
    4 => __( 'Slide updated.', 'theme-it' ),
    5 => isset( $_GET['revision'] ) ? sprintf( __( 'Hero slide restored to revision from %s', 'theme-it' ), wp_post_revision_title( ( int ) $_GET['revision'], false ) ) : false,
    6 => sprintf( __( 'Hero slide published. <a href="%s">View Slide</a>', 'theme-it' ), esc_url( get_permalink( $post_ID ) ) ),
    7 => __( 'Slide saved.', 'theme-it' ),
    8 => sprintf( __( 'Slide submitted. <a target="_blank" href="%s">Preview Wrestler</a>', 'theme-it' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
    9 => sprintf( __( 'Slide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Slide</a>', 'theme-it' ),
      date_i18n( __( 'M j, Y @ G:i', 'theme-it' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
    10 => sprintf( __( 'Slide draft updated. <a target="_blank" href="%s">Preview Slide</a>', 'theme-it' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
  );

  return $messages;
}




/*-----------------------------------------------------------------------------------*/
/* Display contextual help
/*-----------------------------------------------------------------------------------*/

add_action( 'contextual_help', 'ti_hero_contextual_help', 10, 3 );

function ti_hero_contextual_help( $contextual_help, $screen_id, $screen ) { 
  
  //$contextual_help .= var_dump( $screen); // use this to help determine $screen->id
  
  if ( 'hero' == $screen->id ) {
    $contextual_help =
      '<p>' . __( 'Here are some basic guidelines to help with posting content to the hero slider.', 'theme-it' ) . '</p>' .
      '<ul>' .
      	'<li>' . __( 'Images and videos for each slide should be at least 480px &times; 270px in dimension to display properly', 'theme-it' ) . '</li>' .
      '</ul>';
  } elseif ( 'edit-Wrestler' == $screen->id ) {
    $contextual_help = 
      '<p>' . __( 'This is the help screen displaying Hero Slide content.', 'theme-it' ) . '</p>' ;
  }
  
  return $contextual_help;
}




?>