<?php
/**
 * Soundcheck Options Init
 *
 * Initializes and loads up theme options. Uses the Struts option framework.
 * See https://github.com/jestro/struts
 *
 * @since 2.0
 */
if ( ! function_exists( 'soundcheck_options_init' ) ) :
function soundcheck_options_init() {

	/* Load options class (struts) */
	locate_template( 'inc/options/classes/struts.php', true );
	
	/* Conigure options load */
	Struts::load_config( array(
		// required, set this to the URI of the root Struts directory
		'struts_root_uri' => get_template_directory_uri() . '/inc/options',
		// optional, overrides the Settings API html output
		'use_struts_skin' => true, 
	) );
	
	/* Load options */
	locate_template( 'inc/options/options-theme.php', true );
	locate_template( 'inc/options/options-style.php', true );
	
}
endif;


/**
 * Soundcheck Theme Option
 *
 * Function called to get a Theme Option. 
 * The option defaults to false unless otherwise set.
 *
 * @since 2.0
 */
if ( ! function_exists( 'soundcheck_option' ) ) :
function soundcheck_option( $option_name, $default = false ) {

	global $theme_options;

	$option = $theme_options->get_value( $option_name );

	if ( isset( $option ) && ! empty( $option ) ) {
		return $option;
	}

	return $default;
	
}
endif;


/**
 * Soundcheck Style Option
 *
 * Function called to get a Style Option. 
 * The option defaults to false unless otherwise set.
 *
 * @since 2.0
 */
if ( ! function_exists( 'soundcheck_style' ) ) :
function soundcheck_style( $option_name, $default = false ) {

	global $theme_styles;

	$option = $theme_styles->get_value( $option_name );

	if ( isset( $option ) && ! empty( $option ) ) {
		return $option;
	}

	return $default;
	
}
endif;


/**
 * Get Category List
 *
 * Utility function to get the category list and 
 * return array of category ID and Name.
 *
 * @retunr Array Category ID and Name
 * @since 2.0
 */
if ( ! function_exists( 'soundcheck_get_category_list' ) ) :
function soundcheck_get_category_list( $events = false ) {

	// Pull all the categories into an array
	$list = array();
	$args = array();
	
	// Show emtpy categories in list, 
	// in which the events category should display
	if ( $events )
		$args = array( 'hide_empty' => 0 );
	
	$categories = get_categories( $args );
	$list[''] = __( 'Select a category:', 'soundcheck' );
	
	foreach ( (array) $categories as $category ) {
	    $list[$category->cat_ID] = $category->cat_name;
	    // Don't show post count for event category lists, 
	    // it will just be confusing seeing "0"
	    if ( ! $events )
	    	$list[$category->cat_ID] .= ' ('.$category->category_count.')';
	}
	
	return $list;
	
}
endif;


?>