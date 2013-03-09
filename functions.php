<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Yuriy
 * Date: 11/4/12
 * Time: 5:04 PM
 */

/** Tell WordPress to run pmc_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'pmc_setup' );

if ( ! function_exists( 'pmc_setup' ) ):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * To override pmc_setup() in a child theme, add your own pmc_setup to your child theme's
     * functions.php file.
     *
     * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
     * @uses register_nav_menus() To add support for navigation menus.
     * @uses add_custom_background() To add support for a custom background.
     * @uses add_editor_style() To style the visual editor.
     * @uses load_theme_textdomain() For translation/localization support.
     * @uses add_custom_image_header() To add support for a custom header.
     * @uses register_default_headers() To register the default custom header images provided with the theme.
     * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
     *
     */
    function pmc_setup() {

        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        // This theme uses post thumbnails
        add_theme_support( 'post-thumbnails' );

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain( 'pmc', TEMPLATEPATH . '/languages' );

        $locale = get_locale();
        $locale_file = TEMPLATEPATH . "/languages/$locale.php";
        if ( is_readable( $locale_file ) )
            require_once( $locale_file );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => __( 'Primary Navigation', 'pmc' ),
            'secondary' => __( 'Secondary Navigation', 'pmc' ),
        ) );
    }
endif;

if ( ! function_exists( 'pmc_posted_author' ) ) :
    /**
     * Prints HTML with meta information for the current post—date/time and author.
     */
    function pmc_posted_author() {
        printf( __( '%2$s', 'pmc' ),
            'meta-prep meta-prep-author',
            sprintf( '<span class="author"><a href="%1$s" title="%2$s">%2$s</a></span>',
                get_author_posts_url( get_the_author_meta( 'ID' ) ),
                sprintf( esc_attr__( '%s', 'pmc' ), get_the_author() ),
                get_the_author()
            )
        );
    }
endif;

if ( ! function_exists( 'pmc_posted_datetime' ) ) :
    /**
     * Prints HTML with meta information for the current post—date/time
     */
    function pmc_posted_datetime() {
        printf( __( '%2$s', '%3$s', 'pmc' ),'meta-prep meta-prep-author',
            sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
            get_permalink(),
            esc_attr( get_the_time() ),
        get_the_date())
               );
    }
endif;

if ( ! function_exists( 'pmc_posted_category' ) ) :
    /**
     * Prints HTML with meta information for the current category
     */
    function pmc_posted_category() {

        if ( count( get_the_category() ) ) :

            printf( '<span class="%1$s">%2$s</span> ', 'cat-links', get_the_category_list( ', ' ) );

        endif;
    }
endif;

if ( ! function_exists( 'pmc_posted_tags' ) ) :
    /**
     * Prints HTML with meta information for the current category
     */
    function pmc_posted_tags() {

        $tags_list = get_the_tag_list( '', ', ' );
        if ( $tags_list ):
            printf('<span class="%1$s"> %2$s</span>', 'tag-links', $tags_list );
        endif;
    }
endif;

if ( ! function_exists( 'pmc_comments_counter' ) ) :
    /**
     * Prints HTML with meta information for the current category
     */
    function pmc_comments_counter() {
    ?>
        <span class="comments"><?php comments_popup_link( __( 'Оставить комментарий', 'pmc' ),__( '1 Comment', 'pmc' ),__( '% Comments', 'pmc' ) );?></span>
    <?php
    }
endif;

if ( ! function_exists( 'pmc_comments_edit' ) ) :
    /**
     * Prints HTML with meta information for the current category
     */
    function pmc_comments_edit() {

    edit_post_link( '', '<span class="edit-link">', '</span>' );

   }
endif;

/* Display social icons */
if ( ! function_exists( 'pmc_social' ) ) :
    /**
     * Prints HTML with meta information for the current category
     */
    function pmc_social() {
        $social = "<span class='social-icon'><img src=".home_url('/')."wp-content/themes/pmc/images/icons/social/facebook.png></span>";
        $social = $social."<span class='social-icon'><img src=".home_url('/')."wp-content/themes/pmc/images/icons/social/linkedin.png></span>";
        $social = $social."<span class='social-icon'><img src=".home_url('/')."wp-content/themes/pmc/images/icons/social/twitter.png></span>";
        $social = $social."<span class='social-icon'><img src=".home_url('/')."wp-content/themes/pmc/images/icons/social/rss.png></span>";
        $social = $social."<span class='social-icon'><img src=".home_url('/')."wp-content/themes/pmc/images/icons/social/youtube.png></span>";
        return $social;
    }
endif;


function pmc_widgets_init(){

    register_sidebar( array(
        'name' => __( 'Menu Widgets Area', 'pmc' ),
        'id' => 'menu-widget-area',
        'description' => __( 'Area for menu widgets', 'pmc' ),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Events Widgets Area', 'pmc' ),
        'id' => 'event-widget-area',
        'description' => __( 'Area for events widgets', 'pmc' ),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Primary Widget Area', 'pmc' ),
        'id' => 'primary-widget-area',
        'description' => 'The primary widget area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Secondary Widget Area', 'pmc' ),
        'id' => 'secondary-widget-area',
        'description' => 'The secondary widget area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

}

add_action('widgets_init','pmc_widgets_init');

function paginate() {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

    $pagination = array(
        'base' => @add_query_arg('paged','%#%'), //(string) (optional) Used to reference the url, which will be used to create the paginated links. The default value '%_%' in 'http://example.com/all_posts.php%_%' is replaced by 'format' argument (see below). Default: '%_%'
        'format' => '/page/%#%',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'show_all' => false,
        'end_size'     => 1,
        'mid_size'     => 2,
        'type' => 'list',
        'next_text' => '&raquo;',
        'prev_text' => '&laquo;'
    );

    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );

    echo paginate_links( $pagination );
}