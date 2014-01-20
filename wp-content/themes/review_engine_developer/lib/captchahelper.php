<?php
require_once('recaptchalib.php');

class CaptchaHelper {
	public $publicKey = '';
	public $privateKey = '';
	
	public function CaptchaHelper()
	{
		$this->publicKey 	= get_option( 'recaptcha_public_key' , '' );
		$this->privateKey = get_option( 'recaptcha_private_key' , '' );
	}
	
	public function generateCaptcha(){
		if ( !empty( $this->publicKey )  )
			echo recaptcha_get_html($this->publicKey);
		else {
			echo __('To use reCaptcha, please register at ', 're') . '<a href="https://www.google.com/recaptcha/admin/create">https://www.google.com/recaptcha/admin/create</a>';
		}
	}
	 
	public function validate(){
		$resp = recaptcha_check_answer ( $this->privateKey ,
                                 $_SERVER["REMOTE_ADDR"],
                                 $_POST["recaptcha_challenge_field"],
                                 $_POST["recaptcha_response_field"]);
		return array( 'success' => $resp->is_valid , 'return_msg' => $resp->error );
	}	
}
