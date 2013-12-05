<?php
	global $user_ID;
	if($user_ID < 1)
	{
		wp_redirect( tgt_get_permalink('login') );
		exit;
	}
		
?>
<?php
	include PATH_PROCESSING . DS. 'edit_profile_processing.php';
	get_header();	
	$error;
	$success;
?>
    <div id="container">
    	<div class="container_res">
        	<div class="container_main">
				<!-- side bar start here -->            	
					<?php
						get_sidebar();
						$user = get_userdata($user_ID);
					?>            
				<!--sidebar end here-->
				<div class="col_right">
                	<div class="col">
                         <div class="col_box">
                            <h1 class="blue2" style="font-size:25px; float:none;"><?php _e (' Edit Profile', 're');?></h1>
                            <?php if(!empty($error))
                           		 {
                            		echo '<br><br><div class="message-box" style="width: 308px; color:red; background-color: #FFEBE8"><p class="error">';
                            		$i=0;
							  		foreach ($error as $err)
                            		{
                            			if($i>0)
                            				echo '<br>';
                            			echo $err;
                            			$i++;                            			
                            		}                            		
                            		echo '</p></div>';                  	
                           		 }
                           		 elseif(isset($success))
                           		 {
                           		 	echo '<br><br><div class="message-box" style="width: 308px; color: #40A7E7"><p class="error">';
									_e ('Your profile updated.', 're');
                           		 	echo '</p></div>';
                           		 }
                            ?>
                            <form name="edit_profile_form" action="" method="post" enctype="multipart/form-data">                            
                            <div class="form">
                            	<h3 class="blue2" style="font:italic 20px arial; color: #4B8DB6; border-bottom: 2px solid rgb(196, 210, 210); padding: 0px 0pt;"><?php _e ('User\'s Information', 're');?></h3>
                            	<div id="review_title" class="review-input">                            	
									<label class="review-label" for="username" id="username-prompt-text"><strong><?php _e ('Enter username here', 're');?></strong></label>
									<input class="review-text" type="text" name="username_display" id="username_display" value="<?php echo $user->user_login?>" disabled="disabled"/>
									<input class="review-text" type="hidden" name="username" value="<?php echo $user->user_login?>"/>
									<span class="red"></span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter username here', 're');?></p>
										</div>
									</div>
								</div>
								<p class="error" id="username_error"></p>
                            	<div id="review_title" class="review-input">
									<label class="review-label" for="firstname" id="firstname-prompt-text" style="margin-top: 0px;"><strong><?php _e ('Enter first name here', 're');?></strong></label>
									<input class="review-text" type="text" name="firstname" id="firstname" value="<?php if(!empty($user->first_name)) echo htmlspecialchars($user->first_name); ?>"/>
									<span class="red"></span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter first name here', 're');?></p>
										</div>
									</div>
								</div>
								<p class="error" id="firstname_error"></p>
                                <div id="review_title" class="review-input">
									<label class="review-label" for="lastname" id="lastname-prompt-text" style="margin-top: 0px;"><strong><?php _e ('Enter last name here', 're');?></strong></label>
									<input class="review-text" type="text" name="lastname" id="lastname" value="<?php if(!empty($user->last_name)) echo htmlspecialchars($user->last_name); ?>"/>
									<span class="red"></span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter last name here', 're');?></p>
										</div>
									</div>
								</div>                              
                                <p class="error" id="lastname_error"></p>
                                <div id="review_title" class="review-input">
									<label class="review-label" for="profile_name" id="profile-prompt-text" style="margin-top: 0px;"><strong><?php _e ('Enter profile name here', 're');?></strong></label>
									<input class="review-text" type="text" name="profile_name" id="profile_name" value="<?php echo htmlspecialchars($user->display_name); ?>"/>
									<span class="red">*</span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter profile name here', 're');?></p>
										</div>
									</div>
								</div>                                
                                <p class="error" id="profile_name_error"></p>
                                <div class="box_comment">                                	
                                	<input type="file" name="avatar" id="avatar">
                                </div><br>
                                <div class="message-box" style="width: 80px; height: 80px;">
                                	<img src="<?php $avatar = get_user_meta($user_ID, 'avatar', true); if(!empty($avatar)) echo URL_UPLOAD.$avatar; else echo TEMPLATE_URL.'/images/no_avatar.gif';?>" style="width: 80px; height: 80px;">                                	
                                </div>
                                <h3 class="blue2" style="font:italic 20px arial; color: #4B8DB6; border-bottom: 2px solid rgb(196, 210, 210); padding: 0px 0pt;""><?php _e ('User\'s Account', 're');?></h3>
								<div id="review_title" class="review-input">
									<label class="review-label" for="user_email" id="email-prompt-text" style="margin-top: 0px;"><strong><?php _e ('Enter email here', 're');?></strong></label>
									<input class="review-text" type="text" name="user_email" id="user_email" value="<?php echo $user->user_email?>"/>
									<span class="red">*</span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter email name here', 're');?></p>
										</div>
									</div>
								</div>                      
                                <p class="error" id="user_email_error"></p>
                                <div id="review_title" class="review-input">
									<label class="review-label" for="password" id="password-prompt-text" style="margin-top: 0px"><strong><?php _e ('Enter password here', 're');?></strong></label>
									<input class="review-text" type="password" name="password" id="password"/>
									<span class="red">*</span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter password here', 're');?></p>
										</div>
									</div>
								</div>
                                <p class="error" id="password_error"></p>                                
                                <div id="review_title" class="review-input">
									<label class="review-label" for="new_password" style="margin-top: 0px"><strong><?php _e ('Enter new password here', 're');?></strong></label>
									<input class="review-text" type="password" name="new_password" id="new_password"/>
									<span class="red"></span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter new password here', 're');?></p>
										</div>
									</div>
								</div>                                
                                <p class="error" id="new_password_error"></p>
                                <div id="review_title" class="review-input">
									<label class="review-label" for="new_confirm_password" style="margin-top: 0px"><strong><?php _e ('Enter new confirm password here', 're');?></strong></label>
									<input class="review-text" type="password" name="new_confirm_password" id="new_confirm_password"/>
									<span class="red"></span>
									<div id="review_title_tooltip" class="review-tooltip" style="display: none">
										<div>
											<p><?php _e ('Enter new confirm password here', 're');?></p>
										</div>
									</div>
								</div>                                
										<p class="error" id="new_confirm_password_error"></p> 
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
                              <div style=" border-bottom: 2px solid rgb(196, 210, 210); padding: 10px 0pt;""></div> 
                              <div class="butt_search" style="margin-top:15px; float:left;">  
                                 <div class="butt_search_left"></div>        
												<div class="butt_search_center">
												<input type="submit" class="button" value="<?php _e ('Save', 're');?>" name="save_user_profile" id="save_user_profile" />
												</div>
                                 <div class="butt_search_right"></div>
                              </div>
                              <div class="butt_search" style="margin-top:15px; float:left; margin-left: 15px">
											<div class="butt_search_left2"></div>        
											<div class="butt_search_center2"><input type="button" class="button" value="<?php _e ('Cancel', 're');?>" name="cancel_user_profile" id="cancel_user_profile"/></div>
                                 <div class="butt_search_right2"></div>
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
	
		jQuery('#save_user_profile').click(function(){
			var profile_name = jQuery('#profile_name').val();
			if(profile_name == '')
			{			
				jQuery('#profile_name_error').html('<?php _e ('Please enter your profile name', 're');?>');
				return false;
			}
			else jQuery('#profile_name_error').html('');	
			return check_user_account();
			
			return true;
		});
		
		jQuery('#cancel_user_profile').click(function(){
			window.location = '<?php echo HOME_URL ?>';
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
		function check_user_account()
		{
			var count = 0;
			var pre_email = "<?php echo $user->user_email;?>";
			var email = jQuery('#user_email').val();
			var pass = jQuery('#password').val();
			var new_pass = jQuery('#new_password').val();
			var new_confirm_pass = jQuery('#new_confirm_password').val();
			if(email == '')
			{
				jQuery('#user_email_error').html('<?php _e ('Please your enter email', 're');?>');
				return false;
			}
			else if(!validateEmail(email))
			{
				jQuery('#user_email_error').html('<?php _e ('Email is invalid.', 're');?>');
				return false;
			}
			else if(pre_email != email)
			{
				jQuery('#user_email_error').html('');
				if(pass == '')
				{
					jQuery('#new_confirm_password_error').html('');
					jQuery('#new_password_error').html('');					
					jQuery('#password_error').html('<?php _e ('Please enter your password.', 're');?>');
					return false;
				}
				else jQuery('#password_error').html('');
			}
			else jQuery('#password_error').html('');
			if(new_pass != '')
			{
				jQuery('#new_password_error').html('');
				if(new_confirm_pass == '')
				{			
					jQuery('#new_confirm_password_error').html('<?php _e ('Please enter new confirm password.', 're');?>');
					return false;
				}
				else 
				{				
					if(new_confirm_pass != new_pass)
					{					
						jQuery('#new_confirm_password_error').html('<?php _e ('Confirm password is invalid.', 're');?>');
						return false;
					}
					else 
					{
						jQuery('#new_confirm_password_error').html('');
						jQuery('#new_password_error').html('');
					}
				}
			}
			if(new_confirm_pass != '')
			{
				jQuery('#new_confirm_password_error').html('');
				if(new_pass == '')				{
					
					jQuery('#new_password_error').html('<?php _e ('Please enter new password.', 're');?>');
					return false;
				}
				else jQuery('#new_password_error').html('');
				if(new_pass != new_confirm_pas)
				{
					jQuery('#new_password_error').html('<?php _e ('Confirm password is invalid.', 're');?>');
					return false;
				}
				else 	
					jQuery('#new_password_error').html('');				
			}
			if(new_pass != '' && new_confirm_pass !='' && new_pass == new_confirm_pass)
			{
				if(password == '')
				{
					jQuery('#password_error').html('<?php _e ('Please enter password.', 're');?>');
					return false;
				}
				else jQuery('#password_error').html('');
			}
				
			if((new_pass == '' && new_confirm_pass =='') || new_pass == new_confirm_pass)
			{
				jQuery('#new_password_error').html('');
				jQuery('#new_confirm_password_error').html('');
			}
			return true;
		}		
		jQuery(document).ready(function(){
			var username = jQuery('#username').val();
			var password = jQuery('#password').val();			
			var email = jQuery('#user_email').val();
			var profile_name = jQuery('#profile_name').val();
			if(username !='')
			{
				jQuery('#username-prompt-text').hide();
			}
			if(email !='')
			{
				jQuery('#email-prompt-text').hide();
			} 
			if(profile_name != '')
			{
				jQuery('#profile-prompt-text').hide();
			}
			if(password != '')
			{
				jQuery('#password-prompt-text').hide();
			}
			if(jQuery('#firstname').val() != '')
				jQuery('#firstname-prompt-text').hide();
			if(jQuery('#lastname').val() != '')
				jQuery('#lastname-prompt-text').hide();
		});		
	</script>
<?php
	get_footer();
?>