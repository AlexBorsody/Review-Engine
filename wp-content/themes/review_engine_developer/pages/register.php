<?php
	global $user_ID;
	if($user_ID > 0)
	{
		//wp_redirect(HOME_URL);
		wp_redirect(get_author_posts_url($user_ID));
		exit;
	}  
	include PATH_PROCESSING . DS. 'register_processing.php';
	get_header();
	$error;
	$data;	
?>
    <div id="container">
    	<div class="container_res">
        	<div class="container_main">
				<!-- side bar start here -->            	
					<?php
						get_sidebar();
						$setting_enable_captchar = get_option(SETTING_ENABLE_CAPTCHA);
					?>            
				<!--sidebar end here-->
				<div class="col_right">
                	<div class="col">
                         <div class="col_box">
                            <h1 class="blue2" style="font-size:25px; float:none;"><?php _e (' Register', 're');?></h1>
                            <?php if(!empty($error))
                           		  {
                            		echo '<div class="form"><p class="error">';							
							  		foreach ($error as $err)
                            		{
                            			echo $err . '<br />';
                            		}                            		
                            		echo '</p></div>';                  	
                           		  }
                            ?>
                            <form name="register_form" action="" method="post">                                                       
                            <div class="form">
                            	<div id="review_title" class="review-input">                            	
									<label class="review-label" for="username" id="username-prompt-text" style="margin-top: 0px;"><strong><?php _e ('Enter username here', 're');?></strong></label>
									<input class="review-text" type="text" name="username" id="username" value="<?php if(!empty($error)) echo htmlspecialchars($data['username']); ?>"/>									
									<span class="red">*</span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter username here', 're');?></p>
										</div>
									</div>
								</div>
                            	<p class="error" id="username_error"></p>
                            	<div id="review_title" class="review-input">                            	
									<label class="review-label" for="password" id="password-prompt-text" style="margin-top: 0px;"><strong><?php _e ('Enter password here', 're');?></strong></label>
									<input class="review-text" type="password" name="password" id="password" value=""/>									
									<span class="red">*</span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter password here', 're');?></p>
										</div>
									</div>
								</div>
                                <p class="error" id="password_error"></p>
                                <div id="review_title" class="review-input">                            	
									<label class="review-label" for="confirm_password" id="confirm-password-prompt-text" style="margin-top: 0px;"><strong><?php _e ('Enter confirm password here', 're');?></strong></label>
									<input class="review-text" type="password" name="confirm_password" id="confirm_password" value=""/>									
									<span class="red">*</span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter confirm password here', 're');?></p>
										</div>
									</div>
								</div>                                
                                <p class="error" id="confirm_password_error"></p>
                                <div id="review_title" class="review-input">                            	
									<label class="review-label" for="user_email" id="user_email-prompt-text" style="margin-top: 0px;"><strong><?php _e ('Enter your email here', 're');?></strong></label>
									<input class="review-text" type="text" name="user_email" id="user_email" value="<?php if(!empty($error)) echo $data['user_email']?>"/>									
									<span class="red">*</span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter your email here', 're');?></p>
										</div>
									</div>
								</div>                                
                                <p class="error" id="user_email_error"></p>
                                <div id="review_title" class="review-input">                            	
									<label class="review-label" for="profile_name" id="profile_name-prompt-text" style="margin-top:0px;"><strong><?php _e ('Enter profile name here', 're');?></strong></label>
									<input class="review-text" type="text" name="profile_name" id="profile_name" value="<?php if(!empty($error)) echo htmlspecialchars($data['profile_name'])?>"/>									
									<span class="red">*</span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter profile name here', 're');?></p>
										</div>
									</div>
								</div>
								<p class="error" id="profile_name_error"></p>
								<?php	if($setting_enable_captchar['register']) {
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
										<div class="butt_search_center"><input type="submit" class="button" value="<?php _e ('Register', 're');?>" name="register_user" id="register_user"/></div>
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
		jQuery('#username').focusin(function(){		
			jQuery('#username-prompt-text').hide();
		});
		jQuery('#username').focusout(function(){
			if ( jQuery('#username').val() == '' )
				jQuery('#username-prompt-text').show();
		});
		jQuery('#password').focusin(function(){		
			jQuery('#password-prompt-text').hide();
		});
		jQuery('#password').focusout(function(){
			if ( jQuery('#password').val() == '' )
				jQuery('#password-prompt-text').show();
		});
		jQuery('#confirm_password').focusin(function(){		
			jQuery('#confirm-password-prompt-text').hide();
		});
		jQuery('#confirm_password').focusout(function(){
			if ( jQuery('#confirm_password').val() == '' )
				jQuery('#confirm-password-prompt-text').show();
		});
		jQuery('#user_email').focusin(function(){		
			jQuery('#user_email-prompt-text').hide();
		});
		jQuery('#user_email').focusout(function(){
			if ( jQuery('#user_email').val() == '' )
				jQuery('#user_email-prompt-text').show();
		});
		jQuery('#profile_name').focusin(function(){		
			jQuery('#profile_name-prompt-text').hide();
		});
		jQuery('#profile_name').focusout(function(){
			if ( jQuery('#profile_name').val() == '' )
				jQuery('#profile_name-prompt-text').show();
		});
		jQuery('#register_user').click(function(){	
			var count=0;
			var username = jQuery('#username').val();
			var password = jQuery('#password').val();
			var confirm_password = jQuery('#confirm_password').val();
			var email = jQuery('#user_email').val();
			var profile_name = jQuery('#profile_name').val();
			var security_code = jQuery('#sc').val();		

			if(security_code == '')
			{
				count += 1;
				jQuery('#sc_error').html('<?php _e ('Please enter security code', 're');?>');
			}
			else				
				jQuery('#sc_error').html('');
			if(username == '')
			{
				count += 1;
				jQuery('#username_error').html('<?php _e ('Please enter username', 're');?>');				
			}
			else jQuery('#username_error').html('');
			if(password == '')
			{
				count += 1;
				jQuery('#password_error').html('<?php _e ('Please enter your password', 're');?>');
			}
			else jQuery('#password_error').html('');
			if(confirm_password == '')
			{
				count += 1;
				jQuery('#confirm_password_error').html('<?php _e ('Please enter your confirm password', 're');?>');
			}
			else
			{
				if(password != confirm_password)
				{
					count += 1;
					jQuery('#confirm_password_error').html('<?php _e ('Confirm password is invalid', 're');?>');
				}
				else jQuery('#confirm_password_error').html('');
			}
			if(email == '')
			{
				count += 1;
				jQuery('#user_email_error').html('<?php _e ('Please enter your email', 're');?>');
			}
			else
			{
				if(!validateEmail(email))
				{
					count += 1;
					jQuery('#user_email_error').html('<?php _e ('Email is invalid', 're');?>');
				}
				else
					jQuery('#user_email_error').html('');
			}
			if(profile_name == '')
			{
				count += 1;
				jQuery('#profile_name_error').html('<?php _e ('Please enter your frofile name', 're');?>');
			}
			else jQuery('#profile_name_error').html('');
			if(count > 0)
				return false;
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
			var username = jQuery('#username').val();
			var password = jQuery('#password').val();
			var confirm_password = jQuery('#confirm_password').val();
			var email = jQuery('#user_email').val();
			var profile_name = jQuery('#profile_name').val();
			if(username !='')			
				jQuery('#username-prompt-text').hide();
			if(password != '')
				jQuery('#password-prompt-text').hide();
			if(confirm_password != '')
				jQuery('#confirm-password-prompt-text').hide();
			if(email != '')
				jQuery('#user_email-prompt-text').hide();
			if(profile_name != '')
				jQuery('#profile_name-prompt-text').hide();
		});
</script>
<?php
	get_footer();
?>