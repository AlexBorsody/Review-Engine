<?php
/*
 * @Author: James. 
 */
@ini_set('display_errors', 0);
global $wp_query, $custom_query;
$message_approve = '';
require( TEMPLATEPATH . '/admin_processing/admin_dashboard_list_reviews_processing.php' );
$ad_version = get_theme_data(TEMPLATEPATH . '/style.css');
$new_version = tgt_get_version(20);//get version of review engine

$update = '';

if($new_version['version'] != $ad_version['Version'] && $new_version['name']==$ad_version['Name'])	
	$update= 1;
global $wpdb;
$prefix = $wpdb->prefix;	

$count_total_editor = $wpdb->get_var("SELECT COUNT(u.ID) FROM ".$prefix."users u, ".$prefix."usermeta um WHERE  u.ID = um.user_id AND um.meta_key = '".$prefix."capabilities' AND  um.meta_value LIKE '%reviewer%'");
$count_total_user = $wpdb->get_var("SELECT COUNT(u.ID) FROM ".$prefix."users u, ".$prefix."usermeta um WHERE  u.ID = um.user_id AND um.meta_key = '".$prefix."capabilities' AND  um.meta_value LIKE '%subscriber%'");

$count_total_published_product = $wpdb->get_var("SELECT COUNT(p.ID) FROM ".$prefix."posts p WHERE  p.post_type = 'product' AND p.post_status = 'publish'");
$count_total_pending_product = $wpdb->get_var("SELECT COUNT(p.ID) FROM ".$prefix."posts p WHERE  p.post_type = 'product' AND p.post_status = 'pending'");

$count_total_published_article = $wpdb->get_var("SELECT COUNT(p.ID) FROM ".$prefix."posts p WHERE  p.post_type = 'article' AND p.post_status = 'publish'");
$count_total_pending_article = $wpdb->get_var("SELECT COUNT(p.ID) FROM ".$prefix."posts p WHERE  p.post_type = 'article' AND p.post_status = 'pending'");

$count_total_published_editor_review = $wpdb->get_var("SELECT COUNT(c.comment_ID) FROM ".$prefix."comments c WHERE  c.comment_type  = 'editor_review' AND  c.comment_approved = '1'");
$count_total_published_user_review = $wpdb->get_var("SELECT COUNT(c.comment_ID) FROM ".$prefix."comments c WHERE  c.comment_type  = 'review' AND  c.comment_approved = '1'");

$count_total_suggestion = $wpdb->get_var("SELECT COUNT(c.comment_ID) FROM ".$prefix."comments c WHERE  c.comment_type  = 'suggestion' AND  c.comment_approved = '1'");

