<?php
/**
 * Pagination
 *
 */

if ( $wp_query->max_num_pages > 1 ) : // Check for pages ?>

  <div id="nav-below" class="pagenavi">
  	
  	<?php if ( function_exists( 'wp_pagenavi' ) ) : // Check for WP Page Navi Plugin ?>
  	
  		<?php wp_pagenavi(); ?>
  	
  	<?php else : ?>
  		
  		<div class="nav-previous button"><?php next_posts_link(  __( '&larr; Older posts', 'framework' ) ); ?></div>
  	  
  		<div class="nav-next button"><?php previous_posts_link( __( 'Newer posts &rarr;', 'framework' ) ); ?></div>
  	
  	<?php endif; // End WP Page Navi plugin check ?>
  
  </div><!-- #nav-below -->

<?php endif; // end page check ?>
