<?php
include PATH_ADMIN_PROCESSING . DS. 'admin_mailing_settings_processing.php';
$helper = new Html();
$helper->css('/css/admin.css');
$error_register;
$error_forgot_password;
$error_new_pass;
$error_publish_review;
$isSaved;
?>

<div class="wrap"> <!-- #wrap 1 -->
	<div id="icon-edit" class="icon32"><br></div>
	<h2>
		<?php _e ('Mailing Settings', 're');?>
	</h2>
	<div class="tgt_atention">
		<strong><?php _e('Problems? Questions?','re');?></strong><?php _e(' Contact us at ','re');?><em><a href="http://www.dailywp.com/support/" target="_blank">Support</a></em>. 
	</div>
	<?php 
		if(!empty($error_forgot_password) || !empty($error_new_pass) || !empty($error_publish_review) || !empty($error_register) || !empty($error_fb_login))
		{
			echo '<div class="error">';				
			if(!empty($error_register['register_mail_title']))
			{
				_e ('Error: ', 're');			
				echo $error_register['register_mail_title'].'<br>';
			}
			if(!empty($error_register['mailing_register_message']))
			{
				_e ('Error: ', 're');			
				echo $error_register['mailing_register_message'].'<br>';
			}
			if(!empty($error_forgot_password['reset_password_mail_title']))
			{
				_e ('Error: ', 're');			
				echo $error_forgot_password['reset_password_mail_title'].'<br>';
			}
			if(!empty($error_forgot_password['reset_password_mail_message']))
			{
				_e ('Error: ', 're');			
				echo $error_forgot_password['reset_password_mail_message'].'<br>';
			}
			if(!empty($error_new_pass['new_password_mail_title']))
			{
				_e ('Error: ', 're');
				echo $error_new_pass['new_password_mail_title'].'<br>';
			}
			if(!empty($error_new_pass['new_password_mail_message']))
			{
				_e ('Error: ', 're');
				echo $error_new_pass['new_password_mail_message'].'<br>';
			}
			if(!empty($error_publish_review['publish_review_mail_title']))
			{
				_e ('Error: ', 're');
				echo $error_publish_review['publish_review_mail_title'].'<br>';
			}
			if(!empty($error_publish_review['publish_review_mail_message']))
			{
				_e ('Error: ', 're');
				echo $error_publish_review['publish_review_mail_message'].'<br>';
			}
			if(!empty($error_fb_login['facebook_login_mail_title_error']))
			{
				_e ('Error: ', 're');
				echo $error_fb_login['facebook_login_mail_title_error'].'<br>';
			}
			if(!empty($error_fb_login['facebook_login_mail_msg_error']))
			{
				_e ('Error: ', 're');
				echo $error_fb_login['facebook_login_mail_msg_error'];
			}
			echo '</div>';
		}
		else if ($isSaved > 0)
		{
			echo '<div class="updated below-h2">';
			_e ('Your settings have been successfully.', 're');			
			echo '</div>';
			$isSaved = 0;
		}
	?>
		<form action="" method="post">	 <!-- form -->	
		
		<div id="poststuff" class="has-right-sidebar"> <!-- box post 1 Register mail-->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e ('Register Mailing', 're');?></label></h3>
						<div class="inside">				
							<table class="form-table"> <!-- form table -->
								<tbody>
									<?php $isEnable = -1;
										$isEnable = get_option(SETTING_MAILING_REGISTER_ENABLE);
										if($isEnable < 0)
											$isEnable = 1;										
									?>
									<tr>
									<td><?php _e ('Enable Register Mailing', 're');?> <a href="#tooltip_enable_register_mail" class="tooltip">[?]</a>
											<div id="tooltip_enable_register_mail" class="tooltip-content t-wide" style="display: none">
												<?php _e('Toggle the feature sending mail to people who register successful','re');?>
											</div>
									<td><select id="enable_register_mailing" name="enable_register_mailing" style="width:80px;">
										<option id="enable" value="1" <?php if($isEnable) echo 'selected="selected"'?>><?php _e ('Enable', 're');?></option>
										<option id="disable" value="0" <?php if(!$isEnable) echo 'selected="selected"'?>><?php _e ('Disable', 're');?></option>
									</select></td>									
									</tr>
									<tr class="form-field">
									<th scope="row"><label for="register_mail_title"><?php _e ('Register Mail Title', 're');?><span class="description"><?php _e (' (required)', 're');?></span></label>
									<a href="#tooltip_register_mail_title" class="tooltip">[?]</a>
										<div id="tooltip_register_mail_title" class="tooltip-content t-wide" style="display: none">
											<p><?php _e('You can use some short codes to enhance your message title such as','re');?></p>
										</div></th>
									<?php 
										$register_mail_title = get_option('tgt_mailing_register_content');										
									?>
									<td><input type="text" id="register_mail_title" name="register_mail_title" value="<?php
									if(!empty($error_register['register_mail_title'])) // error edit
									{
										echo stripcslashes(trim($_POST['register_mail_title']));
									}
									else 
										if(!empty($register_mail_title[0])) echo stripcslashes(trim($register_mail_title[0]));
										?>" style="width: 500px;">
									<p id="register_mail_title_error" style="color: red;"><?php if(!empty($error_register['register_mail_title'])) echo $error_register['register_mail_title']; ?></p>
									</td>
									</tr>
									<tr class="form-field">
									<th scope="row"><label for="register_mail_msg"><?php _e ('Register Mail Message', 're');?><span class="description"><?php _e (' (required)', 're');?></span></label>
									<a href="#tooltip_register_mail_msg" class="tooltip">[?]</a>
										<div id="tooltip_register_mail_msg" class="tooltip-content t-wide" style="display: none">
											<p><?php _e('You can use some short codes to enhance your message title such as','re');?></p>
											<ul>
												<li><b>[customer]</b> : <?php _e('customer name' ,'ad')?> </li>
												<li><b>[website_url]</b> : <?php _e('website address' ,'ad')?> </li>
												<li><b>[login_url]</b>: <?php _e('the login address' ,'ad')?></li>
												<li><b>[website_name]</b>: <?php _e('the website name' ,'ad')?></li>
											</ul>
										</div></th>									
									<td>
									<textarea rows="7" cols="100" id="mailing_register_message" name="mailing_register_message" style="width: 500px;"><?php									
										if(!empty($error_register['mailing_register_message']))
										{
											echo $_POST['mailing_register_message'];
										}
										else echo $register_mail_title[1];?></textarea>
										<p id="mailing_register_message_error" style="color: red;"><?php if(!empty($error_register['mailing_register_message'])) echo $error_register['mailing_register_message']; ?></p>								
									</td>
									</tr>								
									
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>
							
							<p/>
						    <div class="section-button-area">							
							    <div class="section-buttons">
								    <input class="left-align button-primary" type="submit" class="" id="save_register_enable" name="save_register_enable" value="<?php _e (' Save', 're');?>">
								    <input class="left-align button" type="submit" value="<?php _e (' Reset to Default', 're');?>" class="" name="save_dafault_register_enable">
							    </div>
							    <div class="clear"></div>
						    </div>			
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- //post box 1 register mail-->
		
		<div id="poststuff" class="has-right-sidebar"> <!-- box post 5 Login Facebook mail-->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e ('New Facebook Login Account Mailing ', 're');?></label></h3>
						<div class="inside">				
							<table class="form-table"> <!-- form table -->
								<tbody>								
									<tr class="form-field">
									<th scope="row"><label for="register_mail_title"><?php _e ('New Account Mail Title', 're');?><span class="description"><?php _e (' (required)', 're');?></span></label>
									<a href="#tooltip_register_mail_title" class="tooltip">[?]</a>
										<div id="tooltip_register_mail_title" class="tooltip-content t-wide" style="display: none">
											<?php _e('You can use some short codes to enhance your message title such as','re');?>
										</div></th>
									<?php 
										$facebook_mail_title = get_option('tgt_mailling_facebook_login_content');										
									?>
									<td><input type="text" id="facebook_login_mail_title" name="facebook_login_mail_title" value="<?php
									if(!empty($error_fb_login['facebook_login_mail_title_error'])) // error edit
									{
										echo stripcslashes(trim($_POST['facebook_login_mail_title']));
									}
									else 
										if(!empty($facebook_mail_title[0])) echo stripcslashes(trim($facebook_mail_title[0]));
										?>" style="width: 500px;">
									<p id="register_mail_title_error" style="color: red;"><?php if(!empty($error_register['register_mail_title'])) echo $error_register['register_mail_title']; ?></p>
									</td>
									</tr>
									<tr class="form-field">
									<th scope="row"><label for="facebook_login_mail_msg"><?php _e ('New Account Mail Message', 're');?><span class="description"><?php _e (' (required)', 're');?></span></label>
									<a href="#tooltip_register_mail_msg" class="tooltip">[?]</a>
										<div id="tooltip_register_mail_msg" class="tooltip-content t-wide" style="display: none">
											<?php _e('You can use some short codes to enhance your message such as','re');?>
										</div></th>									
									<td>
									<textarea rows="7" cols="100" id="mailing_facebook_login_message" name="mailing_facebook_login_message" style="width: 500px;"><?php									
										if(!empty($error_fb_login['facebook_login_mail_msg_error']))
										{
											echo $_POST['mailing_facebook_login_message'];
										}
										else echo $facebook_mail_title[1];?></textarea>
										<p id="mailing_register_message_error" style="color: red;"><?php if(!empty($error_register['mailing_register_message'])) echo $error_register['mailing_register_message']; ?></p>								
									</td>
									</tr>								
									
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>
							
							<p/>
						    <div class="section-button-area">							
							    <div class="section-buttons">
								    <input class="left-align button-primary" type="submit" class="" id="save_register_enable" name="save_facebook_login" value="<?php _e (' Save', 're');?>">
								    <input class="left-align button" type="submit" value="<?php _e (' Reset to Default', 're');?>" class="" name="save_dafault_facebook_login">
							    </div>
							    <div class="clear"></div>
						    </div>			
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- //post box 5 register mail-->
		
		<div id="poststuff" class="has-right-sidebar"> <!-- box post 2 Reset password-->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e ('Reset Password Confirm Mailing', 're');?></label></h3>
						<div class="inside">			
							<table class="form-table"> <!-- form table -->
								<tbody>									
									<tr class="form-field">
									<th scope="row"><label for="reset_password_mail_title_label"><?php _e ('Reset Password Confirm Mail Title', 're');?><span class="description"><?php _e (' (required)', 're');?></span></label>
									<a href="#tooltip_reset_mail_title" class="tooltip">[?]</a>
										<div id="tooltip_reset_mail_title" class="tooltip-content t-wide" style="display: none">
											<?php _e('You can use some short codes to enhance your message title such as','re');?>
										</div></th>
									<?php 
										$reset_password_confirm_mail = get_option('tgt_mailing_forgot_content');										
									?>
									<td><input type="text" name="reset_password_mail_title" id="reset_password_mail_title" value="<?php
										if(!empty($error_forgot_password['reset_password_mail_title']))
											{
												echo stripslashes(trim($_POST['reset_password_mail_title']));
											} 
											else if(!empty($reset_password_confirm_mail)) echo stripslashes(trim($reset_password_confirm_mail[0]));
										?>" style="width: 500px;">
										<p style="color: red;"><?php if(!empty($error_forgot_password['reset_password_mail_title'])) echo $error_forgot_password['reset_password_mail_title'];?></p>
									</td>
									</tr>
									<tr class="form-field">
									<th scope="row"><label for="reset_mail_msg_label"><?php _e ('Reset Password Mail Message', 're');?><span class="description"><?php _e (' (required)', 're');?></span></label>
									<a href="#tooltip_reset_password_mail_title" class="tooltip">[?]</a>
										<div id="tooltip_reset_password_mail_title" class="tooltip-content t-wide" style="display: none">
											<?php _e('You can use some short codes to enhance your message such as','re');?>
										</div></th>									
									<td>
									<textarea rows="7" cols="100" id="reset_password_mail_message" name="reset_password_mail_message" style="width: 500px;"><?php
										if(!empty($error_forgot_password['reset_password_mail_message']))
										{
											echo stripslashes(trim($_POST['reset_password_mail_message']));
										}
										else if(!empty($reset_password_confirm_mail)) echo stripslashes(trim($reset_password_confirm_mail[1]));
									?></textarea>									
									<p style="color: red;"><?php if(!empty($error_forgot_password['reset_password_mail_message'])) echo $error_forgot_password['reset_password_mail_message'];?></p>	
									</td>
									</tr>
								</tbody>
							</table> <!-- //form table -->							
							<div class="clear"></div>							
							<p/>
						    <div class="section-button-area">							
							    <div class="section-buttons">
								    <input class="left-align button-primary" type="submit" class="" name="save_reset_password" value="<?php _e (' Save', 're');?>">
								    <input class="left-align button" type="submit" value="<?php _e (' Reset to Default', 're');?>" class="" name="save_default_password_confirm">
							    </div>
							    <div class="clear"></div>
						    </div>							
						</div>
					</div>				
				</div>
			</div>
		</div>	 <!-- //post box 2 Reset Password-->
		<div id="poststuff" class="has-right-sidebar"> <!-- box post 3 New password-->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e ('New Password Mailing', 're');?></label></h3>
						<div class="inside">			
							<table class="form-table"> <!-- form table -->
								<tbody>									
									<tr class="form-field">
									<th scope="row"><label for="new_password_mail_title_label"><?php _e ('New Password Mail Title', 're');?><span class="description"><?php _e (' (required)', 're');?></span></label>
									<a href="#tooltip_new_password_mail_title" class="tooltip">[?]</a>
										<div id="tooltip_new_password_mail_title" class="tooltip-content t-wide" style="display: none">
											<?php _e('You can use some short codes to enhance your message title such as','re');?>
										</div></th>
									<?php 
										$new_password_confirm_mail = get_option('tgt_mailing_new_pw_content');										
									?>
									<td><input type="text" id="new_password_mail_title" name="new_password_mail_title" value="<?php 
									if(!empty($error_new_pass['new_password_mail_title']))
											{
												echo stripslashes(trim($_POST['new_password_mail_title']));
											} 
											else if(!empty($new_password_confirm_mail[0])) echo stripslashes(trim($new_password_confirm_mail[0]));
										?>" style="width: 500px;">
										<p style="color: red;"><?php if(!empty($error_new_pass['new_password_mail_title'])) echo $error_new_pass['new_password_mail_title'];?></p>
									</td>
									</tr>
									<tr class="form-field">
									<th scope="row"><label for="new_password_mail_msg_label"><?php _e ('New Password Mail Message', 're');?><span class="description"><?php _e (' (required)', 're');?></span></label>
									<a href="#tooltip_new_password_mail_msg" class="tooltip">[?]</a>
										<div id="tooltip_new_password_mail_msg" class="tooltip-content t-wide" style="display: none">
											<?php _e('You can use some short codes to enhance your message such as','re');?>
										</div></th>									
									<td>
									<textarea rows="6" cols="100" id="new_password_mail_message" name="new_password_mail_message" style="width: 500px;"><?php 
											if(!empty($error_new_pass['new_password_mail_message']))
											{
												echo stripslashes(trim($_POST['new_password_mail_message']));
											} 
											else if(!empty($new_password_confirm_mail)) echo stripslashes(trim($new_password_confirm_mail[1]));
										?></textarea>
										<p style="color: red;"><?php if(!empty($error_new_pass['new_password_mail_message'])) echo $error_new_pass['new_password_mail_message'];?></p>
									</td>
									</tr>								
									
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>
							
							<p/>
						    <div class="section-button-area">							
							    <div class="section-buttons">
								    <input class="left-align button-primary" type="submit" class="" name="save_new_password" value="<?php _e (' Save', 're');?>">
								    <input class="left-align button" type="submit" value="<?php _e (' Reset to Default', 're');?>" class="" name="save_defautl_new_password">
							    </div>
							    <div class="clear"></div>
						    </div>			
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- //post box 3 New Password-->
		 
		<div id="poststuff" class="has-right-sidebar"> <!-- box post 4 publish review-->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e ('Publish Review Mailing', 're');?></label></h3>
						<div class="inside">			
							<table class="form-table"> <!-- form table -->
								<tbody>
									<?php $isEnable = -1;
										$isEnable = get_option(SETTING_MAILING_PUBLISH_ENABLE);
										if($isEnable < 0)
											$isEnable = 1;										
									?>
									<tr>
									<td><?php _e ('Enable Publish Review Mailing', 're');?> <a href="#tooltip_enable_review_publish_mail" class="tooltip">[?]</a>
											<div id="tooltip_enable_review_publish_mail" class="tooltip-content t-wide" style="display: none">
												<?php _e('Toggle the feature sending mail to people when publish a review','re');?>
											</div>
									<td><select id="enable_review_publish_mailing" name="enable_review_publish_mailing" style="width:80px;">
										<option id="enable_review_publish" value="1" <?php if($isEnable) echo 'selected="selected"'?>><?php _e ('Enable', 're');?></option>
										<option id="disable_review_publish" value="0" <?php if(!$isEnable) echo 'selected="selected"'?>><?php _e ('Disable', 're');?></option>
									</select></td>									
									</tr>
									<tr class="form-field">
									<th scope="row"><label for="publish_review_mail_title_label"><?php _e ('Publish Review Mail Title', 're');?><span class="description"><?php _e (' (required)', 're');?></span></label>
									<a href="#tooltip_publish_review_mail_title" class="tooltip">[?]</a>
										<div id="tooltip_publish_review_mail_title" class="tooltip-content t-wide" style="display: none">
											<?php _e('You can use some short codes to enhance your message title such as','re');?>
										</div></th>
									<?php 
										$publish_review_confirm_mail = get_option('tgt_mailing_publish_content');										
									?>
									<td><input type="text" id="publish_review_mail_title" name="publish_review_mail_title" value="<?php
											if(!empty($error_publish_review['publish_review_mail_title']))
											{
												echo stripslashes(trim($_POST['publish_review_mail_title']));
											} 
											else if(!empty($publish_review_confirm_mail)) echo stripslashes(trim($publish_review_confirm_mail[0]));
										?>" style="width: 500px;">
										<p style="color: red;"><?php if(!empty($error_publish_review['publish_review_mail_title'])) echo $error_publish_review['publish_review_mail_title'];?></p>
									</td>
									</tr>
									<tr class="form-field">
									<th scope="row"><label for="publish_review_mail_msg_label"><?php _e ('Publish Review Mail Message', 're');?><span class="description"><?php _e (' (required)', 're');?></span></label>
									<a href="#tooltip_publish_review_mail_msg" class="tooltip">[?]</a>
										<div id="tooltip_publish_review_mail_msg" class="tooltip-content t-wide" style="display: none">
											<?php _e('You can use some short codes to enhance your message such as','re');?>
										</div></th>									
									<td>
									<textarea rows="6" cols="100" id="publish_review_mail_message" name="publish_review_mail_message" style="width: 500px;"><?php
											if(!empty($error_publish_review['publish_review_mail_message']))
											{
												echo $_POST['publish_review_mail_message'];
											}
											else if(!empty($publish_review_confirm_mail)) echo $publish_review_confirm_mail[1];?></textarea>
											<p style="color: red;"><?php if(!empty($error_publish_review['publish_review_mail_message'])) echo $error_publish_review['publish_review_mail_message'];?></p>
									</td>
									</tr>									
								</tbody>
							</table> <!-- //form table -->							
							<div class="clear"></div>							
							<p/>
						    <div class="section-button-area">							
							    <div class="section-buttons">
								    <input class="left-align button-primary" type="submit" class="" name="save_publish_review" value="<?php _e (' Save', 're');?>">
								    <input class="left-align button" type="submit" value="<?php _e (' Reset to Default', 're');?>" class="" name="save_default_publis_review">
							    </div>
							    <div class="clear"></div>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<div id="mailing-submit">						
		   <div class="section-button-area">							
			   <div class="section-buttons">
				   <input class="left-align button-primary" type="submit" class="" name="mailing_save_all" value="<?php _e ('Save all' , 're')?>">
				   <input class="left-align button" type="submit" value="<?php _e('Reset all to Default', 're')?>" class="" name="set_default_all">
			   </div>
			   <div class="clear"></div>
		   </div>		
		</div>		
	</form> <!-- //form -->	
</div> <!-- //end wrap 1 -->
<?php 
//global $error_register;
//var_dump($error_register);
?>