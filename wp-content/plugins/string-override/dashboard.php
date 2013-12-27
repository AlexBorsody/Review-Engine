<?php 
/*
this file contains the code for managing the dashboard wigdets
*/

function string_override_dashboard_widget()
{
//global $wp_meta_boxes;
//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
//unset($wp_meta_boxes['dashboard']['normal']['core']);
//unset($wp_meta_boxes['dashboard']['side']['core']);
//echo"<pre>";print_r($wp_meta_boxes['dashboard']);
//echo"</pre>";
wp_add_dashboard_widget('example_dashboard_widget', 'Latest Five Strings', 'list_latest_five');
}

// function to list 5 latest string on dashboard
function list_latest_five(){
global $wpdb;
$strings_list = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."string_override" );
//print_r($strings_list);
echo "<table><tr><td><b>List of latest strings</b></td></tr>";
foreach($strings_list as $stringitem){
echo "<tr><td>".$stringitem->id."</td>";
echo "<td>".$stringitem->name."</td>";
echo "<td>".$stringitem->value."</td></tr>";
}
echo "</table>";
}

// add action 

add_action('wp_dashboard_setup', 'string_override_dashboard_widget' );
?>