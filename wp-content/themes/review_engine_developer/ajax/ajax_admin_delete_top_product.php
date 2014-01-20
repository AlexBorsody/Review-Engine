<?php
add_action('wp_ajax_nopriv_admin_delete_top_product', 	'admin_delete_top_product');
add_action('wp_ajax_admin_delete_top_product', 'admin_delete_top_product');
function admin_delete_top_product()
{
    try {
            $check_role = tgt_check_role();
            if($check_role != true)
                    throw new Exception(__('You are not permission','re'), 102);
            // get paramester
                      
            $product_id = $_POST['product_id'];
            if($product_id > 0)
            {
            	$top_products = get_option(PRODUCT_TOP);
            	if(!empty($top_products) && is_array($top_products))
            	{
            		foreach ($top_products as $key=>$id)
            		{
            			if($id == $product_id)
            			 unset($top_products[$key]);
            		}
            		update_option(PRODUCT_TOP, $top_products);
            	}
            	if(empty($top_products))
            		$re = 0;
                else $re = count($top_products);
            }            
            else
                    $re = -1;
            // prepare response
            $response = json_encode(array('success' => true, 'para' => $re));
	}
	catch (Exception $ex)
	{
		$response = json_encode(array('success' => false, 'message' => $ex->getMessage()));		
	}	
	header('HTTP/1.1 200 OK');
	header('Content-Type: application/json');
	echo $response;
	exit;
}