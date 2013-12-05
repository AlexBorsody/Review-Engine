<?php 
	include PATH_PROCESSING . DS. 'forgot_password_processing.php';
	get_header();
	$error;
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
                            <h1 class="blue2" style="font-size:25px; float:none;"><?php _e (' Forgot Password', 're');?></h1>
                            <?php
                           		if(!empty($error))
                           		{
                           			echo '<div class="form"><p class="error" id="error">';
                           			echo $error;
                           			echo '</p></div>';
                           		}
                           		else 
                           		{                           			
									echo '<div class="form"><p class="ava_search" style="font: 12px arial; color: #474C4C">';
                           			_e ('Please enter your e-mail address. You will receive a new password via e-mail.', 're');
                           			echo '</p></div>';
                           		}
                            ?>
                            <form name="login_form" action="" method="post">                                                        
                            <div class="form">
                            	<div id="review_title" class="review-input">                            	
									<label class="review-label" for="user_email" id="forgot_pass_email-prompt-text" style="margin-top: 0px;"><strong><?php _e ('Enter your email here', 're');?></strong></label>
									<input class="review-text" type="text" name="forgot_pass_email" id="forgot_pass_email" value="<?php if(!empty($error)) echo $_POST['forgot_pass_email']?>"/>									
									<span class="red">*</span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter your email here', 're');?></p>
										</div>
									</div>
								</div>       
									<p class="error" id="forgot_pass_email_error"></p>
									<?php $setting_enable_captchar = get_option(SETTING_ENABLE_CAPTCHA); 
										if($setting_enable_captchar['forgot_pass']) { 
											require_once( TEMPLATEPATH . '/lib/captchahelper.php' );
											$captchaHelper = new CaptchaHelper();
										?>
										<div id="recaptcha">          
											<?php $captchaHelper->generateCaptcha(); ?>
										</div>
										<div style="clear: both;"></div>
										<p class="error" id="sc_error"></p>
										<?php } ?>
										
										<div class="butt_search" style="margin-top:15px; float:left;">
											<div class="butt_search_left"></div>        
											<div class="butt_search_center"><input type="submit" class="button" value="<?php _e ('Get New Password', 're');?>" name="submit_forgot_password" id="submit_forgot_password"/></div>
                                 <div class="butt_search_right"></div>                                    
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
		
		jQuery('#submit_forgot_password').click(function()
		{	
			var email = jQuery('#forgot_pass_email').val();
			if(email == '')
			{				
				jQuery('#error').html('');
				jQuery('#forgot_pass_email_error').html('<?php _e ('Please enter your email', 're');?>');
				return false;
			}
			else
			{ 
				if(!validateEmail(email))
				{
					jQuery('#error').html('');
					jQuery('#forgot_pass_email_error').html('<?php _e ('Email is invalid', 're');?>');
					return false;
				}				
				else jQuery('#forgot_pass_email_error').html('');
			}
			if(jQuery('#sc').val() =='')
			{				
				jQuery('#error').html('');
				jQuery('#sc_error').html('<?php _e ('Please enter security code', 're');?>');
				return false;
			}			
			else jQuery('#sc_error').html('');
			return true;
		});
		function validateEmail(str) {
			var at="@";
			var dot=".";
			var lat=str.indexOf(at);
			var lstr=str.length;
			var ldot=str.indexOf(dot);
			if (str.indexOf(at)==-1){
			   return false;
			}

			if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
			   return false;
			}

			if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
			    return false;
			}

			 if (str.indexOf(at,(lat+1))!=-1){
			    return false;
			 }

			 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
			    return false;
			 }

			 if (str.indexOf(dot,(lat+2))==-1){
			    return false;
			 }
			
			 if (str.indexOf(" ")!=-1){
			    return false;
			 }

	 		 return true;				
		}
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
			var email = jQuery('#forgot_pass_email').val();
			if(email != '')
			{
				jQuery('#forgot_pass_email-prompt-text').hide();
			}
		});
</script>
<?php
	get_footer();
?>