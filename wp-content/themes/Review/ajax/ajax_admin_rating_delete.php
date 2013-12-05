<?php
add_action('wp_ajax_nopriv_admin_rating_delete', 	'review_ajax_rating_delete');
add_action('wp_ajax_admin_rating_delete', 'review_ajax_rating_delete');

function review_ajax_rating_delete(){
	try{	
		// check auth
		$check_role = tgt_check_role();
		if($check_role != true)			
		{			
			header('HTTP/1.1 404 Not Found');
			exit;
		}
			
		// get parameter
		$rating_id = $_POST['rating_id'];		
		
		/**
		 * Process Data
		 */
		
		
		$ratings = get_option(SETTING_RATING);
		
		// delete rating in category
		$cat_rating = get_option(SETTING_CATEGORY_RATING);
		foreach ($cat_rating as $key => $rate){
			$index = array_search($rating_id, $rate);
			if ($index !== false){
				unset($cat_rating[$key][$index]);
			}
		}
		$test = json_encode($cat_rating);
		update_option(SETTING_CATEGORY_RATING, $cat_rating);
		
		// delete rating
		unset($ratings[$rating_id]);
		update_option(SETTING_RATING, $ratings);
		
		// prepare response
		//$response = $test;
		$response = json_encode(array('success' => true, 'id' => $rating_id));
	
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