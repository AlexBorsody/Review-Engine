<?php
// get editor comment
global $helper, $wp_query, $post, $wp_rewrite;
$reviews_number = get_option('tgt_reviews_per_product');
$current_page = get_query_var('cpage');
if (empty($reviews_number)) $reviews_number = 10;
echo '<ul class="reviews-list">';
wp_list_comments(array('type'=>'editor_review',
                        'callback'=>'show_editor_reviews',
                        'page'=>'1',
                        'reverse_top_level'=> true));

wp_list_comments(array('type' => 'review',
                      'callback' => 'show_user_reviews'
                      //'reverse_top_level'=> true
                      //'per_page' => 1,
                      /*'page' => $current_page*/));

//echo '<pre>';
//print_r( $wp_query );
//echo '</pre>';

echo '</ul>';
//var_dump($post->ID);
$review_count = absint( get_post_meta( $post->ID, 'tgt_rating_count', true ) );
$review_count += $review_count +  absint( get_post_meta( $post->ID, 'tgt_edior_rating_count', true ) );
if ($review_count == 0){?>
	<div class="content_review">
		<div class="revieww" styles="padding-bottom: 20px;">
			<p class="red no-review" style="margin: 10px 20px">
				<?php _e('This product has no review yet. Be the first to review, click ','re'); ?>
				<a class="go_review"><?php  _e('here', 're') ?></a>
			</p>
		</div>
	</div>
<?php }

$total_page = $wp_query->max_num_comment_pages ;
if ( $total_page > 1 )
{
	echo '<div class="pagination" style="width: auto;">';
	echo '<p>' . __('Pages:') . '</p>';
	paginate_comments_links( array('add_fragment' => '#reviews', 'type' => 'list', 'prev_text' => '«', 'next_text' => '»') );
	echo '</div>';	
}
?>
<script type="text/javascript"><!--
	var ajaxURL = '<?php echo HOME_URL . '/?do=ajax' ?>';
	function vote(review_id, user_id, type, div_id){
		jQuery.ajax({
			type : 'post',
			url: reviewAjax.ajaxurl,
			data: {
				action: 'like_review',
				review_id: review_id,
				user_id: user_id,
				type: type
			},
			beforeSend:function(){
				if (type == 1)
					jQuery('#' + div_id).find('.like-count').html( '<?php echo $helper->image('loading.gif', '') ?>' );
				if (type == 0)
					jQuery('#' + div_id).find('.dislike-count').html( '<?php echo $helper->image('loading.gif' ) ?>' );
			},
			success: function(data){
				if (data.success){
					if (type == 1){
						jQuery('#' + div_id).find('.like-count').html( data.count );
					}
					if (type == 0){
						jQuery('#' + div_id).find('.dislike-count').html( data.count );
					}
					jQuery('#' + div_id).find('.thumb-up').html( '<?php echo $helper->image('thumb_up.png', 'like' ); ?>' );
					jQuery('#' + div_id).find('.thumb-down').html( '<?php echo $helper->image('thumb_down.png', 'dislike' ); ?>' );
				}
			}
		});
	}
-->
</script>