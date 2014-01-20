<div class="col_left primary-sidebar">
<?php
global $helper,$wp_rewrite; 
$args = array(
	'type'                     => 'post',	
	'hide_empty'               => 0,
	'exclude'                  => 1,
	'hierarchical'             => 1,
	'pad_counts'               => false );
$main_category = get_categories($args);
?>

<!-- new widget -->

<!--
	SORTING PRODUCT
-->
<?php if ( false ) {
	global $sorting_pages, $wp_rewrite;
	$curr_category = get_query_var('cat');
	$cat_link = get_category_link( $curr_category );
	$current_type = !empty( $_GET['sort_type'] ) ? $_GET['sort_type'] : 'recent-products';
	$sort_lists = get_option( SETTING_SORTING_TYPES );
	if ( is_array( $sort_lists ) ) {
	?>
<div class="sidebar-widget">
	<h1 class="widget-title"><?php _e('Product Sorting' ,'re') ?></h1>
	<ul class="product-sorting">
		<?php foreach((array) $sort_lists as $sort_type ) {
			$selected = $current_type == $sort_type ? 'class="selected-sorting"' : '';
			if ( $wp_rewrite->using_permalinks() )
				$url = $cat_link . '?sort_type=' . $sort_type;
			else
				$url = $cat_link . '&sort_type=' . $sort_type;
			?>
			<li <?php echo $selected ?>><a href="<?php echo $url ?>"> <?php echo $sorting_pages[$sort_type]['name'] ?> </a></li>
		<?php } ?>
	</ul>
</div>
<!--
	END SORTING PRODUCT
-->
<?php } // end if array
} // end if_category ?>

<?php
	if ( is_active_sidebar( 'sidebar-hompage-widget-area' ) && is_home() ) {
		dynamic_sidebar( 'sidebar-hompage-widget-area' );
	}
	if ( is_active_sidebar( 'sidebar-category-widget-area' ) && is_category() ) {
		dynamic_sidebar( 'sidebar-category-widget-area' );
	}
	if ( is_active_sidebar( 'sidebar-left-widget-area' ) ) {
		dynamic_sidebar( 'sidebar-left-widget-area' );
	}
?>
	
</div>