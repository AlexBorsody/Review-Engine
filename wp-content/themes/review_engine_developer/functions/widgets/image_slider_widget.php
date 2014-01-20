<?php
class Image_slider_Widget extends WP_Widget {	
	function Image_slider_Widget() {		
		$widget_ops = array( 'classname' => 'imagesslider', 'description' => __('Display your rotating images in the sidebar.', 're') );		
		$this->WP_Widget( '', __('RE Slider Images', 're'), $widget_ops );
	}	
	function widget( $args, $instance ) {
		extract( $args );		
		$title 		=  $instance['title'] ;
		$time 		=  $instance['time'] ;
		$image1 		=  $instance['image1'] ;
		$image2 		=  $instance['image2'] ;
		$image3 		=  $instance['image3'] ;
		$image4 		=  $instance['image4'] ;
		$image5 		=  $instance['image5'] ;
		$urlimage1 		=  $instance['urlimage1'] ;
		$urlimage2 		=  $instance['urlimage2'] ;
		$urlimage3 		=  $instance['urlimage3'] ;
		$urlimage4 		=  $instance['urlimage4'] ;
		$urlimage5 		=  $instance['urlimage5'] ;
		echo $before_widget;		
		if ( $title ){
			echo $before_title . $title . $after_title;	
		}				
		?>
		<div class="widget-review-slider fadein">
			<ul>
			<?php if (!empty($image1)) {	?>
				<li class="review-slider-item">
					<?php if (!empty($urlimage1)){ echo '<a href="'.$urlimage1.'" >'; }?>
					<?php echo '<img src="'.$image1.'" />'; ?>
					<?php if (!empty($urlimage1)){ echo '</a>'; }?>
				</li>
			<?php } ?>
			<?php if (!empty($image2)) {	 ?>
				<li class="review-slider-item">
					<?php if (!empty($urlimage2)){ echo '<a href="'.$urlimage2.'" >'; }?>
					<?php echo '<img src="'.$image2.'" />'; ?>
					<?php if (!empty($urlimage2)){ echo '</a>'; }?>
				</li>
			<?php } ?>
			<?php if (!empty($image3)) { ?>
				<li class="review-slider-item">
				<?php if (!empty($urlimage3)){ echo '<a href="'.$urlimage3.'" >'; }?>
					<?php echo '<img src="'.$image3.'" />'; ?>
					<?php if (!empty($urlimage3)){ echo '</a>'; }?>
				</li>				
			<?php } ?>
			<?php if (!empty($image4)) {?>
				<li class="review-slider-item">
				<?php if (!empty($urlimage4)){ echo '<a href="'.$urlimage4.'" >'; }?>
					<?php echo '<img src="'.$image4.'" />'; ?>
					<?php if (!empty($urlimage4)){ echo '</a>'; }?>
				</li>			
			<?php } ?>
			<?php if (!empty($image5)) {	 ?>
				<li class="review-slider-item">
				<?php if (!empty($urlimage5)){ echo '<a href="'.$urlimage5.'" >'; }?>
					<?php echo '<img src="'.$image5.'" />'; ?>
					<?php if (!empty($urlimage5)){ echo '</a>'; }?>
				</li>			
			<?php } ?>
			</ul>
		</div>
		
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('.widget-review-slider ul li').hide();
			
			function slidingLoop(){
				var parent = jQuery('.widget-review-slider ul');
				
				jQuery('.widget-review-slider ul li:first').fadeIn(500).delay(2000).fadeOut(500, function(){
					jQuery(this).appendTo( jQuery(this).parent() );
					slidingLoop();
				});
			};
			slidingLoop();

		});
		</script>
		<?php 		
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['time'] = strip_tags( $new_instance['time'] );	
		$instance['image1'] = strip_tags( $new_instance['image1'] );
		$instance['image2'] = strip_tags( $new_instance['image2'] );
		$instance['image3'] = strip_tags( $new_instance['image3'] );
		$instance['image4'] = strip_tags( $new_instance['image4'] );
		$instance['image5'] = strip_tags( $new_instance['image5'] );	
		$instance['urlimage1'] = strip_tags( $new_instance['urlimage1'] );
		$instance['urlimage2'] = strip_tags( $new_instance['urlimage2'] );
		$instance['urlimage3'] = strip_tags( $new_instance['urlimage3'] );
		$instance['urlimage4'] = strip_tags( $new_instance['urlimage4'] );
		$instance['urlimage5'] = strip_tags( $new_instance['urlimage5'] );
		return $instance;
	}
	function form( $instance ) {
		$defaults = array( 'title' => __('Images Slider', 're'), 'time' => '10000', 
		'image1' => '',
		'urlimage1' => '',
		'image2' => '',
		'urlimage2' => '',
		'image3' => '',
		'urlimage3' => '',
		'image4' => '',
		'urlimage4' => '',
		'image5' => '',
		'urlimage5' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 	
		
		?>		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 're'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'time' ); ?>"><?php _e('Milliseconds:', 're'); ?></label>
			<input id="<?php echo $this->get_field_id( 'time' ); ?>" name="<?php echo $this->get_field_name( 'time' ); ?>" value="<?php echo $instance['time']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image1' ); ?>"><?php _e('Image #1', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'image1' ); ?>" name="<?php echo $this->get_field_name( 'image1' ); ?>" value="<?php echo $instance['image1']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'urlimage1' ); ?>"><?php _e('Url Image #1', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'urlimage1' ); ?>" name="<?php echo $this->get_field_name( 'urlimage1' ); ?>" value="<?php echo $instance['urlimage1']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image2' ); ?>"><?php _e('Image #2', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'image2' ); ?>" name="<?php echo $this->get_field_name( 'image2' ); ?>" value="<?php echo $instance['image2']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'urlimage2' ); ?>"><?php _e('Url Image #2', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'urlimage2' ); ?>" name="<?php echo $this->get_field_name( 'urlimage2' ); ?>" value="<?php echo $instance['urlimage2']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image3' ); ?>"><?php _e('Image #3', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'image3' ); ?>" name="<?php echo $this->get_field_name( 'image3' ); ?>" value="<?php echo $instance['image3']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'urlimage3' ); ?>"><?php _e('Url Image #3', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'urlimage3' ); ?>" name="<?php echo $this->get_field_name( 'urlimage3' ); ?>" value="<?php echo $instance['urlimage3']; ?>" class="widefat" type="text" />
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id( 'image4' ); ?>"><?php _e('Image #4', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'image4' ); ?>" name="<?php echo $this->get_field_name( 'image4' ); ?>" value="<?php echo $instance['image4']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'urlimage4' ); ?>"><?php _e('Url Image #4', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'urlimage4' ); ?>" name="<?php echo $this->get_field_name( 'urlimage4' ); ?>" value="<?php echo $instance['urlimage4']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image5' ); ?>"><?php _e('Image #5', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'image5' ); ?>" name="<?php echo $this->get_field_name( 'image5' ); ?>" value="<?php echo $instance['image5']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'urlimage5' ); ?>"><?php _e('Url Image #5', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'urlimage5' ); ?>" name="<?php echo $this->get_field_name( 'urlimage5' ); ?>" value="<?php echo $instance['urlimage5']; ?>" class="widefat" type="text" />
		</p>
	<?php
	}
}