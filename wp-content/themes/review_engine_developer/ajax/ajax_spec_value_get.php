<?php
/*
 * @Author: James. 
 */
add_action('wp_ajax_nopriv_get_spec_by_post', 	'review_ajax_get_spec_value');
add_action('wp_ajax_get_spec_by_post', 'review_ajax_get_spec_value');

function review_ajax_get_spec_value(){
	$response;
	try{	
		// check auth
		// this no need to check auth
			
		/**
		 * Get parameter
		 */
		$post_id = $_REQUEST['post_id'];		
		
		/**
		 * Processing data
		 */
		$specs = get_post_meta($post_id, 'tgt_product_spec', true);
		$result = array();
		foreach( (array) $specs as $id => $value){
			$result[] = array('ID' => $id, 'value' =>$value);
		}
		// prepare response
		$response = json_encode(array('success' => true, 'specs' => $result));
	
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