<?php
global $helper,$wp_query,$posts, $user_id, $current_user;
require PATH_PROCESSING . DS . 'product_suggest_processing.php';
get_header();

/**
 * Toannm
 */
?>
	 
	 <!-- Body start here -->
	 
    <div id="container">
    	<div class="container_res">
        	<div class="container_main">
				<!-- side bar start here -->
            	
					<?php
						get_sidebar();
					?>
            
					<!--sidebar end here-->    
					<?php ?>
					<div class="col_right">
						<div class="col_box">
						  
							<div class="section-title">
							 <h1 class="blue2" style="font-size:25px; float:none;padding-bottom: 4px"><?php _e (' Product Suggestion', 're');?></h1>
							</div>
							<p class="message" style="font: 12px Arial, sans-serif; margin: 5px 0 10px 0">
								<?php if (!empty ($message)) {
								  echo $message;
								} else {
								  _e("Can't find your product? You can suggest your product here and we will consider to update product you suggesting ASAP ",'re');
								}
								?>								
							</p>
							<p id="error_notice" class="error-message red" style="display: none"></p>
							<?php
							?>
							<form id="suggest_form" action="" method="post" style="margin-top: 20px;">
								<?php if ( !$user_ID ) {?>
								<div class="form">
									<div id="review_title" class="review-input">                            	
										<label class="review-label" for="name" id="name_label" style="margin-top: 0px;"><strong><?php _e ('Your Name', 're');?></strong></label>
										<input class="review-text" type="text" name="name" id="suggest_name" value=""/>									
										<span class="red">*</span>
										<div id="review_title_tooltip" class="review-tooltip" style="display: none; top: -20px">
											<div>
												<p><?php _e ('Please enter your name so that we can contact to you later', 're');?></p>
											</div>
										</div>
										</div>
								</div>
								<!--email-->
								<div class="form">
									<div id="review_title" class="review-input">                            	
										<label class="review-label" for="email" id="email_label" style="margin-top: 0px;"><strong><?php _e ('Your Email', 're');?></strong></label>
										<input class="review-text" type="text" name="email" id="suggest_email" value=""/>									
										<span class="red">*</span>
										<div id="review_title_tooltip" class="review-tooltip" style="display: none; top: -30px">
											<div>
												<p><?php _e ('Please enter your email so that we can contact to you later. <br /> Check your email format before submitting ', 're');?></p>
											</div>
										</div>
										</div>
								</div>
								<div class="clear"></div>								
								<?php }else {
								?>
								<input type="hidden" name="name" value="<?php echo $current_user->user_login ?>" />
								<input type="hidden" name="email" value="<?php echo $current_user->user_email ?>" />
								<p style="margin: 5px 0 0 5px;"> <?php
								  _e('Login as ', 're');
								  echo $helper->link($current_user->user_login, get_author_posts_url($user_ID) );
								?> </p>
								<?php 
								  } ?>
								<!--summary-->
								<p style="margin: 10px 0 0px 5px">
									<label for=""><strong> <?php _e('Suggestion: ','re') ?>  </strong><span class="red">*</span></label>
									<br/>
									<span class="sub-title" style="color: #515151;"> <?php _e ('Summary your suggestion, such as "Nikon D7000 is missing", "You should have review about New Macbook Air..." ', 're');?>
									<br/>
									</span>
								</p>							  
								<div id="review_con" class="review-input" style="height: 150px; width: 60%">								  
									<textarea class="review-text" id="suggest_detail" name="detail"  cols="30" rows="5" maxlength="<?php echo $limitation['con']?>"></textarea>								  
								</div>
								
								<div class="butt_search" style="margin-top:15px; float:left;">
									<div class="butt_search_left"></div>        
									<div class="butt_search_center" style="padding: 0 15px"><input type="submit" class="button" value="<?php _e ('Submit', 're');?>" name="submit" id="login_user"/></div>
									<div class="butt_search_right"></div>
								</div>
							</form>
						</div>
					</div>
					<?php	?>
            </div>
        </div>
    </div>
    
    <!--body end here-->
	 <script type="text/javascript">	 
	 var error_name_empty = '<?php echo $error_name_empty ?>';
	 var error_email_empty = '<?php echo $error_email_empty ?>';
	 var error_email_invalid = '<?php echo $error_email_invalid ?>';
	 var error_detail_empty = '<?php echo $error_detail_empty ?>';
	 var error_detail_too_long = '<?php echo $error_detail_too_long ?>';
	 
		jQuery(document).ready(function(){
			
			jQuery('.review-text').focusin(function(){
				jQuery(this).parent().find('.review-label').hide();
				jQuery(this).parent().find('.review-tooltip').show();
			});
			jQuery('.review-text').focusout(function(){
				if (jQuery(this).val() == '' )
					jQuery(this).parent().find('.review-label').show();
				jQuery(this).parent().find('.review-tooltip').hide();
			});
			jQuery('#suggest_form').submit(function(){
				// validate
				if (jQuery('#suggest_name').val() == ''){
				  showError(error_name_empty);
				  return false;
				}
				
				if (jQuery('#suggest_email').val() == ''){
				  showError(error_email_empty);
				  return false;
				}
				
				if ( !validateEmail( jQuery('#suggest_email').val() ) ){
				  showError(error_email_invalid);
				  return false;				  
				}
				
				if (jQuery('#suggest_detail').val() == ''){
				  showError(error_detail_empty);
				  return false;
				}
				
				if ( jQuery('#suggest_detail').val().length > 300 ){
				  showError(error_detail_too_long);
				  return false;
				}
				
				jQuery('#error_notice').hide();
			});
		});
		
		function showError(msg){
		  jQuery('#error_notice').html(msg);
		  jQuery('#error_notice').show();
		  jQuery('html, body').animate({'scrollTop' : jQuery('#error_notice').offset().top  }, 'slow');
		}
		
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
		
	</script>
<?php
	get_footer();
?>