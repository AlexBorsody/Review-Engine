<?php
add_action('wp_ajax_nopriv_admin_rating_edit', 	'review_ajax_rating_edit');
add_action('wp_ajax_admin_rating_edit', 'review_ajax_rating_edit');

function review_ajax_rating_edit(){
	$response;
	try{	
		// check auth
		$check_role = tgt_check_role();
		if($check_role != true)
		{			
			header('HTTP/1.1 404 Not Found');
			exit;
		}
			
		// get parameter
		$id = $_POST['id_rating'];
		$name = $_POST['name_rating'];
		
		/**
		 * Process Data
		 */
		$globalRating = get_option(SETTING_RATING);
		$globalRating[$id] = $name;
		update_option(SETTING_RATING, $globalRating);
		
		// prepare response
		//$response = $test;
		$response = json_encode(array('success' => true, 'name' => $name));
	
	} // if process fail, return error message
	catch (Exception $ex){
		$response = json_encode(array('success' => false, 'message' => $ex->getMessage()));
		header('HTTP/1.1 500 Internal Server Error');
		header('Content-Type: application/json');
		echo $response;
		
		exit;
	}
	
	//return respose
	header('HTTP/1.1 200 OK');
	header('Content-Type: application/json');
	echo $response;
	
	exit;
}

?>