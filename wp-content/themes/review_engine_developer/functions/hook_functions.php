<?php
/**
 * Modify query data
 * @author toannm
 */

add_filter( 'pre_get_posts', 'review_pre_get_posts' );
function review_pre_get_posts($query)
{
	global $wp_query, $wp_rewrite, $current_custom_page, $is_main_query;		
		
	if ( $query->get('post_type') != '' ) return $query;
	
	if ( 	get_query_var('post_type') == 'article' ||
			get_query_var('pagename') == 'articles' ||
			( !empty($_GET['action']) && $_GET['action'] == 'articles' ) )
	{
		$page = get_query_var('page');
		$post_type = $query->get('post_type');
		if ( $post_type == '' )
		{
			$query->init();
			$query->set('post_type', 'article');
			$query->set('posts_per_page', get_option('posts_per_page') );
			$query->set('paged', $page ? $page : 1);
			$query->set('order', 'DESC' );
			$query->set('orderby', 'date' );
		}
		return $query;
	}
	
	if ( is_admin() )
		return $query;

	//
	// if is homepage
	if ( is_category() || is_home() )
	{
		// get sorting
		$default_sort = &get_option(SETTING_SORTING_DEFAULT) ? get_option(SETTING_SORTING_DEFAULT) : 'recent-products';		
		$sorting_type = !empty($_GET['sort_type']) ? $_GET['sort_type'] : $default_sort;
		
		$query = tgt_set_default_query_args($query);
		
		$ratingof = get_option( PRODUCT_SHOW_RATING , '0');		
		
		if ( $query->get('post_type') ){
			switch ( $sorting_type ) {
				case 'recent-products' :
					break;
				case 'top-price' :
					$query->set('meta_key' , 'tgt_product_price');
					$query->set('orderby' , 'meta_value_num');
					$query->set('order' , 'DESC');
					break;
				case 'top-review-count' :
					$query->set('orderby' , 'meta_value_num');
					$query->set('order' , 'DESC');
					if ( $ratingof == '1' )
						$query->set('meta_key' , 'tgt_editor_rating_count');
					else
						$query->set('meta_key' , 'tgt_rating_count');
					break;
				case 'top-view' :
				$query->set('orderby' , 'meta_value');
					$query->set('order' , 'DESC');
					$query->set('meta_key' , 'tgt_view_count');
					break;
				case 'top-rating' :
					$query->set('orderby' , 'meta_value_num');
					$query->set('order' , 'DESC');
					if ( $ratingof == '1' )
						$query->set('meta_key' , 'tgt_editor_rating');
					else
						$query->set('meta_key' , 'tgt_rating');
					break;
			}
		}
	}
	elseif ( is_tag() )
	{
		$query = tgt_set_default_query_args($query);
	}
	elseif ( is_author() )
	{
		//$query = tgt_set_default_query_args($query);
		$query = tgt_set_default_query_args($query);		
	}
	elseif ( is_search() )
	{
		$query = tgt_set_default_query_args($query);		
		if ( isset($_GET['category']) && !empty( $_GET['category'] )  )
		{
			$cats = $_GET['category'];
			$query_cat = '';
			$i = 1;
			if( isset($cats) && is_array($cats)){
				foreach ($cats as $cat) {
					$query_cat .= $cat;
					if ( $i < count($cats)){
						$query_cat .= ',';
					}
					$i++;
				}
				$query->set( 'cat' , $query_cat );
			} else {
				$query->set( 'cat' , $cats );
			}
			//$query->set('cat' , $_GET['c'] );
		}
		$query->set('s' , !empty($_GET['key']) ? $_GET['key'] : '' );
	}
	elseif ( is_feed() )
	{
		$query = tgt_set_default_query_args($query);
		$query->set('posts_per_page', -1);
		$query->set('post_type', true);
	}
	
	return $query;
}

function tgt_set_default_query_args($query)
{
	global $wp_rewrite;
	$page = 1;	
	if ( $wp_rewrite->using_permalinks() )
		$page = get_query_var('paged') ? get_query_var('paged') : 1;
	else
		$page = get_query_var('page') ? get_query_var('page') : 1;
	
	$args = array(
					'post_type' => 'product',
					'posts_per_page' => get_option(SETTING_PRODUCTS_PER_PAGE) ? get_option(SETTING_PRODUCTS_PER_PAGE) : 10,
					'paged' => $page,
					'order' => 'DESC',
					'orderby' => 'date'
					);
	foreach( $args as $key => $value )
		$query->set($key, $value);
	return $query;
}

/**
 * Filter posts_where
 * @author: James
 */
