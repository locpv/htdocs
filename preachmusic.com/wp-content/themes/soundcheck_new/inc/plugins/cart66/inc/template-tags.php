<?php

if ( ! function_exists( 'soundcheck_get_cart66_product' ) ) :
/**
 * Cart66 Product Info
 *
 * @since 2.0
 */
function soundcheck_get_cart66_product( $args = array() ) { 
    global $post;
    
    // Set post ID (not currently used, but may)
	$post_id = isset( $args['id'] ) ? $args['id'] : get_the_ID();
    
    // Set of defualt arguments
    $defaults = array(
    	'option' => '', 
    	'echo' => 1 
    );
    
    // Set of valid options
    $options = array( 'id', 'itemnumber', 'name', 'price' );
    
    $args = wp_parse_args( $args, $defaults );
    extract( $args );
    
    // Return early if supplied option is not a valid option
    if( ! in_array( $option, $options ) )
    	return;
    
    // Set ID
    $product_id = get_post_meta( $post_id, '_product', true ); 
    
    // Return early if there is not a product id set
    if ( ! $product_id )
    	return;
    	
    // Create new cart66 instance
    $product = new Cart66Product();
    
    // Query DB for product ID
    $products = $product->getModels( "where id=$product_id", 'order by name' );
    
    // Loop through values
    foreach( $products as $p ) {
    	if ( $option == 'id' )
    		$option = esc_html( $p->id );
    	elseif ( $option == 'itemnumber' )
    		$option = esc_html( $p->itemNumber );
    	elseif ( $option == 'name' )
    		$option = esc_html( $p->name );
    	elseif ( $option == 'price' )
    		$option = esc_html( CART66_CURRENCY_SYMBOL . $p->price );
    	else
    		return;
    }
    
    if( $echo )
		echo $option;
    else
		return $option;
		
}
endif;


if ( ! function_exists( 'soundcheck_get_cart66_cart' ) ) :
/**
 * Cart66 Cart Info
 *
 * @since 2.0
 */
function soundcheck_get_cart66_cart( $args = array() ) { 

    global $post;
    
	$post_id = isset( $args['id'] ) ? $args['id'] : get_the_ID();
   
	$defaults = array(
    	'option' => '',
    	'echo' => 1
    );
    
    $options = array( 'count' );
    
    $args = wp_parse_args( $args, $defaults );
    extract( $args );
    
    // Return early if supplied option is not a valid option
    if( ! in_array( $option, $options ) )
    	return;

    $cart = Cart66Session::get( 'Cart66Cart' );

    if ( $option == 'count' ) {
    	$option = $cart->countItems(); // Get number of items in cart
    }
    
    if( $echo )
		echo $option;
    else
		return $option;
		
}
endif;


if ( ! function_exists( 'soundcheck_cart66_product_price_link' ) ) :
/**
 * Set the entry price for each post. 
 *
 * @package Soundcheck
 * @since 1.0
 */
function soundcheck_cart66_product_price_link() {
	
	if ( ! $price = soundcheck_get_cart66_product( array( 'option' => 'price' ) ) )
		return;
	
	printf( '<a class="price" href="%1$s" title="%2$s">%3$s</a>',
	    esc_url( the_permalink() ),
	    soundcheck_the_title_attribute(),
	    sprintf( esc_html__( '%s', 'soundcheck' ), $price )
	);
}
endif;
