<?php
class Page_Widget extends WP_Widget {	
	function Page_Widget() {		
		$widget_ops = array( 'classname' => 'page-text', 'description' => __('Display content of specified page', 're') );		
		$this->WP_Widget( '', __('RE Page', 're'), $widget_ops );
	}
	
	function form( $instance ) {
		$defaults = array( 'title' => '' , 'page_id' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$pages = get_pages();
		//echo '<pre>';
		//print_r($menus);
		//echo '</pre>';
		?>
		<label for="<?php echo $this->get_field_name('title') ?>"><?php _e('Title', 're');?>:</label>
		<input type="text" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title') ?>" class="widefat" value="<?php echo $instance['title'] ?>" />
		
		<label for="<?php echo $this->get_field_name('page_id'); ?>"><?php _e('Page to show' , 're') ?>:</label>
		<select class="widefat" name="<?php echo $this->get_field_name('page_id'); ?>" id="<?php echo $this->get_field_id('menu_id'); ?>">
			<?php
			foreach( $pages as $page ){
				$selected = '';
				if ( $instance['page_id'] == $page->ID )
					$selected = 'selected="selected"';
				echo '<option value="' . $page->ID . '" '.$selected.' >' . $page->post_title . '</option>';
			}
			?>
		</select>
		<?php
		
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 	= strip_tags( $new_instance['title'] );
		$instance['page_id'] = strip_tags( $new_instance['page_id'] );
		return $instance;
	}
	
	function widget( $args, $instance ) {
		extract( $args );		
		$title 		=  $instance['title'] ;	
		$page_id 	=  $instance['page_id'] ;
		
		echo $before_widget;
		if ( !empty($title) ){
			echo $before_title . $title . $after_title;
		}
		
		$page = get_post( $page_id );		
		echo apply_filters( 'the_content' , $page->post_content );
		
		echo $after_widget;
	}
	
}

register_widget('Page_Widget');