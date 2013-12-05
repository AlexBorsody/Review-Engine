<?php
global $helper,$wp_query,$posts,$cat, $sorting_pages, $wp_rewrite;
$curr_category 		= get_query_var('cat');
$cat_link 				= get_category_link( $curr_category );
$default_sort 			= get_option(SETTING_SORTING_DEFAULT) ? get_option(SETTING_SORTING_DEFAULT) : 'recent-products';
$sort_type 				= !empty( $_GET['sort_type'] ) ? $_GET['sort_type'] : $default_sort;								
$sort_lists 			= get_option( SETTING_SORTING_TYPES );
$filter 					= empty( $_GET['filter'] ) ? '' : $_GET['filter']; // filter value
$page 					= get_query_var('paged') ? get_query_var('paged' ) : get_query_var('page');
$offset 					= get_query_var('posts_per_page') ? get_query_var('posts_per_page') : 10 ;
$param_url 				= '';
$page 					= $page ? $page : 1;
$filters 				= array();

/**
 * Filter form
 */
if ( !empty($_POST ) && !empty($_POST['filter_value']) ){
	$fvalues = array();
	foreach( $_POST['filter_value'] as $group ){
		foreach( $group as $value ){
			$fvalues[] = $value;
		}
	}
	
	$link = add_query_arg( 'filter', implode(',', $fvalues ) );
	
	wp_redirect( $link );
}
if ( !empty($_GET['filter']) ){
	$filters = explode(',', $_GET['filter'] );
	//var_dump($filters);
}
/**
 *
 */
$param = array(
					'sort_type' => $sort_type,
					'filter' 	=> $filter
					);
if ( empty($_GET['filter'] ) )
	unset( $param['filter'] );
	
if ( empty($_GET['sort_type'] ) )
	unset( $param['sort_type'] );

if ( !empty($param) )
	$param_url = '?' . http_build_query( $param );

get_header();

/*
**James: Get all reviews by category
*/


