<?php
add_action('wp_ajax_nopriv_like_review', 	'review_ajax_like_review');
add_action('wp_ajax_like_review', 'review_ajax_like_review');

function review_ajax_like_review(){
	$response;	
	try{	
		// check auth
		// this no need to check auth
			
		/**
		 * Get parameter
		 */
		$review_ID = $_REQUEST['review_id'];
		$user_ID = $_REQUEST['user_id'];
		$type = $_REQUEST['type'];
		global $current_user;
		/**
		 * Processing data
		 */
		$likes = get_comment_meta($review_ID, 'tgt_likes', true);
		$dislikes = get_comment_meta($review_ID, 'tgt_dislikes', true);
		$review_owner = get_commentdata($review_ID);
		if (!is_array($likes) ) $likes = array();
		if (!is_array($dislikes) ) $dislikes = array();
		
		// validate
		if ((in_array( $user_ID, $likes ))  || (in_array( $user_ID, $dislikes )) ){
			throw new Exception(__('User has voted already' , 're') );
		}
		$current_count = 0;
		if ($type == 1) { // if like
			$likes[] = $user_ID;
			update_comment_meta( $review_ID, 'tgt_likes' , $likes);
			
			if(get_user_meta($current_user->ID,'tgt_thumbup_count',true) != '')
				$current_count = get_user_meta($current_user->ID,'tgt_thumbup_count',true);
			$current_count ++;
			update_user_meta($current_user->ID, 'tgt_thumbup_count', $current_count );			
		}else {
			$dislikes[] = $user_ID;
			update_comment_meta( $review_ID, 'tgt_dislikes' , $dislikes);
			
			if(get_user_meta($current_user->ID,'tgt_thumbdown_count',true) != '')
				$current_count = get_user_meta($current_user->ID,'tgt_thumbdown_count',true);
			$current_count ++;
			update_user_meta($current_user->ID, 'tgt_thumbdown_count', $current_count );			
		}
		
		// prepare response
		//$response = $test;
		$count = 0;
		if ($type) $count = count($likes);
		else $count = count($dislikes);
		$response = json_encode(array('success' => true, 'count' => $count));
	
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