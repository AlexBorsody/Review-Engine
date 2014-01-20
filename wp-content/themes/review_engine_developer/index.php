<?php
global $helper,$wp_query,$posts, $post, $sorting_pages, $current_custom_page;
get_header();
?>
	<!-- Body start here -->	 
	<div id="container">
		<div class="container_res">
			<div class="container_main">				
				<div class="col_right">
					 <!-- Notification Sidebar -->
						  <?php
						  if ( is_active_sidebar( 'homepage-widget-area' ) ) {
							  dynamic_sidebar( 'homepage-widget-area' );
						  }
						  ?> 
					 <!-- End Notification Sidebar -->					
					 <?php
					 
					$top_products = query_top_products();	
					if ( !empty( $top_products ) ) { ?>
					<div class="col">
						  <div class="section-title">
								<h1 class="blue2"><?php _e('Top products','re'); ?></h1>
						  </div>
							<?php
								$i = 0;
								foreach( $top_products as $post ) {
									 the_post( $post );
									 $post_id = $post->ID;
									 $image_thumb = get_post_meta ( $post->ID ,'tgt_product_images',true);
							?> 
						<div class="col_box">
							<?php if($i == 0) { ?>
								<div class="vote">
									<p><?php echo $i+1; ?></p>  
								</div>
							<?php } else { ?>
								<div class="vote" style="background:url('<?php echo TEMPLATE_URL; ?>/images/icon_vote2.png') no-repeat scroll center center transparent;">                        
									<p><?php echo $i+1; ?></p>  
								</div>
							<?php } ?>
							<div class="avatar">
								<?php
								if( has_post_thumbnail ($post_id) ){
									 $thumb_url =  wp_get_attachment_image_src( get_post_thumbnail_id($post_id), array( 104, 84) );
									 echo '<div class="index-thumb">';								  
									 echo wp_get_attachment_image( get_post_thumbnail_id($post_id), array( 104, 84) );				  
									 echo '</div>';
								} else {
									echo '<img src="'.TEMPLATE_URL.'/images/no_image.jpg" style="width:104px;height:84px;" alt=""/>';
								} ?> 								
								<div class="vote_star" style="text-align: center">	
									<div class="star" style="">
									<?php
									$rating = get_post_meta ( $post->ID , get_showing_rating(),true);
									tgt_display_rating( $rating, 'top_rating_'.$post->ID, true, 'star-disabled' );
									?>	
									</div>
										
									
								</div>
								<div class="clear"></div>
								
								<p>
									<a href="<?php echo get_permalink ( $post->ID); ?>">
										<?php echo tgt_comment_count( 'No Review', '%d Review', '%d Reviews', $post->comment_count); ?>
									</a>
								</p>
							</div>
							
							<div class="text">
								<div class="title">
									<div class="title_left">
										<h1><a href="<?php echo get_permalink ( $post->ID); ?>">
										<?php
									  	$the_post = get_post( $post->ID , ARRAY_A);
									  	$title = $post->post_title;
									  	$content = $post->post_content;
									  	if(strlen($title) > 32) {
										  	echo substr($title,0,31).'...'; 
										}else{
											echo $title;
										}
										?>										
										</a></h1>
										<p>
										<?php
										//list tags					
										$tags = get_the_tags();
										$tag_link_arr = array();
										if($tags != '') {
											foreach($tags as $tags_item)	
											$tag_link_arr[] = '<a href="'.get_tag_link($tags_item->term_id).'">'.$tags_item->name.'</a>';
										} else {
											$tag_link_arr[] = __('No tags','re');												
										}
										echo '<span class="tag-list">';
										echo implode(',',$tag_link_arr);
										echo '</span>';
										?>										
										</p>
									</div>                                    
									
								</div>
								
								<div class="content_text">
									<p><?php echo tgt_limit_content($content, 34); ?> <a href="<?php echo get_permalink($post_id); ?>"><?php _e('more','re'); ?>&nbsp;&raquo;</a></p>
									
									<div class="box_butt" style="float:left; margin-top:15px;">
									<?php
													 $product_website = '#';
													 if(get_post_meta($post_id,'tgt_product_url',true) != '') {
														 $product_website =  tgt_get_the_product_link($post_id);
													 ?>	
										<p class="blue">
														  <a href="<?php echo esc_url_raw($product_website); ?>"  target="_blank"><?php _e('Visit Website','re'); ?></a>
													 </p>
													 <?php } ?>
									</div>
								</div>
							</div>
						</div> 
						<?php $i++;
						} ?>
					</div>	
					<?php } ?>                                          
					<div class="clear"></div>
					<?php
						/**
						**James: Get Latest Products
						*/
						global $wp_query;
						wp_reset_query();
					?>
					<?php                     
					if ( have_posts() ) 
						  {
								/**
								 * get default widget
								 */
								$default_sort = get_option(SETTING_SORTING_DEFAULT) ? get_option(SETTING_SORTING_DEFAULT) : __('recent-products', 're');
								$sort_type = !empty( $_GET['sort_type'] ) ? $_GET['sort_type'] : $default_sort;
								$sort_lists = get_option( SETTING_SORTING_TYPES );
						  ?>
					<div class="col">
						<div class="section-title" style="">
								<?php if ( !empty( $sort_lists) )  {?>
									 <div class="sort-area" style="float: right">
										  <span class="label"><?php _e('View products by', 're') ?>:</span>
										  <div class="sorting-wrapper">
												 <div class="sorting">
														<form id="sorting_form" action="<?php bloginfo('wpurl') ?>" method='GET'>
																<select name="sort_type">
																		  <?php foreach( $sort_lists as $id => $type ) {
																				  $selected = $sort_type == $type ? 'selected="selected"' : '';
																				  ?>
																		  <option value="<?php echo $type ?>" <?php echo $selected ?>><?php echo $sorting_pages[$type]['name'] ?></option>
																		  <?php } ?>
																</select>
														</form>
												 </div>
										  </div>
									 </div>
								<?php } ?>
						<h1 class="blue2"><?php echo $sorting_pages[$sort_type]['name'] ?></h1>								
						</div>
						<?php
								while(have_posts()) {
								the_post(); 
								$post_id = get_the_ID();			
						?> 					
						<div class="col_box">
							<div class="box_border">  
								<div class="col_box2">
									<div class="vote" style="background:none; width:27px;"></div>                                    
									<div class="avatar">
										<?php
													 if( has_post_thumbnail() ){
														  echo '<div class="index-thumb">';
														  echo wp_get_attachment_image( get_post_thumbnail_id(), array(104, 84) );
														  //tgt_the_product_thumb(URL_UPLOAD.'/'.$image_thumb[0]['thumb'],104,84);											
														  echo '</div>';
													 }
													 else
													 {
														  echo '<a href="'.get_permalink($post_id).'">';
														  echo '<img src="'.TEMPLATE_URL.'/images/no_image.jpg" style="width:104px;height:84px;" alt=""/>';
														  echo '</a>';	
													 }
													 ?> 
													 <div class="vote_star">
														  <div class="star" style="">
																<?php
																//$rating = get_post_meta($post_id, 'tgt_rating', true);
																$rating = get_post_meta($post_id, get_showing_rating(), true);
																tgt_display_rating( $rating, 'recent_rating_'.$post_id);
																?>
														  </div>	
													 </div>
													 <div class="clear"></div>                                        
													 <p><a href="<?php echo get_permalink($post_id); ?>"> <?php echo tgt_comment_count( 'No Revew', '%d Review', '%d Reviews', $post->comment_count); ?> </a></p>
									</div>
									
									<div class="text">
										<div class="title">
											<div class="title_left">
												<h1><a href="<?php echo get_permalink($post_id); ?>">
												<?php						
												if(strlen($post->post_title) > 32)
												{
													echo substr($post->post_title,0,31).'...';
												}else
													echo $post->post_title;
												?>													
												</a></h1>
												<p>
												<?php
												//list tags					
													 $tags = get_the_tags();
													 $tag_link_arr = array();
													 if($tags != '')
													 {
														  foreach($tags as $tags_item)	
																$tag_link_arr[] = '<a href="'.get_tag_link($tags_item->term_id).'">'.$tags_item->name.'</a>';
													 }
													 else
													 {
														  $tag_link_arr[] = __('No tags','re');
													 }
													 echo '<span class="tag-list">';
													 echo implode(',',$tag_link_arr);
													 echo '</span>';
												?>
												</p>
											</div> 
										</div>
										
										<div class="content_text">
											<p><?php echo tgt_limit_content(get_the_content(), 34); ?> <a href="<?php echo get_permalink($post_id); ?>"><?php _e('more','re'); ?>&nbsp;&raquo;</a></p>
											
											<div class="box_butt" style="float:left; margin-top:15px;">
												<?php
																	 $product_website = '#';
																	 if(get_post_meta($post_id,'tgt_product_url',true) != '') {
																		 $product_website = $product_website =  tgt_get_the_product_link($post_id);
																	 ?>
																	 <p class="blue">
																		  <a href="<?php echo esc_url_raw($product_website); ?>"  target="_blank"><?php _e('Visit Website','re'); ?></a>
																	 </p>	 
																<?php } ?>
											</div>
										</div>
									</div>
								</div>
							 </div>                             
							 
						  </div>
						 <?php
							}
						?>
					</div>                   
					<?php
					}else
			echo '<font color="#FF0000" style="font-style:italic">'.__('No Result Found Here !','re').'</font>';
			?>       
				</div>
					<!-- SIDEBAR GOES HERE -->
					<?php
						get_sidebar();
					?>					
					<!-- SIDEBAR END HERE -->
				<div class="clear"></div>
			</div>
		</div>
	</div>
	
	<!--body end here-->
<script type="text/javascript">
jQuery(document).ready(function(){
	 jQuery('.star-disabled').rating();
	 jQuery('.rating input[type=radio]').rating();
	 jQuery('#sorting_form').each(function(){
		  var current = jQuery(this),
				select = current.find('select[name=sort_type]');
		  select.change(function(){
				current.submit();
		  });
	 });
});
</script>
<?php
	get_footer();
?>