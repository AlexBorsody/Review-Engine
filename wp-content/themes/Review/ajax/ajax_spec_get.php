<?php
/*
 * @Author: James. 
 */
add_action('wp_ajax_nopriv_get_spec_by_category', 	'review_ajax_get_spec');
add_action('wp_ajax_get_spec_by_category', 'review_ajax_get_spec');

function review_ajax_get_spec(){
	$response;
	try{	
		// check auth
		// this no need to check auth
			
		/**
		 * Get parameter
		 */
		$cat_id = $_REQUEST['cat_id'];		
		
		/**
		 * Processing data
		 */
		$specs_arr = get_all_data_spec_by_cat_id_tgt($cat_id);
		
		$specs = '<table id="spectable" class="speclist" cellpadding="0" cellspacing="0" >';
		foreach ($specs_arr as $k => $v) {
			$specs .= '<tr>';
			$specs .= '<td colspan="2" class="group-title"><label for="' .$v['group_name']. '"> ' .$v['group_name']. ' </label></td>';
			if ( is_array($v['value']) &&  count($v['value']) > 0){
				
				foreach ($v['value'] as $k1 => $v1) {
					$specs .= '<tr>';
					$specs .= '<td> <label for="' .$v1['value_name']. '">' .$v1['value_name']. '</label> </td>';
					$specs .= '<td> <textarea type="text" class="specvalue" id="g_' .$v['spec_id']. '_' .$v1['spec_value_id']. '" name="product[spec][g_' .$v['spec_id']. '_' .$v1['spec_value_id']. ']" value="" ></textarea> </td>';
				}				
				
			}else{
				$specs .= '</tr>';
				$specs .= '<td colspan="2">'.__('This specification has no specification value','re'). '</td>';
			}
		
		}
		
		
		
		
		
		
		
		
		// prepare response
		$response = json_encode(array('success' => true, 'specs' => $specs));
	
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