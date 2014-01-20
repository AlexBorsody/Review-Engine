<?php 
global $helper,$wp_query, $artile_query;

require ( PATH_PROCESSING . DS. 'single_article_processing.php' );
get_header();
the_post();
$article_query[ 'id' ] = (int) $post->ID;
$article_query['post_name'] = $post->post_name;

$order = get_option( 'comment_order' );
?>
<div id="container">
    	<div class="container_res">
        	<div class="container_main">
                
                <div class="col_right">
                	<div class="col">
                        <div class="col_box" style="border-bottom:1px #dce4e4 solid;">
                            <h1 class="blue"><?php the_title(); ?></h1>
                            
                            <div class="reply">
                            	<!--<img style="float:left; margin:0 10px;" src="images/icon_reply.png" alt=""/>-->
										<?php echo $helper->image('icon_reply.png','', array('style' => 'float:left; margin:0 10px;')) ?>
                                <p><a id="go_reply"> <?php comments_number( __( 'no reply', 're' ), __( 'one reply', 're') , __( '% reply', 're' ) );?></a></p>
                            </div>
                        </div>
                        <?php
								/**
								 * get the product info stored in post meta tgt_product_id
								 */
								$product_ID = get_post_meta($post->ID, 'tgt_product_id', true);
								$product = get_post($product_ID);
								if ( ! empty( $product_ID ) && is_object( $product ) ){
									$rating = get_post_meta($product_ID, 'tgt_rating', true);
								?>
                        <div class="col_box" id="product_info">
                            <div class="box_border">
                                <div class="col_box3">
                                    <div class="text2">
                                        <div class="title2">
                                            <div class="title_left" style="width:550px;">
                                                <h1> <?php echo $helper->link($product->post_title, get_permalink($product_ID) ) ?> </h1>
                                                
                                                <p> <?php echo $helper->image('icon_tag.png', '', array('style' => 'float:left; margin-right:10px;') ) ?> 
                                                <?php
																$post_tags = wp_get_post_tags( $product_ID );
																//get_tag_link()
																$tags = array();
																//var_dump($post_tags);
																if (!empty( $post_tags )){
																	foreach ($post_tags as $tag){
																		$tags[] = $helper->link( $tag->name, get_tag_link($tag->term_id) );
																	}
																	echo implode(', ', $tags );
																}else {
																	_e('This product has no tags', 're');
																}
																?>
                                                </p>
                                            </div>
                                            
                                            <div class="title_right" style="float:right;">
                                                <div class="vote_star">
                                                    <div class="star">
																		<?php tgt_display_rating($rating, 'rating-item-'. $product_ID) ?>
																		<script type="text/javascript">
																			jQuery('.star-disabled').rating();
																		</script>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                             
                             <!--<div class="box_border2">  
                                <p><?php echo $post->ID;?></p>
                             </div>-->
                         </div>
								<?php } ?>
                        
                        <div class="col_box post_content" style="border-bottom:4px #dce4e4 solid;">
                            <p class="textt"><?php echo the_content(); ?></p>
                         </div>
								<?php
								$pre_post = get_previous_post();
								$next_post = get_next_post();
								if ( is_object( $pre_post ) || is_object( $next_post ) ) {
								?>                         
									<div class="col_box" style="border-bottom:1px #dce4e4 solid;">
										<?php
										if ( $pre_post ) {?>
											<div class="arrow">
												<?php echo $helper->image('arrow_left.png', '<<', array('style' => 'float:left; margin-right:20px;')) ?>                            	
												<p style="text-align:left;"><?php _e( 'Previous Article', 're');?>:<br/><?php previous_post_link( ); ?></p>
											</div>
										<?php }									
										if ( $next_post ) {?> 
											<div class="arrow" style="float:right;">
											<?php echo $helper->image('arrow_right.png', '<<', array('style' => 'float:right; margin-left:20px')) ?>
												 <p style="text-align:right;"><?php _e( 'Next Article', 're');?><br/><?php next_post_link( ); ?></p>
											</div>
										<?php } ?>
									</div>
								<?php } ?>
                     </div>
                     <?php comments_template(); ?> 
                </div>
					 
					<div class="col_left">
							<?php get_sidebar();?>
					</div>
            </div>
        </div>
    </div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#go_reply').click(function(){			
			jQuery('html, body').animate({'scrollTop' : jQuery('#commentform').offset().top }, 'slow');
		});
	});
</script>
<?php 
get_footer();
