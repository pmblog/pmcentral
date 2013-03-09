<?php

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php

        wp_title( '|', true, 'right' );
        bloginfo( 'name' );

    ?></title>

    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <?php
    /* We add some JavaScript to pages with the comment form
     * to support sites with threaded comments (when in use).
     */
    if ( is_singular() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    /* Always have wp_head() just before the closing </head> tag of your theme, or you will break many plugins, which
     * generally use this hook to add elements to <head> such as styles, scripts, and meta tags. */

    wp_head();
    ?>
</head>

<body>


<div id="wrapper">

