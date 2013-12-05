
<!-------------->
<!--STYLESHEET-->
<!-------------->
<?php
// include processing page
require ( TEMPLATEPATH . '/admin_processing/admin_review_settings_processing.php' );
// start processing
AdminReviewSettingsProcessing::reviewSettingsProcessing();

$helper = new Html();
$helper->css('/css/admin.css');

//echo AdminReviewSettingsProcessing::getSubmitSetting();
?>



<div class="wrap"> <!-- #wrap 1 -->
	<div id="icon-edit" class="icon32"><br></div>
	<h2>
		<?php _e( 'Review Settings', 're' );?>
	</h2>
	<div class="tgt_atention">
		<strong><?php _e('Problems? Questions?','re');?></strong><?php _e(' Contact us at ','re');?><em><a href="http://www.dailywp.com/support/" target="_blank">Support</a></em>. 
	</div>
	<?php if ( AdminReviewSettingsProcessing::hasSettingMessage() ) : ?>
	<div class="updated below-h2">
		<?php AdminReviewSettingsProcessing::getSettingMessage(); ?>
	</div>
	<?php endif;?>
	
	<?php if ( AdminReviewSettingsProcessing::hasError() ) : ?>
	<div class="error">
		<?php AdminReviewSettingsProcessing::getErrorMessage(); ?>
	</div>
	<?php endif;?>

	<form method="post">	 <!-- form -->	
		
		<div id="poststuff" class="has-right-sidebar"> <!-- box post 1 -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e( 'Review settings', 're' );?></label></h3>
						<div class="inside">						
							
							<table class="form-table"> <!-- form table -->
								<tbody>
									<tr>
										<th scope="row">
											<label for="tgt_fb_login">
												<?php _e( 'Enable facebook Login', 're' );?>
											</label>
											<a href="#fb_login_description" class="tooltip">[?]</a>
											<div id="fb_login_description" class="tooltip-content t-wide" style="display: none; position: absolute; z-index: 9998; left: 333px; top: 289px;">
												<?php _e ( 'Enable facebook login or not?', 're' );?>
											</div>
										</th>
										<td>
											<select id="tgt_fb_login" name="tgt_fb_login">
												<option value="0"><?php _e ( 'Disable', 're' );?></option>
												<option value="1" <?php AdminReviewSettingsProcessing::getFacebookLoginSetting(); ?>><?php _e ( 'Enable', 're' );?></option>
											</select>
										</td>										
									</tr>
									<tr>
										<th scope="row">
											<label for="tgt_allow_review">
												<?php _e( 'Allow Review', 're' );?>
											</label>
											<a href="#allow_review_description" class="tooltip">[?]</a>
											<div id="allow_review_description" class="tooltip-content t-wide" style="display: none">
												<?php _e ( 'Allow user review or not?', 're' );?>
											</div>
										</th>
										<td>
											<select id="tgt_allow_review" name="tgt_allow_review">
												<option value="0"><?php _e ( 'Disable', 're' );?></option>
												<option value="1" <?php AdminReviewSettingsProcessing::getAllowReviewSetting(); ?>><?php _e ( 'Enable', 're' );?></option>
											</select>
										</td>										
									</tr>
									<tr>
										<th scope="row">
											<label for="tgt_enable_like">
												<?php _e( 'Allow User like/dislike review', 're' );?>
											</label>
											<a href="#enable_like_description" class="tooltip">[?]</a>
											<div id="enable_like_description" class="tooltip-content t-wide" style="display: none">
												<?php _e ( 'Allow user like/dislike review?', 're' );?>
											</div>
										</th>
										<td>
											<select id="tgt_enable_like" name="tgt_enable_like">
												<option value="0"><?php _e ( 'Disable', 're' );?></option>
												<option value="1" <?php AdminReviewSettingsProcessing::getEnableLikeSetting(); ?>><?php _e ( 'Enable', 're' );?></option>
											</select>
										</td>										
									</tr>
                                                                        <tr>
										<th scope="row">
											<label for="tgt_enable_like">
												<?php _e( 'Showing rating of', 're' );?>
											</label>
											<a href="#top_product_rating" class="tooltip">[?]</a>
											<div id="top_product_rating" class="tooltip-content t-wide" style="display: none">
												<?php _e ( 'Choose user rating of editor rating to show in product list.', 're' );?>
											</div>
										</th>
										<td>
											<select id="tgt_top_product_rating" name="tgt_top_product_rating">
												<option value="0"><?php _e ( 'User', 're' );?></option>
												<option value="1" <?php AdminReviewSettingsProcessing::getTopProductSetting(); ?>><?php _e ( 'Editor', 're' );?></option>
											</select>
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label for="tgt_user_have_editor">
												<?php _e( 'User have editor?', 're' );?>
											</label>
											<a href="#user_editor_description" class="tooltip">[?]</a>
											<div id="user_editor_description" class="tooltip-content t-wide" style="display: none">
												<?php _e ( 'User can use editor or not.', 're' );?>
											</div>
										</th>
										<td>
											<select id="tgt_user_have_editor" name="tgt_user_have_editor">
												<option value="0"><?php _e ('Disable', 're');?></option>
												<option value="1" <?php AdminReviewSettingsProcessing::getEditorSetting(); ?>><?php _e('Enable', 're');?></option>
											</select>
										</td>										
									</tr>
									<tr>
										<th scope="row">
											<label for="tgt_auto_publish">
												<?php _e ( 'Auto publish submitted review', 're' );?>												
											</label>
											<a href="#auto_publish_description" class="tooltip">[?]</a>
											<div id="auto_publish_description" class="tooltip-content t-wide" style="display: none">
												<?php _e ( 'Enables automated publishing review or not.', 're' );?>
											</div>
										</th>									
										<td id="auto_publish_tr">
											<select id="tgt_auto_publish" name="tgt_auto_publish">
												<option value="0"><?php _e ( 'Disable', 're' );?></option>
												<option value="1" <?php AdminReviewSettingsProcessing::getPublishSetting(); ?>><?php _e ( 'Enable', 're' );?></option>
											</select>
										</td>										
									</tr>
                                    
									<tr class="form-field <?php AdminReviewSettingsProcessing::isErrorMessage( 'tgt_publish_min_posts' );?>"  id="auto_publish_tr">
										<th scope="row">
											<label for="tgt_publish_min_posts">
												<?php _e ( 'Minimum number of review(s)', 're' );?>												
											</label>
											<a href="#auto_publish_description2" class="tooltip">[?]</a>
											<div id="auto_publish_description2" class="tooltip-content t_wide" style="display: none">
												<?php _e ( 'Specified minimum number of published reviews that the member needed to "auto publish". If you enter the number 3, members must have 3 published reviews or more to get their review be "auto publish" automatically', 're' );?>
											</div>
										</th>									
										<td>
											<input type="text" id="tgt_publish_min_posts" onkeypress="return NumbersPrice(event);" name="tgt_publish_min_posts" style="width: 15%"  value="<?php AdminReviewSettingsProcessing::getPublishMinPosts(); ?>">											
											<span class="tgt_warning"><?php echo '<br>' . __ ( 'Must be a non-negative number', 're' );?></span>											
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label for="tgt_auto_publish">
												<?php _e ( 'Submit review without login', 're' );?>
											</label>
											<a href="#submit_review_nologin" class="tooltip">[?]</a>
											<div id="submit_review_nologin" class="tooltip-content t-wide" style="display: none">
												<?php _e ( 'Allow submit review without login.', 're' );?>
											</div>
										</th>
										<td id="auto_publish_tr">
											<select id="tgt_submit_review_nologin" name="tgt_submit_review_nologin">
												<option value="0"><?php _e ( 'No', 're' );?></option>
												<option value="1" <?php AdminReviewSettingsProcessing::getSubmitSetting(); ?>><?php _e ( 'Yes', 're' );?></option>
											</select>
										</td>
									</tr>
									<tr class="form-field <?php AdminReviewSettingsProcessing::isErrorMessage( 'tgt_title_limit' );?>">
										<th scope="row"><label for="tgt_title_limit"><?php _e( 'Title limitation', 're' );?><span class="description">(<?php _e( 'required', 're' );?>)</span></label>
											<a href="#title_limit_description" class="tooltip">[?]</a>		
											<div id="title_limit_description" class="tooltip-content t_wide" style="display: none">
												<?php _e ( 'Title words count limitation', 're' );?>
											</div>
										</th>							
										<td><input type="text" id="tgt_title_limit" onkeypress="return NumbersPrice(event);" name="tgt_title_limit" style="width: 15%" value="<?php AdminReviewSettingsProcessing::getTitleLimitationSetting(); ?>" ></td>
									</tr>
									<tr class="form-field <?php AdminReviewSettingsProcessing::isErrorMessage( 'tgt_con_limit' );?>">
										<th scope="row"><label for="tgt_con_limit"><?php _e( '"The bad" limitation', 're' );?><span class="description">(<?php _e( 'required', 're' );?>)</span></label>
											<a href="#con_limit_description" class="tooltip">[?]</a>		
											<div id="con_limit_description" class="tooltip-content t_wide" style="display: none">
												<?php _e ( 'The maximum number of words written in the defect', 're' );?>
											</div>
										</th>									
										<td><input type="text" id="tgt_con_limit" onkeypress="return NumbersPrice(event);" name="tgt_con_limit" style="width: 15%" value="<?php AdminReviewSettingsProcessing::getTheBadLimitationSetting(); ?>" ></td>
									</tr>
									<tr class="form-field <?php AdminReviewSettingsProcessing::isErrorMessage( 'tgt_pro_limit' );?>">
										<th scope="row"><label for="tgt_pro_limit"><?php _e( '"The good" limitation', 're' );?><span class="description">(<?php _e( 'required', 're' );?>)</span></label>
											<a href="#pro_limit_description" class="tooltip">[?]</a>		
											<div id="pro_limit_description" class="tooltip-content t_wide" style="display: none">
												<?php _e ( 'The maximum number of words written in the advantages', 're' );?>
											</div>
										</th>									
										<td><input type="text" id="tgt_pro_limit" onkeypress="return NumbersPrice(event);" name="tgt_pro_limit" style="width: 15%" value="<?php AdminReviewSettingsProcessing::getTheGoodLimitationSetting(); ?>"></td>
									</tr>
									<tr class="form-field <?php AdminReviewSettingsProcessing::isErrorMessage( 'tgt_bottom_line_limit' );?>">
										<th scope="row"><label for="tgt_bottom_line_limit"><?php _e( '"Bottom line" limitation', 're' );?><span class="description">(<?php _e( 'required', 're' );?>)</span></label>
											<a href="#bottom_line_limit_description" class="tooltip">[?]</a>		
											<div id="bottom_line_limit_description" class="tooltip-content t_wide" style="display: none">
												<?php _e ( 'The maximum number of words written in bottom line', 're' );?>
											</div>
										</th>									
										<td><input type="text" id="tgt_bottom_line_limit" onkeypress="return NumbersPrice(event);" name="tgt_bottom_line_limit" style="width: 15%" value="<?php AdminReviewSettingsProcessing::getBottomLineLimitationSetting(); ?>" ></td>
									</tr>
									<tr class="form-field <?php AdminReviewSettingsProcessing::isErrorMessage( 'tgt_review_limit' );?>">
										<th scope="row"><label for="tgt_review_limit"><?php _e( 'Review limitation', 're' );?><span class="description">(<?php _e( 'required', 're' );?>)</span></label>
											<a href="#review_limit_description" class="tooltip">[?]</a>		
											<div id="review_limit_description" class="tooltip-content t_wide" style="display: none">
												<?php _e ( 'The maximum number of words written in review content', 're' );?>
											</div>
										</th>								
										<td><input type="text" id="tgt_review_limit" onkeypress="return NumbersPrice(event);" name="tgt_review_limit" style="width: 15%" value="<?php AdminReviewSettingsProcessing::getReviewLimitationSetting(); ?>"></td>
									</tr>
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>
							
							<p/>
						    <div class="section-button-area">							
							    <div class="section-buttons">
								    <input class="left-align button-primary" type="submit" class="" name="save" value="<?php _e( 'Save', 're' );?>">
								    <input class="left-align button" type="submit" value="<?php _e( 'Reset to default', 're' );?>" class="" name="reset_default">
							    </div>
							    <div class="clear"></div>
						    </div>			
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- //post box 1 -->
		
		<!-- example  style for post box 2 -->
	</form> <!-- //form -->
	
