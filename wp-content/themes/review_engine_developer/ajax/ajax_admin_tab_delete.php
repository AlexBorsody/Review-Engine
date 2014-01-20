<?php
/*
 * @Author: James. 
 */
add_action('wp_ajax_nopriv_admin_tab_delete', 	'review_ajax_tab_del');
add_action('wp_ajax_admin_tab_delete', 'review_ajax_tab_del');

function review_ajax_tab_del(){
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
		$tgt_tab			= $wpdb->prefix . 'tgt_tab';

		$para = $_POST['para'];	
		
		// process data
		// Delete tab
		
		$wpdb->query("DELETE FROM $tgt_tab WHERE ID = $para");			
		$check = 1;
		
		
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