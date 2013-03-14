<?php
/*-----------------------------------------------------------------------------------*/
/*	Register WP3.0+ Menus
/*-----------------------------------------------------------------------------------*/

if( !function_exists( 'my_register_menu' ) ) {
	function my_register_menu() {
		register_nav_menu('main-menu', __('Main menu'));
	}
	add_action('init', 'my_register_menu');
}

// Register global settings
if(function_exists("register_options_page"))
{
    register_options_page('Global');
    register_options_page('Поиск');
}

//email HTML format
add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));

/* Disable the Admin Bar */
show_admin_bar(false);

/*-----------------------------------------------------------------------------------*/
/*	Load Translation Text Domain
/*-----------------------------------------------------------------------------------*/

load_theme_textdomain( 'framework' );
/*-----------------------------------------------------------------------------------*/
/*	Register Sidebars
/*-----------------------------------------------------------------------------------*/

if( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Main Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));   
}


/*-----------------------------------------------------------------------------------*/
/*	Configure WP2.9+ Thumbnails 
/*-----------------------------------------------------------------------------------*/

if( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( '', 50, true ); // Normal post thumbnails
	add_image_size( 'thumbnail-large', 560, '', false); // for blog pages
	add_image_size( 'post-homepage', 940, 280, true); // for blog pages
}


add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
 
function my_deregister_styles() {
	wp_deregister_style( 'wp-admin' );
}
/*-----------------------------------------------------------------------------------*/
/*	Register and load front end JS
/*-----------------------------------------------------------------------------------*/

if( !function_exists( 'my_enqueue_scripts' ) ) {
	function my_enqueue_scripts() {
	  	wp_deregister_script('jquery');
		wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js');
		wp_register_script('my_custom', get_template_directory_uri() . '/js/jquery.custom.js', array('jquery', 'ui-custom'));
		wp_register_script('ui-custom', '/wp-includes/js/jquery/ui/jquery.ui.core.min.js', 'jquery');
		wp_register_script('mousewheel',  get_template_directory_uri() . '/js/jquery.mousewheel.js', 'jquery');
		wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', 'jquery');
	
		wp_enqueue_script('jquery');
		wp_enqueue_script('ui-custom');
		wp_enqueue_script('my_custom');
		wp_enqueue_script('bootstrap');
		
		wp_localize_script( 'my_custom', 'ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // setting ajaxurl
	}
	add_action('wp_enqueue_scripts', 'my_enqueue_scripts');
}

/*-----------------------------------------------------------------------------------*/
/*	Add Browser Detection Body Class
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'my_browser_body_class' ) ) {
	function my_browser_body_class($classes) {
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	
		if($is_lynx) $classes[] = 'lynx';
		elseif($is_gecko) $classes[] = 'gecko';
		elseif($is_opera) $classes[] = 'opera';
		elseif($is_NS4) $classes[] = 'ns4';
		elseif($is_safari) $classes[] = 'safari';
		elseif($is_chrome) $classes[] = 'chrome';
		elseif($is_IE){ 
			$classes[] = 'ie';
			if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version)) $classes[] = 'ie'.$browser_version[1];
		} else $classes[] = 'unknown';
	
		if($is_iphone) $classes[] = 'iphone';
		return $classes;
	}
	
	add_filter('body_class','my_browser_body_class');
}


/*-----------------------------------------------------------------------------------*/
/*  Root path
/*-----------------------------------------------------------------------------------*/

if( !function_exists( 'my_root_path' ) ) {
	function my_root_path($url) {
		$count = strlen(home_url());
		$path = substr($url, $count);
		return $path;
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Allow file download
/*-----------------------------------------------------------------------------------*/




/*-----------------------------------------------------------------------------------*/
/*	Load Theme Options
/*-----------------------------------------------------------------------------------*/

define('MY_FILEPATH', TEMPLATEPATH);
define('MY_DIRECTORY', get_template_directory_uri());

require_once (MY_FILEPATH . '/functions/theme-functions.php');
