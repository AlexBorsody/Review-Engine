<?php
$error_register = array();
$error_forgot_password = array();
$error_new_pass = array();
$error_publish_review = array();
$error_fb_login = array();
$isSaved = 0;
if(!empty($_POST['save_register_enable']))
{
	$error_register = array();
	$error_register = tgt_set_register_mailing();
	if(empty($error_register))
	{
		$isSaved = 1;
	}
}
else if(!empty($_POST['save_reset_password']))
{
	$error_forgot_password = array();
	$error_forgot_password = tgt_set_reset_password_confirm_mailing();
	if($error_forgot_password)
	{
		$isSaved = 1;
	}
}
else if(!empty($_POST['save_new_password']))
{
	$error_new_pass = array();
	$error_new_pass = tgt_set_new_password_mailing();
	if(empty($error_new_pass))
	{
		$isSaved = 1;
	}
}
else if(!empty($_POST['save_publish_review']))
{
	$error_publish_review = array();
	$error_publish_review = tgt_set_publish_review_mailing();
	if(empty($error_publish_review))
	{
		$isSaved = 1;
	}
}
else if(!empty($_POST['mailing_save_all']))
{
	$error_register = array();
	$error_register = tgt_set_register_mailing();
	$error_forgot_password = array();
	$error_forgot_password = tgt_set_reset_password_confirm_mailing();
	$error_new_pass = array();
	$error_new_pass = tgt_set_new_password_mailing();
	$error_publish_review = array();
	$error_publish_review = tgt_set_publish_review_mailing();
	$error_fb_login = array();
	$error_fb_login = tgt_set_facebook_login();
	if(empty($error_forgot_password) && empty($error_new_pass) && empty($error_publish_review) && empty($error_register) && empty($error_fb_login))
	{
		$isSaved = 1;
	}
}
else if(!empty($_POST['save_dafault_register_enable']))
{
	tgt_set_default_register_mailing();
	$isSaved = 1;
}
else if(!empty($_POST['save_default_password_confirm']))
{
	tgt_set_default_reset_password_confirm_mailing();
	$isSaved = 1;
}
else if(!empty($_POST['save_defautl_new_password']))
{
	tgt_set_default_new_password_mailing();
	$isSaved = 1;
}
elseif (!empty($_POST['save_facebook_login']))
{
	$error_fb_login = array();
	$error_fb_login = tgt_set_facebook_login();
	if(empty($error_fb_login))
	{
		$isSaved = 1;
	}
}
elseif(!empty($_POST['save_dafault_facebook_login']))
{
	tgt_set_default_facebook_login();
	$isSaved = 1;
}
else if(!empty($_POST['save_default_publis_review']))
{
	tgt_set_default_publish_review_mailing();
	$isSaved = 1;
}
else if(!empty($_POST['set_default_all']))
{
	tgt_set_default_reset_all();
	$isSaved = 1;
}
function tgt_set_default_register_mailing()
{
	$defaults = get_default_settings();
	update_option(SETTING_MAILING_REGISTER_ENABLE, $defaults[SETTING_MAILING_REGISTER_ENABLE]);	
	update_option(SETTING_MAILING_REGISTER_CONTENT, $defaults[SETTING_MAILING_REGISTER_CONTENT]);
}
function tgt_set_default_reset_password_confirm_mailing()
{
	$defaults = get_default_settings();
	update_option(SETTING_MAILING_FORGOT_CONTENT, $defaults[SETTING_MAILING_FORGOT_CONTENT]);	
}
function tgt_set_default_new_password_mailing()
{
	$defaults = get_default_settings();
	update_option(SETTING_MAILING_NEW_PW_CONTENT, $defaults[SETTING_MAILING_NEW_PW_CONTENT]);	
}
function tgt_set_default_publish_review_mailing()
{
	$defaults = get_default_settings();
	update_option(SETTING_MAILING_PUBLISH_ENABLE, $defaults[SETTING_MAILING_PUBLISH_ENABLE]);	
	update_option(SETTING_MAILING_PUBLISH_CONTENT, $defaults[SETTING_MAILING_PUBLISH_CONTENT]);
}
function tgt_set_default_facebook_login()
{
	$defaults = get_default_settings();
	update_option(SETTING_MAILLING_FACEBOOK_LOGIN_CONTENT, $defaults[SETTING_MAILLING_FACEBOOK_LOGIN_CONTENT]);
}
function tgt_set_default_reset_all()
{
	tgt_set_default_register_mailing();
	tgt_set_default_reset_password_confirm_mailing();
	tgt_set_default_new_password_mailing();
	tgt_set_default_publish_review_mailing();
	tgt_set_default_facebook_login();
}
function tgt_set_register_mailing()
{
	$register__error = array();	
	if(empty($_POST['register_mail_title']))
	{
		$register__error['register_mail_title'] = __ ('Register Mail Title can\'t be empty', 're');
	}
	if(empty($_POST['mailing_register_message']))
	{
		$register__error['mailing_register_message'] = __ ('Register Mail Message can\'t be empty', 're');
	}	
	if(!empty($register__error))
	{		
		return $register__error;
	}
	update_option(SETTING_MAILING_REGISTER_ENABLE, $_POST['enable_register_mailing']);	
	update_option(SETTING_MAILING_REGISTER_CONTENT, array(stripslashes(trim($_POST['register_mail_title'])), stripslashes(trim($_POST['mailing_register_message']))));	
}
function tgt_set_facebook_login()
{
	$facebook_login_error = array();
	if(empty($_POST['facebook_login_mail_title']))
	{
		$facebook_login_error['facebook_login_mail_title_error'] = __ ('New Account Title can\'t be empty.', 're');	
	}
	if(empty($_POST['mailing_facebook_login_message']))
	{
		$facebook_login_error['facebook_login_mail_msg_error'] = __ ('New Account Title can\'t be empty.', 're');
	}
	if(!empty($facebook_login_error))
		return $facebook_login_error;
	update_option(SETTING_MAILLING_FACEBOOK_LOGIN_CONTENT, array(stripslashes(trim($_POST['facebook_login_mail_title'])), stripslashes(trim($_POST['mailing_facebook_login_message']))));
}

