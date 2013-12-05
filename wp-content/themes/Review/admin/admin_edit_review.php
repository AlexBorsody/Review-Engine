<?php
$helper = new Html();
include PATH_ADMIN_PROCESSING . DS .'admin_edit_review_processing.php';
?>

<div class="wrap"> <!-- #wrap 1 -->
	<div id="icon-edit" class="icon32"><br></div>
	<h2>
		<?php _e( 'Edit Review', 're' );?>
	</h2>
	<div class="tgt_atention">
		<strong><?php _e('Problems? Questions?','ad');?></strong><?php _e(' Contact us at ','ad');?><em><a href="http://www.dailywp.com/support/" target="_blank">Support</a></em>. 
	</div>	
	<?php 
    if($message != '') 
    {
        echo '<div class="updated below-h2">'.$message.'</div>'; 
    }
    ?>
	<div id="poststuff">
		<div class="postbox">
			<h3 class="hndle"><?php _e("Review's Content for",'re') ?>&nbsp;<a href="admin.php?page=review-engine-add_product&p=<?php echo $post->ID; ?>" target="_blank"><?php echo $post->post_title; ?></a></h3>
			<div class="inside">
				<form action="" method="post" id="editreview">
					<label for="title"><?php _e('Title:', 're')?></label>
					<input type="text" name="edit_title" id="" value="<?php if(isset($_POST['edit_title'])) echo $_POST['edit_title']; else echo $comment_meta[0]['title']; ?>" class="review-text" />
					
					<label for="pro"><?php _e('The good:', 're')?></label>
					<textarea name="edit_good" id="" cols="30" class="review-textarea" rows="4"><?php if(isset($_POST['edit_good'])) echo $_POST['edit_good']; else echo htmlspecialchars( $comment_meta[0]['pro'] ); ?></textarea>
					
					<label for="con"><?php _e('The bad:', 're')?></label>
					<textarea name="edit_bad" id="" cols="30" class="review-textarea" rows="4"><?php if(isset($_POST['edit_bad'])) echo $_POST['edit_bad']; else echo htmlspecialchars( $comment_meta[0]['con'] ); ?></textarea>
					
					<label for="bottomline"><?php _e('Bottom line:', 're')?></label>
					<textarea name="edit_bottom" id="" cols="30" class="review-textarea" rows="4"><?php if(isset($_POST['edit_bottom'])) echo $_POST['edit_bottom']; else echo htmlspecialchars( $review_data->comment_content ); ?></textarea>
					
					<label for="review"><?php _e('Review:', 're')?></label>
					<textarea name="edit_review" id="reviewtext" cols="30" class="review-textarea" rows="4"><?php if(isset($_POST['edit_review'])) echo $_POST['edit_review']; else echo htmlspecialchars( $comment_meta[0]['review'] ); ?></textarea>
					<?php $helper->js('tinymce/tiny_mce.js') ?>
					<script type="text/javascript"><!--
						tinyMCE.init({
							theme : "advanced",
							mode : "exact",
							plugins: "fullscreen,table",
							elements : "reviewtext",
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
							width:"600px"
					  });
						-->
						</script>
					
					<div id="submitdiv">
						<input class="button button-primary " type="submit" name="save_edit" value="<?php _e('Save','re'); ?>" />
						<a href="admin.php?page=review-engine-list-reviews" class="button"><?php _e('Cancel','re'); ?></a>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div> <!-- //end wrap 1 -->