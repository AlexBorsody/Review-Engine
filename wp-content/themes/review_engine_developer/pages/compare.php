<?php
global $wpdb;
get_header();
if(isset($_POST['cate']['id']) && !empty($_POST['cate']['id']))
{
		//$spec_query = "SELECT * FROM ".$wpdb->prefix."tgt_spec WHERE term_id = ".$_POST['cate']['id']." ORDER BY ID";
		$spec_arr = get_all_data_spec_by_cat_id_tgt($_POST['cate']['id']);
}
?>
    
    <div id="container">
    	<div class="container_res">
        	<div class="container_main">
				<?php
				if(isset($_POST['cate']['id']) && !empty($_POST['cate']['id']))
				{
				?>
            	<div style="border-bottom: 4px solid rgb(236, 238, 239); width:998px;" class="col_box">
                            <h1 class="blue2"><?php echo $_POST['cate']['name']; ?>&nbsp;<?php _e('comparison chart','re'); ?></h1>
                </div>
            	<div class="compare">
                	<table cellspacing="0" style="width: 980px; table-layout: fixed;">
                    	<tbody>
                        	                           
                        	<tr>							
					<td style="border-bottom:1px solid #fff; width:170px !important;border-top:1px solid #C5CCCC; padding:10px; background-color:#C4D2D2; vertical-align:top;"><strong><?php _e('Product name','re'); ?></strong></td>
					<?php
					if(count($_POST['pro_id']) > 0)
					{
						for($i=0; $i<count($_POST['pro_id']); $i++)
						{
							//$image_thumb = get_post_meta($_POST['pro_id'][$i],'tgt_product_images',true);
							$post_id = $_POST['pro_id'][$i];
					?>
							<td align="center" style="border-bottom:1px solid #C5CCCC; border-right:1px solid #C5CCCC;border-top:1px solid #C5CCCC; width:170px; padding:10px; vertical-align:top;">
								<a href="<?php echo get_permalink($_POST['pro_id'][$i]); ?>" target="_blank">
								<?php
								if( has_post_thumbnail( $post_id ) )
								{
									$thumbnail = wp_get_attachment_image( get_post_thumbnail_id( $post_id ) , array(80,80), false, array('class' => 'compare-thumbnail') );
									echo $thumbnail;
									//echo '<img src="'.URL_UPLOAD.'/'.$image_thumb[0]['thumb'].'" style="width:80;height:80px;border: 1px solid #C5CCCC; padding: 3px;" alt="dailywp.com"/>';								
								}
								else									
									echo '<img src="'.TEMPLATE_URL.'/images/no_image.jpg" style="width:80;height:80px;border: 1px solid #C5CCCC; padding: 3px;"  alt=""/>';
								?>
								</a>
								<div style="width:auto;">
										<a href="<?php echo get_permalink($_POST['pro_id'][$i]); ?>" target="_blank"><?php echo get_the_title($_POST['pro_id'][$i]); ?></a>						
								</div>
							</td>
					<?php
						}
					}
					?>
				</tr>				
				<tr>
					<td style="border-bottom:1px solid #fff; width:120px; padding:10px; background-color:#C4D2D2; vertical-align:top;">
						<strong><?php _e("Editor's rating",'re'); ?></strong>
					</td>
					<?php
					if(count($_POST['pro_id']) > 0)
					{
						for($i=0; $i<count($_POST['pro_id']); $i++)
						{
							$rating = get_post_meta($_POST['pro_id'][$i],'tgt_editor_rating',true);							
					?>
							<td style="border-bottom:1px solid #C5CCCC; border-right:1px solid #C5CCCC;border-top:1px solid #C5CCCC; width:170px; padding:10px; text-align:center;">
							<?php							
								tgt_display_rating( $rating, 'editor_rating_'.$_POST['pro_id'][$i], true, 'star-disabled' );
							?>				
							</td>
					<?php
						}
					}
					?>
				</tr>
				<tr>
					<td style="border-bottom:1px solid #fff; width:120px; padding:10px; background-color:#C4D2D2; vertical-align:top;">
						<strong><?php _e("User's rating",'re'); ?></strong>
					</td>
					<?php
					if(count($_POST['pro_id']) > 0)
					{
						for($i=0; $i<count($_POST['pro_id']); $i++)
						{
							$rating = get_post_meta($_POST['pro_id'][$i],'tgt_rating',true);							
					?>
							<td style="border-bottom:1px solid #C5CCCC; border-right:1px solid #C5CCCC;border-top:1px solid #C5CCCC; width:170px; padding:10px; text-align:center;">
							<?php							
								tgt_display_rating( $rating, 'user_rating_'.$_POST['pro_id'][$i], true, 'star-disabled' );
							?>				
							</td>
					<?php
						}
					}
					?>
				</tr>
				<tr>
					<td style="border-bottom:1px solid #fff; width:120px; padding:10px; background-color:#C4D2D2; vertical-align:top;">
						<strong><?php _e('Price','re'); ?></strong>
					</td>
					<?php
					if(count($_POST['pro_id']) > 0)
					{
						for($i=0; $i<count($_POST['pro_id']); $i++)
						{
								//$product_price = __('Pricing not available','re');
								if(get_post_meta($_POST['pro_id'][$i],'tgt_product_price',true) != '')
										$product_price = get_post_meta($_POST['pro_id'][$i],'tgt_product_price',true);// Get product price
														
					?>
							<td style="border-bottom:1px solid #C5CCCC; border-right:1px solid #C5CCCC; width:170px; padding:10px;">
								<span style="color:#F75C00; font-size:18px;"><?php echo tgt_format_currency_symbol($product_price); ?></span>			
							</td>
					<?php
						}
					}
					?>
				</tr>
                            <?php
			    if(is_array($spec_arr) && count($spec_arr) > 0)
			    {
			    foreach ($spec_arr as $value) {			    	
				
					if(!empty($value['value']))
					{
						$spec_detail = $value['value'];
						foreach($spec_detail as $k => $v)
						{						
			    ?>
						<tr>
						    <td style="border-bottom:1px solid #fff; padding:10px; background-color:#C4D2D2; vertical-align:top;"><strong><?php echo $v['value_name']; ?></strong></td>                       
						    <?php
						    if(count($_POST['pro_id']) > 0)
						    {
							    for($j=0; $j<count($_POST['pro_id']); $j++)
							    {
								    $product_spec = get_post_meta($_POST['pro_id'][$j],'tgt_product_spec',true);
								    
						    ?>
								    <td style="border-bottom:1px solid #C5CCCC; border-right:1px solid #C5CCCC; width:170px; padding:10px;">
									    <?php
										if(isset($product_spec['g_'.$value['spec_id'].'_'.$v['spec_value_id']]))
												echo $product_spec['g_'.$value['spec_id'].'_'.$v['spec_value_id']];												
									    ?>
								    </td>
						    <?php
							    }
						    }
						    ?>
						</tr>
			    <?php
						}
					}
				}
                            }
			    ?>  
			    <tr>
					<td style="border-bottom:1px solid #fff; width:120px; padding:10px; background-color:#C4D2D2; vertical-align:top;">
						<strong><?php _e('Website','re'); ?></strong>
					</td>
					<?php
					if(count($_POST['pro_id']) > 0)
					{
						for($i=0; $i<count($_POST['pro_id']); $i++)
						{
								$product_website = '';
									if(get_post_meta($_POST['pro_id'][$i],'tgt_product_url',true) != '')
										$product_website =  tgt_get_the_product_link($_POST['pro_id'][$i]);	
														
					?>
							<td style="border-bottom:1px solid #C5CCCC; border-right:1px solid #C5CCCC; width:170px; padding:10px;">
								<div class="box_butt" style="float: left;">
									<?php if(!empty($product_website)) { ?>
										<p class="blue"><a href="<?php echo esc_url_raw($product_website); ?>"  target="_blank"><?php _e('Visit Website','re'); ?></a></p>
									<?php } 
									else {
									?>
										<p class="blue"><a target="_blank"><?php _e('Visit Website','re'); ?></a></p>
									<?php } ?>
								</div>			
							</td>
					<?php
						}
					}
					?>
				</tr>                          
                        </tbody>
                    </table>
                </div>
				<?php
				}else
						echo '<p class="red">'.__("You haven't choose any product yet, please try again", 're') . '</p>';
				?>
            </div>
        </div>
    </div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.star-disabled').rating();	
});
</script> 
<?php
	get_footer();
?>