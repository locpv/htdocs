<?php 
/**
 * The page template file.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */

// Set search placeholder text
$search_placeholder = __( 'Search for something...', 'theme-it' ); 

?>

<script type="text/javascript">
  function doSerachBlur(theValue) {
  	if (theValue.value == '') {
  		theValue.value = '<?php _e( $search_placeholder ); ?>';
  	}
  }
  function doSearchFocus(theValue) {
  	if (theValue.value == '<?php _e( $search_placeholder ); ?>') {
  		theValue.value = '';
  	}
  }
</script>

<div id="search" role="search">
	<form method="get" id="searchform" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  	<input type="text" class="search-field" name="s" value="<?php esc_attr_e( $search_placeholder ); ?>" onblur="doSerachBlur(this)" onfocus="doSearchFocus(this)" />
		<input type="submit" class="search-submit" value="GO" />
	</form>
</div><!-- #search -->