$cate_obj  = get_category($cat,false);
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
				 /**
				  * List Filter
				  */
				 $groups = get_all_data_filter_by_cat_id_tgt($cat);			 
				 if (is_array($groups) && !empty ($groups) ){
				?>
			<div class="col">
				<div class="box_border" style="margin-bottom:20px; margin-top:0;">
					<div class="col_box4" id="filter_product">
					 <form id="filter_form" action="" method="post" >
					 	<?php if( $wp_rewrite->using_permalinks() != 1 ) {?>
						<input type="hidden" name="cat" value="<?php echo $curr_category;?>"/>
						<?php } ?>
						<div style="width: 690px;margin-bottom: 50px" class="title_left">
						 	<h1 style="float:left;"><?php _e('Find a product:','re') ?>
							<?php
								$param = array(
												'sort_type' => $sort_type,
												'filter' 	=> $filter
												);
								/*if( isset ($_GET['filter']) && $filter != '' ) {
									echo '('. get_filter_name($groups, $_GET['filter']) .')';
									// display clear filter link if has filter
									unset( $param['filter'] );
									$url = http_build_query( $param );
									?>
									<a class="clear-filter" href="<?php echo $cat_link . '/?' . $url ?>">
										<img src="<?php echo TEMPLATE_URL?>/images/delete.png" alt="Clear Filter" title="<?php _e('Clear Filter','re') ?>" />
									</a>
							<?php }*/ ?>
							</h1> 
						</div>
						<div class="clear"></div>
						
						<div id="filter_wrapper" style="overflow: hidden; width: 688px; position: relative; height: 230px;">
							<a href="#next" id="filter-next" class="filter-next" style="position: absolute; top: 80px;right: 0px; z-index: 9">
								<?php echo $helper->image('arrow_right1.png','>') ?>
							</a>
							<a href="#previous" id="filter-prev" class="filter-next" style="position: absolute; top: 80px;left: 0px; z-index: 9">
								<?php echo $helper->image('arrow_left1.png','>') ?>
							</a>
							<div id="filter_page_1" style="width: 688px; position: absolute;" >
							
							<?php
								$count = 0;
								foreach($groups as $group ){
									$count ++;
								 ?>
								<div class="find find-list" >
									<h3 style="margin-top: -5px;"><?php echo $group['group_name']  ?></h3>
									<div class="scrollbar_cat">
									  <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
										<div class="viewport">
											<div class="overview">
											<ul >
											<?php
											$filter_count = 0;
											foreach( (array)$group['value'] as $value  ) {
												$filter_count++;
												// generate catgory filter link
												$param['filter'] = $value['filter_value_id'];
												$url = http_build_query( $param );
											?>
												<li>
													<input type="checkbox" name="filter_value[<?php echo $group['filter_id'] ?>][]" value="<?php echo $value['filter_value_id']?>"
													<?php
														if ( in_array( $value['filter_value_id'], (array) $filters ) ){
															echo 'checked="checked"';
														}
														//if(isset( $filters ) ) {
														//	foreach ( $filters as $value ) {
														//		if( $value['filter_value_id'] == stripcslashes($value) ) {
														//			echo 'checked="checked"';
														//		}
														//	}
														//}else{
														//	//echo 'checked="checked"';
														//}
													?> />
													<label for="">
														<?php echo $value['value_name']?>
													</label>
												</li>
											<?php
											} // end foreach foreach( (array)$group['values'] as $value  ) 
											?> 
										</ul>
										</div>
										</div>
									</div>		
									</div>
								<?php
								} ?>
								<input type="submit" style="margin-top: 40px;" value="<?php _e('Go', 're') ?> &raquo;">
							</div>
							<div class="clear"></div>
						</div> <!--end #filter_wrapper-->
						</form>
					</div> <!--end .col_box4-->
				</div> <!--end .box_border-->
			</div> <!--end .col-->
			
			<?php
			}	
			if ( have_posts() ) 
			{
			?>			 
			<?php
			/**
			 * list product
			 */
			?>
			<form id="category_sort_form" action="<?php get_term_link( $cat ) ?>" method="get">
				<input type="hidden" name="sort_type" value="<?php echo $sort_type ?>" />
				<input type="hidden" name="filter" value="<?php echo $filter ?>" />
				<?php
				if ( !$wp_rewrite->using_permalinks() ){
					echo '<input type="hidden" name="cat" value="' . $cat . '" />';
				}
				?>
			</form>
			<form action="<?php echo tgt_get_permalink('compare'); ?>" method="post" name="frmCompare" id="frmCompare">
			<input type="hidden" value="<?php echo $cat; ?>" name="cate[id]" />
			<input type="hidden" value="<?php echo $cate_obj->name; ?>" name="cate[name]" />
			<div class="col_box" style="border-bottom: 4px solid rgb(236, 238, 239);">			
				<h1 class="blue2 category-title">
				  <?php echo $cate_obj->name; ?>
				  <?php  if(get_option(SETTING_FEED_LINK_CATEGORY)==1) { ?>
				  <a href="<?php echo get_category_feed_link( $cat, 'rss2' ) ?>">
					  <img src="<?php echo TEMPLATE_URL ?>/images/feed_blue.png" width="20" height="20" alt="Feed" title="<?php _e('Feed this category','re') ?>" />
				  </a>
				  <?php } ?>
				</h1>			
				<div class="box_butt">
					 <p class="orange"><a href="#" onclick="submit_compare();return false;"><?php _e('Compare Items','re'); ?></a></p>
				</div>
                            
            <div class="box_select" style="width:auto; background:none; text-align:right; float:right; margin-right:20px;">
            <img style="float:right; margin:5px 0 0 10px;" src="<?php echo TEMPLATE_URL; ?>/images/icon_question.png" alt="" title="Select products below to compare"/><p style="float:right;"><?php _e('You checked','re'); ?>&nbsp;<strong style="color:#f65c00;"><label id="show_count">0</label>&nbsp;<?php _e('item(s)','re'); ?></strong>&nbsp;<?php _e(' to be compared','re'); ?></p>
				<input type="hidden" value="0" id="default_count" />
			    </div> 
		    </div>
			 <?php
				if ( !empty( $sort_lists) )   {?>
					<div class="sort-area" style="float: right">
						<span class="label"><?php _e('View products by') ?>:</span>
						<div class="sorting-wrapper">
							<div class="sorting">
								<!--<form id="sorting_form" action="<?php bloginfo('wpurl') ?>" method='GET'>-->
									<select id="cat_sort_type" name="cat_sort_type">
										<?php foreach( $sort_lists as $id => $type ) {
											$selected = $sort_type == $type ? 'selected="selected"' : '';
											?>
										<option value="<?php echo $type ?>" <?php echo $selected ?>><?php echo $sorting_pages[$type]['name'] ?></option>
										<?php } ?>
									</select>
								<!--</form>-->
							</div>
						</div>
					</div>
				<?php } ?>
			<?php
				$index = 1 + ( $page - 1) * $offset;
				while(have_posts())
				{
					the_post();
			?>
			<div class="col_box">
            <div class="box_border">
					<div class="col_box2">
						<div class="vote" style="background:none; width:27px;"></div>                                    
						<div class="avatar">
							<?php
							//$image_thumb = get_post_meta($post->ID,'tgt_product_images',true);
							if( has_post_thumbnail( $post->ID ) ){
								//$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) , array( 104, 84) );
								echo '<div class="index-thumb">';
								//tgt_the_product_thumb( $thumb_url[0] , 104 , 84);
								echo wp_get_attachment_image( get_post_thumbnail_id( $post->ID ) , array( 104, 84) , false, array( 'alt' =>  $post->post_title ) );
								echo '</div>';
							}
							else
								echo '<img src="'.TEMPLATE_URL.'/images/no_image.jpg" style="width:104px;height:84px;" alt=""/>';
							?> 
							<div class="vote_star">
								<div class="star" style="">
								<?php
								$rating = get_post_meta($post->ID, get_showing_rating() ,true);
								tgt_display_rating( $rating, 'recent_rating_'.$post->ID);
								?>
								</div>	
							</div>
							<div class="clear"></div>                                        
							<p><a href="<?php the_permalink($post->ID); ?>"><?php echo tgt_comment_count( 'No Revew', '%d Review', '%d Reviews', $post->comment_count); ?></a></p>
						</div>
						<div class="text" >
							<div class="title" >
								<div class="title_left">
									<h1><a href="<?php the_permalink(); ?>">
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
										$tag_link_arr[] = __('No Tags', 're');
									echo '<span class="tag-list">';
									echo implode(', ',$tag_link_arr);
									echo '</span>';
									?>
									</p>
								</div>
				
								<div class="title_right">
									<label><?php _e('compare this','re'); ?></label>
									
									<div class="check"><input type="checkbox" style="float:left; margin:0; padding:0; border:3px #fff04d solid; " value="<?php echo $post->ID; ?>" onclick="count_compare(this);" id="pro_id[]" name="pro_id[]" /></div>
								</div> 
							</div>
							
							<div class="content_text">
								<p><?php echo tgt_limit_content(get_the_content(), 34); ?> <a href="<?php the_permalink(); ?>"><?php _e('more','re'); ?>&nbsp;&raquo;</a></p>
								<div class="box_butt" style="float:left; margin-top:15px;">
									<?php
									$product_website = '#';
									if(get_post_meta($post->ID,'tgt_product_url',true) != '')
										$product_website = $product_website =  tgt_get_the_product_link($post->ID);
									?>
									<p class="blue"><a href="<?php echo esc_url_raw($product_website); ?>"  target="_blank"><?php _e('Visit Website','re'); ?></a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- number -->
				<div class="box_border2">
					<p><?php echo $index; $index++; ?></p>
				</div>
			</div>
			<?php
				}
			?>
			</form>
			<!--Pagination-->
			<div class="col_box">
				<?php 
				if ( $wp_query->max_num_pages > 1 ) {
				?>
				<div class="pagination">
					<b class="paginate_title">  <?php _e('Pages') ?> :</b>
					<?php
						//echo paginate_links( get_pagination_args() );$cat_link
						global $wp_rewrite;
						$pagination = get_pagination_args();
						if ( $wp_rewrite->using_permalinks() )
							$pagination['base'] =  $cat_link . '/page/%#%/' . $param_url ;
						tgt_the_pagination_links( $pagination );
					?>	
				</div>
				<?php } ?>
			</div>                       
			<?php
			}else { ?>
				<div class="section-title">			
				  <h1><?php echo $cate_obj->name; ?></h1>
            </div>
				<!--<p style="font-style:italic; padding: 10px 20px; color: #ED4444 "> <?php _e('There is no available product','re') ?>  </p>-->
				<p class="red" style="padding: 10px 20px;  ">
				  <?php _e("This category has no product yet", 're') ?>
				  <br />
				  <?php echo __("But you can suggest us to update products at ", 're') . $helper->link('here', tgt_get_permalink('product_suggest')) ?>
				</p>	
			 <?php 				
			}
			?>                       
                     
                </div>
				
					<!-- SIDEBAR GOES HERE -->
					<?php
						get_sidebar();
					?>					
					<!-- SIDEBAR END HERE -->
					
            </div>
        </div>
    </div>
    
    <!--body end here-->

