<?php
$review = array();
if (!isset($_GET['id']) || empty($_GET['id']) ){
	echo "<script language='javascript'>window.location = 'admin.php?page=review-engine-list-reviews'</script>";
}else if(isset($_GET['id'],$_GET['action']) && !empty($_GET['id']) && !empty($_GET['action']))
{
	$helper->css('css/admin.css');
	$message = '';
	
	$comment_meta = get_comment_meta( $_GET['id'] , "tgt_review_data" );
	$review_data = get_comment($_GET['id']);	
	$post = get_post($review_data->comment_post_ID);
	// Do acction
	if(isset($_POST['save_edit']) && !empty($_POST['save_edit']))
	{
		$allowed_tags = '<p><a><table><tr><td><th><ul><ol><li><dt><dl><br><img><b><i><u><strong><h1><h2><h3><h4><h5><h6><code><pre>';
		if(isset($_POST['edit_title']) && !empty($_POST['edit_title']))
			$comment_new_meta['title'] = strip_tags(stripcslashes($_POST['edit_title']));		
		if(isset($_POST['edit_good']) && !empty($_POST['edit_good']))
			$comment_new_meta['pro'] = strip_tags(stripcslashes($_POST['edit_good']));
		if(isset($_POST['edit_bad']) && !empty($_POST['edit_bad']))
			$comment_new_meta['con'] = strip_tags(stripcslashes($_POST['edit_bad']));
		if(isset($_POST['edit_bottom']) && !empty($_POST['edit_bottom']))
		{
			$review_data->comment_content = $_POST['edit_bottom'];
			wp_update_comment(array(
									'comment_ID' => $_GET['id'],
									'comment_content' => strip_tags(stripcslashes($_POST['edit_bottom']),$allowed_tags)
							));
		}
		if(isset($_POST['edit_review']) && !empty($_POST['edit_review']))
			$comment_new_meta['review'] = $_POST['edit_review'];
		update_comment_meta($_GET['id'],'tgt_review_data',$comment_new_meta);
		$message = __('Review has been edited successfully', 're');
	}
}
?>