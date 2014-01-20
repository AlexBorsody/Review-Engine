<?php

$error_name_empty = __('Please enter your name','re');
$error_email_empty = __('Please enter your email','re');
$error_email_invalid = __('Your email is invalid','re');
$error_detail_empty = __('Please enter your suggestion','re');
$error_detail_too_long = __('Your suggestion is too long, please summary you suggestion to 500 characters','re');

global $user_ID, $current_user;

$suggestion = array();
$error = '';
$message = '';


if (isset($_POST['submit'])){
	/**
	 * validate
	 */
	if ( empty ($_POST['name']) ){
		$error .= $error_name_empty . '<br />';
	}
	
	if ( empty ($_POST['email']) ){
		$error .= $error_email_empty . '<br />';
	}
	
	if ( !check_email( ($_POST['email']  ) ) ){
		$error .= $error_email_invalid . '<br />';
	}
	
	if ( empty ($_POST['detail']) ){
		$error .= $error_detail_empty . '<br />';
	}
	
	/**
	 * processing
	 */
	$suggestion['name'] 		= strip_tags( $_POST['name'] );
	$suggestion['email'] 	= strip_tags( $_POST['email'] );
	$suggestion['detail'] 	= strip_tags( $_POST['detail'] );

	if (empty ($error) ){
		$time = current_time('mysql');
		$suggestion['detail'] = str_replace('<','&lt;',$suggestion['detail']);	
		$suggestion['detail'] = str_replace('>','&gt;',$suggestion['detail']);
		$data = array(
			'comment_post_ID' => 1,
			'comment_author' => $suggestion['name'],
			'comment_author_email' => $suggestion['email'],
			'comment_type' => 'suggestion',
			'comment_content' => $suggestion['detail'],
			'comment_date' => $time,
		);
		
		$com_id = wp_insert_comment($data);
		$message = __('Your suggestion has been submit, we will respond you as soon as possible. <br />Thank you for your suggestion', 're');
	}
}