<script type="text/javascript">
var total = 0;
var item = 0
var current = 0;
if (jQuery("#default_count").length > 0) {
  document.getElementById("show_count").innerHTML = document.getElementById("default_count").value;
}
function count_compare(str)
{
	total = document.getElementById("default_count").value;
	if(str.checked == true)
	{
		total ++;	
	}
	if(str.checked == false)
	{
		if(total>0)
			total --;
	}
	document.getElementById("default_count").value = total;
	document.getElementById("show_count").innerHTML = document.getElementById("default_count").value;
}
function submit_compare()
{	
	if(document.getElementById("default_count").value == 0)
		alert('<?php _e("Please select the items you want to compare!","re"); ?>');
	else if(document.getElementById("default_count").value == 1)
		alert('<?php _e("Please select two or more items you want to compare!","re"); ?>');
	else if(document.getElementById("default_count").value >= 2)
		document.frmCompare.submit();
}
	jQuery(document).ready(function(){
		initFilterNav('#filter_page_1');
		jQuery('#filter_page_1').css('width', jQuery('#filter_page_1 .find-list').length * 226);
		jQuery('#filter_page_2').css('width', jQuery('#filter_page_2 .find-list').length * 226);		
		
		jQuery('#filter-next').click(function(){
			if (current < item - 3 ){
				jQuery('#filter_page_1').animate({ left: "-=226" },'fast');
				jQuery('#filter-prev').show();
				current++;
				if (current >= item - 3 )
					jQuery('#filter-next').hide();
			}
			return false;
		});
		jQuery('#filter-prev').click(function(){
			if (current > 0){
				jQuery('#filter_page_1').animate({ left: "+=226" },'fast');
				jQuery('#filter-next').show();
				current--;
				if (current <= 0)
					jQuery('#filter-prev').hide();
			}
			
			return false;
		});
		
		jQuery('.filter-more-link').click(function(){
			jQuery('.find-more' ).hide().removeClass('selected');
			jQuery(jQuery(this).attr('href') ).show().addClass('selected');
			jQuery('#filter_page_1').hide();
			jQuery('#filter_page_2').show();		
			initFilterNav('#filter_page_2');
			return false;
		});
		jQuery('#filter_less').click(function(){
			jQuery('#filter_page_2').hide();
			jQuery('#filter_page_1').show();	
			initFilterNav('#filter_page_1');
			return false;	
		});
	});	
		
	function initFilterNav(divId){
		current = 0;
		if (divId == '#filter_page_1'){
			item = jQuery(divId +' .find-list').length;
			jQuery(divId).css('width', jQuery(divId + ' .find-list').length * 226);
		}
		else{
			item = jQuery(divId +' .selected .find').length;
			jQuery(divId).css('width', jQuery(divId + ' .find-more').length * 226);
		}
		
		jQuery(divId).css('left', '0');		
		jQuery('#filter-prev').hide();
		jQuery('#filter-next').show();
		if (item <= 3){			
			jQuery('#filter-next').hide();
		}
	}
	
jQuery(document).ready(function(){
	jQuery('.scrollbar_cat').tinyscrollbar();
	jQuery('.star-disabled').rating();	
});
</script>
<?php
	get_footer();
?>