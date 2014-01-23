<?php 
/**
 * The page template file.
 *
 * @package Soundcheck
 * @since 1.0
 */
?>

<form method="get" role="search" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="text" class="search-field" name="s" placeholder="<?php esc_attr_e( 'Search', 'soundcheck' ); ?>&hellip;" />
    <input type="submit" class="search-submit" value="<?php esc_attr_e( 'GO', 'soundcheck' ); ?>" />
</form>


