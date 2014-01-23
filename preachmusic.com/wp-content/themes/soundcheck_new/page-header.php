<?php
/**
 * This template file determines the content of the page title
 * by checking for page type. Used in multiple files.
 *
 * @package Soundcheck
 * @since 1.0
 */
?>


<?php if ( is_404() || soundcheck_is_multiple() ) : ?>
<?php else : ?>
	<header id="page-header" class="regular">
	    <h1 class="page-title"><?php the_title(); ?></h1>
	    
	    <?php if ( $post->post_content != '' ) : ?>
	    	<div class="page-content">
	    		<?php the_content() ?>
	    	</div>
	    <?php endif; ?>
	</header>
<?php endif; ?>

<div class="customAjaxAddToCartMessage Cart66Success" style="display:none"></div>	

