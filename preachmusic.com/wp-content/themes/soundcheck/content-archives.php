<?php  
/**
 * The loop for displaying the archives information for template-archives.php,
 * when no posts are avaialable, 404 pages, or empty search results.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      2.0
 */
?>

<section id="entry-container" role="contentinfo">

	<article id="post-archives" class="entry">
	
		<div class="entry-content">
				
			<h4><?php _e( 'Last 30 Posts', 'theme-it' ); ?></h4>
			<ul>
			  <?php
			  /**
			   * Recent Posts
			   *
			   */
			  $args = array (
			  	'numberposts' => '30'
			  );
			  $archives = get_posts( $args );
			  
			  // Spit out each post as a line item link
			  foreach( $archives as $post ) {
			  	echo '<li><a href="' . get_permalink() . '">' . esc_html( the_title( '', '', false ) ) . '</a></li>';
			  } ?>
			</ul>
			
			<h4><?php _e( 'Archives by Month:', 'theme-it' ); ?></h4>
			<ul>
			  <?php 
			  /**
			   * Monthly Archives
			   *
			   */
			  wp_get_archives( 'type=monthly' ); ?>
			</ul>
			
			<h4><?php _e( 'Archives by Subject:', 'theme-it' ); ?></h4>
			<ul>
			  <?php 
			  /**
			   * Categories
			   *
			   */
			  wp_list_categories( 'title_li=' ); ?>
			</ul>
			
			<h4><?php _e( 'Maybe a Page:', 'theme-it' ); ?></h4>
			<ul>
			  <?php 
			  /**
			   * Pages
			   *
			   */
			  wp_list_pages( 'title_li=' ); ?>
			</ul>
			
		</div><!-- .entry-content -->
			
	</article><!-- #post-## -->

</section><!-- #entry-container -->
