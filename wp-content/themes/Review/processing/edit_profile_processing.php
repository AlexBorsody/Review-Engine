<?php
global $wp_version;
if (version_compare($wp_version, '3.1', '<')) {
    require_once("wp-includes/registration.php");
}
if(isset($_POST['save_user_profile']))
{
	global $user_ID;	
	$username = stripslashes(strip_tags( $_POST['username'] ));
	$firstname = stripslashes(strip_tags( $_POST['firstname'] ));
	$lastname = stripslashes(strip_tags( $_POST['lastname'] ));
	$profile_name = stripslashes(strip_tags( $_POST['profile_name'] ));
	$password = $_POST['password'];
	$new_pass = $_POST['new_password'];
	$new_confirm_pass = $_POST['new_confirm_password'];
	$user_email = $_POST['user_email'];
	$avatar = $_FILES['avatar'];
	$security_code = '';	
	$success = false;
	$error= array();
	if(!empty($new_pass) && !empty($new_confirm_pass))
	{		
		if($new_confirm_pass != $new_pass)
		{			
			$error[] = __ ('Error: New confirm password is invalid.', 're'); 
		}
		if(empty($password))
		{
			$error[] = __ ('Error: Password can\'t be empty', 're');
		}		
	}
	elseif( (empty($new_pass) && !empty($new_confirm_pass)) || (empty($new_confirm_pass) && !empty($new_pass)) )
	{		
		$error[] = __ ('Error: Incorrect new password and new confirm password.', 're');
		if(empty($password))
		{
			$error[] = __ ('Error: Password can\'t be empty', 're');
		}
	}
	else 
	{
		$user = get_userdata($user_ID);
		if($user->user_email != $user_email)
		{
			if(empty($password))
			{
				$error[] = __ ('Error: Password can\'t be empty', 're');
			}
			else 
			{
				if(!user_pass_ok($username, $password))
				{
					$error[] = __('Error: Password is invalid.','re');
				}
			}
		}
	}
	if(empty($profile_name))
	{
		$error[] = __ ('Error: Profile name can\'t be empty', 're');
	}
	if(!empty($new_pass) || !empty($new_confirm_pass) || ($user->user_email != $user_email))
	{
		$setting_enable_captchar = get_option(SETTING_ENABLE_CAPTCHA);
		if($setting_enable_captchar['forgot_pass'])
		{
			require_once( TEMPLATEPATH . '/lib/captchahelper.php' ) 	;
			$captchaHelper = new CaptchaHelper();
			$validateResult = $captchaHelper->validate();
			
			if ( !$validateResult['success'] ){
				$error[] = __ ('Error: Security code is incorrect.', 're');
			}
		}
		if(!user_pass_ok($username, $password) && !empty($password))
		{			
			$error[] = __('Error: Password is invalid.','re');
		}
	}
		
	if(empty($error))
	{		
		$userdata = array(
				'ID' => $user_ID,
				'user_email' => $user_email,
				'first_name' => $firstname,
				'last_name' => $lastname,
				'display_name' => $profile_name						
				);
		if(!empty($new_pass))
		{
			$userdata = array_merge($userdata, array('user_pass' => $new_pass));
		}
		
		$user_id = wp_update_user($userdata);		
		
		if(!empty($avatar['name']) && $user_id > 0)
		{
			$saveto = "/avatar";					
			if(!file_exists(PATH_UPLOAD.$saveto))
			{				
				mkdir(PATH_UPLOAD.$saveto, 0777);
			}			
			$previous_avatar = get_user_meta($user_ID,'avatar',true);		
			if(file_exists(PATH_UPLOAD . $previous_avatar) && !empty($previous_avatar))
			{
				unlink(PATH_UPLOAD . $previous_avatar);
			}			
			$image = array(
					'source' => $_FILES['avatar']['tmp_name'],
					'destination' => $saveto,
					'name_prefix' => '',
					'width' => 80,
					'height' => 80,
					'type' => $_FILES['avatar']['type']
				);
			$image_results = tgt_resize($image);
			if(!empty($image_results))						
				update_user_meta($user_ID, 'avatar', $image_results);	
		}
		if($user_id > 0)
			$success = true;	
	}
}
?>