<?php
/**
 * get rating
 * @Author: Toannm
 */
global $post, $current_user, $user_ID, $helper;
$cat = get_the_category();
$ratings = get_option(SETTING_CATEGORY_RATING);
$globalRating = get_option(SETTING_RATING);

if (!empty($ratings[$cat[0]->term_id]) ) {
	$ratings = $ratings[$cat[0]->term_id];
}
else {
	$ratings = array();
}
?>
<div class="content_review">
<div class="revieww" style="padding-bottom: 20px;">
	
<?php
$submit_nologin = get_option(SETTING_SUBMIT_WITHOUT_LOGIN);
if ( $user_ID > 0 || $submit_nologin)
{
	if ($has_reviewed == false) {
?>
	<form id="submit_review" action="" method="post">
	<div class="review_left">
		<?php 
		if (!empty($ratings)){ ?>
		<div class="overall">
			<?php
			foreach ($ratings as $rating){
			?>
			  <div class="orange_rate2">
				  <p class="rate"><?php echo $globalRating[$rating] ?></p>
					<div class="vote_star" style="background:none; border:none; height:auto; margin:5px 0; width: 100%">
						 <div class="stars_wrapper" style="margin-left:15px;">
							<input type="hidden" name="rating[<?php echo $rating?>]" value="0"/>
							<input title="<?php _e('Abysmal','re')?>" class="review_rate {split:2} review-point" type="radio" name="rating[<?php echo $rating?>]" value="1"/>
							<input title="<?php _e('Terrible','re')?>" class="review_rate {split:2} review-point" type="radio" name="rating[<?php echo $rating?>]" value="2"/>
							<input title="<?php _e('Poor','re')?>" class="review_rate {split:2} review-point" type="radio" name="rating[<?php echo $rating?>]" value="3"/>
							<input title="<?php _e('Mediocre','re')?>" class="review_rate {split:2} review-point" type="radio" name="rating[<?php echo $rating?>]" value="4"/>
							<input title="<?php _e('OK','re')?>" class="review_rate {split:2} review-point" type="radio" name="rating[<?php echo $rating?>]" value="5"/>
							<input title="<?php _e('Good','re')?>" class="review_rate {split:2}" type="radio" name="rating[<?php echo $rating?>]" value="6"/>
							<input title="<?php _e('Very Good','re')?>" class="review_rate {split:2} review-point" type="radio" name="rating[<?php echo $rating?>]" value="7"/>
							<input title="<?php _e('Excellent','re')?>" class="review_rate {split:2} review-point" type="radio" name="rating[<?php echo $rating?>]" value="8"/>
							<input title="<?php _e('Outstanding','re')?>" class="review_rate {split:2} review-point" type="radio" name="rating[<?php echo $rating?>]" value="9"/>
							<input title="<?php _e('Spectacular','re')?>" class="review_rate {split:2} review-point" type="radio" name="rating[<?php echo $rating?>]" value="10"/>
						 </div>
						 <script type="text/javascript">
							jQuery(document).ready(function(){							
								jQuery('.review_rate').rating();
								jQuery('.rating-cancel').remove();
							});
						 </script>
					</div>
			  </div>
			<?php } 
			?>			  
			  
		 </div>
	<?php } ?>
	</div>
    
		<div class="review_center">
			 <div class="view" style="position:relative;"> 
				  <div class="box_reply" style="margin-top:0; width: 785px">
						<p class="sum"><strong style="color:#0184E7; font-size:16px;"> <?php  _e('Write review','re') ?> </strong></p><br/>
                                                <p class="sum"> <?php _e('Please remember to rate for this product','re'); ?> </p>
                                                <div id="review_error" class="red">
						</div>
                                                <?php if($user_ID < 1) { ?>
                                                <div id="review-form">
                                                    <p style="margin: 20px 0 0px 5px">
                                                        <label for=""><strong> <?php _e('Your information','re') ?>  </strong><span class="red">*</span></label>
                                                    </p>
                                                    <div id="review_username" class="review-input">
                                                        <label class="review-label" for="" <?php if (!empty($review['username']) ) echo 'style="display:none;"' ?>><strong> <?php _e('Your name','re')?> </strong></label>
                                                        <input type="text" name="user_name" id="user_name" class="review-text"/>
                                                        <span class="red">*</span>
                                                        <div id="review_username_tooltip" class="review-tooltip" style="display: none;top: -10px">
                                                            <div>
                                                                <?php _e('Your name will be displayed on your review.','re');?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div id="review_email" class="review-input">
                                                        <label class="review-label" for="" <?php if (!empty($review['user_email']) ) echo 'style="display:none;"' ?>><strong> <?php _e('Your email','re')?> </strong></label>
                                                        <input type="text" name="user_email" id="user_email" class="review-text"/>
                                                        <span class="red">*</span>
                                                        <div id="review_useremail_tooltip" class="review-tooltip" style="display: none;top: 0px">
                                                            <div>
                                                                <?php _e('Your email for display author email','re');?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <?php } ?>												
						<div id="review-form">
                                                        <p style="margin: 10px 0 0px 5px">
                                                            <label for=""><strong> <?php _e('Review Title','re') ?>  </strong><span class="red">*</span></label>
                                                        </p>
                                                      <div id="review_title" class="review-input">
                                                              <label class="review-label" for="" <?php if (!empty($review['title']) ) echo 'style="display:none;"' ?>><strong> <?php _e('Type your review title','re')?> </strong></label>
                                                              <input class="review-text" id="r_title" type="text" name="title" value="<?php if (!empty($review['title'])) echo $review['title'] ?>" maxlength="<?php echo $limitation['title']?>"/>
                                                              <span class="red">*</span>
                                                              <div id="review_title_tooltip" class="review-tooltip" style="display: none;top: -45px">
                                                                      <div>
                                                                              <p> <?php
                                                                              _e('Summarize your review about this product in one line. ','re');
                                                                              echo $limitation['title'] . __(' charaters maximum','re');
                                                                              ?> </p>
                                                                              <p> <?php _e('Characters left: ', 're'); ?> <span id="title_count" class="counter"><?php echo $limitation['title'] ?></span> </p>
                                                                      </div>
                                                              </div>
                                                      </div>
							  
							  <p style="margin: 20px 0 0px 5px">
									<label for=""><strong> <?php _e('The Good','re') ?>  </strong><span class="red">*</span></label>
									<br/>
									<span class="sub-title"> <?php  _e('What was the best part of working with this company? ','re'); ?>
									<br/>
									<?php _e(' Characters left: ','re')?>
									<span class="counter" id="pro_count"><?php echo $limitation['pro'] ?></span>
									</span>
								</p>
							  <div id="review_pro" class="review-input review-input-full" style="height: 100px">								  
								  <textarea class="review-text" id="r_pro" name="pro"  cols="30" rows="3" maxlength="<?php echo $limitation['pro']?>"></textarea>									  
							  </div>
							  							  
							  <p style="margin: 20px 0 0px 5px">
									<label for=""><strong> <?php _e('The Bad ','re') ?>  </strong><span class="red">*</span></label>
									<br/>
									<span class="sub-title"> <?php  _e('What were some of the challenges you faced while working with this agency? ','re'); ?>
									<br/>
									<?php _e(' Characters left: ','re')?>
									<span class="counter" id="con_count"><?php echo $limitation['con'] ?></span>
									</span>
								</p>							  
							  <div id="review_con" class="review-input review-input-full" style="height: 100px">								  
								  <textarea class="review-text" id="r_con" name="con"  cols="30" rows="5" maxlength="<?php echo $limitation['con']?>"></textarea>								  
							  </div>
							  
								<p style="margin: 20px 0 0px 5px">
									<label for=""><strong> <?php _e('Bottom line','re') ?>  </strong></label>
									<br/>
									<span class="sub-title"> <?php _e('Explain your overall experience in working with this company and your recommendation on others who may want to work with them.','re'); ?>
									<br/>
									<?php _e(' Characters left: ','re')?>
									<span class="counter" id="bottomline_count"><?php echo $limitation['bottomline'] ?></span>
									</span>
								</p>
							  
								<div id="review_bottomline" class="review-input review-input-full" style="height: 130px;">								  
								  <textarea class="review-text" id="r_bottomline" name="bottomline"  cols="30" rows="5" maxlength="<?php echo $limitation['bottomline']?>"></textarea>
								</div>
							  
								<p style="margin: 20px 0 0px 5px">
									<label for=""><strong> <?php _e('Review','re') ?>  </strong></label>
									<br/>
									<span class="sub-title"> <?php _e('Your review about this product in detail. ','re') ?>
									</span>
								</p>
								<?php  if ($editor_enable) {?>
									<textarea class="review-text" id="r_content" name="review" cols="30" rows="10"></textarea>
									
									<script language="javascript" type="text/javascript" src="<?php echo TEMPLATE_URL ?>/js/tinymce/tiny_mce.js"></script>
									<script type="text/javascript"><!--
										tinyMCE.init({
											theme : "advanced",
											mode : "exact",
											plugins: "fullscreen,table",
											elements : "r_content",
											theme_advanced_fonts : "Arial=arial,helvetica,sans-serif;"+
												"Courier New=courier new,courier;"+
												"Georgia=georgia,palatino;"+
												"Tahoma=tahoma,arial,helvetica,sans-serif;"+
												"Times New Roman=times new roman,times;"+
												"Verdana=verdana,geneva;",
											theme_advanced_font_sizes: "8px,10px,12px,14px,16px,24px,28px,32px",
											theme_advanced_toolbar_location : "top",
											theme_advanced_toolbar_align: "left",
											theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,"
											+ "justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,"
											+ "bullist,numlist,outdent,indent,fullscreen",
											theme_advanced_buttons2 : "link,unlink,anchor,image,separator,"
											+"undo,redo,cleanup,code,separator,sub,sup,charmap,separator, tablecontrols",
											theme_advanced_buttons3 : "",
											height:"300px",
											width:"700px"
									  });
										-->
									</script>
								<?php } else {?>
								<div id="review_review" class="review-input review-input-full" style="height: 200px;">
									<textarea class="review-text" id="r_content" name="review" cols="30" rows="10"></textarea>
								</div>
								<?php } ?>
						  
							  <p class="sum">
									<?php
									_e(' The posting of advertisements, profanity, or personal attacks are prohibited. ', 're');
									echo $helper->link( __('Click here','re') , '#')  . __(' to review our site terms of use.','re');
									?>
							  </p>

							  <div class="butt_search" style="margin-top:15px; float:left;">  
								  <div class="butt_search_left"></div>        
									  <div class="butt_search_center"><input type="submit" name="submit_review" class="button" value="Submit" /></div>
								  <div class="butt_search_right"></div>
							  </div>
						  
							  <div class="butt_search" style="margin-top:15px; float:left; margin-left:15px;">  
								  <div class="butt_search_left2"></div>        
									  <div class="butt_search_center2"><input style="text-shadow:1px 0 #000;" type="button" id="cancel_review" class="button" value="Cancel" /></div>
								  <div class="butt_search_right2"></div>
							  </div>
					  </div>

				  </div>
			 </div>
		</div>
							  
		</form>				 
	<?php }
	else { ?>
		<p class="review-message">
			<?php _e('You have reviewed this product already ','re')?>
		</p>
	<?php
	}
}
	else {// end if ($user_ID ?>
	<p class="review-message"> <?php
	_e('Please ','re');
	echo $helper->link( __('login','re'), tgt_get_permalink('login') ) ;
	_e(' or ','re');
	echo $helper->link( __('register','re'), tgt_get_permalink('register') ) ;
	_e(' to submit a review','re'); ?> </p>
	<?php } ?>
	
