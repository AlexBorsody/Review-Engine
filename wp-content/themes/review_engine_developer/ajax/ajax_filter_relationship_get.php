<?php
/*
 * @Author: James. 
 */
add_action('wp_ajax_nopriv_get_filter_relationship', 	'review_ajax_get_filter_relationship');
add_action('wp_ajax_get_filter_relationship', 'review_ajax_get_filter_relationship');

function review_ajax_get_filter_relationship(){
	$response;
		
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
		$post_id = $_REQUEST['post_id'];		
		
		/**
		 * Processing data
		 */
		global $wpdb;
			$prefix = $wpdb->prefix;
			$table_filter = $prefix . 'tgt_filter';
			$table_filter_value = $prefix . 'tgt_filter_value';
			$table_filter_rel = $prefix . 'tgt_filter_relationship';
			
			$sql = "SELECT val.ID AS ID, val.name AS name, filter.ID AS group_id, filter.name AS group_name
				FROM $table_filter_rel AS relationship, $table_filter AS filter, $table_filter_value AS val
				WHERE (relationship.post_id = $post_id)
					AND (filter.ID = val.group_id)
					AND (val.ID = relationship.filter_value_id)";
					
			$filters = $wpdb->get_results($sql, ARRAY_A);		
		// prepare response
		$response = json_encode(array('success' => true, 'filters' => $filters));	
	
	//return respose
	header('HTTP/1.1 200 OK');
	header('Content-Type: application/json');
	echo $response;
	
	exit;
}

?>