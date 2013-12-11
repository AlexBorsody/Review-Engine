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


add_action( 'admin_footer', 'remove_temp_role', 10 );
function remove_temp_role () { ?>
<script type="text/javascript">
(function($) {
$("#createuser select > option[value='author']").remove();
$("#createuser select > option[value='subscriber']").remove();
$("#createuser select > option[value='contributor']").remove();
$("#createuser select > option[value='editor']").remove();
})(jQuery)
</script>
<?php }

//Fix for cookie error while login.
function set_wp_test_cookie() {
       setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
       if ( SITECOOKIEPATH != COOKIEPATH )
               setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);
}
add_action( 'after_setup_theme', 'set_wp_test_cookie', 101 );

//Removed the pages for reviewer role
add_action( 'admin_menu', 'my_remove_menu_pages' );
function my_remove_menu_pages() {
    global $user_ID;
    if ( current_user_can( 'reviewer' ) ) {
          remove_menu_page( 'edit.php' );
          remove_menu_page( 'edit.php?post_type=article' );
          remove_menu_page('tools.php');
          remove_menu_page('edit-comments.php');
          //remove_menu_page('index.php');
          remove_menu_page('post-new.php');
    }
}
add_action('admin_head','remove_dashboard');
function remove_dashboard(){
     global $user_ID;
     if ( current_user_can( 'reviewer' ) ) {
          echo "<style> 
                    #dashboard-widgets-wrap,li#wp-admin-bar-comments, li#wp-admin-bar-new-content, #screen-meta-links{display:none;}
                    /*html.wp-toolbar { padding-top: 0px !important;*/ } 
               </style>";
          //add_menu_page('Back to homepage', 'custom menu', 'manage_options', get_bloginfo('url'), 'my_custom_menu_page', plugins_url( 'myplugin/images/icon.png' ), 6 );
     }
}
