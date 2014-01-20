<?php
global $wp_version;
if (version_compare($wp_version, '3.1', '<')) {
    require_once("wp-includes/registration.php");
}
if(isset($_POST['register_user']))
{
	$data = array();
	$data['username'] = $_POST['username'];
	$data['password'] = $_POST['password'];
	$data['confirm_pass'] = $_POST['confirm_password'];
	$data['user_email'] = $_POST['user_email'];
	$data['profile_name'] = stripslashes(strip_tags( $_POST['profile_name'] ));
	$data['security_code'] = $_POST['sc'];
	$error = array();
	$setting_enable_captchar = get_option(SETTING_ENABLE_CAPTCHA);
	if($setting_enable_captchar['register'])
	{
		require_once( TEMPLATEPATH . '/lib/captchahelper.php' ) 	;
		$captchaHelper = new CaptchaHelper();
		$validateResult = $captchaHelper->validate();
		
		if ( !$validateResult['success'] ){
			$error[] = __ ('Error: Security code is incorrect.', 're');
		}
	}
	if(empty($data['profile_name']))
	{
		$error[] = __ ('Error: Profile name can\'t be empty.', 're');
	}
	elseif (empty($data['username']))
	{
		$error[] = __ ('Error: Username can\'t be empty.', 're');
	}
	elseif (!validate_username($data['username'])) 
	{
		$error[] = __ ('Error: Username is invalid.', 're');
	}
	elseif (empty($data['password'])) 
	{
		$error[] = __ ('Error: Password can\'t be empty.', 're');
	}
	elseif(empty($data['confirm_pass']))
	{
		$error[] = __ ('Error: Confirm password can\'t be empty.', 're');
	}
	elseif($data['password'] != $data['confirm_pass'])
	{
		$error[] = __ ('Error: Confirm password is invalid.', 're');
	}
	elseif (empty($data['user_email']))
	{
		$error[] = __ ('Error: Email can\'t be empty.', 're');
	}
	elseif (!check_email($data['user_email']))
	{
		$error[] = __ ('Error: Email is invalid', 're');
	}	
	elseif(username_exists($data['username'])) 
	{		
		$error[] = __ ('Error: Username already exists', 're');
	}
	elseif (email_exists($data['user_email']))
	{
		$error[] = __ ('Error: Email already exists', 're');
	}
	elseif (empty($error))	
	{
		$new_user = array(
				'user_login' => $data['username'],
				'user_pass' => $data['password'],
				'user_email' => $data['user_email'],
				'display_name' => $data['profile_name'],
				'show_admin_bar_front' => false,
				'show_admin_bar_admin' => false
				);
		$user_id = wp_insert_user($new_user);		
		if($user_id > 0) // send mail and redirect
		{
			$message  = __ ('Registration is completed. ', 're');
			
			if(get_option('tgt_mailing_register_enable'))
			{
				tgt_mailing_register($data['user_email'], $data['profile_name']);
				$message .= __ ('Check email to receive your account. ', 're');
			}
			$message .= __ ('Click ', 're');
			$message .= '<a href="';
			$message .= tgt_get_permalink('login') .'">';
			$message .= __ (' here', 're');
			$message .= '</a>';	
			$message .= __ (' to login ', 're');
			setMessage($message); 
		}		
	}	
}