<?php
/**
 * Metaboxes Setup
 *
 * Here we create custom metaboxes using WPAlchemy.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */


/**
 * WPAlchemy Metabox Scripts and Styles
 *
 * @since     1.0
 */
add_action( 'add_meta_boxes', 'ti_metabox_init' );

function ti_metabox_init() {
	// Register
	wp_register_script( 'metabox',        ti_ADMINURL . '/metabox/MetaBox.js', 'jquery', '1.0',	true );
	wp_register_style(  'metabox',        ti_ADMINURL . '/metabox/MetaBox.css' );
	wp_register_style(  'metabox-custom', ti_ADMINURL . '/metabox/metabox-custom.css' );
	
	// Enqueue
	wp_enqueue_script( 'metabox' );
	wp_enqueue_style( 'metabox' );
	wp_enqueue_style( 'metabox-custom' );
}


/**
 * WPAlchemy Metabox Class
 *
 * http://farinspace.com/wpalchemy-metabox/
 *
 * @since     1.0
 */
include_once ti_ADMINPATH . '/metabox/MetaBox.php';


/**
 * WPAlchemy MediaAccess Class
 *
 * http://farinspace.com/wpalchemy-metabox/
 *
 * @since     1.0
 */
include_once ti_ADMINPATH . '/metabox/MediaAccess.php';

/* Define a media acess object */
$wpalchemy_media_access = new WPAlchemy_MediaAccess();


/**
 * Album Info Metabox
 *
 * @since     1.0
 */
$album_info_mb = new WPAlchemy_MetaBox( array(
  'id'       => '_album_info_mb',
  'title'    => 'Album Info',
  'types'    => array( 'discography' ),
  'template' => ti_ADMINPATH . '/metabox/metabox-album-info.php'
));


/**
 * Page Excerpt Metabox
 *
 * @since     1.0
 */
$page_excerpt_mb = new WPAlchemy_MetaBox( array(
  'id'       => '_page_excerpt_mb',
  'title'    => 'Page Excerpt',
  'types'    => array( 'page', 'discography' ),
	'exclude_template' => array( 'template-post-page.php', 'template-post-gallery.php' ),
  'template' => ti_ADMINPATH . '/metabox/metabox-page-excerpt.php'
));


/**
 * Media Embed Metabox
 *
 * @since     1.0
 */
$media_embed_mb = new WPAlchemy_MetaBox( array(
  'id'       => '_media_embed_mb',
  'title'    => 'Media Embed',
  'types'    => array( 'page', 'post', 'hero' ),
  'context'  => 'side',
  'template' => ti_ADMINPATH . '/metabox/metabox-media-embed.php'
));


/**
 * Post Page Metabox
 *
 * @since     1.0
 */
$post_page_mb = new WPAlchemy_MetaBox( array(
  'id'               => '_post_page_mb',
  'title'            => 'Custom Post Page',
  'types'            => array( 'page' ),
  'context'          => 'side',
  'include_template' => array( 'template-post-page.php', 'template-post-gallery.php' ),
  'template'         => ti_ADMINPATH . '/metabox/metabox-post-page.php'
));


?>