function tgt_set_reset_password_confirm_mailing()
{
	$reset_pass_error = array();
	if(empty($_POST['reset_password_mail_title']))
	{
		$reset_pass_error['reset_password_mail_title'] = __('Reset Password Confirm Mail Title can\'t be empty','re');
	}
	if(empty($_POST['reset_password_mail_message']))
	{
		$reset_pass_error['reset_password_mail_message'] = __('Reset Password Confirm Mail Message can\'t be empty','re');
	}
	if(!empty($reset_pass_error))
	{
		return $reset_pass_error;
	}
	update_option(SETTING_MAILING_FORGOT_CONTENT, array(stripslashes(trim($_POST['reset_password_mail_title'])), stripslashes(trim($_POST['reset_password_mail_message']))));
}
function tgt_set_new_password_mailing()
{	
	$new_pass_error = array();
	if(empty($_POST['new_password_mail_title']))
	{
		$new_pass_error['new_password_mail_title'] = __ ('New Password Mail Title can\'t be empty', 're');
	}
	if(empty($_POST['new_password_mail_message']))
	{
		$new_pass_error['new_password_mail_message'] = __ ('New Password Mail Message can\'t be empty', 're');
	}
	if(!empty($new_pass_error))
	{
		return $new_pass_error;
	}
	update_option(SETTING_MAILING_NEW_PW_CONTENT, array($_POST['new_password_mail_title'], $_POST['new_password_mail_message']));	
}
function tgt_set_publish_review_mailing()
{
	$publish_review_error = array();
	if(empty($_POST['publish_review_mail_title']))
	{
		$publish_review_error['publish_review_mail_title'] = __ ('Publish Review Mail Title can\'t be empty', 're'); 
	}
	if(empty($_POST['publish_review_mail_message']))
	{
		$publish_review_error['publish_review_mail_message'] = __ ('Publish Review Mail Message can\'t be empty', 're');
	}
	if(!empty($publish_review_error))
	{
		return $publish_review_error;
	} 
	update_option(SETTING_MAILING_PUBLISH_ENABLE, $_POST['enable_review_publish_mailing']);	
	update_option(SETTING_MAILING_PUBLISH_CONTENT, array(stripslashes(trim($_POST['publish_review_mail_title'])), stripslashes(trim($_POST['publish_review_mail_message']))));
}
function set_save_all_mailing()
{
	tgt_set_register_mailing();
	tgt_set_reset_password_confirm_mailing();
	tgt_set_new_password_mailing();
	tgt_set_default_publish_review_mailing();
}
?>