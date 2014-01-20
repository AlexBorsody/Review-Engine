<?php
add_action('wp_ajax_nopriv_admin_product_spec_get', 	'review_ajax_get_specification');
add_action('wp_ajax_admin_product_spec_get', 'review_ajax_get_specification');

function review_ajax_get_specification(){
	try{
		// check auth
//		$check_role = tgt_check_role();
//		if($check_role != true)			
//			throw new Exception('You are not permission', 103);
			
		// get parameter
		$cat_id = $_REQUEST['cat_id'];
		global $wpdb;
		
		$spec_results = get_all_data_spec_by_cat_id_tgt($cat_id);
		
		/**
		 * Process Data
		 */	
		// query spec from database
		//$spec = array();				
		
		// prepare response
		//$response = $test;
		//$response = json_encode(array('success' => true, 'spec' => $spec));
	
	} // if process fail, return error message
	catch (Exception $ex){
		$response = json_encode(array('success' => false, 'message' => $ex->getMessage()));
	}
	
	//return respose
//	header('Content-Type: application/json');
//	echo $response;
	if(!empty($spec_results))
	{
		
		foreach ($spec_results as $specs)
		{
			//echo '<tr><td>';
			echo $specs['group_name'];
			echo '<table width="50%" >';
			$spec_arr = json_decode($specs['value']);
			foreach ($spec_arr as $spec) {
			?>
				<tr>
					<td width="40%"><?php echo $spec['value_name']; ?></td>
					<td width="60%"> <input type="text" name="<?php echo $spec['spec_value_id']; ?>" value="" > </td>
				</tr>			
			<?php
			}
			echo '</table>';
//			echo '<table><tr>';				
//			echo '<td><input type="text"" name="" value="" /></td>';
//			echo '</tr>';
//			echo '</table>'; 
		}
		
	}
	exit;
}

?>