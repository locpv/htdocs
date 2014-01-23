<div class="entry-content">

	<?php
	/**
	 * The Content
	 *
	 */
	if ( ! is_singular() ) :
	    global $more;
	    $more = 0;
	endif;

	the_content( sprintf( '<span class="moretext">%1$s</span>', __( '&hellip; Continue Reading', 'soundcheck' ) ) ); ?>

	<?php
	/**
	 * Page Links
	 *
	 */
	wp_link_pages( array(
	    'before' => sprintf( '<p class="pagelinks"><span>%s</span>', __( 'Pages:', 'soundcheck' ) ),
	    'after' => '</p>',
	    'link_before' => '<span class="page-numbers">',
	    'link_after' => '</span>'
	) ); ?>

	<?php
	/**
	 * Tags
	 *
	 */
	if ( ( $tag_list = get_the_tag_list( '<div class="tag-list">', ' ', '</div>' ) ) ) {
		printf( __( '%1$s', 'soundcheck' ), $tag_list );
	}
	?>

</div>