$tgt_rss_feed = 'http://www.dailywp.com/feed/';
?>
<div class="wrap">
        <div class="icon32" id="icon-themes"><br/></div>
        <h2><?php _e('ReviewEngine Dashboard', 're') ?></h2>        
		<?php 
		if($message_approve != '') 
		{		
			echo '<div class="updated below-h2">'.$message_approve.'</div>'; 
		}
		?>
	<div class="dashboard-col-left dashboard-column">
		<div class="dash-left metabox-holder">
			<div class="postbox">
				<div class="statsico"></div>
				<h3 class="hndle"><span><?php _e('ReviewEngine Info', 're') ?></span></h3>
				<div class="preloader-container">
						<div class="insider" id="boxy">    
							<ul>
								<li>
								<?php echo $ad_version['Name']; ?>: <strong><?php echo $ad_version['Version']; ?></strong>
								 </li>
							</ul> 
							<ul>
								 <li>
								<?php echo $new_version['name']." ".$new_version['version'];?> is available!
								<?php if($update==1):?>
								 <a href="http://www.dailywp.com/member/member.php" target="_blank">
									<?php _e('Please update now','re');?> 
								 </a>
								<?php endif;?>
								 </li>
							</ul> 
							<ul>
								 <li><?php _e('Total Users', 're'); ?>: <a href="users.php" style="font-size:13px;"><strong><?php echo $count_total_editor + $count_total_user; ?></strong></a>&nbsp;<?php echo '(&nbsp;<font color="#21759B"><strong>'.$count_total_editor.'</strong></font>&nbsp;'.__('reviewer(s) and','re').'&nbsp;<font color="#21759B"><strong>'.$count_total_user.'</strong></font>&nbsp;'.__('user(s)','re'); ?>&nbsp;)</li>
							</ul>
							<ul>
								 <li><?php _e('Total Published Products', 're'); ?>: <a style="font-size:13px;" href="admin.php?page=review-engine-list-products"><strong><?php echo $count_total_published_product + $count_total_pending_product; ?></strong></a>&nbsp;<?php echo '(&nbsp;<font color="#21759B"><strong>'.$count_total_published_product.'</strong></font>&nbsp;'.__('published and','re').'&nbsp;<font color="#21759B"><strong>'.$count_total_pending_product.'</strong></font>&nbsp;'.__('pending','re'); ?>&nbsp;)</li>
							</ul>                        
							<ul>
								 <li><?php _e('Total Published Articles', 're'); ?>: <a style="font-size:13px;" href="admin.php?page=review-engine-list-articles"><strong><?php echo $count_total_published_article  + $count_total_pending_article; ?></strong></a>&nbsp;<?php echo '(&nbsp;<font color="#21759B"><strong>'.$count_total_published_article.'</strong></font>&nbsp;'.__('published and','re').'&nbsp;<font color="#21759B"><strong>'.$count_total_pending_article.'</strong></font>&nbsp;'.__('pending','re'); ?>&nbsp;)</li>
							</ul>  
							<ul>
								 <li><?php _e("Total Published Product's Reviews", 're'); ?>: <a  style="font-size:13px;" href="admin.php?page=review-engine-list-reviews"><strong><?php echo $count_total_published_editor_review + $count_total_published_user_review; ?></strong></a>&nbsp;<?php echo '(&nbsp;<font color="#21759B"><strong>'.$count_total_published_editor_review.'</strong></font>&nbsp;'.__("reviewer's review(s) and",'re').'&nbsp;<font color="#21759B"><strong>'.$count_total_published_user_review.'</strong></font>&nbsp;'.__("user's review(s)",'re'); ?>&nbsp;)</li>
							</ul>
							<ul>
								 <li><?php _e('Total Suggestions', 're'); ?>: <a style="font-size:13px;" href="admin.php?page=review-engine-list-suggestions"><strong><?php echo $count_total_suggestion; ?></strong></a> </li>
							</ul> 
							<ul>
								 <li><?php _e('Product Support', 're'); ?>: <a style="font-size:13px;" href="http://www.dailywp.com/support/" target="_blank"><?php _e('Technical','re');?></a></li>
							</ul>
					  </div>
				 </div>
			</div> <!-- postbox end -->
			<?php		
			$reviews = tgt_lr_get_reviews();
			?>	 				
							
			<table cellspacing="0" class="widefat post fixed"> <!-- list table -->
				<thead> <!-- table header -->
					<tr>						
						<th style="width:30%"  class="manage-column column-author" id="author" scope="col"><?php _e( 'Pending Review(s)', 're' );?></th>
						<th style="width:20%" class="manage-column column-author" id="email" scope="col"><?php _e( 'Author', 're' );?></th>
						<th style="width:35%" class="manage-column column-reivew" id="review" scope="col"><?php _e( 'Review Content', 're' );?></th>
						<th style="width:15%" class="manage-column column-date" id="date" scope="col"></th>
					</tr>
				</thead> <!-- //table header -->
				
				<tfoot> <!-- table footer -->
					<tr>
						 <th colspan="4"> <a class="button" href="admin.php?page=review-engine-list-reviews"> <?php _e('See All', 're') ?></a> </th>					
					</tr>
				</tfoot> <!-- //table footer -->
				<tbody> <!-- table body -->
				<?php
				if( ! empty( $reviews ) ) {				
					foreach( $reviews as $review ) {
						$reviewStatus = wp_get_comment_status( $review->comment_ID );
						if( $reviewStatus == 'unapproved' ) {
							$reviewStatus = __('Pending','re');
						}
						$comment_meta = get_comment_meta( $review->comment_ID , "tgt_review_data" );
				?>
					<form method="post" name="list_suggest_form" target="_self">
					<input type="hidden" name="review_id" value="<?php echo $review->comment_ID; ?>"/>
					<tr style="background-color:#FFFFE0;">
						<td class="column-author">
							<?php _e( 'Product', 're' );?>:"<a href="admin.php?page=review-engine-add_product&amp;p=<?php echo $review->comment_post_ID;?>"><strong><?php echo $review->post_title; ?></strong></a>"															
						</td>
						<td class="column-author">						
							<strong><?php echo $review->comment_author; ?></strong><br/>
							<?php _e('Review date:','re'); ?>&nbsp;<?php echo date( 'M d, Y', strtotime( $review->comment_date ) ); ?>
						</td>					
						<td class="column-bottom-line review-list">
							<h3 class="title-review">
								"<?php echo $comment_meta[0]['title']; ?>"
								<a class="row-actions" onclick="return confirm_delete();" href="admin.php?page=review-engine-list-reviews&amp;id=<?php echo $review->comment_ID;?>&amp;action=edit">-&nbsp;<?php _e('Edit','re'); ?></a>
							</h3>
							<a id="link_more_quick_<?php echo $review->comment_ID; ?>" onclick="show_all('<?php echo $review->comment_ID; ?>'); return false;" href="#" class="row-title"><strong><?php _e('Show all','re'); ?>&nbsp;&raquo;</strong></a>
							<div id="show_all_quick_review_<?php echo $review->comment_ID;?>" style="display:none;">
									<div class="review-into">
											<h3 class="title"> <?php _e('The good', 're') ?> </h3>
											<p>
													<?php echo $comment_meta[0]['pro']; ?>
											</p>
											
									</div>
									<div class="review-desc">
											<h3> <?php _e('The bad ', 're') ?> </h3>
											<p>
													<?php echo $comment_meta[0]['con']; ?>
											</p>
									</div>
									<div class="review-desc">
											<h3> <?php _e('Bottom line', 're') ?> </h3>
											<p>
													<?php echo $review->comment_content; ?>
											</p>
									</div>
									<div class="review-desc">
											<h3> <?php _e('Review', 're') ?> </h3>
											<p>
													<?php echo $comment_meta[0]['review']; ?>
											</p>
									</div>
									<a id="link_hide_quick" onclick="hide_all('<?php echo $review->comment_ID; ?>');return false;" href="#" class="row-title"><strong><?php _e('Hide','re'); ?>&nbsp;&laquo;</strong></a>
							</div>	
						</td>
							
						<td class="date column-date">
							<abbr><input class="button" type="submit" name="quick_approve" value="<?php _e('Approve','re'); ?>"/></abbr>
						</td>	
					</tr>
					</form> <!-- //form -->
				<?php
					}
				}
				?>
				</tbody> <!-- //table body -->
			</table> <!-- //list table -->
			
			<div class="tablenav" style="height:13px;"> 
		
			</div>		
			
			<div class="postbox">
					<div class="newspaperico"></div><a target="_new" href="<?php echo $tgt_rss_feed ?>"><div class="rssico"></div></a>
					<h3 class="hndle" id="poststuff"><span><?php _e('Latest news from dailywp.com community', 're') ?></span></h3>
					<div class="preloader-container">
					   <div class="insider" id="boxy">
							<iframe src="http://www.dailywp.com/community/?action=recent-news&pid=8" width="100%" height="360">
									<p><?php _e('Your browser does not support iframes.','re'); ?></p>
							</iframe>
					   </div> <!-- inside end -->
					</div>
			</div> <!-- postbox end -->
			
		</div> <!-- dash-left end -->	
	</div>
	
	<!--- COLUMN 2 --->
	<div class="dashboard-col-left dashboard-column">
		<div class="dash-left metabox-holder">
			<!--- RECENT PRODUCT  --->
			<div class="postbox">
				<div class="statsico"></div>
				<h3 class="hndle re-dashboard-title">
					<a href="#recent_products_list" class="selected toggle-products" id="recent_products"><?php _e('Recent Products','re') ?></a> |
					<a href="#top_products_list" class="toggle-products" id="top_products"><?php _e('Top Rated Products','re') ?></a>
				</h3>
				<div class="preloader-container" id="products_list">
					<table id="recent_products_list" cellspacing="0" class="widefat post fixed products-list"> <!-- list table -->
						<thead> <!-- table header -->
							<tr>						
								<th style="width:30%"  class="manage-column column-author" id="author" scope="col"><?php _e( 'Title', 're' );?></th>
								<th style="width:20%" class="manage-column column-author" id="email" scope="col"><?php _e( 'Categories', 're' );?></th>
								<th style="width:30%" class="manage-column column-author" id="author" scope="col"><?php _e( 'Tags', 're' );?></th>
								<th style="width:20%" class="manage-column column-date" id="author" scope="col"><?php _e( 'Date', 're' );?></th>
							</tr>
						</thead> <!-- //table header -->
						
						<tfoot> <!-- table footer -->
							<tr>
								 <th colspan="4"> <a class="button" href="edit.php?post_type=product"> <?php _e('See All', 're') ?></a> </th>					
							</tr>
						</tfoot> <!-- //table footer -->
						<tbody> <!-- table body -->
						<?php
						$recent_products = query_posts(array('post_type' => 'product',
															 'posts_per_page' => 10,
															 'post_status' => 'publish',
															 'order' => 'DESC',
															 'orderby' => 'date'));
						if(!empty($recent_products))
						{
							foreach($recent_products as $k => $v)
							{
								$categories = '';
								$tags = '';
								$categories = get_the_category($v->ID);
								$tags = get_the_tags($v->ID);														
						?>
							<tr style="background-color:#FFFFE0;" id="recent_products">
								<td class="column-author">
									<strong><?php echo $v->post_title; ?></strong>
									<div class="star">
									<?php
									$rating = get_post_meta ( $v->ID ,'tgt_rating',true);
									//echo $rating;
									tgt_display_rating( $rating, 'recent_rating_'.$v->ID, true, 'star-disabled' );							
									?>
									</div>
								</td>
													
								<td class="column-author">
									<?php if(!empty($categories[0]) && isset($categories[0])) echo $categories[0]->name; ?>
								</td>
								<td class="column-author">	
									<?php
									if(!empty($tags))
									{
										$tags_name = '';
										foreach($tags as $k_tags => $v_tags)
										{
											$tags_name .= $v_tags->name.',';
										}
										echo trim($tags_name,',');
									}else
										echo __('No Tags','re');
									?>
								</td>	
								<td class="column-author">	
									<?php echo date( get_option('date_format'), strtotime( $v->post_date ) ); ?>
								</td>
							</tr>
						<?php
							}
						}
						?>
						</tbody> <!-- //table body -->
					</table> <!-- //list table -->
					<table id="top_products_list" cellspacing="0" class="widefat post fixed products-list" style="display:none;"> <!-- list Top Product -->
						<thead> <!-- table header -->
							<tr>						
								<th style="width:30%"  class="manage-column column-author" id="author" scope="col"><?php _e( 'Title', 're' );?></th>
								<th style="width:20%" class="manage-column column-author" id="email" scope="col"><?php _e( 'Categories', 're' );?></th>
								<th style="width:30%" class="manage-column column-author" id="author" scope="col"><?php _e( 'Tags', 're' );?></th>
								<th style="width:20%" class="manage-column column-date" id="author" scope="col"><?php _e( 'Date', 're' );?></th>
							</tr>
						</thead> <!-- //table header -->
						
						<tfoot> <!-- table footer -->
							<tr>
								 <th colspan="4"> <a class="button" href="admin.php?page=review-engine-top-product"> <?php _e('See All', 're') ?></a> </th>					
							</tr>
						</tfoot> <!-- //table footer -->
						<tbody> <!-- table body -->
						<?php
						//$top_products = init_top_product();
						$custom_query = 'top-product';
						$top_products = query_posts(array(	'post_type' => 'product',
															'post_status' => 'publish',
															'posts_per_page' => 10,
															'meta_key' => 'tgt_rating',
															'orderby' => 'meta_value',
															'order' => 'DESC'));
						$custom_query = '';
						
						if(!empty($top_products))
						{						
							foreach($top_products as $k => $v)
							{
								$categories = '';
								$tags = '';
								$categories = get_the_category($v->ID);
								$tags = get_the_tags($v->ID);
						?>
							<tr style="background-color:#FFFFE0;">
								<td class="column-author">
									<strong><?php echo $v->post_title; ?></strong>
									<div class="star">
									<?php
									$rating = get_post_meta ( $v->ID ,'tgt_rating',true);
									//echo $rating;
									tgt_display_rating( $rating, 'top_rating_'.$v->ID, true, 'star-disabled' );							
									?>
									</div>
								</td>
													
								<td class="column-author">
									<?php if(!empty($categories[0]) && isset($categories[0])) echo $categories[0]->name; ?>
								</td>
								<td class="column-author">	
									<?php
									if(!empty($tags))
									{
										$tags_name = '';
										foreach($tags as $k_tags => $v_tags)
										{
											$tags_name .= $v_tags->name.',';
										}
										echo trim($tags_name,',');
									}else
										echo __('No Tags','re');
									?>
								</td>	
								<td class="column-author">	
									<?php echo date( get_option('date_format'), strtotime( $v->post_date ) ); ?>
								</td>
							</tr>
						<?php
							}						
						}
						?>
						</tbody> <!-- //table body -->
					</table> <!-- //list table -->					
				</div>
			</div>
			<!--- RECENT ARTICLE --->
			<div class="postbox">
				<div class="statsico"></div>
				<h3 class="hndle"><span><?php _e('Recent Articles','re') ?></span></h3>
				<div class="preloader-container">
					<table id="recent_products_list" cellspacing="0" class="widefat post fixed products-list"> <!-- list table -->
						<thead> <!-- table header -->
							<tr>						
								<th style="width:30%"  class="manage-column column-author" id="author" scope="col"><?php _e( 'Title', 're' );?></th>
								<th style="width:20%" class="manage-column column-author" id="email" scope="col"><?php _e( 'Categories', 're' );?></th>
								<th style="width:30%" class="manage-column column-author" id="author" scope="col"><?php _e( 'Product', 're' );?></th>
								<th style="width:20%" class="manage-column column-date" id="author" scope="col"><?php _e( 'Date', 're' );?></th>
							</tr>
						</thead> <!-- //table header -->
						
						<tfoot> <!-- table footer -->
							<tr>
								 <th colspan="4"> <a class="button" href="edit.php?post_type=article"> <?php _e('See All', 're') ?></a> </th>					
							</tr>
						</tfoot> <!-- //table footer -->
						<tbody> <!-- table body -->
						<?php
						$recent_articles = query_posts(array('post_type' => 'article',
															 'posts_per_page' => 10,
															 'post_status' => 'publish',
															 'order' => 'DESC',
															 'orderby' => 'date'));
						if(!empty($recent_articles))
						{
							foreach($recent_articles as $k => $v)
							{
								$categories = '';
								$tags = '';
								$categories = get_the_category($v->ID);
								$tags = get_the_tags($v->ID);														
						?>
							<tr style="background-color:#FFFFE0;" id="recent_products">
								<td class="column-author">
									<strong><?php echo $v->post_title; ?></strong>									
								</td>
													
								<td class="column-author">
									<?php if(!empty($categories[0]) && isset($categories[0])) echo $categories[0]->name; ?>
								</td>
								<td class="column-author">	
									<?php
									if(get_post_meta($v->ID,'tgt_product_id',true) == ''){
										echo __('Empty','re');
									}else{
										$product_ID = get_post_meta($v->ID, 'tgt_product_id', true);
										if ( ! empty ( $product_ID ) ){					
											echo get_post_field('post_title', $product_ID);					
										}										
									}
									?>
								</td>	
								<td class="column-author">	
									<?php echo date( get_option('date_format'), strtotime( $v->post_date ) ); ?>
								</td>
							</tr>
						<?php
							}
						}
						?>
						</tbody> <!-- //table body -->
					</table> <!-- //list table -->
				</div>
			</div>
			<div class="postbox">
				<div class="newspaperico"></div><a target="_new" href="<?php echo $tgt_rss_feed ?>"><div class="rssico"></div></a>
				<h3 class="hndle" id="poststuff"><span><?php _e('Latest News', 'cp') ?></span></h3>
			 <div class="preloader-container">
			<div class="insider" id="boxy">
				<?php 
				wp_widget_rss_output($tgt_rss_feed, array('items' => 5, 'show_author' => 0, 'show_date' => 1, 'show_summary' => 1)); 
				?>
			</div> <!-- inside end -->
			 </div>
			</div> <!-- postbox end -->
		</div>
	</div>
	<div class="clear"></div>
</div> <!-- /wrap -->
<script type="text/javascript">

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
jQuery(document).ready(function(){
	jQuery('.toggle-products').each(function(){
		var current = jQuery(this);
			container = jQuery('#products_list');
		
		current.click(function(){
			var target = jQuery(this).attr('href');
				lists = container.find('.products-list');
			lists.hide();
			jQuery(target).show();
			jQuery('.toggle-products').removeClass('selected');
			jQuery(this).addClass('selected');		
			return false;
		});	
	});
	jQuery('.star-disabled').rating();
});
</script>