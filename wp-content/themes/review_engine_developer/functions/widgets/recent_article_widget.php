<?php
class Recent_Article_Widget extends WP_Widget {	
	function Recent_Article_Widget() {		
		$widget_ops = array( 'classname' => 'recentarticle', 'description' => __('Display article in the sidebar.', 're') );		
		$this->WP_Widget( '', __('RE Recent Article', 're'), $widget_ops );
	}	
	function widget( $args, $instance ) {
		extract( $args );		
		$title 		=  $instance['title'] ;	
		$recent 		=  $instance['recent'] ;
		echo $before_widget;		
		if ( $title ){
			echo $before_title . $title . $after_title;	
		}	
		global $post,$query_contraint;
		$args = array(					
				'post_type' 	=>	'article',
				'post_status'   	=> 'publish',
				'showposts'		=> $instance['recent']
				);		
		wp_reset_query();			
			query_posts($args);		
			if(have_posts()) {					
		?>	
		<div class="widget-products">
		<?php while (have_posts()){ the_post();	$post_id = $post->ID; ?>		
		<div class="widget-item">
			<h3><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h3>
			
			<?php
			 if( has_post_thumbnail() ){
			 	echo '<div class="widget-thumb">';				  
				  echo wp_get_attachment_image( get_post_thumbnail_id(), array(77, 77) );	
				echo '</div>';
			 }
			?> 				
			<p class="widget-intro"><?php echo substr(strip_tags($post->post_content),0,233).'...'; ?></p>
			<div class="clear"></div>
			<p class="widget-stat">
				<span class="widget-stat-time"> <?php echo the_time(get_option('date_format')); ?> </span>
				<span class="widget-stat-comments"> <?php
				 	echo $post->comment_count == 0 ? '0 Comment' : _n('%d Comment', '%d Comments', $post->comment_count, 're');					
				?> </span>				
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
		$instance['recent'] = strip_tags( $new_instance['recent'] );		
		return $instance;
	}
	function form( $instance ) {
		$defaults = array( 'title' => __('Recent Article', 're'), 'recent' => '5', );
		$instance = wp_parse_args( (array) $instance, $defaults ); 		
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'recent' ); ?>"><?php _e('Number of article to show', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'recent' ); ?>" name="<?php echo $this->get_field_name( 'recent' ); ?>" value="<?php echo $instance['recent']; ?>" style="width:30px;" class="widefat" type="text" />
		</p>
	<?php
	}
}