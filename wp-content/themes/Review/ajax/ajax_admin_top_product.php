<?php
add_action('wp_ajax_nopriv_admin_top_product', 	'review_ajax_top_product');
add_action('wp_ajax_admin_top_product', 'review_ajax_top_product');

function review_ajax_top_product()
{
    try {
            $check_role = tgt_check_role();
            if($check_role != true)
                    throw new Exception(__('You are not permission','re'), 102);
            // get paramester
            global $wpdb;            
            $product_title = $_POST['product_title'];
            $first = $_POST['first'];
            $list_product = array();
            $re = '';
            if($first == 1)
            {
                // search product with maximun rating
               /*$tmp_products = get_posts(array('post_type' => 'product', 'post_status' => 'publish'));
               $rating_products = array();
               if(!empty($tmp_products))
               {
                   foreach ($tmp_products as $tmp_product)
                   {
                        //$rate = get_post_meta($tmp_product->ID, PRODUCT_RATING, true);
                        $rate = get_rating_value($tmp_product->ID);
                        if(empty($rate) ) $rate = 0;
                        $rating_products[$tmp_product->ID] = $rate;
                   }
                   arsort($rating_products);
               }
               if(!empty ($rating_products))
               {
                   $i=0;
                   $max = 10;//get_option(SETTING_TOP_NUMBER_PRODUCT);
                   foreach ($rating_products as $key=>$rating_product)
                   {
                       foreach ($tmp_products as $tmp_product)
                       {
                           if($i< $max && $tmp_product->ID == $key)
                                $list_product[] = $tmp_product;
                       }
                       $i++;
                   }
               }*/
                $list_product = get_top_product_rating();
            }
            if(!empty($product_title))
            {
                $list_product = array();
                global $wpdb;
                $sql = "SELECT ID, post_title FROM $wpdb->posts WHERE post_type='product' AND post_status='publish' AND post_title LIKE '%" . $product_title . "%'";
                $list_product = $wpdb->get_results($sql);
                $re = '';
            }
            if(!empty($list_product))
            {
                $re .= '<h2>'.__ ('List of Product', 're').'</h2>';
                $re .= '<div class="postbox" style="width: 55%">';
                $re .= '<table border="0" width="100%" class="submitbox" name="seach_product" id="seach_product" cellpadding="0" cellspacing="0">';
                $re .= '<tr><th width="5%"></th>';
                $re .= '<th width="40%"></th>';
                $re .= '<th width="30%"></th>';
                $re .= '<th width="30%"></th></tr>';
                $i = 0;
                foreach ($list_product as $list)
                {
                    if(empty($rate_display)) $rate_display = 0;
                    $re .= '<tr>';
                    $re .= '<td width="5%"><input class="check_product" type="checkbox" value="'.$list->ID.'" id="check_product_' . $i++ . '" name="check_product[]" style="margin-left: 10px;"';
                    $re .= '</td>';
                    $title = strip_tags($list->post_title);
                    $re .= '<td width="40%" style="padding: 5px; height: 40px; overflow: hidden;"> '.$title.'</td>';
                    $re .= '<td width="30%" style="padding: 5px; height: 40px; overflow: hidden;"> '. get_categories_name($list->ID). '</td>';
                    $re .= '<td width="25%" style="padding: 5px; height: 40px; overflow: hidden;"> '. tgt_get_rating( get_rating_value($list->ID), 'top_rating_'.$list->ID, true, 'star-disabled' ) . '</td>';
                    $re .= '</tr>';
                }
                $re .= '</table>';
                $re .= '</div>';
            }            
            else
                    $re = '';
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