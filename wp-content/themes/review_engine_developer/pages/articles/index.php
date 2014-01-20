<?php
global $helper,$wp_query,$posts,$post, $current_custom_page;

get_header();
/*
**James: Get all articles
*/
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
					<div class="col_box" style="border-bottom:4px #eceeef solid;">
						<h1 class="blue2">
							<?php echo __('Articles of ','re') . get_bloginfo('name') ?>
							<?php if(get_option(SETTING_FEED_LINK_ARTICLE)==1) { ?>
							<a href="<?php echo get_post_type_archive_feed_link( 'article' , 'rss2' ) ?>">
								<img src="<?php echo TEMPLATE_URL ?>/images/feed_blue.png" width="20" height="20" alt="article feed" title="<?php _e('Feed') ?>" />
							</a>
							<?php } ?>
						</h1>
					</div>
			<?php
			//$page = $wp_query->query_vars['paged'];
			//wp_reset_postdata();
			//query_posts(array(
			//						'post_type' => 'article',
			//						'posts_per_page' => 1,
			//						'paged' => $page ? $page : 1,
			//						'order' => 'DESC',
			//						'orderby' => 'date'
			//					  ));
			if ( have_posts() ) 
			{
				while(have_posts())
				{
					the_post();
					$art_id = get_the_ID();

			?>
			<div class="col_box2" style="padding:0 20px 20px 20px; width:678px; margin-bottom:20px;">
                            <div class="text" style="width:690px;">
                                <div class="title" style="width:690px;">
                                    <div class="title_left" style="width:560px;">
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
					if(get_post_meta($art_id,'tgt_product_id',true) != '')
					{
					    $product_id = get_post_meta($art_id,'tgt_product_id',true);					    
						$product_status = get_post_field('post_status',$product_id );
						if($product_status == 'publish')
						{
					?>
							<label style="color:#1793D3;"><?php _e('Product','re'); ?>:&nbsp;</label>
							<a style="color:#9AA4A4;" href="<?php echo get_permalink($product_id);?>">
					<?php
							echo get_the_title($product_id);
							echo '</a>';
						}else
							echo '&nbsp;';
					}else
					    echo '&nbsp;';
					?>	
					</p>
                                    </div>				    
                                </div>
                                
                                <div class="content_text" style="width:690px;">
									<p><?php echo tgt_limit_content(get_the_content(),34); ?> <a href="<?php the_permalink(); ?>"><?php _e('more','re'); ?>&nbsp;&raquo;</a></p>
                                    <br/>
                                    
                                    <p><a style="color:#1793D3;" href="<?php the_permalink(); ?>"><?php _e('Comments','re'); ?>&nbsp;(<?php echo $post->comment_count; ?>)</a></p>
                                </div>
                            </div>
                        </div>
			<?php
				}
			?>			
			<!--Pagination-->
			<div class="col_box">
				<?php //echo tgt_generate_pagination('paged', 2);
				if ( $wp_query->max_num_pages > 1 ) {
				?>
				<div class="pagination">
					<b class="paginate_title">  <?php _e('Pages') ?> :</b>
					<?php
						echo paginate_links( get_pagination_args() );
					?>	
				</div>
				<?php  } ?>
			</div>
			<?php
			}else{ ?>
				<p class="red">
				  <?php _e("Unfortunally, there is not article written yet.", 're') ?>
				</p>	
			<?php
			}
			?>                     
                </div>
				
				<!-- side bar start here -->
            	
					<?php
						get_sidebar();
					?>
            
				<!--sidebar end here-->
            </div>
        </div>
    </div>
    
    <!--body end here-->

<?php
	get_footer();
?>