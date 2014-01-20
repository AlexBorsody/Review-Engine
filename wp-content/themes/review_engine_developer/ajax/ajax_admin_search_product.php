<?php
add_action('wp_ajax_nopriv_admin_article_search_product', 	'tgt_admin_search_product');
add_action('wp_ajax_admin_article_search_product', 'tgt_admin_search_product');

function tgt_admin_search_product()
{
	try {
		$check_role = tgt_check_role();
		if($check_role != true)		
			throw new Exception(__('You are not permission','re'), 102);			
		// get paramester
		global $wpdb;
		$para = $_POST['category'];
		$product_title = $_POST['product_title'];
		$product_id = $_POST['product_id'];
		
		$list_product = array();
		if($para > 0)
		{			
			global $wpdb;
			if(empty($product_title))
			{
				$sql = "SELECT id, post_title, post_content FROM $wpdb->posts 
				WHERE post_type='product' AND Post_status='publish' AND id IN (SELECT object_id
													FROM $wpdb->term_relationships tr, $wpdb->term_taxonomy tt, $wpdb->terms t 
													WHERE tt.taxonomy='category' AND tr.term_taxonomy_id = tt.term_taxonomy_id AND t.term_id= tt.term_id AND t.term_id=".$para.")";
			}
			else 
				$sql = "SELECT id, post_title, post_content FROM $wpdb->posts WHERE Post_status='publish' AND post_title LIKE '%".$product_title."%' AND post_type='product' AND id IN (SELECT object_id FROM $wpdb->term_relationships tr, $wpdb->term_taxonomy tt, $wpdb->terms t WHERE tt.taxonomy='category' AND tr.term_taxonomy_id = tt.term_taxonomy_id AND t.term_id= tt.term_id AND t.term_id=".$para.")";
			$list_product = $wpdb->get_results($sql);			
			$re = '';
		}
		if(!empty($list_product) && $product_id < 1)
		{
			$re .= '<h2>'.__ ('List of Product', 're').'</h2>';
			$re .= '<div class="postbox">';						
			$re .= '<table border="0" width="100%" class="submitbox" name="seach_product" id="seach_product" cellpadding="0" cellspacing="0">';
			$re .= '<tr><th width="5%"></th>';
			$re .= '<th width="10%"></th>';
			$re .= '<th width="85%"></th></tr>';			
			foreach ($list_product as $list)
			{				
				$link = URL_UPLOAD;
				$images = array();
				$images = get_post_meta($list->id, 'tgt_product_images', true);
				$re .= '<tr>';
				$re .= '<td><input type="radio" value="'.$list->id.'" id="radio_product" name="radio_product" style="margin-left: 10px;"';				
				$re .= '</td>';
				$title = strip_tags($list->post_title);
				$content = strip_tags(substr($list->post_content, 0, 250));
				$image_path = '';
				if(!empty($images))				
					$image_path = URL_UPLOAD.'/'.$images[0]["thumb"];
				else 
					$image_path = TEMPLATE_URL.'/images/no_image.jpg';
				if($image_path!='') 
					$re .= '<td><img src="'.$image_path.'" height="48" width="48" alt="image111" />'.'</td>';
				$re .= '<td style="padding: 5px; height: 57px; overflow: hidden;"> <strong>'.$title.'</strong><br>'.$content.'</td>';				
				$re .= '</tr>';
			}
			$re .= '</table>';
			$re .= '</div>';
		}
		else if(!empty($list_product) && $product_id > 0)
		{
			$re = '<h2>'.__ ('You chose', 're').'</h2>';
			$re .= '<div class="postbox">';
			$re .= '<table border="0" width="100%" class="submitbox" name="seach_product_1" id="seach_product" cellpadding="0" cellspacing="0">';
			$re .= '<th width="10%"></th>';
			$re .= '<th width="85%"></th>';			
			foreach ($list_product as $list)
			{				
				if($product_id == $list->id)
				{
					$link = URL_UPLOAD;
					$images = array();
					$images = get_post_meta($list->id, 'tgt_product_images', true);
					$re .= '<tr>';
					$title = strip_tags($list->post_title);
					$content = strip_tags(substr($list->post_content, 0, 250));
					if(!empty($images))				
						$image_path = URL_UPLOAD.'/'.$images[0]["thumb"];
					else $image_path = TEMPLATE_URL.'/images/no_image.jpg';
						$re .= '<td style="padding-left: 8px;"><img src="'.$image_path.'" height="48" width="48" alt="image111" />'.'</td>';				
					$re .= '<td> <div style="height: 57px; overflow: hidden; padding: 5px;"> <label><strong>'.$title.'</strong><br>'.$content.'</label> </div> </td>';				
					$re .= '</tr>';
				}
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