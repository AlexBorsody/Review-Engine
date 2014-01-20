<?php
add_action('wp_ajax_nopriv_admin_article_auto_save_trash', 	'tgt_admin_article_auto_save_trash');
add_action('wp_ajax_admin_article_auto_save_trash', 'tgt_admin_article_auto_save_trash');

function tgt_admin_article_auto_save_trash()
{
	try {
		$check_role = tgt_check_role();
		if($check_role != true)		
			throw new Exception(__('You are not permission','re'), 102);			
		// get paramester
		
		$category = $_POST['category'];
		$title = $_POST['article_title'];
		$content = $_POST['article_content'];			
		$post_id = $_POST['article_post_id'];
		
		$postarr = array(
			'post_status' => 'trash', 
		 	'post_type' => 'article',
			'post_author' => 1,			
			'post_title' => $title,
			'post_content' => $content,
			'post_category' => array($category)
		);
		$re = 0;
		if($post_id > 0)
		{
			$postarr = array_merge($postarr, array('ID' => $post_id));
			$re = wp_update_post($postarr);
		}	
		else 
			$re = wp_insert_post($postarr);
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