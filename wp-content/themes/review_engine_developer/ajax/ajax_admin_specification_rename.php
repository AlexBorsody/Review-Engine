<?php
/*
 * @Author: James. 
 */
add_action('wp_ajax_nopriv_admin_spec_rename', 	'review_ajax_spec_rename');
add_action('wp_ajax_admin_spec_rename', 'review_ajax_spec_rename');

function review_ajax_spec_rename(){
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
		$para = explode('_',$_POST['id_spec']);
		$new_name = $_POST['name_spec'];
		
		// process data
		// Delete group spec
		$check = 0;
		if($new_name  == '')
		{
			$check =0;
		}
		else
		{
			if($para[0] == 'group')
			{
				$wpdb->query("	UPDATE ".$wpdb->prefix."tgt_spec 
								SET name = '$new_name'
								WHERE ID = $para[1]");
				$check = 1;
			}
			// Delete each spec value
			if($para[0] == 'spec' && isset($para[3]))
			{				
				$tmp_spec = array();
				$curr_spec_arr = array();
				// Get the current specification base on group id
				$q_spec="SELECT value FROM ".$wpdb->prefix."tgt_spec WHERE ID =  $para[1]";	
				$curr_spec_tmp = $wpdb->get_results( $q_spec );
				$curr_spec = json_decode($curr_spec_tmp[0]->value);	
				// Delete Specification value
				if (!empty($curr_spec))
				{					
					$c = 0;
					foreach($curr_spec as $k=>$v)
					{						
						if($k == $para[2].'_'.$para[3])
						{						
							unset($curr_spec->$k);						
						}					
					}	
					foreach($curr_spec as $k=>$v)
					{						
						$curr_spec_arr = array_merge($curr_spec_arr,array($k => $v));
					}
				}
				$new_spec = array_merge($curr_spec_arr,array($para[2].'_'.$para[3] => $new_name));
				foreach ($new_spec as &$a) { 
					$a = ascii_to_entities( $a ); 
				} 
				$new_spec = json_encode($new_spec);				
				
				$wpdb->query("	UPDATE ".$wpdb->prefix."tgt_spec 
								SET value = '$new_spec'
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