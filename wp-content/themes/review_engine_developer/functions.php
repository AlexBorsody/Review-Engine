<?php
// define some constant
define ('FOLDER_STR', get_template()); // ~ name template directory
define('HOME_URL', get_bloginfo('url')); //reference http://localhost/wordpress_3
define('STYLESHEET_URL', get_bloginfo('stylesheet_url'));//reference /wordpress/wp-content/themes/hotel_pro/style.css
define('TEMPLATE_URL', get_bloginfo('template_url')); //reference /wordpress/wp-content/themes/hotel_pro
define ('WP_URL', get_bloginfo('wpurl')); //reference http://localhost/wordpress_3
define('DS', DIRECTORY_SEPARATOR);

// define path
define('PATH_LIB', 					TEMPLATEPATH . DS . 'lib');
define('PATH_PAGES', 				TEMPLATEPATH . DS . 'pages');
define('PATH_PROCESSING', 			TEMPLATEPATH . DS . 'processing');
define('PATH_ADMIN', 				TEMPLATEPATH . DS . 'admin');
define('PATH_ADMIN_PROCESSING', 	TEMPLATEPATH . DS . 'admin_processing');
define('PATH_FUNCTIONS', 			TEMPLATEPATH . DS . 'functions');
define('PATH_AJAX', 					TEMPLATEPATH . DS . 'ajax');

// include the library helper
require_once PATH_LIB . DS . 'pagination.php';
require_once PATH_LIB . DS . 'html.php';
require_once PATH_LIB . DS . 'facebook.php';
//require_once PATH_LIB . DS . 'tgt_user.php';
$helper = new Html();
global $current_custom_page, $is_main_query;
$is_main_query = true;
//
require_once PATH_FUNCTIONS . DS . 'shortcodes.php';
require_once PATH_FUNCTIONS . DS . 'functions.php';
require_once PATH_ADMIN . DS . 'admin.php';

// auto login facebook
tgt_login_facebook_auto();