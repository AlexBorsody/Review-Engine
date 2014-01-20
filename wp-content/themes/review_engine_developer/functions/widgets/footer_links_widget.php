<?php
class Footer_Links_Widget extends WP_Widget {	
	function Footer_Links_Widget() {		
		$widget_ops = array( 'classname' => 'links', 'description' => __('Display specified menu links', 're') );		
		$this->WP_Widget( '', __('RE Footer links', 're'), $widget_ops );
	}
	
	function form( $instance ) {
		$defaults = array( 'title' => '' , 'menu_id' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$menus = wp_get_nav_menus();
		//echo '<pre>';
		//print_r($menus);
		//echo '</pre>';
		?>
		<label for="<?php echo $this->get_field_name('title') ?>"><?php _e('Title', 're');?>:</label>
		<input type="text" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title') ?>" class="widefat" value="<?php echo $instance['title'] ?>" />
		
		<label for="<?php echo $this->get_field_name('menu_id'); ?>"><?php _e('Menu to show' , 're') ?>:</label>
		<select class="widefat" name="<?php echo $this->get_field_name('menu_id'); ?>" id="<?php echo $this->get_field_id('menu_id'); ?>">
			<?php
			foreach( $menus as $menu ){
				$selected = '';
				if ( $instance['menu_id'] == $menu->term_id )
					$selected = 'selected="selected"';
				echo '<option value="' . $menu->term_id . '" '.$selected.' >' . $menu->name . '</option>';
			}
			?>
		</select>
		<?php
		
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 	= strip_tags( $new_instance['title'] );
		$instance['menu_id'] = strip_tags( $new_instance['menu_id'] );
		return $instance;
	}
	
	function widget( $args, $instance ) {
		extract( $args );		
		$title 		=  $instance['title'] ;	
		$menu_id 	=  $instance['menu_id'] ;
		
		echo $before_widget;
		if ( !empty($title) ){
			echo $before_title . $title . $after_title;
		}
		
		wp_nav_menu(
			array(
				'menu' => $menu_id,
				'container' => false,
				'menu_class' => 'widget-links'
			)
		);
		
		echo $after_widget;
	}
	
}

register_widget('Footer_Links_Widget');