<?php 
/* admin actions like listing strings, edit strings and add string code is there*/

function string_override_action() {
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
if($_GET['action']== '' ||$_GET['action']== 'list'){
string_list();
}elseif($_GET['action']== 'add'){
string_add();
}elseif($_GET['action']== 'edit'){
string_edit($_GET['id']);
}elseif($_GET['action']== 'delete'){
string_delete($_GET['id']);
}

}

function string_list(){
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."string_override");
echo "<div class='wrap'>";
echo "<h2>Strings List<a class=\"button add-new-h2\" href=\"admin.php?page=string-override&amp;action=add\">Add New</a></h2>";
echo '<table cellspacing="0" class="widefat post fixed"><thead><tr><th style="" class="manage-column column-title" id="title" scope="col">Id</th>';
echo '<th style="" class="manage-column column-title"  scope="col">Short code</th>';
echo '<th style="" class="manage-column column-title"  scope="col">String</th>';
echo '<th style="" class="manage-column column-title"  scope="col">value</th>';
echo '<th style="" class="manage-column column-title" scope="col">active</th>';
echo '<th style="" class="manage-column column-title"  scope="col">action</th>';
echo '</thead></tr><tbody>';
foreach($results as $result){
echo '<tr>';
echo '<td class="post-title column-title"><strong>'.$result->id.'</strong></td>';
echo '<td class="post-title column-title"><strong>[stringoverride id="'.$result->id.'"]</strong></td>';
echo '<td class="post-title column-title"><strong>'.$result->name.'</strong></td>';
echo '<td class="post-title column-title"><strong>'.substr($result->value,1,20).'</strong></td>';
echo '<td class="post-title column-title"><strong>'.$active=($result->active == 1) ? 'Yes' : 'No'.'</strong></td>';
echo '<td class="post-title column-title"><strong><a href="admin.php?page=string-override&amp;action=edit&amp;id='.$result->id.'">Edit</a>&nbsp;&nbsp;<a href="admin.php?page=string-override&amp;action=delete&amp;id='.$result->id.'">Delete</a></strong></td>';
echo '</tr>';
}
echo '</tbody></table>';
echo "</div>";
}
function string_add(){
echo "<div class='wrap'>";
echo "<h2>Strings Add<a class=\"button add-new-h2\" href=\"admin.php?page=string-override&amp;action=list\">Back to list</a></h2>";
echo '<form id="post" method="post" action="post.php" name="post"><div class="metabox-holder has-right-sidebar" id="poststuff">';
echo '<div id="post-body"><div id="post-body-content">';
echo '<div class="postbox "><div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>String Name</span></h3><div class="inside"><input type="text" autocomplete="off" id="title" value="" tabindex="1" size="30" name="string_name"></div></div>';
echo '<div class="postbox " ><div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>String Value</span></h3><div class="inside"><textarea id="string_value" tabindex="6" name="string_value" cols="40" rows="1"></textarea></div></div>';
echo '<div class="postbox " ><div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Is Active</span></h3><div class="inside"><input type="checkbox" checked id="string_active" name="string_active" ></div></div>';
echo '<input type="submit" value="Add String" name="submit" style="float: left;" class="button-primary"></div>';
echo '</div><input type="hidden" value="0" name="string_id"><input type="hidden" value="edit_string" name="string_override_admin_action"></form>';
echo "</div>";
}
function string_edit($stringId){
global $wpdb;
$result = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."string_override where id= '".$stringId."'");
//print_r($result[0]->id);
if($result[0]->active == '1'){$checked = 'checked';}elseif($result[0]->active == '0'){ $checked = '';}
echo "<div class='wrap'>";
echo "<h2>Strings Edit<a class=\"button add-new-h2\" href=\"admin.php?page=string-override&amp;action=list\">Back to list</a></h2>";
echo '<form id="post" method="post" action="" name="post"><div class="metabox-holder has-right-sidebar" id="poststuff">';
echo '<div id="post-body"><div id="post-body-content">';
echo '<div class="postbox "><div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>String Name</span></h3><div class="inside"><input type="text" autocomplete="off" id="title" value="'.$result[0]->name.'" tabindex="1" size="30" name="string_name"></div></div>';
echo '<div class="postbox " ><div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>String Value</span></h3><div class="inside"><textarea id="excerpt" tabindex="6" name="string_value" cols="40" rows="1">'.$result[0]->value.'</textarea></div></div>';
echo '<div class="postbox " ><div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Is Active</span></h3><div class="inside"><input type="checkbox" id="string_active" name="string_active" '.$checked.'></div></div>';
echo '<input type="submit" value="Update String" name="submit" style="float: left;" class="button-primary"></div>';
echo '</div><input type="hidden" value="'.$result[0]->id.'" name="string_id"><input type="hidden" value="edit_string" name="string_override_admin_action"></form>';
echo "</div>";
}
function string_override_admin_submit_string(){
//echo get_option('siteurl') ."/wp-admin/admin.php?page=string-override&message=".$_POST['string_override_admin_action'];
if($_POST['string_id'] > 0){
update_string($_POST['string_id']);
}else{
update_string(0);
}
wp_redirect(get_option('siteurl') ."/wp-admin/admin.php?page=string-override");
	exit();
}

function update_string($string_id){
  global $wpdb;
  $adding = false;
  $update = false;
  if((int)$string_id > 0) {
    $update = true;
  }
  if($_POST['string_active'] == "on"){
  $isactive=1;
  }else{$isactive=0;}
 $string_columns = array(
		'name' => $_POST['string_name'],
		'value' =>stripslashes($_POST['string_value']),
		'active' =>$isactive,
		);
		//print_r($string_columns);exit();
 if($update === true) {
		$where = array( 'id' => (int)$string_id );
		if ( false === $wpdb->update( $wpdb->prefix."string_override", $string_columns, $where ) ) {
echo "some error occurs editing string";
		}			  
 }else{
 		if ( false === $wpdb->insert($wpdb->prefix."string_override",  $string_columns ) ) {
echo "some error occurs adding new string";
		}	
 }
	
}

function string_delete($stringId){
global $wpdb;
$wpdb->query("DELETE FROM ".$wpdb->prefix."string_override WHERE id = '".$stringId."'");
//wp_redirect(get_option('siteurl') ."/wp-admin/admin.php?page=string-override");
//exit();
echo "string deleted";

}