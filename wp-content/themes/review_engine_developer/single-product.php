<?php
global $helper,$wp_query,$post, $allowedtags, $allowedposttags, $current_user;
include PATH_PROCESSING . DS . 'single_product_processing.php';
count_view_product($post->ID);
get_header();
$product_website = '';
$product_images = '';
$product_price = '';
if(get_post_meta($post->ID,'tgt_product_url',true) != '')
	$product_website = get_post_meta($post->ID,'tgt_product_url',true);// Get product website
/*if(get_post_meta($post->ID,'tgt_product_images',true) != '')
	$product_images = get_post_meta($post->ID,'tgt_product_images',true);// Get product images*/
if(get_post_meta($post->ID,'tgt_product_price',true) != '')
	$product_price = get_post_meta($post->ID,'tgt_product_price',true);// Get product price	
$post_date = explode(' ',$post->post_date);
$view_post = get_post_meta($post->ID, PRODUCT_VIEW_COUNT, true);
if(empty($view_post))
	$view_post = 0;
$tab_content = get_post_meta( $post->ID , 'tgt_tab' , true );
$open_comment = comments_open();
?>
<div id="container">
		<div class="container_res">
			<div class="container_main hreview-aggregate">
			 <!-- Notification Sidebar -->
					  <?php
						if ( is_active_sidebar( 'homepage-widget-area' ) ) {
							dynamic_sidebar( 'homepage-widget-area' );
						}
					?> 
				 <!-- End Notification Sidebar -->	
				<div class="content_product">
					 <div class="col_box" style="width:998px;">                         
						 <div class="text3" style="margin-left:0px;">
							<div class="title3" style="width:998px;">
								<div class="title_left" style="width:600px;">
									<span class="item"> <span class="fn">
										<h1>  
											<?php echo $post->post_title; ?>
											<?php //if ($current_user->has_cap('administrator'))  {
												   if (current_user_can('edit_others_posts')) {?> 
													<a href="<?php echo HOME_URL.'/wp-admin/post.php?post='.$post->ID.'&action=edit';?>"> 
														<img class="edit_link" src="<?php echo TEMPLATE_URL . '/images/pencil.png';?>" alt="edit" title="<?php _e('Edit', 're')?>"> 
													</a>
											<?php }?>
										</h1> 
									</span></span> 
									<p>													
										<?php echo $helper->link ( vsprintf ( __("%s's website","re"), $post->post_title) , tgt_get_the_product_link($post->ID), array('target' => 'product') ) ?>
									</p>
								</div>
											
								<div class="title_right" style="float:right;">
									<p class="rate" style="color:#9facac;"><?php _e('Users Rating','re'); ?>:</p>
									<div class="vote_star">
										<div class="star">
											<?php
											tgt_display_rating($product['rating']['user']['rating'], 'product[rating][user]')
											?>
										</div>
									</div>
								</div>
								
								<div class="title_right" style="float:right; margin-right:20px;">
									<p class="rate"><?php _e("Editor's Rating","re"); ?>:</p>
									<div class="vote_star">
										<div class="star">
											<?php
											tgt_display_rating($product['rating']['editor']['rating'], 'product[editor][user]')
											?>
										</div>
										
									</div>
								</div>								
								<script type="text/javascript">
									jQuery('.star-disabled').rating();
								</script>
								
								<!-- Display rating of product -->
								<?php $rating = get_post_meta ( $post->ID , get_showing_rating(),true); ?>
								<span class="rating" style="display: none">
									<span class="average"><?php echo $rating ?></span>
								    <span class="best">10</span>
								</span>
							</div>
						 </div>
					 </div>
				</div>
				
				<div class="content">
					 <div class="left">					
						<div class="slide_show" style="margin-bottom: 20px;">
									<div class="big-photos">
								<?php
								$attachments = get_children( array(
										'post_parent' => $post->ID,
										'post_type' => 'attachment',
										'post_mime_type' => 'image',
										'orderby' => 'menu_order',
										'order' => 'ASC'
										));
								
								if ( has_post_thumbnail( $post->ID ) )
									$feature_att = get_post_thumbnail_id( $post->ID );
								
								if ( !empty($attachments) && is_array( $attachments ) )
								{
									$attachments = array_values( $attachments );
									if ( !isset($feature_att) )
									{
										$feature_att = $attachments[0]->ID;
									}
										
									foreach ( $attachments as $image ) {
										$arg = array(
														 'style' => 'display: none',
														 'class' => '',
														 );
										$url = array( 'medium' => wp_get_attachment_image_src( $image->ID, 'large') ,
														'thumb' => wp_get_attachment_image_src( $image->ID, 'thumb'),
														'full' => wp_get_attachment_image_src( $image->ID, 'full')
														);
										if ( $feature_att == $image->ID )
										{
											$arg['style'] = '';
											$arg['class'] = 'selected';
										}
									?>
										<a rel="lightbox-products1" class="<?php echo $arg['class'] ?> product-big-photo" id="big_image_<?php echo $image->ID; ?>" href="<?php echo $url['full'][0];?>" title="<?php the_title()?>" style="<?php echo $arg['style'] ?>" >
											<img src="<?php echo $url['medium'][0] ?>" alt="<?php the_title()?>"/>			
										</a>
									<?php
									}
								}
								else
								{
									echo $helper->image( 'no_image.jpg', 'No Image' );
								}
								?>
								</div>									
						   
								<?php if ( (!empty($attachments) || is_array( $attachments )) && count($attachments) > 1 ) {
									$width = count($attachments) * 100;
								?>
									<div class="slide-wrapper">
										<a href="#" class="slide-nav" id="slide_next" title="<?php _e('Next','re') ?>"><span><?php _e('Next','re') ?></span></a>
										<a href="#" class="slide-nav" id="slide_prev" title="<?php _e('Prev','re') ?>"><span><?php _e('Prev','re') ?></span></a>
										<div class="slide">										
											<ul class="thumbs-list" style="width: <?php echo $width . 'px' ?>" id="thumb_slide_list" >
											<?php 
											foreach ( $attachments as $image ) {
												$thumb_url = wp_get_attachment_image_src( $image->ID , 'thumbnail' );
												?>
												<li class="thumb-item">
													<div>
														<a href="#big_image_<?php echo $image->ID ?>" class="product-small-thumbnail">
															<img src="<?php echo $thumb_url[0];?>" id="att_<?php echo $image->ID; ?>" style="width:90px;">
														</a>
													</div>
												</li>
												<?php } ?>
											</ul>
										</div>
									</div>
									<?php } ?>                      	
						</div><!-- class-slideshow -->
					 </div>
					 
					 <div class="right">
						<div id="product_intro">
						<?php
							setup_postdata ($post);
							global $more;
							$more = 0;
							the_content("<p><strong>".__('More info', 're')."</strong></p>");
							//echo truncate( apply_filters( 'the_content' , get_the_content() ) , '800' );
							?>
						</div>
						<div id="product_desc" style="display: none">
							<?php 
								global $more;
								$more = 1;
								the_content(); 
							?> 
						<p>
							<a class="hide-desc" href="#product"><strong> <?php _e('Hide description','re') ?></strong> </a>
						</p>
						</div>
						<div class="content_text">
							 <div class="box_butt" style="float:left; margin-top:15px;">
								  <p class="blue" style="float:left;">								  
											<?php echo $helper->link ( __('Visit Website','re') , tgt_get_the_product_link($post->ID), array('target' => 'product') ) ?>
								  </p>                                  
								  <p class="re"><?php _e('OR','re'); ?>  <a class="go_review" href="#tc_write"><?php _e('Review This!','re'); ?></a></p>
							 </div>
						</div>
						 
						 <div class="content_text" style="margin-top:25px;">
							
								<p class="date">
									<span class="info-price"><?php _e('Price','re'); ?>:</span>									
									<span class="price-num"><?php echo tgt_format_currency_symbol($product_price); ?></span>
								</p>									
						<p class="date">
									<span class="info-date"><?php _e('Date','re'); ?>:</span>
									<span><?php echo date('F d, Y',strtotime($post_date[0])); ?></span>
								</p>
						<p class="date">
									<span class="info-tags"><?php _e('Tags','re'); ?>: </span>
									<?php the_tags('', ', ', '');?>
								</p>
								<p class="date">
									<span class="info-view"><?php echo __('Views','re')?>:</span>
									<span><?php echo $view_post; ?></span>
								</p>
								<p class="date">
									<span class="info-review"><?php echo __('Reviews','re')?>:</span>
									<span>
									<?php
										if ( get_option( PRODUCT_SHOW_RATING , 1 ) == 1 )
											$count = (int)get_post_meta( $post->ID , PRODUCT_EDITOR_RATING_COUNT , true );
										else 
											$count = (int)get_post_meta( $post->ID , PRODUCT_RATING_COUNT , true );
										
										if ( $count == 0 )
											echo '<span class="votes hidden">0</span> '. __('This product hasn\'t been reviewed yet' , 're' ) ;
										else if ( $count == 1 )
											echo '<span class="votes hidden">1</span> 1 '. __('Review' , 're' ) ;
										else 
											echo '<span class="votes hidden">'.$count.'</span> '. sprintf( __(' %s Reviews' , 're' ) , $count ) ;
											//comments_number( '<span class="count hidden">0</span> This product hasn\'t been reviewed yet', '<span class="count">1</span> Review', '<span class="count">%d</span> Reviews' );
										?>
									</span>
								</p>
						 </div>
					 </div>
					</div>
					<div class="clear"></div>
				
			   <div class="content">
					<div class="tab">
						<div class="tab_link">
							<ul>
								<li id="tab_review" class="tab-item select"><a href="#tc_review"> <?php _e('Reviews','re'); ?> </a></li>
								<li id="tab_spec" class="tab-item"><a href="#tc_spec"><?php _e('Specifications','re'); ?></a></li>
										
								<?php if ( get_option(SETTING_ENABLE_ARTICLE) ) {?>
								<li id="tab_articles" class="tab-item"><a href="#tc_article"><?php _e('Articles','re'); ?></a></li>
								<?php } ?>
								
								<li id="tab_write" class="tab-item"><a href="#tc_write"><?php _e('Write review','re'); ?> </a></li>								
								
								<?php
								if (  $open_comment == true ){  ?>
								<li id="tab_comment" class="tab-item"><a href="#tc_comment"><?php _e('Comments','re'); ?> </a></li>		
								<?php
								}
								?>
								
								<?php
								$result = get_tab_data_tgt();
								if(!empty($result))
								{
									foreach($result as $k_g => $v_g)
									{
										$content = '';												
										if( !empty($tab_content['tab_'.$v_g['ID']] ))
										{ ?>
											<li id="additional_tab_<?php echo $v_g['ID']; ?>" class="tab-item additional-tab">
												<a href="#tc_addition_<?php echo $v_g['ID']; ?>">
														<?php echo $v_g['name']; ?>
												</a>
											</li>
								<?php
										}
									}
								}
								?>
							</ul>
						</div>
					</div>
						<div class="clear"></div>
						<div id="tc_review" class="review_tab_content" style="border: medium none;">
							<?php
							comments_template('/pages/product_reviews.php', true);
							?>
						</div>
						
						<?php
						if (  $open_comment == true ){
						?>
						<div class="review_tab_content" id="tc_comment" style="display:none;">							
							<?php
							comments_template('/pages/product_writecomment.php', true); ?>							
						</div>
						<?php							
						}
						?>
						
						<div class="review_tab_content" id="tc_spec" style="border: medium none;display: none; padding: 10px 0 0 5px;">
							<?php include PATH_PAGES . DS . 'product_spec.php'; ?>
						</div>
						
						<?php
						if ( get_option(SETTING_ENABLE_ARTICLE) ){ ?>
						<div class="review_tab_content" id="tc_article" style="display:none;">
							<?php include PATH_PAGES . DS . 'product_articles.php' ?>							
						</div>
						<?php } ?>
						
						<div class="review_tab_content" id="tc_write" style="display:none;">
							<?php if (get_option( SETTING_ALLOW_REVIEW )) {?>
							<?php include PATH_PAGES . DS . 'product_writereview.php' ?>
							<?php } else {
								echo '<p class="red" style="padding: 10px 20px"> Unfortunately, review currently closed. Please try again later  </p>';
							}
							?>
						</div>
						
						<?php
						if(!empty($result))
						{
							foreach($result as $k_g => $v_g)
							{
								$content = get_post_meta($post->ID, 'tgt_tab', true);
								$content = $tab_content;
								
								if( !empty($content ) )
								{
									$content = $content['tab_'.$v_g['ID']];										
									if(!empty($content))
									{
						?>
										<div class="review_tab_content" id="tc_addition_<?php echo $v_g['ID']; ?>" style="border: medium none;display:none; padding: 10px 0 0 5px;">
											<div class="content_review">
												<div class="revieww post_content" style="padding-bottom: 20px;">
													<?php echo '<p>' . preg_replace( '/<br\s*\/>/', '</p><p>', $content ) . '</p>'; ?>
												</div>
											</div>
										</div>
						<?php
									}
								}
							}
						}
						?>
						
				</div>
				
			</div>
		</div>
	</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	// open comment if has #comment-* in url
	pattern = /^#comment-/;
	if ( pattern.test(window.location.hash) )
		jQuery('#tab_comment > a').trigger('click');

	jQuery('.more-link').click(function(){
		//var target = jQuery(this).attr('href');
		jQuery('#product_intro').hide();
		jQuery('#product_desc').show();
		return false;
	});
	jQuery('.hide-desc').click(function(){
		//var target = jQuery(this).attr('href');
		jQuery('#product_desc').hide();
		jQuery('#product_intro').show();
		return false;
	});
	
	//
	jQuery('.star-disabled').rating();
	
	if ( jQuery('.no-review').length != 0 ){
		jQuery('.review_tab_content').hide();
		jQuery('.tab-item').removeClass('select');
		jQuery('.additional-tab').removeClass('select');
		jQuery('#tab_spec').addClass('select');
		jQuery('#tc_spec').show();
	}
	
	jQuery('.product-small-thumbnail').click(function(){
		var current = jQuery(this),
			id = current.attr('href'),
			target = jQuery(id),
			big_photos = jQuery('.product-big-photo'),
			selected =  jQuery('.big-photos .selected');
			
			selected.fadeOut(500, function(){
				selected.removeClass('selected');
				target.fadeIn(500, function(){ jQuery(this).addClass('selected') });
			});
			return false;
	});
	
	jQuery('#thumb_slide_list').each(function() {
		var current 	= jQuery(this),
			container 	= jQuery('.slide-wrapper'),
			elements 	=  current.find('.thumb-item'),
			next 			= container.find('#slide_next'),
			prev 			= container.find('#slide_prev'),
			nav 			= container.find('.slide-nav'),
			width 		= 100,
			count 		= elements.length;
			slide_count = 3;
		
		if ( count > 3 )
		{
			next.click(function(){
				current.stop(true, true);
				current.animate({left : '-=100'}, 'normal', function(){
					var elements = container.find('.thumb-item'),
						first = elements.first(),
						left = current.offset().left;
					current.append(first);
					current.offset({left: left + 100});
				});
				return false;
			})
			
			prev.click(function(){
				var elements = container.find('.thumb-item'),
					last = elements.last(),
					left = current.offset().left;
				current.prepend(last);
				current.offset({left: left - 100});
				current.stop(true, true);
				current.animate({left : '+=100'}, 'normal', function(){
				});
				return false;
			})
		}
		else
		{
			nav.hide();
		}
	});
	var images_url = '<?php echo get_bloginfo('template_url') . '/images/' ?>';
	var lightbox_args = {
		imageLoading : images_url + 'lightbox-ico-loading.gif' ,
		imageBtnClose :  images_url + 'lightbox-btn-close.gif' ,
		imageBtnPrev :  images_url + 'lightbox-btn-prev.gif' ,
		imageBtnNext  :  images_url + 'lightbox-btn-next.gif' ,
		imageBlank : images_url + 'lightbox-blank.gif'
	}
	
	jQuery('a.product-big-photo').lightBox(lightbox_args);
	
});


function tgt_show_image(id)
{
	var count_images = <?php if(!empty($product_images)) echo count($product_images); else echo 0; ?>;
	for(var i=0; i<count_images; i++)
	{
		document.getElementById('big_image_'+i).style.display = "none";		
	}
	document.getElementById('big_image_'+id).style.display = '';	
}

</script>

<?php
	get_footer();
?>
<?php
function count_view_product($post_id)
{
	ob_start();
	$cookie_views = array();
	$cookie_views = isset ($_COOKIE['view_product']) ? $_COOKIE['view_product'] : '';
	$count = 1;
	if(!empty($cookie_views))
	{
		$cookie_views = explode(',', $cookie_views);
		foreach ($cookie_views as $cookie_view)
		{
			if($cookie_view == $post_id)
			{
				$count = 0;
			}
		}
	}
	if($count == 1)
	{
		$cookie_views[] = $post_id;
		$cookie_views = implode(',', $cookie_views);
		setcookie("view_product", $cookie_views, time()+ 2*3600,  "/");
	}
	$view_post = 0;
	$view_post = get_post_meta($post_id, PRODUCT_VIEW_COUNT, true);
	$view_post += $count;
	update_post_meta($post_id, PRODUCT_VIEW_COUNT, $view_post);
}
?>
