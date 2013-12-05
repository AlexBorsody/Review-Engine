<?php
/*
 * @Author: James. 
 */
add_action('wp_ajax_nopriv_get_filter_by_category', 	'review_ajax_get_filter');
add_action('wp_ajax_get_filter_by_category', 'review_ajax_get_filter');

function review_ajax_get_filter(){
	$response;
	try{	
		// check auth
		$check_role = tgt_check_role();
		if($check_role != true)
		{			
			header('HTTP/1.1 404 Not Found');
			exit;
		}
			
		/**
		 * Get parameter
		 */
		$cat_id = $_REQUEST['cat_id'];		
		
		/**
		 * Processing data
		 */
		$filters_arr = get_all_data_filter_by_cat_id_tgt($cat_id);
		$filters = '';
		foreach ($filters_arr as $k => $v) {
			$filters .= '<div id="group_' .$v['filter_id']. '">';
			$filters .= '<h4 class="filter_title">' .$v['group_name']. '&nbsp; <span>[+]</span></h4>';
			if (is_array($v['value']) && count($v['value']) > 0 ){
				$filters .= '<ul id="g_' .$v['filter_id']. '">';
				foreach ($v['value'] as $k1 => $v1) {
					$filters .= '<li>';
					$filters .= '<input type="checkbox" class="filtervalue" name="product[filter][g'.$v['filter_id'].'][]" value="'.$v1['filter_value_id'].'"/>';
					$filters .= '<label for="product[filter]['.$v['filter_id'].']"> '.$v1['value_name'].' </label>';
				}				
			}
		}
		
		// prepare response		
		$response = json_encode(array('success' => true, 'filters' => $filters));
	
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