<?php
/*
Plugin Name: Social Sharing Analytics
Plugin URI: http://ctrlq.org/analytics/
Description: Display social sharing statistics of your blog posts in the WordPress Admin dashboard.
Author: Amit Agarwal
Version: 0.2
Author URI: http://www.labnol.org/about/
*/

function add_labnol_column($columns) {
  return array_merge( $columns, 
           array('labnolsocial' => __('Social Stats')) );
}

function social_enqueue($hook) {
    if( 'edit.php' != $hook )
        return;
    wp_enqueue_script( 'social_script', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=labnol', array(), false, true  );
}
add_action( 'admin_enqueue_scripts', 'social_enqueue' );

function labnol_columns( $column, $post_id ) {
  if ( $column == "labnolsocial" ) :
?>

<div class="addthis_toolbox addthis_default_style" 
  addthis:url="<?php echo get_permalink ( $post_id ); ?>" 
  addthis:title="<?php echo htmlentities(get_the_title($post_id)); ?>"> 
  <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> 
  <a class="addthis_button_tweet"></a> 
  <a class="addthis_button_google_plusone" g:plusone:size="medium"></a> 
</div>
<?php
 endif; 
}

add_filter('manage_posts_columns' , 'add_labnol_column');
add_action('manage_posts_custom_column' , 'labnol_columns', 10, 2);
add_filter('manage_pages_columns' , 'add_labnol_column');
add_action('manage_pages_custom_column' , 'labnol_columns', 10, 2);

?>