<?php
/**
 * get rating
 * @Author: Toannm
 */
global $post, $current_user, $user_ID, $helper, $wp_query;

$cat = get_the_category();
?>
<div class="content_review">
<div class="revieww" style="padding-bottom: 20px;">
	
<?php
$submit_nologin = get_option(SETTING_SUBMIT_WITHOUT_LOGIN);

if ( $user_ID > 0 || $submit_nologin)
{
	$number_of_pages = 0;
?>
	   
		<div class="review-comments">
			 <div class="view" style="position:relative;">
				<script>
				function show_reply_form( comment_id ) {					
					if(comment_id > 0)
					{
						jQuery('.cancel.button').hide();
						jQuery('.reply.button').show();	
						jQuery('.reply-form').hide();
						jQuery('#reply_button_' + comment_id).hide();						
						jQuery('#child_reply_form_' + comment_id).fadeIn(500);
						jQuery('#cancel_button_' + comment_id).fadeIn(500);
					}else
					{
						jQuery('.reply-form').show();
						jQuery('.reply-form.child').hide();
						jQuery('.cancel.button').hide();
						jQuery('.reply.button').show();						
					}					
					return true;
				}
				</script>
				<ul class="commentlist">
				<?php
				wp_list_comments(array( 'type' => 'comment',
										'callback' => 'tgt_show_comments') );								
				?>
				</ul>
				<form id="submit_comment_product" action="<?php echo site_url('wp-comments-post.php') ?>" method="post">
					<div class="reply-form">
						<h3 class="comment-title"><?php  _e('Write your comment','re') ?></h3>
						<div id="comment_error" class="red"></div>
						<?php if($user_ID < 1) { ?>
						<div id="review-form">
							<p style="margin: 20px 0 0px 5px">
								<label for=""><strong> <?php _e('Your information','re') ?>  </strong><span class="red">*</span></label>
							</p>
							<div id="comment_username" class="review-input">
								<label class="review-label" for="" <?php if (!empty($review['username']) ) echo 'style="display:none;"' ?>><strong> <?php _e('Your name','re')?> </strong></label>
								<input type="text" id="author" name="author" id="comment_user_name" class="review-text"/>
								<span class="red">*</span>
								<div id="review_username_tooltip" class="review-tooltip" style="display: none;top: -10px">
									<div>
										<?php _e('Your name will be displayed on your comment.','re');?>
									</div>
								</div>
							</div>
							<div id="comment_email" class="review-input">
								<label class="review-label" for="" <?php if (!empty($review['user_email']) ) echo 'style="display:none;"' ?>><strong> <?php _e('Your email','re')?> </strong></label>
								<input type="text" name="email" id="comment_user_email" class="review-text"/>
								<span class="red">*</span>
								<div id="review_useremail_tooltip" class="review-tooltip" style="display: none;top: 0px">
									<div>
										<?php _e('Your email for display author email','re');?>
									</div>
								</div>
							</div>													
						</div>
						<?php } ?>												
						<div id="review-form">      							  
							<p style="margin: 20px 0 0px 5px">
								<label for=""><strong> <?php _e('Comment ','re') ?>  </strong><span class="red">*</span></label>									
							</p>
							<div id="review_pro" class="review-input review-input-full" style="height: 100px">								  
								<textarea class="review-text" name="comment"  cols="30" rows="3" maxlength="<?php echo $limitation['pro']?>"></textarea>									  
							</div>							

							<div class="butt_search" style="margin-top:15px; float:left;">  
								<div class="butt_search_left"></div>        
									<div class="butt_search_center"><input type="submit" name="submit_comment" class="button" value="Submit" /></div>
								<div class="butt_search_right"></div>
							</div>	
						</div>
					</div>
					<?php comment_id_fields(); ?>
					<input type="hidden" name="redirect_to" value="<?php echo get_permalink($post->ID) ?>">
					<?php do_action('comment_form', $post->ID); ?>
				</form>
			</div>
		</div>
	<?php	
}
	else {// end if ($user_ID ?>
	<p class="review-message"> <?php
	_e('Please ','re');
	echo $helper->link( __('login','re'), tgt_get_permalink('login') ) ;
	_e(' to submit the comment','re'); ?> </p>
	<?php } ?>
	
</div>
</div>
<script type="text/javascript">
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
	
	jQuery('#submit_comment_product').submit(function(){
		/**
		 * Validation
		 */	
		if ( jQuery('#comment_user_name').val() == '' ){
			showErrorComment(error_username_empty);
			jQuery('#comment_username').addClass('review-input-error');
			scrollUpCommentError();
			return false;
		}
		else {
			jQuery('#comment_username').removeClass('review-input-error');
		}
		if ( jQuery('#comment_user_email').val() == '' ){
			showErrorComment(error_useremail_empty);
			jQuery('#comment_email').addClass('review-input-error');
			scrollUpCommentError();
			return false;
		}
		else if (!validateEmail(jQuery('#comment_user_email').val())){
			showErrorComment('<?php echo $error_useremail_invalid; ?>');
			jQuery('#comment_email').addClass('review-input-error');
			scrollUpCommentError();
			return false;
		}
		else{
			jQuery('#comment_email').removeClass('review-input-error');
		}
			
		jQuery('#comment_error').html('');
		
	});
	
	// count charaters						
		
	jQuery('textarea[maxlength]').keyup(function(){
		var max = parseInt(jQuery(this).attr('maxlength'));
		if(jQuery(this).val().length > max){
			jQuery(this).val(jQuery(this).val().substr(0, jQuery(this).attr('maxlength')));
		}			
	});			
	
});

function countCharaters(string){
	return string.length;
}

function showErrorComment(error){
	jQuery('#comment_error').html(
		jQuery('<p class="red">' + error + '</p>')
	);
}
function scrollUpCommentError(){
	jQuery('html, body').scrollTop( jQuery('#comment_error').offset().top );
}


</script>