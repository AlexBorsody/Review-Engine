<?php
global $helper,$wp_query,$posts,$cat, $post;

$params = $_GET;
foreach( $params as $key => $request )
{
	if ( empty($request) )
	{
		unset( $params[$key] );
	}
}
$param_url 	= '?' . http_build_query( $params );
$base 		= get_bloginfo('wpurl') . '/page/%#%';

get_header();	

/*
**James: Get all reviews by search key
*/

?>
	 
	 <!-- Body start here -->
	 
    <div id="container">
    	<div class="container_res">
        	<div class="container_main">
				<!-- side bar start here -->
				<!--sidebar end here-->    
				
                <div class="col_right">
			<?php
			 /**
			  * List Filter
			  */
			/*
			if(isset($_GET['get_topic'],$_GET['c']) && $_GET['get_topic'] != '' && $_GET['c'] != '')
			{
				//$groups = get_filter_groups($_GET['c']);
				$groups = get_all_data_filter_by_cat_id_tgt($_GET['c']);					
				$cat = $_GET['c'];
				if (!empty ($groups) ){
			?>
			<div class="col">
				<div class="box_border" style="margin-bottom:20px; margin-top:0;">
					<div class="col_box4" id="filter_product">
						<div style="width: 690px;margin-bottom: 50px" class="title_left">
							<h1 style="float:left;"><?php _e('Find a product:','re') ?>
							<?php
							  if( isset ($_GET['filter']) ) {
								 echo '('. get_filter_name($groups, $_GET['filter']) .')';
							  }
							?>
							</h1>
						</div>
						<div class="clear"></div>
						
						<div id="filter_wrapper" style="overflow: hidden; width: 688px; position: relative; height: 165px;">
							<a href="#next" id="filter-next" class="filter-next" style="position: absolute; top: 80px;right: 0px; z-index: 9">
								<?php echo $helper->image('arrow_right1.png','>') ?>
							</a>
							<a href="#previous" id="filter-prev" class="filter-next" style="position: absolute; top: 80px;left: 0px; z-index: 9">
								<?php echo $helper->image('arrow_left1.png','>') ?>
							</a>
							<div id="filter_page_1" style="width: 688px; position: absolute">
							<?php
								$count = 0;
								foreach($groups as $group ){
									$count ++;
								 ?>
									<div class="find find-list">
										<ul>
											 <li><strong> <?php echo $group['group_name']  ?></strong></li>
											<?php
											$filter_count = 0;
											foreach( (array)$group['value'] as $value  ) {
												$filter_count++;
												if ($filter_count >= 5 && count($group['value']) > 5)
													break;
											?>
												<li>
													<a href="<?php echo tgt_get_filter_url($cat, $value['filter_value_id'])  ?>"> <?php echo $value['value_name'] ?> </a>
												</li>
												<?php
											} // end foreach foreach( (array)$group['values'] as $value  ) 
											if ( is_array($group['value']) && count($group['value']) > 5 ){?>
												<li>
													<a href="#filter_group_<?php echo $group['filter_id'] ?>" class="filter-more-link" > <?php _e('More...','re')?> </a>
												</li>
											<?php
											}
											?> 
										</ul>
									</div>
								<?php
								} ?>
							</div>
							
							<div id="filter_page_2" style="width: 688px; display: none;" >
									<p style="margin: 3px;"> <a href="#" id="filter_less"> <?php _e('Go Back','re') ?>  </a> </p>
									<?php  foreach($groups as $group ){ ?>
									<div class="find-more" id="filter_group_<?php echo $group['filter_id']?>"  >
										<div class="find" <?php if ($count % 3 == 0 ) echo 'style="border: none"' ?>>
											<ul>
												<li><strong> <?php echo $group['group_name']  ?></strong></li>
												<?php
													$value_count = 0;
													foreach( (array)$group['value'] as $value  ) {
														$value_count++;
														if ($value_count % 5 == 0 ) {
															echo '</ul></div><div class="find"><ul>
																<li></li>';
														}
													?>
														<li>
															<a href="<?php echo tgt_get_filter_url($cat, $value['filter_value_id'])  ?>"> <?php echo $value['value_name'] ?> </a>
														</li>
														<?php
													} // end foreach foreach( (array)$group['values'] as $value  ) 
												?> 
											</ul>
										</div>
										</div> div.find-more find
									<?php } ?>
								</div>
							<div class="clear"></div>
						</div> end #filter_wrapper
					</div> end .col_box4
				</div> end .box_border
			</div> end .col
			<?php
				} //' End if empty group 
			} // End if $_GET['get_topic']
			*/
			if ( have_posts() ) 
			{
				/*
			    if(isset($_GET['get_topic'],$_GET['c']) && $_GET['get_topic'] != '' && $_GET['c'] != '')
			    {
				$cate_obj  = get_term_by( 'term_id', $_GET['c'], 'category');
			?>
			<form action="<?php echo tgt_get_permalink('compare'); ?>" method="post" name="frmCompare" id="frmCompare">
			<input type="hidden" value="<?php echo $cate_obj->term_id; ?>" name="cate[id]" />
			<input type="hidden" value="<?php echo $_GET['get_topic']; ?>" name="cate[name]" />
			    <div class="col_box"  style="border-bottom: 4px solid rgb(236, 238, 239);">
				<h1 class="blue2"><?php echo $cate_obj->name; ?></h1>
				<div class="box_butt">
				    <p class="orange"><a href="#"  onclick="submit_compare();return false;"><?php _e('Compare Items','re'); ?></a></p>
				</div>
				
				<div class="box_select" style="width:auto; background:none; text-align:right; float:right; margin-right:20px;">
				    <img style="float:right; margin:5px 0 0 10px;" src="<?php echo TEMPLATE_URL; ?>/images/icon_question.png" alt=""/><p style="float:right;"><?php _e('You checked','re'); ?>&nbsp;<strong style="color:#f65c00;"><label id="show_count">0</label>&nbsp;<?php _e('item(s)','re'); ?></strong>&nbsp;<?php _e(' to be compared','re'); ?></p>
				    <input type="hidden" value="0" id="default_count" />
				</div> 
			    </div>
			<?php
			    } */
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
							if( has_post_thumbnail ($post->ID) ){
								//$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID) , 'medium' );								
								echo '<div class="index-thumb"><a href="'. get_permalink() .'">';
								echo wp_get_attachment_image( get_post_thumbnail_id( $post->ID ) , array( 104, 84) , false, array( 'alt' =>  $post->post_title ) );
								echo '</a></div>';
							}
							else
								echo '<img src="'.TEMPLATE_URL.'/images/no_image.jpg" style="width:104px;height:84px;" alt=""/>';
							?> 
							<div class="vote_star">
								<div class="star" style="">
								<?php
								$rating = get_post_meta($post->ID, get_showing_rating(),true);
								tgt_display_rating( $rating, 'recent_rating_'.$post->ID);
								?>
								</div>	
							</div>
							<div class="clear"></div>
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
										$tag_link_arr[] = __('No tags','re');
									echo '<span class="tag-list">';
									echo implode(', ',$tag_link_arr);
									echo '</span>';
									?>
									</p>
								</div>
								<?php
								if(isset($_GET['get_topic'],$_GET['c']) && $_GET['get_topic'] != '' && $_GET['c'] != '')
								{
								?>
								<div class="title_right">
									<label><?php _e('compare this','re'); ?></label>
									
									<div class="check"><input type="checkbox" style="float:left; margin:0; padding:0; border:3px #fff04d solid; " value="<?php echo $post->ID; ?>" onclick="count_compare(this);" id="pro_id[]" name="pro_id[]" /></div>
								</div>
								<?php
								}
								?>
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
			</div>
			 <?php
				 }
			 ?>
			 </form>
			 <!--Pagination-->
			 <div class="col_box pagination_div">
				<?php 
				if ( $wp_query->max_num_pages > 1 ) {
				?>
				<div class="pagination">
					<b class="paginate_title">  <?php _e('Pages') ?> :</b>
					<?php
						global $wp_rewrite;
						$args = get_pagination_args();
						if ( $wp_rewrite->using_permalinks() )
							$args['base'] = $base . $param_url;
						echo paginate_links( $args );
					?>	
				</div>
				<?php } ?>
			 </div>                       
			 <?php
			 }else {
			 ?>
				<p class="red">
				  <?php _e("Sorry, we can't find product you want", 're') ?>
				  <br />
				  <?php echo __("But you can suggest us to update products at ", 're') . $helper->link(__('here', 're'), tgt_get_permalink('product_suggest') ) ?>
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
// For filter bar
var total = 0;
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
	jQuery('.star-disabled').rating();	
});
</script>
<?php
	get_footer();
?>