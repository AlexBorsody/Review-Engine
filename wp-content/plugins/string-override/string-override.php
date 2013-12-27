<?php 
/*
Plugin Name: String Override
Plugin URI: http://www.perisun.com
Description: replace text in template and post/pages/widgets.
Author: Satish Kadyan
Version: 1.1
Author URI: http://www.perisun.com
*/
function string_override_install()
{
    global $wpdb;
    $table = $wpdb->prefix."string_override";
    $structure = "CREATE TABLE $table (id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200) NOT NULL, value LONGTEXT NOT NULL, active INT(1) NOT NULL DEFAULT '1')";
    $wpdb->query($structure);
}
/* registered action hooks for the string overrirde
*/ 
require_once("shortcode.php");
require_once("admin-menu.php");
require_once("dashboard.php");
require_once("actions.php");
add_action('activate_string-override/string-override.php', 'string_override_install');
if($_REQUEST['string_override_admin_action'] == 'edit_string') {	
add_action('admin_init', 'string_override_admin_submit_string');}
add_filter('widget_text', 'do_shortcode');

?>
