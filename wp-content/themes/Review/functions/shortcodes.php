<?php
function tgt_treats_formatter($content) {
	$new_content = '';	
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';	
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';	
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);	
	foreach ($pieces as $piece) {		
		if (preg_match($pattern_contents, $piece, $matches)) {			
			$new_content .= $matches[1];
		} else {			
			$new_content .= wptexturize(wpautop($piece));		
		}
	}	
	return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'tgt_treats_formatter', 99);
add_filter('widget_text', 'tgt_treats_formatter', 99);

add_shortcode( 'cus', 'cus_col_shortcode' );
function cus_col_shortcode( $atts, $content = null ) {	
	extract(shortcode_atts(array(
	"width" => ''
	), $atts));
	return "<div style='width:".$width."' class='shortcode columns_div first'>".do_shortcode($content).'</div>';	
}
add_shortcode( 'cus_last', 'cus_last_col_shortcode' );
function cus_last_col_shortcode( $atts, $content = null ) {		
	extract(shortcode_atts(array(
	"width" => ''
	), $atts));
	return "<div style='width:".$width."' class='shortcode columns_div last_col'>".do_shortcode($content).'</div><div class="clearboth"></div>';	
}
add_shortcode( 'two', 'two_col_shortcode' );
function two_col_shortcode( $atts, $content = null ) {	
	return "<div class='shortcode columns_div two_col first'>".do_shortcode($content).'</div>';	
}
add_shortcode( 'two_last', 'two_last_col_shortcode' );
function two_last_col_shortcode( $atts, $content = null ) {	
	return "<div class='shortcode columns_div two_col last_col'>".do_shortcode($content).'</div><div class="clearboth"></div>';	
}
add_shortcode( 'three', 'three_col_shortcode' );
function three_col_shortcode( $atts, $content = null ) {	
	return "<div class='shortcode columns_div three_col first'>".do_shortcode($content).'</div>';	
}
add_shortcode( 'three_last', 'three_last_col_shortcode' );
function three_last_col_shortcode( $atts, $content = null ) {	
	return "<div class='shortcode columns_div three_col last_col'>".do_shortcode($content).'</div><div class="clearboth"></div>';	
}

add_shortcode( 'bq_left', 'bq_left_shortcode' );
function bq_left_shortcode( $atts, $content = null ) {	
	return "<div class='shortcode blockquote-left'>".do_shortcode($content).'</div>';	
}
add_shortcode( 'bq_right', 'bq_right_shortcode' );
function bq_right_shortcode( $atts, $content = null ) {	
	return "<div class='shortcode blockquote-right' align = 'center'>".do_shortcode($content).'</div>';	
}