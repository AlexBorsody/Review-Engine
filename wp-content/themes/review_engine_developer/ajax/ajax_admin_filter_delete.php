<?php
/*
 * @Author: James. 
 */

//add_action('wp_ajax_admin_filter_delete', 'tgt_filter_del');
add_action('wp_ajax_nopriv_admin-filter-delete', 	'review_ajax_filter_del');
add_action('wp_ajax_admin-filter-delete', 			'review_ajax_filter_del');

function review_ajax_filter_del(){
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
		$tgt_filter				= $wpdb->prefix . 'tgt_filter';
		$tgt_filter_category	= $wpdb->prefix . 'tgt_filter_category';
		$tgt_filter_value		= $wpdb->prefix . 'tgt_filter_value';
		
		
		$para = explode('_',$_POST['para']);	
		
		// process data
		// Delete group filter
		$check = 0;
		if($para[1] == 'group')
		{
			$wpdb->query("DELETE FROM $tgt_filter WHERE ID = $para[2]");
			$wpdb->query("DELETE FROM $tgt_filter_category WHERE filter_id = $para[2]");
			$wpdb->query("DELETE FROM $tgt_filter_value WHERE group_id = $para[2]");	
			$check = 1;
		}
		// Delete each filter value
		if($para[1] == 'filter' && isset($para[4]))
		{			
			$wpdb->query("DELETE FROM $tgt_filter_value WHERE ID = $para[2]");	
			$check = 2;
		}
		// prepare response
		$response = json_encode(array('success' => true, 'para' => $check));
	
	} // if process fail, return error message
	catch (Exception $ex){
		//$response = json_encode(array('success' => false, 'message' => $ex->getMessage()));
		$response = json_encode(array('success' => false, 'message' => $ex->getMessage()));
	}
	
	//return respose
	header('HTTP/1.1 200 OK');
	header('Content-Type: application/json');
	echo $response;

	exit;
}

?>