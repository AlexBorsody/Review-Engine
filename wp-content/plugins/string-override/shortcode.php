<?php
/*
shortcode for string override
*/
function short_string_override($id_arr) {
extract(shortcode_atts(array('id' => 'your string id here'), $id_arr));
global $wpdb;
$result = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."string_override where id= '".$id."'");
$toreturn = "";
if($result[0]->active == 1){
$toreturn = $result[0]->value;
}
	return $toreturn; 
}
add_shortcode('stringoverride', 'short_string_override');
function string_override_manual($id)
{
global $wpdb;
$result = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."string_override where id= '".$id."'");
$toreturn = "";
if($result[0]->active == 1){
$toreturn = $result[0]->value;
}
	return $toreturn; 
 
}
?>
