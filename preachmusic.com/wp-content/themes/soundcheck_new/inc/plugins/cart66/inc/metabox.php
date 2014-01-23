<?php
/**
 * Add scripts and styles
 *
 * @since 2.1.0
 */
function soundcheck_cart66_meta_box_scripts( $hook ) {

    $screen = get_current_screen();
    $screen = $screen->id;

    if ( $screen != 'post' && $screen != 'edit-post' )
		return;

    wp_enqueue_style( 'soundcheck-metabox', get_template_directory_uri() . '/css/theme-metabox.css', false, soundcheck_version_id() );
    
}
add_action( 'admin_enqueue_scripts', 'soundcheck_cart66_meta_box_scripts' );


/**
 * Add meta boxes
 *
 * @since 2.1.0
 */
function soundcheck_add_meta_boxes( $post_type ) {
	
	// Only show the metabox if the post is in the "Store" category or a sub category of the store
	if ( ! $products_category = soundcheck_option( 'products_category' ) )
		return;
	
	if ( $categories = get_term_children( (int) $products_category, 'category' ) ) {
	    array_push( $categories, $products_category );
	} else {
	    $categories = $products_category;
	}
	
	if ( ! in_category( $categories ) )
		return;
	
	// Show metabox if is Post page
	// Allow themes to add to post type in which the metabox can be displayed.
	if ( in_array( $post_type, apply_filters( 'soundcheck_cart66_products_mb_post_types', array( 'post' ) ) ) ) {
		add_meta_box( 'soundcheck_products_meta', __( 'Product Details', 'soundcheck' ), 'soundcheck_cart66_products_mb', $post_type, 'side', 'high' );
	}

}
add_action( 'add_meta_boxes', 'soundcheck_add_meta_boxes' );


/**
 * Render cart66 products metabox
 *
 * @since 2.1.0
 */
function soundcheck_cart66_products_mb( $post ) {

	// Nonce to verify intention later
	wp_nonce_field( 'soundcheck_cart66_products_mb_save', 'soundcheck_cart66_products_mb_nonce' );

	// Fields are attached with hooks
	do_action( 'soundcheck_cart66_products_mb_fields', $post->ID );

}


/**
 * PRODUCT: Cart66 Product Select
 *
 * @since 2.1.0
 */
function soundcheck_cart66_product_mb_field( $post_id ) { 

	$field_name = '_product';
	$value = get_post_meta( $post_id, $field_name, true ); 
	
	$product = new Cart66Product();
	$products = $product->getModels( 'where id>0', 'order by name' );
	?>
	
	<div id="soundcheck-cart66-product">
	<?php if ( count( $products ) ) : ?>
		<p class="soundcheck-meta-field">			
			<label for="<?php echo esc_attr( $field_name ) ?>">
				<?php _e( 'Product', 'soundcheck' ); ?>
			</label>
			
			<select name="<?php echo esc_attr( $field_name ); ?>" id="<?php echo esc_attr( $field_name ); ?>" class="widefat">
	        	<option value=""><?php _e( 'Select a product...', 'soundcheck' ); ?></option>
	      	  	<?php foreach( $products as $p ) : // loop through available products ?>
	      	  		<option value="<?php echo esc_attr( $p->id ); ?>" <?php echo $value == $p->id ? ' selected="selected"' : '' ?>>
	      	  	    	<?php
	    				printf( __( '%1$s &mdash; %2$s %3$s', 'soundcheck' ),
	    				    esc_html( $p->name ),
	    				    esc_html( CART66_CURRENCY_SYMBOL ),
	    				    esc_html( $p->gravityFormId == true ? 'Linked to Gravity Forms' : $p->price )
	    				)
	    				?>
	      	  		</option>
	      	  	<?php endforeach; ?>
			</select>	
		</p>
	<?php else : ?>
	    <p>
	    	<?php
	    	printf( '%1$s <br /><a href="%2$s" title="%3$s">%4$s</a>',
	    		esc_html( 'There are not any Cart66 products setup.', 'soundcheck' ),
	    		esc_url( admin_url( 'admin.php?page=cart66-products' ) ),
	    		esc_attr__( 'Setup a product.', 'soundcheck' ),
	    		esc_html__( 'Setup a product &rarr;', 'soundcheck' )
	    	);			
	    	?>
	    </p>
	<?php endif; // end products check ?>
	</div>
	
<?php }
add_action( 'soundcheck_cart66_products_mb_fields', 'soundcheck_cart66_product_mb_field', 10 );


/**
 * PRODUCT: Save Video Metabox Values
 *
 * @since 2.1.0
 */
function soundcheck_cart66_products_mb_save( $post_id ) {

	global $post;

	// verify nonce
	if ( ! isset( $_POST['soundcheck_cart66_products_mb_nonce'] ) || ! wp_verify_nonce( $_POST['soundcheck_cart66_products_mb_nonce'], 'soundcheck_cart66_products_mb_save' ) ) 
		return;

	// check autosave
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) 
		return;

	// don't save if only a revision
	if ( wp_is_post_revision( $post_id ) ) 
		return;

	// check permissions
	if ( ! current_user_can( 'edit_post' ) ) 
		return;		
	
	// these are the default fields that get saved
	$fields = apply_filters( 'soundcheck_cart66_products_mb_save', array(
		'_product'
	) );

	soundcheck_update_post_meta_field( $fields, $post_id );

}
add_action( 'save_post', 'soundcheck_cart66_products_mb_save' );