add_filter('posts_where', 'review_post_where' );
function review_post_where($where)
{
	@ini_set('display_errors', 0);
	global $wpdb;
	
	// set filter for author page
	// get post has been reviewed by this author
	if ( is_author() )
	{
		$where = "AND {$wpdb->posts}.post_type = 'product' AND {$wpdb->posts}.post_status = 'publish'";
	}
	if ( is_search () )
	{		
		//$where .=
	}
	if ( (is_category() || is_search()) && !empty($_GET['filter']  ) )
	{
		$posts 		= $wpdb->posts;
		$filter_relation = $wpdb->prefix . 'tgt_filter_relationship';
		$filter_val = $wpdb->prefix . 'tgt_filter_value';
		$filter_value = $_GET['filter'];
		
		// get groups
		$group_query = $wpdb->get_results( $wpdb->prepare("SELECT DISTINCT fvalue.group_id,fvalue.ID FROM {$filter_val} as fvalue
														WHERE fvalue.ID IN ({$filter_value})") );
		$groups = array();
		foreach((array)$group_query as $row ){
			$groups[$row->group_id][] = $row->ID;
		}
		
		$temp 	= $wpdb->prepare("SELECT relation2.post_id FROM {$filter_relation} as relation2
								 JOIN {$filter_val} as val2 ON relation2.filter_value_id = val2.ID
								 WHERE ");
		$c 		= 0;
		foreach( $groups as $id => $group ){
			$v 		= implode(',',$group);
			$temp 	= $wpdb->prepare("SELECT relation2.post_id FROM {$filter_relation} as relation2
								 JOIN {$filter_val} as val2 ON relation2.filter_value_id = val2.ID
								 WHERE ( val2.group_id = {$id} AND val2.ID IN ({$v}) ) ");
			
			$where .= " AND {$posts}.ID IN ($temp) ";
		}
	}
	return $where;
}

/**
 * Filter posts_join
 * @author: James
 */
add_filter('posts_join', 'review_post_join' );
function review_post_join($join)
{
	@ini_set('display_errors', 0);
	global $wp_query, $current_user, $wpdb;
	// set filter for author page
	// get post has been reviewed by this author
	if ( is_author() )
	{
		//$wpdb->users
		$posts 		= $wpdb->posts;
		$users 		= $wpdb->users;
		$comments 	= $wpdb->comments;
		$author 		= get_query_var('author');
		$join 		= " JOIN {$comments} ON {$posts}.ID = {$comments}.comment_post_ID AND {$comments}.user_id = $author ";		
	}
	
	if ( (is_category() || is_search()) && !empty($_GET['filter']  ) )
	{
		$posts 				= $wpdb->posts;
		$filter_relation 	= $wpdb->prefix . 'tgt_filter_relationship';
		$filter_val 		= $wpdb->prefix . 'tgt_filter_value';
		$filter_value 		= $_GET['filter'];
		
		$join 	.= " 	JOIN {$filter_relation} AS relation ON {$posts}.ID = relation.post_id
						JOIN {$filter_val} AS fvalue ON relation.filter_value_id = fvalue.ID
		";
	}
	return $join;
}

// Choose field want to select
add_filter('posts_fields', 'review_get_fields');
function review_get_fields($fields)
{
	global  $wpdb;
	$posts = $wpdb->posts;	
	if(is_author())
	{
		$c = $wpdb->comments;
		$fields = "$posts.*, $c.comment_ID";
	}
	return $fields;
}

//add_filter('posts_orderby', 'review_post_order');
function review_post_order($orderby)
{
	global $wpdb, $custom_query, $current_custom_page;
	
	if ( ( $current_custom_page == 'product_sorting'  ) || !empty( $_GET['sort_type'] ) )
	{
		if(isset($_GET['sort_type'])){
		if ( 	$_GET['sort_type'] == 'top-price' ||
				$_GET['sort_type'] == 'top-view' ||
				$_GET['sort_type'] == 'top-rating' )
			$orderby = " CAST( {$wpdb->postmeta}.meta_value AS UNSIGNED ) DESC";
		}
	}
	if ( is_admin() && isset( $_GET['page'])  && $_GET['page'] == 'review-engine-dashboard' && $custom_query == 'top-product' )
	{
		$orderby = " CAST( {$wpdb->postmeta}.meta_value AS UNSIGNED ) DESC";
	}
	
	return $orderby;
}

/**
 * Function for hook in product_article.php file
 * @author James
 */
function join_article_of_product($join = '')
{
	global $wpdb,$post;
	$p = $wpdb->posts;
	$post_meta = $wpdb->postmeta;
	$join = "JOIN $post_meta  ON $post_meta.post_id=$p.ID AND $post_meta.meta_key = 'tgt_product_id' AND $post_meta.meta_value = ".$post->ID."";
	return $join;
}
function where_article_of_product($where = '')
{
	$where = "AND post_type = 'article' AND post_status='publish'";
	return $where;
}
function article_of_product_limits($limits)
{	
	$limits = "LIMIT 0, 10";
	return $limits;
}
/**
 * get comment page number
 * @author toannm
 */
add_filter('get_comments_pagenum_link' , 'new_get_comments_pagenum_link');
function new_get_comments_pagenum_link($content) {
	$content = str_ireplace('#comments' , '#reviews', $content);
	$page = get_query_var('cpage');
	if ($page == 1)
		$content = str_ireplace('comment-page-1' , '', $content);
	return $content;
}
/**
 * Approve review
 * @author toannm
 */
add_action('wp_set_comment_status','update_review_rating', 10, 2);
function update_review_rating($comment_ID, $status){
	$comment = get_comment($comment_ID);
	if( ! $comment ) {
		return;
	}
	if ( $comment->comment_type == 'review' || $comment->comment_type == 'editor_review' ){
		if ($status == 'approve'){
			update_product_review_rating($comment_ID);
		}
		else{
			update_product_review_rating($comment_ID, true);		
		}
	}
}
/*
 * Auto login hook without password
 */
function auto_login_hook($user_login) {
    if (!is_user_logged_in()) {
        $user = get_userdatabylogin($user_login);
        $user_id = $user->ID;
        wp_set_current_user($user_id, $user_login);
        wp_set_auth_cookie($user_id);
        do_action('wp_login', $user_login);
    }
}
add_action('auto_login', 'auto_login_hook');
?>