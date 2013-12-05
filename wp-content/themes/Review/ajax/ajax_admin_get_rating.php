<?php
add_action('wp_ajax_nopriv_admin_get_rating', 	'review_ajax_get_rating');
add_action('wp_ajax_admin_get_rating', 'review_ajax_get_rating');

function review_ajax_get_rating(){
	try{		
		// check auth
		$check_role = tgt_check_role();
		if($check_role != true)			
		{			
			header('HTTP/1.1 404 Not Found');
			exit;
		}
			
		// get parameter
		// process data
		$globalRating = get_option(SETTING_RATING);
		if (empty($globalRating)) $globalRating = array();
		
		$rating = get_option(SETTING_CATEGORY_RATING);
		if (empty($rating)) $rating = array();
	
		$jsonCat = array();
		foreach ($rating as $key => $cat){
			if (!empty($cat))
				foreach ($cat as $r){
					$jsonObject = array();
					$jsonObject['id'] = $r;
					$jsonObject['name'] = $globalRating[$r];
					$jsonCat[$key][] = $jsonObject;
				}
		}
		
		// prepare response
		$response = json_encode(array('success' => true, 'rating' => $jsonCat));
	
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