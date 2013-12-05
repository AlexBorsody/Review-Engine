<?php
add_action('login_form_login', 'hook_login');
function hook_login()
{
	if(!empty($_POST['login_user']))
	{
		$error = '';
		$error_count = 0;
		$setting_enable_captchar = get_option(SETTING_ENABLE_CAPTCHA);
		if($setting_enable_captchar['login'])
		{
				
			require_once( TEMPLATEPATH . '/lib/captchahelper.php' ) 	;
			$captchaHelper = new CaptchaHelper();
			$validateResult = $captchaHelper->validate();
			
			if ( $validateResult['success'] == false ){
				$error = __('Error: Security code is incorrect', 're');
			}
			
			if($error != '')
			{
				$_SESSION['error_login'] = $error;
				$_SESSION['username'] = $_POST['username_login'];			
				wp_redirect(tgt_get_permalink('login'));			
				exit;
			}
			//}
		}
		$data = array();		
		$data['user_login'] = $_POST['username_login'];		
		$data['user_password'] = $_POST['password_login'];
		$data['remember'] = true;		
		$user_name = &wp_signon( $data, false);
		if(empty($_POST['username_login']) || empty($_POST['password_login']) || is_wp_error($user_name))
		{
			if ($error != '')
				$error .= '<br>';
			$error .= __('Error: User name or password is incorrect','re');
			$error_count += 1;
		}else{
		     //After login-in redirect to home page
               wp_redirect(HOME_URL);
               exit;
		}		
		if($error_count > 0)
		{
			global $msg;
			$msg = $error;
			// $_SESSION['error_login'] = $error;
			// $_SESSION['username'] = $_POST['username_login'];
			// wp_redirect(tgt_get_permalink('login'));
			// exit;
		}
		else 
		{
			include_once "wp-includes/ms-functions.php";
			$user_id = get_user_id_from_string($_POST['username_login']);
			$message = __ ('You\'ve successfully logged in. Click ', 're');
			$message .= '<a href="';
			$message .= get_author_posts_url($user_id).'">';
			$message .= __ ('here', 're');
			$message .= '</a>';	
			$message .= __ (' to view your profile or click ', 're');		
			$message .= '<a href="';
			$message .= HOME_URL.'">';
			$message .= __ ('here', 're');
			$message .= '</a>';	
			$message .= __ (' to Home', 're');
			setMessage($message);
			exit;
		}
	}
	
}
do_action('login_form_login');
?>