</div>
</div>
<script type="text/javascript">
<!--
	/**
	 * error message
	 */
	var error_title_empty = '<?php echo $error_title_empty ?>';
	var error_title_short = '<?php echo $error_title_short ?>';
	
	var error_con_empty = '<?php echo $error_con_empty ?>';
	var error_con_short = '<?php echo $error_con_short ?>';
	
	var error_pro_empty = '<?php echo $error_pro_empty ?>';
	var error_pro_short = '<?php echo $error_pro_short ?>';
	var error_not_rating = '<?php echo $error_not_rating ?>';
	var error_username_empty = '<?php echo $error_username_empty; ?>';
    var error_useremail_empty = '<?php echo $error_useremail_empty; ?>';

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
		
		jQuery('#submit_review').submit(function(){
			/**
			 * Validation
			 */
            var user_id = <?php echo $user_ID; ?>;
            if(user_id < 1)
            {
                if ( jQuery('#user_name').val() == '' ){
					showError(error_username_empty);
					jQuery('#review_username').addClass('review-input-error');
					scrollUp();
					return false;
	            }
	            else {
                    jQuery('#review_username').removeClass('review-input-error');
	            }
	            if ( jQuery('#user_email').val() == '' ){
					showError(error_useremail_empty);
					jQuery('#review_email').addClass('review-input-error');
					scrollUp();
					return false;
                }
                else if (!validateEmail(jQuery('#user_email').val())){
                    showError('<?php echo $error_useremail_invalid; ?>');
					jQuery('#review_email').addClass('review-input-error');
					scrollUp();
					return false;
				}
                else{
					jQuery('#review_email').removeClass('review-input-error');
				}
			}
			if ( jQuery('#r_title').val() == '' ){
				showError(error_title_empty);
				jQuery('#review_title').addClass('review-input-error');
				scrollUp();
				return false;
			}
			else {
				jQuery('#review_title').removeClass('review-input-error');				
			}
			
			if ( jQuery('#r_pro').val() == '' ){
				showError(error_pro_empty);
				jQuery('#review_pro').addClass('review-input-error');
				scrollUp();
				return false;
			}
			else {
				jQuery('#review_pro').removeClass('review-input-error');				
			}
			
			if ( jQuery('#r_con').val() == '' ){
				showError(error_con_empty);
				jQuery('#review_con').addClass('review-input-error');
				scrollUp();
				return false;
			}
			else {
				jQuery('#review_con').removeClass('review-input-error');
			}
			// validate member has rated review or not
			if (jQuery('.review_rate:checked').length < (jQuery('.review_rate').length / 20) ){
				showError(error_not_rating);
				scrollUp();
				return false;				
			}
			else {
				jQuery('#review_con').removeClass('review-input-error');				
			}			
			jQuery('#review_error').html('');
			
		});
		
		// count charaters
			var title_limit = <?php echo $limitation['title'] ?>;
			var pro_limit = <?php echo $limitation['pro'] ?>;
			var con_limit = <?php echo $limitation['con'] ?>;
			var bottomline_limit = <?php echo $limitation['bottomline'] ?>;
			var review_limit = <?php echo $limitation['review'] ?>;
			
			jQuery('#r_title').keyup(function(){
				jQuery('#title_count').html( title_limit - countCharaters(jQuery('#r_title').val()));
			});
			
			jQuery('textarea[maxlength]').keyup(function(){
				var max = parseInt(jQuery(this).attr('maxlength'));
				if(jQuery(this).val().length > max){
					jQuery(this).val(jQuery(this).val().substr(0, jQuery(this).attr('maxlength')));
				}
				
				jQuery('#bottomline_count').html( bottomline_limit - countCharaters(jQuery('#r_bottomline').val()));
				jQuery('#con_count').html( con_limit - countCharaters(jQuery('#r_con').val()));
				jQuery('#pro_count').html( pro_limit - countCharaters(jQuery('#r_pro').val()));
			});
			
		jQuery('#cancel_review').click(function(){
			jQuery('#r_title').val('');
			jQuery('#r_pro').val('');
			jQuery('#r_con').val('');
			jQuery('#r_bottomline').val('');
			tinyMCE.get('r_content').setContent('');
		});
	});
	
	function countCharaters(string){
		return string.length;
	}
	
	function showError(error){
		jQuery('#review_error').html(
			jQuery('<p class="red">' + error + '</p>')
		);
	}
	function scrollUp(){
		jQuery('html, body').scrollTop( jQuery('#review_error').offset().top );
	}
-->
</script>
