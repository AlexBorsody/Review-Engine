<?php		
class Advertising_Sidebar_Widget extends WP_Widget {	
	function Advertising_Sidebar_Widget() {
		$widget_ops = array('classname' => 'widget_advertising_sidebar', 'description' => __( 'Advertising put Widget Sidebar Left Area', 're' ) );
		$this->WP_Widget('', __( 'RE Advertising', 're' ), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

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

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];		
		$instance['content'] = $new_instance['content'];
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('Your Advertising','re'),		 
		'content' => '<script type="text/javascript"><!--
		google_ad_client = "pub-5203598262810977";
		google_ad_width = 200;
		google_ad_height = 200;
		google_ad_format = "200x200_as";
		google_ad_type = "text";
		google_ad_channel = "";
		google_color_border = "FFFFFF";
		google_color_bg = "FFFFFF";
		google_color_link = "#333333";
		google_color_text = "000000";
		google_color_url = "#FF5F00";
		//--> </script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>'                            
							) );
		$title = $instance['title'];		
		$content = $instance['content'];		

		echo '<p><label for="'. $this->get_field_id('title') .'">'.__('Title','re').': <textarea class="widefat" id="'. $this->get_field_id('title').'" rows="2" cols="40" name="'. $this->get_field_name('title').'" type="text">'. $title.'</textarea></label></p>';	
		echo '<p><label for="'. $this->get_field_id('content') .'">'.__('Content','re').': <textarea class="widefat" id="'. $this->get_field_id('content').'" rows="10" cols="40" name="'. $this->get_field_name('content').'" type="text">'. $content.'</textarea></label></p>';
		

	}
}

?>