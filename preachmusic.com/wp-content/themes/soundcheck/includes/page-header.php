<?php
/**
 * This template file determines the content of the page title
 * by checking for page type. Used in multiple files.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */

global $is_page;

$title = ti_get_page_title();

if( $is_page !== 'template-post-page' ) : ?>
	
	<header class="page-header">
		
		<?php	
		/**
		 * Page Title
		 *
		 */
		 
		// Check for page title type
		if ( $title['title'] ) : ?>
		
			<h1 class="page-title">
	  		
				<?php echo esc_html( $title['misc'] ); ?> <span><?php echo esc_html( $title['title'] ); ?></span>
	  	
			</h1><!-- page-title -->
	  	
	  	<?php if ( category_description() != '' ) : ?>
				
				<div class="category-description">
	  		
					<?php
					/**
					 * Category Description
					 *
					 */
					echo category_description(); // Display category description if available ?>
					
				</div><!-- category-description -->
			
			<?php endif; ?>
		
		<?php	endif; // End page title type check ?>
		
		
		<?php
		/**
		 * Pagination
		 *
		 */
		if ( $wp_query->max_num_pages > 1 ) : // Check for pages ?>
		
			<div id="nav-above" class="pagenavi">
				
				<?php if ( function_exists( 'wp_pagenavi' ) ) : ?>
					
					<?php wp_pagenavi(); ?>
					
				<?php else : ?>
				
					<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span>' . __( ' Older posts', 'theme-it' ) ); ?></div>
				  
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts ', 'theme-it' ) . '<span class="meta-nav">&rarr;</span>' ); ?></div>
				
				<?php endif; // End WP Page Navi plugin check ?>
			
			</div><!-- #nav-below -->
		
		<?php endif; // end page check ?>
		
	</header><!-- .page-header -->
	
<?php endif; // end custom template post page check ?>
