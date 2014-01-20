<?php
class Products_Widget extends WP_Widget {	
	function Products_Widget() {		
		$widget_ops = array( 'classname' => 'recentproduct', 'description' => __('Display products in the sidebar.', 're') );		
		$this->WP_Widget( '', __('RE Products', 're'), $widget_ops );
	}	
	function widget( $args, $instance ) {
		extract( $args );
		
		wp_reset_query();
		$title 		=  $instance['title'] ;	
		$recent 		=  $instance['recent'] ;	
		$sortby		=  $instance['sortby'] ;	
		echo $before_widget;		
		if ( $title ){
			echo $before_title . $title . $after_title;	
		}	
		global $post,$query_contraint;
		$args = array(					
				'post_type' 	=>	'product',
				'post_status'   	=> 'publish',				
				'showposts'		=> $instance['recent']
				);		
		switch ( $sortby ) {
			case 'recent':				
				$args['order'] = 'DECS';
				break;
			case 'rate_user':	
				$args['meta_key'] = PRODUCT_RATING;
				$args['orderby'] = 'meta_value_num';
				$args['order'] = 'DECS';					
				break;
			case 'rate_reviewer':
				$args['meta_key'] = PRODUCT_EDITOR_RATING;
				$args['orderby'] = 'meta_value_num';
				$args['order'] = 'DECS';				
				break;
			case 'view_count':
				$args['meta_key'] = PRODUCT_VIEW_COUNT;
				$args['orderby'] = 'meta_value_num';
				$args['order'] = 'DECS';				
				break;
			case 'random':				
				$args['orderby'] = 'rand';
				break;
		}
		global $wp_query;
		query_posts($args);
		//echo '<pre>';
		//print_r( $wp_query );
		//echo '</pre>';
		
		if(have_posts()) {					
		?>	
		<div class="widget-products">
		<?php while (have_posts()){ the_post();	$post_id = $post->ID; ?>		
		<div class="widget-item">
			<h3><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h3>
			<div class="widget-thumb">
			<?php
			 if( has_post_thumbnail() ){				  
				  echo wp_get_attachment_image( get_post_thumbnail_id(), array(77, 77) );	
			 }
			 else
				 echo '<img src="'.TEMPLATE_URL.'/images/no_image.jpg" style="width:77px;height:77px;" alt=""/>';
			 ?> 				
				<p class="widget-rating rating">
				<?php $rating = get_post_meta($post_id, get_showing_rating() ,true);
				tgt_display_rating( $rating, 'widget_top_rating_'.$post_id);?>
				</p>
			</div>
			<p class="widget-intro"><?php echo substr(strip_tags($post->post_content),0,233).'...'; ?></p>
			<div class="clear"></div>
			<p class="widget-stat">
				<span class="widget-stat-time"> <?php echo the_time(get_option('date_format')); ?> </span>
				<span class="widget-stat-comments"><?php echo tgt_comment_count( 'No Revew', '%d Review', '%d Reviews', $post->comment_count); ?></span>				
			</p>
			<div class="clear"></div>
		</div>
		<?php } ?>
		</div>
		<div class="clear"></div>
		<?php 
			} 	
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );	
		$instance['sortby'] = strip_tags( $new_instance['sortby'] );
		$instance['recent'] = strip_tags( $new_instance['recent'] );		
		return $instance;
	}
	function form( $instance ) {
		$defaults = array( 'title' => __('Products', 're'), 'sortby' => 'recent', 'recent' => '5', );
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		$sortby 		= $instance['sortby'];		
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="sortby"><?php _e('Sort By:','re') ?></label> <br />
			<select name="<?php echo $this->get_field_name('sortby') ?>" id="<?php echo $this->get_field_id('title') ?>" class="widefat">
				<option value="recent" <?php echo $sortby == 'recent' ? 'selected="selected"' : ''?> ><?php _e('Date','re') ?></option>
				<option value="rate_user"  <?php echo $sortby == 'rate_user' ? 'selected="selected"' : ''  ?> ><?php _e('User\'s rating','re') ?></option>
				<option value="rate_reviewer" <?php echo $sortby == 'rate_reviewer' ? 'selected="selected"' : ''?> ><?php _e('Editor\'s rating','re') ?></option>
				<option value="view_count" <?php echo $sortby == 'view_count' ? 'selected="selected"' : ''?> ><?php _e('Product\'s View Count','re') ?></option>
				<option value="random" <?php echo $sortby == 'random' ? 'selected="selected"' : ''?> ><?php _e('Random','re') ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'recent' ); ?>"><?php _e('Number of product to show', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'recent' ); ?>" name="<?php echo $this->get_field_name( 'recent' ); ?>" value="<?php echo $instance['recent']; ?>" style="width:30px;" class="widefat" type="text" />
		</p>
	<?php
	}
}