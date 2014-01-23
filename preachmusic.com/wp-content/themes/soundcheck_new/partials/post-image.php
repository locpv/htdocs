<figure class="entry-thumbnail">
    <?php
    printf( '<a href="%1$s" title="%2$s" rel="post-%3$d">%4$s</a>',
        esc_url( get_permalink() ),
        esc_attr( sprintf( __( '%1$s', 'soundcheck' ), soundcheck_the_title_attribute() ) ),
        absint( get_the_ID() ),
        get_the_post_thumbnail( get_the_ID(), soundcheck_thumbnail_size() )
    );
    ?>
</figure>