</div> <!-- //end wrap 1 -->

<script type="text/javascript">
	//set some default value page load
	jQuery(document).ready(function(){
		jQuery(".tooltip").hover(function(){
			//jQuery(this).simpletooltip();
		});
		
		if ( jQuery("select[id='tgt_auto_publish'] option:selected").val() == 0 ){
			jQuery("input[id='tgt_publish_min_posts']").attr("disabled", "disabled");
			jQuery("input[id='tgt_publish_min_posts']").attr("readonly", "readonly");
			jQuery("tr[id=auto_publish_tr]").hide();
		}

		//when load page, if have errors, user javascript show these errors
		jQuery("select[id='tgt_auto_publish']").change(function(){
			var val = jQuery("select[id='tgt_auto_publish'] option:selected").val();
			if( val == 0 ) {
				jQuery("input[id='tgt_publish_min_posts']").attr("disabled", "disabled");
				jQuery("input[id='tgt_publish_min_posts']").attr("readonly", "readonly");
				jQuery("tr[id=auto_publish_tr]").fadeOut(1000);
			}
			if( val == 1 ){
				 jQuery("input[id='tgt_publish_min_posts']").removeAttr("disabled");
				 jQuery("input[id='tgt_publish_min_posts']").removeAttr("readonly");
				 jQuery("tr[id=auto_publish_tr]").fadeIn(1000);
			}
		});
	});

	
</script>