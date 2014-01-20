<?php
global $wp_query,$helper,$posts; 
get_header();
//$current_user = get_userdata( $wp_query->query_vars['author'] );
$user = get_userdata( $wp_query->query_vars['author'] );
?>
 <div id="container">
    	<div class="container_res">
        	<div class="container_main">
            <div class="col_right">
                     <div class="col">
                         <div class="col_box">
				<img src="<?php $avatar = get_user_meta($user->ID, 'avatar', true); if(!empty($avatar)) echo URL_UPLOAD.$avatar; else echo TEMPLATE_URL.'/images/no_avatar.gif';?>" style="width: 80px; height: 80px;"> 
				<h1 class="blue2" style="font-size:25px; float:none; color:#FF3C00;"><?php echo $user->display_name; ?></h1>
                         </div>
                         
                         <div class="col_box" style="padding-bottom:15px;">
                             <div class="content_text" style="width:750px;">
                             	<table cellspacing="0" width="100%">
                                	<tbody>
                                    	<tr>
                                        	<td colspan="2" style="background-color:#C4D2D2; text-align:center; font-weight:bold; color:#3D4042; border-bottom:1px #C5CCCC solid;"><?php _e('Profile Informations','re'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                        	<td width="30%" style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-left:1px #C5CCCC solid; border-right:1px #C5CCCC solid;"><?php _e('User Name','re'); ?>:</td>
                                            <td style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-right:1px #C5CCCC solid; font-weight:bold;"><?php echo $user->display_name; ?></td>
                                        </tr>
                                        
                                        <tr>
                                        	<td style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-left:1px #C5CCCC solid; border-right:1px #C5CCCC solid;"><?php _e('First Name','re'); ?>:</td>
                                            <td style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-right:1px #C5CCCC solid; font-weight:bold;"><?php echo $user->first_name; ?></td>
                                        </tr>
                                        
                                        <tr>
                                        	<td style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-left:1px #C5CCCC solid; border-right:1px #C5CCCC solid;"><?php _e('Last Name','re'); ?>:</td>
                                            <td style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-right:1px #C5CCCC solid; font-weight:bold;"><?php echo $user->last_name; ?></td>
                                        </tr>
											
										<!-- <tr>
                                        	<td style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-left:1px #C5CCCC solid; border-right:1px #C5CCCC solid;"><?php _e('Email','re'); ?>:</td>
                                            <td style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-right:1px #C5CCCC solid; font-weight:bold;"><?php echo $user->user_email; ?></td>
                                        </tr> -->
                                    </tbody>
                                </table>
                                
                                <table cellspacing="0" width="100%">
									<tbody>
										<tr>
											<td colspan="2" style="background-color:#C4D2D2; text-align:center; font-weight:bold; color:#3D4042; border-bottom:1px #C5CCCC solid;"><?php _e('Activity Summary','re'); ?></td>
										</tr>
										  
										<tr>
											<td width="30%" style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-left:1px #C5CCCC solid; border-right:1px #C5CCCC solid;">
												<?php _e('Reviews Written','re'); ?>:
											</td>
											<td style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-right:1px #C5CCCC solid; font-weight:bold;">
												<?php echo count_review_tgt($user->ID); ?>
											</td>
										</tr>
										
										<!-- Thumb-up count -->
										<tr>
											<td width="30%" style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-left:1px #C5CCCC solid; border-right:1px #C5CCCC solid;">
												<?php												
												echo $helper->image('thumb_up.png', 'Thumb-up', array('title' => __('Likes','re') ) );
												?>
											</td>
											<td style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-right:1px #C5CCCC solid; font-weight:bold;">
												<?php echo (get_user_meta($user->ID,'tgt_thumbup_count',true) != '' )?get_user_meta($user->ID,'tgt_thumbup_count',true):0; ?>
											</td>
										</tr>
										
										<!-- Thumb-down count -->
										<tr>
											<td width="30%" style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-left:1px #C5CCCC solid; border-right:1px #C5CCCC solid;">
												<?php												
												echo $helper->image('thumb_down.png', 'Thumb-down', array('title' => __('Dislikes','re') ) );
												?>
											</td>
											<td style="background-color:#fff; text-align:left; padding-left:15px; padding-right:15px; color:#3D4042; border-bottom:1px #C5CCCC solid; border-right:1px #C5CCCC solid; font-weight:bold;">
												<?php echo (get_user_meta($user->ID,'tgt_thumbdown_count',true) != '' )?get_user_meta($user->ID,'tgt_thumbdown_count',true):0; ?>
											</td>
										</tr>
									</tbody>
                                </table>
                             </div>
                        </div> 
                 
                        <div class="col_box">
                            <h1 class="blue2" style="font-size:25px; float:none;"><?php echo $user->display_name; ?><?php _e("'s community profile","re"); ?></h1>
                         </div>
                        
                        <div class="col_box" style="padding-bottom:15px;">
                             <div class="content_text" style="border-left:none; width:750px;">
                             	<table cellspacing="0" width="100%">
                                	<tbody>
                                    	<tr>
                                        	<td colspan="3" style="background-color:#C4D2D2; text-align:center; font-weight:bold; color:#3D4042; border-bottom:1px #C5CCCC solid;"><?php echo $user->display_name; ?><?php _e("'s latest reviews",'re'); ?></td>
                                        </tr>
                                        <?php									
					if ( have_posts() )
					{
						  while( have_posts() ) { the_post();
						//for($n=0; $n<count($posts) ; $n++ )
						//{
						//echo'<pre>';
						//print_r($post);
						//echo '</pre>';
						
						  $product_arr = get_post($post->comment_post_ID);
						  //$image_thumb = get_post_meta($post->ID, 'tgt_product_images' , true);
						  
						  $image_thumb = null;
						  if ( has_post_thumbnail($post->ID) )
						  {
								 $thumb_id = get_post_thumbnail_id( $post->ID );
								 $image_thumb = wp_get_attachment_image_src( $thumb_id );
						  }
						  
						  $post_date = explode(' ',$post->post_date);
					?>
                                        <tr>
						<td valign="top" style="background-color:#fff; text-align:center; color:#3D4042; border-bottom:1px #C5CCCC solid; border-left:1px #C5CCCC solid; border-right:1px #C5CCCC solid;width:162px">
							<?php
							if ( !empty( $image_thumb ) )
								echo '<img src="'.$image_thumb[0].'" style="width:80;height:80px;margin-top: 15px;" alt="dailywp.com"/>';								
							else
								echo '<img src="'.TEMPLATE_URL.'/images/no_image.jpg" style="width:80;height:80px;margin-top: 15px;" alt=""/>';
							?>
						</td>
						    
						<td valign="top"  style="background-color:#fff; text-align:left; border-bottom:1px #C5CCCC solid; border-right:1px #C5CCCC solid; padding-left:15px; padding-right:15px;">
							<span>							
							<?php
							echo date('F d, Y',strtotime($post_date[0]));
							?>
							</span>
							<br/>
							<a href="<?php echo get_permalink($post->ID); ?>">
							<?php						
							if(strlen($post->post_title) > 32)
							{
								echo substr($post->post_title,0,31).'...';
							}else
								echo $post->post_title;
							?>							
							</a><br/><br/>
	
							<span style="font:12px/18px arial;">
								<?php echo tgt_limit_content($post->post_content, 34); ?> <a href="<?php echo get_permalink($post->ID); ?>"><?php _e('more','re'); ?>&nbsp;&raquo;</span><br/><br/>
	
							<strong style="float:left;"><?php _e("User's rating","re"); ?>:</strong> <div class="vote_star" style="margin-top:0;margin-left:20px;">
								<div class="star" style="padding-left: 12px;padding-top: 5px;">
								<?php
								$rating = get_comment_meta( $post->comment_ID , 'tgt_review_rating', true );
								tgt_display_rating( $rating['sum'], 'review_rating_'.$post->comment_ID, true, 'star-disabled' );
								?>									
								</div>							    
							</div>
						</td>
                                        </tr>                                        
                                        <?php
						}
					}else
					{ ?>
					<tr>
						<td>
						  <p style="text-align: center;color: #C64B4B">  <?php echo $user->display_name; ?> <?php   _e(' has not write any review yet', 're') ?></p>
						</td>
					</tr>					    
						 <?php 
					}
					?>
                                    </tbody>
                                </table>
                             </div>
                        </div> 
                     </div>
					<!--Pagination-->
					<div class="col_box">
						<?php 
						if ( $wp_query->max_num_pages > 1 ) {
						?>
						<div class="pagination">
							<b class="paginate_title">  <?php _e('Pages') ?> :</b>
							<?php
								echo paginate_links( get_pagination_args() );
							?>	
						</div>
						<?php } ?>
					</div> 
                </div>
					 
					<!-- SIDEBAR GOES HERE -->
					<?php
						get_sidebar();
					?>					
					<!-- SIDEBAR END HERE -->					 
					 
            </div>
        </div>
    </div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.star-disabled').rating();	
});
</script>
<?php

?>
<?php
	get_footer();
?>