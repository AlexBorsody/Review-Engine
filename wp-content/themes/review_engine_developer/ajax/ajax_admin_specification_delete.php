<?php
/*
 * @Author: James. 
 */
add_action('wp_ajax_nopriv_admin_spec_delete', 	'review_ajax_spec_del');
add_action('wp_ajax_admin_spec_delete', 'review_ajax_spec_del');

function review_ajax_spec_del(){
	try{
		// check auth
		$check_role = tgt_check_role();
		if($check_role != true)		
		{			
			header('HTTP/1.1 404 Not Found');
			exit;
		}
		// get parameter
		global $wpdb;
		$tgt_spec			= $wpdb->prefix . 'tgt_spec';
		$tgt_spec_category	= $wpdb->prefix . 'tgt_spec_category';
		$tgt_spec_value		= $wpdb->prefix . 'tgt_spec_value';
		
		$para = explode('_',$_POST['para']);	
		
		// process data
		// Delete group spec
		$check = 0;
		if($para[1] == 'group')
		{
			$wpdb->query("DELETE FROM $tgt_spec WHERE ID = $para[2]");
			$wpdb->query("DELETE FROM $tgt_spec_category WHERE spec_id = $para[2]");
			$wpdb->query("DELETE FROM $tgt_spec_value WHERE spec_id = $para[2]");
			$check = 1;
		}
		// Delete each spec value
		if($para[1] == 'spec' && isset($para[4]))
		{
			$wpdb->query("DELETE FROM $tgt_spec_value WHERE spec_value_id = $para[2]");			
			$check = 2;
		}
		// prepare response
		$response = json_encode(array('success' => true, 'para' => $check));
	
	} // if process fail, return error message
	catch (Exception $ex){
		$response = json_encode(array('success' => false, 'message' => $ex->getMessage()));
	}
	
	//return respose
	header('HTTP/1.1 200 OK');
	header('Content-Type: application/json');
	echo $response;

	exit;
}

?>