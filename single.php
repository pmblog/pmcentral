<?php
/**
 * The Template for displaying all single posts.
 */
get_header(); ?>

<div id="container">
    <div id="content">
        <article>
            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <h1><?php the_field('event_date'); ?></h1>
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>><h1 class="entry-title"><?php the_title(); ?><?php pmc_comments_edit(); ?></h1>
                <div class="entry-meta"><?php pmc_posted_author(); ?></div>

                <?php the_content(); ?>
                 <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'pmblog' ), 'after' => '</div>' ) ); ?>
                <?php pmc_posted_tags(); ?>

                <?php endwhile; // end of the loop. ?>
        </article>
        <section>
        <?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
        <div id="entry-author-info">
            <div id="author-avatar">
                <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'author_bio_avatar_size', 60 ) ); ?>
            </div><!-- #author-avatar -->

            <div id="author-description">
                <h2><?php printf( esc_attr__( '%s', 'pmc' ), get_the_author() ); ?></h2>
                <?php the_author_meta( 'description' ); ?>
                <div id="author-link">
                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
                        <?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'pmc' ), get_the_author() ); ?>
                    </a>
                </div><!-- #author-link	-->
            </div><!-- #author-description -->
        </div><!-- #entry-author-info -->
        <?php endif; ?>
        </section>
        <?php comments_template( '', true ); ?>

    </div><!-- #content -->
    <?php get_sidebar(); ?>
</div><!-- #conteiner -->
<?php get_footer(); ?>