<?php

/* These are functions specific to the included option settings and this theme */


/*-----------------------------------------------------------------------------------*/
/* Add Body Classes for Layout
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'tz_body_class' ) ) { 
	function tz_body_class($classes) {
		$shortname = get_option('tz_shortname');
		$layout = get_option($shortname .'_layout');
		if ($layout == '') {
			$layout = 'layout-2cr';
		}
		$classes[] = $layout;
		return $classes;
	}
	add_filter('body_class','tz_body_class');
}

// if is child return true
function is_child($page_id) {
	global $post;
	$is_child = false;
	if ($post->post_parent != 0) $is_child=true;
	return $is_child;
};

function p($str) {
	return $_POST[$str];
}



function get_post_img($size="thumbnail", $item_id) {
	global $wpdb;
	$res = end($wpdb->get_results("SELECT meta_value FROM wp_frm_item_metas WHERE field_id = 130 AND item_id = $item_id"));

	if ($res) 
		echo wp_get_attachment_image($res->meta_value,$size);
}

function get_base($key) {
	global $wpdb;
	$res = $wpdb->get_results("SELECT meta_value FROM wp_usermeta WHERE meta_key = '$key'");
	$keys = array();
	foreach ($res as $key) {
		$key = end($key);
		if ($key) {
			$add = true;
			foreach ($keys as $val) {
				if ($val == $key) $add = false;
			}
			if($add) $keys[] = $key;
		}
	}
	return $keys;
}



// User roles
add_role('seller', 'Продавец', array(
    'read' => true, // True allows that capability
));

add_action('wp_ajax_check_email', 'check_email');
add_action('wp_ajax_nopriv_check_email', 'check_email');

function check_email() {
	$email = $_POST['email'];
	$res = get_user_by('email', $email);
	if (!$res) {
		die(true);		
	} else
	die(false);
}

/* POST TYPES AND TAXONOMY */

add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'comments',
		array(
			'labels' => array(
			'name' => 'Отзывы',
			'singular_name' => 'Отзыв'
			),
			'menu_position' => 4,
			'supports' => array('title','editor','thumbnail','custom-fields','page-attributes'),
			'public' => true,
			'hierarchical' => false,
			'_builtin' => false,
			'capability_type' => 'post',
			'has_archive' => 'comments',
			'rewrite' => array('slug' => 'comments','with_front' => FALSE)
		)
	);
	flush_rewrite_rules();
}

add_action( 'init', 'create_comments_tax' );
function create_comments_tax() {
	register_taxonomy('comments-type',array (
	0 => 'comments',
	),array(
		'hierarchical' => true,
		'label' => 'Виды отзывов',
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => false,
		'labels' => array('name' => 'Виды отзывов'),
		'singular_label' => 'Вид отзывов')
	);
	flush_rewrite_rules();
}


//ФУНКЦИЯ ДЛЯ СОРТИРОВКИ МАССИВОВ ОБЪЕКТОВ ПО ОДНОМУ ИЗ ПРИЗНАКОВ ОБЪЕКТА
function cmp($a, $b)
{
	if(  $a->sorting ==  $b->sorting ){ return 0 ; } 
  	return ($a->sorting < $b->sorting) ? -1 : 1;
}


//функция доступа по роли пользователя
function is_user_have_role($user_ID, $role_name) {
	$user_have_role = false;
	if($user_ID < 1) return $user_have_role;
	$user_info = get_userdata($user_ID);
	foreach ($user_info->roles as $role) {
		if($role_name == $role) $user_have_role = true;
	}
	return $user_have_role;
}

function t($str) {
	$translates = array(
		'not_approved' => 'Не подтвержден',
		'approved' => 'Подтвержден',
	);

	foreach ($translates as $key => $value) {
		if($str == $key) {
			return $value;
			break;
		}
	}
}

?>
