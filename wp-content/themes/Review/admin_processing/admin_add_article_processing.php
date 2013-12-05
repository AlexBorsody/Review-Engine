<?php
global $user_ID;
$postid = 0;
$status = '';
$preview = 0;
$error = array();
if(isset($_POST['post_id']))
	$postid = $_POST['post_id'];
if(isset($_POST['save']))
{
	$error = check_error();
	$post_status = 'draf';
	if (empty($error))
	{
		if($postid > 0)
			$post_id = tgt_update_article($post_status, $postid);
		else
			$post_id = tgt_save_article($post_status);
		if($post_id > 0) $status = __ ('Article draft updated.', 're');
	}
}
elseif(isset($_POST['publish']))
{	
	$post_status = 'publish';
	$error = check_error();
	if(empty($error))
	{
		if($postid > 0)
		{
			$post_id = tgt_update_article($post_status, $postid);
			if($post_id > 0) $status = __ ('Article updated.', 're');
		}
		else
		{
			$post_id = tgt_save_article($post_status);
			if($post_id > 0) $status = __ ('Article published.', 're');
		}
	}
}
elseif (isset($_POST['preview']))
{
	$post_id = tgt_save_article('draf');
	if($post_id > 0)
		$preview = 1;
	else $preview = 0;
}
function tgt_update_article($post_status, $postedid)
{
	global $user_ID;
	$article = tgt_check_input();
	$post_id_save = 0;
	if(!empty($article))
	{
		$update_post = array(
			'ID' => $postedid,
			'post_title' => $article['title'],
		    'post_content' => $article['content'],
		    'post_status' => $post_status,
			'post_type' => 'article',
		    'post_author' => $user_ID,
			'post_category' => array($article['term_id'])
		);
		$post_id_save = wp_update_post($update_post);
		if(!empty($article['product_id']))
			update_post_meta($post_id_save, 'tgt_product_id', $article['product_id']);
	}
	return $post_id_save;
}
function tgt_save_article($post_status)
{
	global $user_ID;
	$article = tgt_check_input();
	$post_id_save = 0;
	if(!empty($article))
	{
		$insert_post = array(
			'post_title' => $article['title'],
		    'post_content' => $article['content'],
		    'post_status' => $post_status,
			'post_type' => 'article',
		    'post_author' => $user_ID,
			'post_category' => array($article['term_id'])
		);		
		$post_id_save = wp_insert_post($insert_post);
		if(!empty($article['product_id']))
			update_post_meta($post_id_save, 'tgt_product_id', $article['product_id']);
	}
	return $post_id_save;
}
function tgt_check_input()
{
	$article = array();
	if(isset($_POST['posttitle']))
	{
		$article['title'] = $_POST['posttitle'];
	}	
	if(isset($_POST['content']))
	{
		$article['content'] = $_POST['content'];
	}	
	if(isset($_POST['category_search']))
	{
		$article['term_id'] = $_POST['category_search'];
	}	
	if(isset($_POST['radio_product']))
	{
		$article['product_id'] = $_POST['radio_product'];			
	}
	return $article;
}
function check_error()
{
	$error = array();
	if(isset($_POST['publish']) || isset($_POST['save']))
	{
		if(isset($_POST['posttitle']) && empty($_POST['posttitle']))
		{
			$error['title_error'] = __ ('Error: Title article can\'t be empty', 're'); 
		}
		if (isset($_POST['content']) && empty($_POST['content']))
		{
			$error['content_error'] = __ ('Error: Content article can\'t be empty', 're');
		}
		if (isset($_POST['category_search']) && empty($_POST['category_search']))
		{
			$error['category_error'] = __ ('Error: Please select a category', 're');
		}
	}
	return $error;
}