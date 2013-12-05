<?php		
class Categories_Widget extends WP_Widget {	
	function Categories_Widget() {
		$widget_ops = array('classname' => 'wg-categories', 'description' => __( 'Display categories list', 're' ) );
		$this->WP_Widget('', __( 'RE Categories List', 're' ), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;		
		if($instance['title']!=""){
			echo $before_title;
			echo  $instance['title'];
			echo $after_title;
		}
		$sortby 		= $instance['sortby'];		
		global $helper,$wp_rewrite; 
		$args = array(
			'hide_empty'               => $sortby,
			'exclude'                  => 1,
			'hierarchical'             => 1,
			'pad_counts'               => false,
			'style'						=> 'list',
			'title_li'           => '',
		);
		echo '<ul>';
		wp_list_categories($args);
		echo '</ul>';
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['sortby'] = $new_instance['sortby'];
		return $instance;
	}

	function form($instance) {
		$instance 	= wp_parse_args( (array) $instance, array( 'title' => 'Categories',
																			 'sortby' => '1'
																			  ) );
		$title 		= $instance['title'];
		$sortby 		= $instance['sortby'];
		
		echo '<p><label for="'. $this->get_field_id('title') .'">'.__('Title','re').': <textarea class="widefat" id="'. $this->get_field_id('title').'" rows="2" cols="40" name="'. $this->get_field_name('title').'" type="text">'. $title.'</textarea></label></p>';	
		?>		
		<p>			
			<input type="checkbox" name="<?php echo $this->get_field_name('sortby') ?>" value="1" <?php echo ($sortby == 1) ? 'checked="checked"' : ''?> /> <label for=""><?php _e('Hide empty', 're') ?></label> <br />			
		</p>		
		<?php 
	}	
}

?>