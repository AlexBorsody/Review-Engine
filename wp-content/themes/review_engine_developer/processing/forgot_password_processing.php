<?php 
global $wp_version;
if (version_compare($wp_version, '3.1', '<')) {
    require_once("wp-includes/registration.php");
}
if(isset($_GET['login']) && isset($_GET['key']))
{
	$user = $_GET['login'];
	$key = $_GET['key'];
	if($key!= '' && $user !='')
	{
		global $wpdb;
		$query = "SELECT COUNT(*) FROM $wpdb->users WHERE user_login='".$user."' AND user_activation_key='".$key."'";
		$result = $wpdb->get_var($query);		
		if($result == 1)
		{
			$query = "SELECT user_email FROM $wpdb->users WHERE user_login='".$user."' AND user_activation_key='".$key."'";
			$email_new_pass = $wpdb->get_var($query);		
			tgt_mailing_new_password($email_new_pass);
			$message = __ ('Please check your email to receive new passsword or click ', 're');
			$message .= '<a href="';
			$message .= HOME_URL.'">';
			$message .= __ (' here', 're');
			$message .= '</a>';	
			$message .= __ (' to Home', 're');
			setMessage($message);
			exit;			
		}		
	}
}
if(isset($_POST['submit_forgot_password']))
{	
	$error = '';
	$email = $_POST['forgot_pass_email'];
	
	$setting_enable_captchar = get_option(SETTING_ENABLE_CAPTCHA);
	if($setting_enable_captchar['forgot_pass'])
	{
		require_once( TEMPLATEPATH . '/lib/captchahelper.php' ) 	;
		$captchaHelper = new CaptchaHelper();
		$validateResult = $captchaHelper->validate();
		
		if ( !$validateResult['success'] ){
			$error .= __ ('Error: Security code is incorrect.', 're');
		}
	}
	
	// $security_code = '';
	// if(isset($_POST['sc']))
	// {
	//	 $security_code = $_POST['sc'];
	//	 if($security_code == '')
	//	 {
	//		 $error .= __ ('Error: Plese enter security code.', 're');
	//	 }
	//	 elseif ($security_code != $_SESSION['security_code'])
	//	 {
	//		 $error .= __ ('Error: Security code is incorrect.', 're');
	//	 } 
	// }
	if(check_email($email))
	{
		if(email_exists($email))
		{
			tgt_mailing_forgot_password_confirm($email);
			$message = __ ('Check your e-mail for the confirmation link or click ', 're');
			$message = __ ('Please check your email to receive new passsword or click ', 're');
			$message .= '<a href="';
			$message .= HOME_URL.'">';
			$message .= __ (' here', 're');
			$message .= '</a>';	
			$message .= __ (' to Home', 're');
			setMessage($message);				
		}
		else 
		{
			if($error != '')
				$error .= '<br>';
			$error .= __ ('Error: Email is not exists.', 're');			
		}
	}
	else
	{
		if($error != '')
			$error .= '<br>';	 
		$error .= __ ('Email is invalid', 're');
	}
}