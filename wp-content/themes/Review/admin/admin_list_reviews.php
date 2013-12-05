<?php
$helper = new Html();
if(isset($_GET['action']) && $_GET['action'] == 'edit')
{
	require_once TEMPLATEPATH . '/admin/admin_edit_review.php';
	exit;
}
require( TEMPLATEPATH . '/admin_processing/admin_list_reviews_processing.php' );

$lastposts = tgt_lp_get_products( 'product', 'publish', 5 );

$reviews = tgt_lr_get_reviews();
?>
<div class="wrap"> <!-- #wrap 1 -->
	<div id="icon-edit" class="icon32"><br></div>
	<h2>
		<?php _e( 'List Review', 're' );?>
	</h2>
	<div class="tgt_atention">
		<strong><?php _e( 'Problems? Questions?','re' );?></strong><?php _e(' Contact us at ','re');?><em><a href="http://www.dailywp.com/support/" target="_blank">Support</a></em>. 
	</div>
	<?php if ( tgt_lr_have_messages() ) : ?>
	<div class="updated below-h2">
		<?php tgt_lr_print_messages(); ?>
	</div>
	<?php endif;?>
	
	<form method="get" action="" >
		<p class="search-box"> <!-- search box -->
			<label for="post-search-input" class="screen-reader-text"><?php _e( 'Search Products', 're' );?>:</label>
			<input type="text" value="<?php echo htmlspecialchars( $product_query['s'] );?>" name="s" id="post-search-input" >
			<input type="hidden" value="1" name="to" id="title_only" >
			<input type="submit" class="button" value="<?php _e( 'Search Products', 're' );?>">
		</p> <!-- //search box -->
		<input type="hidden" name="page" id="page" value="review-engine-list-reviews" />
	</form>
	<?php if( $product_query[ 'cat' ]
	|| $product_query[ 'tag' ]
	|| $product_query[ 's' ]
	|| $product_query[ 'author' ] ) { ?>
	<div id="products" >
		<table cellspacing="0" class="widefat post fixed"> <!-- list table -->
			<thead> <!-- table header -->
				<tr>				
					<th style="" class="manage-column column-title" id="title" scope="col"><?php _e( 'Title', 're' );?></th>
					<th style="" class="manage-column column-author" id="author" scope="col"><?php _e( 'Author', 're' );?></th>
					<th style="" class="manage-column column-categories" id="categories" scope="col"><?php _e( 'Categories', 're' );?></th>
					<th style="" class="manage-column column-tags" id="tags" scope="col"><?php _e( 'Tags', 're' );?></th>
				</tr>
			</thead> <!-- //table header -->
		<tbody> <!-- table body -->
				<?php
				$pagenum = tgt_lp_get_page_num();
				$perPage = $product_query[ 'per_page' ];
				if ( empty( $lastposts ) ) {
					_e('No Results','re');
				} else {
					$total= $product_query[ 'total' ];
					
					foreach( $lastposts as $post ) {
					    setup_postdata( $post );
					?>		
					<tr valign="top" class="alternate author-other status-publish iedit">
						<td class="post-title column-title">
	                    <strong>
	                    	<?php if( isset( $_GET[ 'product_id'] ) && (int)$_GET[ 'product_id'] == $post->ID ) { 
	                    		echo $post->post_title; 
	                    	} else { ?>
		                    <a title="<?php _e( 'Click this product to view list review of this product', 're' );?>" href="<?php tgt_lr_get_current_url();?>&amp;product_id=<?php the_ID();?>" class="row-title">
		                    	<?php echo $post->post_title;?> 
		                    </a>
		                    <?php }?>
	                    </strong>
						</td>
							<td class="author column-author"><a href="admin.php?page=review-engine-list-reviews&amp;author=<?php the_author_id();?>"><?php the_author();?></a></td>
							<td class="categories column-categories">
							    <?php 
								$post_categories = wp_get_post_categories( $post->ID );
								$cats = array();
								foreach($post_categories as $c){
									$cat = get_category( $c );
									$cats[] =  '<a href="admin.php?page=review-engine-list-reviews&amp;cat=' . $cat->term_id . '">' . $cat->name . '</a>';
								}
								echo ( implode( ', ', $cats ) );
								?>
							</td>
							<td class="tags column-tags">
								<?php
								$tags = wp_get_post_tags( $post->ID );
								$post_tags = array();
								foreach( $tags as $tag ) {
									$post_tags[] = '<a href="admin.php?page=review-engine-list-reviews&tag=' . $tag->term_id . '">' . $tag->name . '</a>';
								}
								if ( ! empty ( $post_tags ) ) {
									echo ( implode( ', ', $post_tags ) );
								} else {
									_e( 'No tags', 're' );
								}
								?>
							</td>
					</tr>
					<?php } // end if?>
				<?php } // end for?>

			</tbody> <!-- //table body -->
		</table> <!-- //list table -->
				
		<div class="tablenav"> 
			<div class="tablenav-pages"> <!-- page navigation -->
				<?php tgt_lp_page_naging( $lastposts ); ?>
			</div> <!-- //page navigation -->
			
			<div class="alignleft actions"> <!-- #selects: filter + bulk action -->
			</div> <!-- //selects: filter + bulk action -->
		</div>
	</div>
	<?php }?>
	<form method="post" >
	<div id="subreview">
		<ul class="subsubsub"><?php  ?>
			<li class="all"><a href="<?php tgt_lr_get_current_url();?>&amp;review_status=all" <?php tgt_lr_get_current( 'all' );?>> <?php _e( 'All', 're' );?> </a> |</li>
			<li class="moderated"><a href="<?php tgt_lr_get_current_url();?>&amp;review_status=hold" <?php tgt_lr_get_current( 'hold' );?>> <?php _e( 'Pending', 're' );?> </a> |</li>
			<li class="approved"><a href="<?php tgt_lr_get_current_url();?>&amp;review_status=approve" <?php tgt_lr_get_current( 'approve' );?>> <?php _e( 'Approved', 're' );?> </a> |</li>
			<li class="spam"><a href="<?php tgt_lr_get_current_url();?>&amp;review_status=spam" <?php tgt_lr_get_current( 'spam' );?>> <?php _e( 'Spam', 're' );?> </a> |</li>
			<li class="trash"><a href="<?php tgt_lr_get_current_url();?>&amp;review_status=trash" <?php tgt_lr_get_current( 'trash' );?>> <?php _e( 'Trash', 're' );?> </a> |</li>
		</ul>
		<div class="tablenav">
			<div class="tablenav-pages"> <!-- page navigation -->
				<?php tgt_lr_page_naging( $lastposts ); ?>
			</div> <!-- //page navigation -->
			<div class="alignleft actions">
				<select name="subaction" id="subaction">
					<?php
					if( $review_query[ 'review_status' ] != 'trash' ) { 
						if( $review_query[ 'review_status' ] != 'hold' ) { ?>
						<option value="hold"><?php _e( 'Unapprove', 're' );?></option>
						<?php } if( $review_query[ 'review_status' ] != 'approve' ) { ?>
						<option value="approve"><?php _e( 'Approve', 're' );?></option>
						<?php } if( $review_query[ 'review_status' ] != 'spam' ) { ?>
						<option value="spam"><?php _e( 'Mark as Spam', 're' );?></option>
						<?php } if( $review_query[ 'review_status' ] != 'trash' ) { ?>
						<option value="trash"><?php _e( 'Move to Trash', 're' );?></option>
						<?php } 
					} else {?>
						<option value="restore"><?php _e( 'Restore', 're' );?></option>
						<option value="delete"><?php _e( 'Delete Permanently', 're' );?></option>
					<?php }?>
				</select>
				<input type="submit" class="button-secondary apply" value="<?php _e( 'Apply', 're' );?>" name="doaction" />
			</div>
			<br class="clear">
		</div>
	</div>
	<div id="reviews" >
		<table id="list_review_table" cellspacing="0" class="widefat comments fixed"> <!-- list table -->
			<thead> <!-- table header -->
				<tr>
					<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input id="allchecked" type="checkbox"></th>
					<th style="width:200px;"  class="manage-column column-author" id="author" scope="col"><?php _e( 'General Info', 're' );?></th>
					<th style="" class="manage-column column-author" id="email" scope="col"><?php _e( 'Author', 're' );?></th>
					<th style="" class="manage-column column-reivew" id="review" scope="col"><?php _e( 'Review Content', 're' );?></th>
					<th style="" class="manage-column column-date" id="date" scope="col"><?php _e( 'Likes & Dislikes', 're' );?></th>
				</tr>
			</thead> <!-- //table header -->			
			<tbody id="the-comment-list" class="list:comment">
	<?php 
		if( ! empty( $reviews ) ) {
			foreach( $reviews as $review ) {
				$reviewStatus = wp_get_comment_status( $review->comment_ID );
				if( $reviewStatus == 'trash' ) {
					$reviewStatus = '<span class="error">' . $reviewStatus . '</span>';
				} elseif( $reviewStatus == 'unapproved' ) {
					$reviewStatus = 'pending';
				} elseif( $reviewStatus == 'approved' ) {
					$reviewStatus = '';
				}
				$comment_meta = get_comment_meta( $review->comment_ID , "tgt_review_data" );
				$likes = count( get_comment_meta( $review->comment_ID , "tgt_likes" ) );
				$dislikes = count( get_comment_meta( $review->comment_ID , "tgt_dislikes" ) );
		?>
				<tr valign="top" class="<?php if( $review->comment_type == 'editor_review' ) { echo 'reviewer ';} ?>alternate author-other status-publish iedit <?php echo $reviewStatus == 'pending' ? 'unapproved' : 'approved' ; ?>">
					<th scope="row" class="check-column"><input type="checkbox" name="review_ids[]" value="<?php echo $review->comment_ID;?>"></th>
					<td class="column-author">
						<?php _e( 'Product', 're' );?>:"<a href="<?php echo get_permalink( $review->comment_post_ID );?>"><strong><?php echo htmlspecialchars( $review->post_title ); ?></strong></a>"															
					</td>
					<td class="column-author">						
						<strong><?php echo htmlspecialchars( $review->comment_author ); ?></strong><br/>
						<?php _e('Review date:','re'); ?>&nbsp;<?php echo date( 'M d, Y', strtotime( $review->comment_date ) ); ?>
					</td>
					<td class="column-bottom-line review-list">
						<h3 class="title-review">
							"<?php echo $comment_meta[0]['title']; ?>"
							<a class="row-actions" onclick="return confirm_delete();" href="admin.php?page=review-engine-list-reviews&amp;id=<?php echo $review->comment_ID;?>&amp;action=edit">-&nbsp;<?php _e('Edit','re'); ?></a>
						</h3>
						<a id="link_more_quick_<?php echo $review->comment_ID; ?>" onclick="show_all('<?php echo (int)$review->comment_ID; ?>'); return false;" href="#" class="row-title"><strong><?php _e('Show all','re'); ?>&nbsp;&raquo;</strong></a>
						<div id="show_all_quick_review_<?php echo $review->comment_ID;?>" style="display:none;">
								<div class="review-into">
										<h3 class="title"> <?php _e('The good', 're') ?> </h3>
										<p>
												<?php echo htmlspecialchars( $comment_meta[0]['pro'] ); ?>
										</p>
										
								</div>
								<div class="review-desc">
										<h3> <?php _e('The bad ', 're') ?> </h3>
										<p>
												<?php echo htmlspecialchars( $comment_meta[0]['con'] ); ?>
										</p>
								</div>
								<div class="review-desc">
										<h3> <?php _e('Bottom line', 're') ?> </h3>
										<p>
												<?php echo htmlspecialchars($review->comment_content ); ?>
										</p>
								</div>
								<div class="review-desc">
										<h3> <?php _e('Review', 're') ?> </h3>
										<p>
												<?php echo $comment_meta[0]['review']  ; ?>
										</p>
								</div>
								<a id="link_hide_quick" onclick="hide_all('<?php echo (int)$review->comment_ID; ?>');return false;" href="#" class="row-title"><strong><?php _e('Hide','re'); ?>&nbsp;&laquo;</strong></a>
						</div>	
					</td>
					<td class="column-date">						
						<?php _e( 'Likes', 're' );?>:<strong><?php echo $likes; ?></strong><br/>
						<?php _e( 'Dislikes', 're' );?>:<strong><?php echo $dislikes; ?></strong>
					</td>					
				</tr>
			<?php
			}
			?>
			</tbody> <!-- //table body -->
			</table> <!-- //list table -->
			<div class="tablenav"> 
				<div class="tablenav-pages"> <!-- page navigation -->
					<?php tgt_lr_page_naging( $lastposts ); ?>
				</div> <!-- //page navigation -->
				
				<div class="alignleft actions"> <!-- #selects: filter + bulk action -->
				</div> <!-- //selects: filter + bulk action -->
			</div>
			
			<?php
		}
	?>
	</div>
	</form>
	
</div>

<script type="text/javascript">
/*
	jQuery('.review-show-button').fadeIn( 200 );
	jQuery('.review-hide-button').fadeIn( 200 );
	jQuery('.review-content').fadeOut( 200 );
	
	jQuery("#post-search-input").focus();
	function showReviewContent( review_id ) {
		jQuery('#review-show-button-' + review_id ).fadeOut(500);
		jQuery('#review-content-' + review_id ).fadeIn(500);
	}
	function hideReviewContent( review_id ) {
		jQuery('#review-show-button-' + review_id ).fadeIn(500);
		jQuery('#review-content-' + review_id ).fadeOut(500);
	}
*/
	function show_all(str)
	{
		jQuery("#link_more_quick_"+str).hide();
		jQuery("#show_all_quick_review_"+str).parent().find('#show_all_quick_review_'+str).show();
		
	}
	function hide_all(str)
	{
		jQuery("#link_more_quick_"+str).show();
		jQuery("#show_all_quick_review_"+str).hide();
		
	}
</script>