<?php
class Notification_Widget extends WP_Widget {	
	function Notification_Widget() {
		$widget_ops = array('classname' => 'notification_sidebar', 'description' => __( 'Notification puts Notification area', 're' ) );
		$this->WP_Widget('', __( 'RE Notification', 're' ), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		
		global $wp_query;
		$page_name_list =  get_query_var('pagename');
		$get_post_name = get_query_var('post_type');
		$index = $instance['index'];
		$category_page = $instance['category'];
		$article = $instance['article'];
		$single_product = $instance['single_product'];
		if( ($index && is_home()) || ( $category_page && is_category()) 
				|| ( $article && ( $page_name_list == 'articles' || $get_post_name == 'article') )
				|| ( $single_product && $get_post_name == 'product' && is_single())  ) {
					
			echo $before_widget;		
			if($instance['title']!=""){
				echo $before_title;
				echo  $instance['title'];
				echo $after_title;
			}				
			
			if($instance['content']!=""){		
				echo $instance['content'];		
			}
			echo $after_widget;
		}
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];		
		$instance['content'] = $new_instance['content'];
		$instance['index'] = $new_instance['index'];
		$instance['category'] = $new_instance['category'];
		$instance['article'] = $new_instance['article'];
		$instance['single_product'] = $new_instance['single_product'];
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('Welcome to Review Engine','re'),		 
		'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec cursus mauris non velit vulputate non consectetur leo congue. Aliquam erat volutpat. Phasellus interdum nisi et ligula fermentum eu tristique lacus scelerisque. Integer ultricies consectetur dui, vitae sodales tortor adipiscing ac. Nullam odio libero, faucibus ut vulputate sit amet, dignissim id nulla. Aliquam sodales luctus suscipit. </p>',
		'index' => '1', 'category' => '1', 'article' => '1', 'single_product' => 1,                      
							 ));
		$title = $instance['title'];		
		$content = $instance['content'];	
		$show_index = $instance['index'];
		$show_category_page = $instance['category'];
		$show_article_page = $instance['article'];
		$show_single_product = $instance['single_product'];

		echo '<p><label for="'. $this->get_field_id('title') .'">'.__('Title','re').': <textarea class="widefat" id="'. $this->get_field_id('title').'" rows="2" cols="40" name="'. $this->get_field_name('title').'" type="text">'. $title.'</textarea></label></p>';	
		echo '<p><label for="'. $this->get_field_id('content') .'">'.__('Content','re').': <textarea class="widefat" id="'. $this->get_field_id('content').'" rows="10" cols="40" name="'. $this->get_field_name('content').'" type="text">'. $content.'</textarea></label></p>';
		echo '<p><label for="'. $this->get_field_id('show_page') .'">'.__('Show in page','re').':';
		?>
		<p>			
			<input type="checkbox" name="<?php echo $this->get_field_name('index') ?>" value="1" <?php echo ($show_index == 1) ? 'checked="checked"' : ''?> /> <label for=""><?php _e('Home page', 're') ?></label> <br />			
		</p>
		<p>			
			<input type="checkbox" name="<?php echo $this->get_field_name('category') ?>" value="1" <?php echo ($show_category_page == 1) ? 'checked="checked"' : ''?> /> <label for=""><?php _e('Category page', 're') ?></label> <br />			
		</p>	
		<p>			
			<input type="checkbox" name="<?php echo $this->get_field_name('article') ?>" value="1" <?php echo ($show_article_page == 1) ? 'checked="checked"' : ''?> /> <label for=""><?php _e('Article list page', 're') ?></label> <br />			
		</p>
		<p>			
			<input type="checkbox" name="<?php echo $this->get_field_name('single_product') ?>" value="1" <?php echo ($show_single_product == 1) ? 'checked="checked"' : ''?> /> <label for=""><?php _e('Single product page', 're') ?></label> <br />			
		</p>		
		<?php 
		echo 	'</label>
			 </p>';

	}
}
?>