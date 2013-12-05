<?php
global $helper,$wp_query,$posts;

get_header();	

/*
**James: Get all reviews by tags
*/

//$tag_name = $wp_query->query_vars['tag'];	
//$paged = $wp_query->query_vars['paged'];

//$args=array(		
//    'paged' => $paged,    
//);

?>
	 
	 <!-- Body start here -->
	 
    <div id="container">
    	<div class="container_res">
        	<div class="container_main"> 
				
                <div class="col_right">                	                      
			<?php			
			//$current_custom_page = 'product_sorting';
			//query_posts(array());
			//$current_custom_page = '';
			if ( have_posts() ) 
			{
			?>
			<div class="col_box" style="border-bottom: 4px solid rgb(236, 238, 239);">			
                            <h1 class="blue2"><?php echo __('Tags :', 're') . single_tag_title( '', false ); ?></h1>	                           
                        </div>
			<?php					
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
												$tag_link_arr[] = __('No tags','re');
											echo '<span class="tag-list">';
											echo implode(', ',$tag_link_arr);
											echo '</span>';
											?>
											</p>
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
					</div>
			<?php
				}
			}	
			?>
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
    <!--body end here-->
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.star-disabled').rating();	
});
</script>
<?php
	get_footer();
?>