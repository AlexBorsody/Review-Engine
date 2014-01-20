<?php
	global $user_ID;
	if($user_ID > 0)
	{
		wp_redirect(HOME_URL);
		exit;
	} 
	include PATH_PROCESSING . DS. 'login_processing.php';
	get_header();
?>
    <div id="container">
    	<div class="container_res">
        	<div class="container_main">
				<!-- side bar start here -->            	
					<?php
						get_sidebar();						
					?>            
				<!--sidebar end here-->	
                <div class="col_right">
                	<div class="col">
                         <div class="col_box">
                            <h1 class="blue2" style="font-size:25px; float:none;"><?php _e (' Login', 're');?></h1>
                            <?php
//                            	 ob_start();
//                            	 if(!session_start())                            	 
//                            	 	session_start();
                           		 // $error_username = '';
                           		 // if(session_is_registered('error_login'))
                           		 // {                         		 	
                            		// echo '<div class="form"><p class="error" id="error">';			
                           			// echo $_SESSION['error_login'];
                           			// $error_username = $_SESSION['username'];                           			                           		 
                            		// echo '</p></div>';
                            		// session_unregister('error_login');
                            		// session_unregister('username');
                           		 // }
                            	global $msg;
                           		if ( !empty($msg) ){
                           			echo '<div class="form"><p class="error" id="error">' . $msg .'</p></div>';
                           		}
                           		 
                            ?>
                            <form name="login_form" action="" method="post">                                                        
                            <div class="form">                            	
                                <div id="review_title" class="review-input">                            	
									<label class="review-label" for="username_login" id="username_login-prompt-text" style="margin-top: 0px;"><strong><?php _e ('Enter username here', 're');?></strong></label>
									<input class="review-text" type="text" name="username_login" id="username_login" value="<?php if ( isset($_POST['username_login']) ) echo $_POST['username_login'] ?>"/>									
									<span class="red">*</span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter username here', 're');?></p>
										</div>
									</div>
								</div>                                
                                <p class="error" id="username_login_error"></p>                             
                                <div id="review_title" class="review-input">                            	
									<label class="review-label" for="password_login" id="password_login-prompt-text" style="margin-top: 0px;"><strong><?php _e ('Enter your passsword here', 're');?></strong></label>
									<input class="review-text" type="password" name="password_login" id="password_login"/>									
									<span class="red">*</span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter your passsword here', 're');?></p>
										</div>
									</div>
								</div> 
                                <p class="error" id="password_login_error"></p>
                                <?php $setting_enable_captchar = get_option(SETTING_ENABLE_CAPTCHA); 
											if($setting_enable_captchar['login']) {
												require_once( TEMPLATEPATH . '/lib/captchahelper.php' );
												$captchaHelper = new CaptchaHelper();
											?>
											<div id="recaptcha">          
												<?php
												$captchaHelper->generateCaptcha();
												?>
											</div>
											<div style="clear: both;"></div>
											<p class="error" id="sc_error"></p>
                                <?php } ?>
                                <div class="butt_search" style="margin-top:15px; float:left;">
                                    <div class="butt_search_left"></div>        
										<div class="butt_search_center"><input type="submit" class="button" value="<?php _e ('Login', 're');?>" name="login_user" id="login_user"/></div>
                                    <div class="butt_search_right"></div>
                                </div>
                                <div class="butt_search" style="margin-top:15px; float:left; font: bold 12px verdana; color: #474C4C;">
                                <p class="re"><a href="<?php echo tgt_get_permalink('forgot_password') ?>" style="margin-left: 10px" class="st" style="font: bold 12px verdana; color: #474C4C;"><?php _e ('Forgot your password?', 're');?></a></p>
                                </div>
                            </div>
                         </form>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </div>    
    <!--body end here-->
    <script type="text/javascript">    	
		jQuery('#login_user').click(function(){	
			var count=0;
			var username = jQuery('#username_login').val();
			var password = jQuery('#password_login').val();			
			if(username == '')
			{
				count += 1;
				jQuery('#username_login_error').html('<?php _e ('Please enter username', 're');?>');				
			}
			else jQuery('#username_login_error').html('');
			if(password == '')
			{
				count += 1;
				jQuery('#password_login_error').html('<?php _e ('Please enter your password', 're');?>');
			}
			else jQuery('#password_login_error').html('');
			if(jQuery('#sc').val() =='')
			{
				count += 1;
				jQuery('#sc_error').html('<?php _e ('Please enter security code', 're');?>');
			}			
			else jQuery('#sc_error').html('');
			if(count > 0)
			{
				jQuery('#error').html('');
				return false;
			}
			return true;
		});
		jQuery('.review-text').focusin(function(){
			jQuery(this).parent().find('.review-label').hide();
			jQuery('.review-tooltip').hide();
			jQuery(this).parent().find('.review-tooltip').show();
		});
		jQuery('.review-text').focusout(function(){
			jQuery(this).parent().find('.review-tooltip').hide();
			if (jQuery(this).val() == '')
				jQuery(this).parent().find('.review-label').show();
		});
		jQuery(document).ready(function(){			
			if(jQuery('#username_login').val() !='')// || jQuery('#username_login').defaultvalue != '')
				jQuery('#username_login-prompt-text').hide();
			if( jQuery("#password_login").val() !='')
				jQuery('#password_login-prompt-text').hide();
		});		
</script>
<?php
	get_footer();
?>