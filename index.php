<?php get_header(); ?>

<div class="aligner">

<?php
        $main_post_id = false;
        $sticky = get_option( 'sticky_posts' );
        $args = array(
            'posts_per_page' => 1,
            'post__in'  => $sticky,
            'ignore_sticky_posts' => 1
            );
        query_posts( $args );

        if ($sticky[0]) { ?>

            <div class="row-fluid">
                <div class="col12 last">

                </div>

                <div class="clear"></div>
            </div>
            <?php }?>
        </div>

</div>

<?php get_footer(); ?>
