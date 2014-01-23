<?php  
/**
 * This template file determines how to display entries header tag,
 * link, and meta information. Used across multiple files.
 *
 * @package WordPress
 * @subpackage Soundcheck
 * @since Soundcheck 1.0
 *
 */
?>


<div id="ti-page-excerpt" class="ti-metabox">
	
	<div class="content">
		
		<p><?php echo __( 'Highlighted text shown after the page title. A little HTML is accepted.', 'theme-it' ); ?></p>
		
		<p>
		  <?php $mb->the_field( 'page_excerpt' ); ?>
		  <textarea name="<?php $mb->the_name(); ?>" ><?php $mb->the_value(); ?></textarea><br />
		</p>
	
	</div><!-- .content -->
	
</div><!-- #ti-page-excerpt -->
