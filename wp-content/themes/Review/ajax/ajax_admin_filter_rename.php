<?php
/*
 * @Author: James. 
 */
add_action('wp_ajax_nopriv_admin_filter_rename', 	'review_ajax_filter_rename');
add_action('wp_ajax_admin_filter_rename', 'review_ajax_filter_rename');

function review_ajax_filter_rename(){
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
		$para = explode('_',$_POST['id_filter']);
		$new_name = $_POST['name_filter'];
		
		// process data
		// Delete group filter
		$check = 0;
		if($new_name  == '')
		{
			$check =0;
		}
		else
		{
			if($para[0] == 'group')
			{
				$wpdb->query("	UPDATE ".$wpdb->prefix."tgt_filter 
								SET name = '$new_name'
								WHERE ID = $para[1]");
				$check = 1;
			}
			// Delete each filter value
			if($para[0] == 'value')
			{				
				$wpdb->query("	UPDATE ".$wpdb->prefix."tgt_filter_value 
								SET name = '$new_name'
								WHERE ID = $para[1]");
				$check = 2;
			}
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