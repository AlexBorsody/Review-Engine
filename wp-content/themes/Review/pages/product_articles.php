<?php 
global $helper,$wp_query,$posts,$cat,$wpdb,$post;

$wp_query = new WP_Query();

add_action('posts_where', 'where_article_of_product');
add_action('posts_join', 'join_article_of_product' );
add_action('post_limits', 'article_of_product_limits' );

$wp_query->get_posts();

?>
	<?php													
	if ( have_posts() ) 
	{
echo '<div class="content_articles">';
		while(have_posts())
		{
			the_post();
			$art_id = get_the_ID();

	?>
<div class="col_box2" style="width: 100%; margin: 10px 0px; float: left;">
	<div style="padding: 0 20px">
		<div class="text" style="width:690px;">
			<div class="title" style="width:690px;">
				<div class="title_left" style="width:560px;">
					<h1><a href="<?php the_permalink(); ?>"><?php echo tgt_limit_content($post->post_title, 5); ?></a></h1>
					<p>
					<?php					
					if(get_post_meta($art_id,'tgt_product_id',true) != '')
					{
					$product_id = get_post_meta($art_id,'tgt_product_id',true);
					$product_name = get_post_field('post_name',$product_id )
					?>
					<label style="color:#1793D3;"><?php _e('Product','re'); ?>:&nbsp;</label>
					<a style="color:#9AA4A4;" href="<?php echo HOME_URL.'/?product='.$product_name; ?>">
					<?php
					echo get_the_title($product_id);
					echo '</a>';
					}else
					echo '  ';
					?>	
					</p>
				</div>				    
			</div>
		
			<div class="content_text" style="width:690px;">
				<p><?php echo tgt_limit_content(get_the_content(),34); ?> <a href="<?php the_permalink(); ?>"><?php _e('more','re'); ?>&nbsp;»</a></p>
				<br/>
				
				<p><a style="color:#1793D3;" href="<?php the_permalink(); ?>"><?php _e('Comments','re'); ?>  (<?php echo $post->comment_count; ?>)</a></p>
			</div>
		</div>
	</div>
</div>
<?php
				}
echo '</div>';
	}
	else {?>
		
		<div class="content_review">
			<div class="revieww" style="padding-bottom: 20px;">
				<p class="red" style="margin: 10px 20px"> <?php _e('This product has no article yet','re'); ?> </p>
			</div>
		</div>
	<?php
	}	
?>