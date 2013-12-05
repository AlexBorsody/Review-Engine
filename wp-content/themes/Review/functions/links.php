<?php
global $custom_pages, $sorting_pages;
$custom_pages = array('register','login','logout','edit_profile','forgot_password','login_facebook','message','product_suggest','compare','articles');
$sorting_pages = array(
							'recent-products' => array(
														'name' => __('Latest Products', 're'),
														'id' =>'recent-products'
													),
							'top-price' => array(
														'name' => __('Top Price','re') ,
														'id' => 'top-price'),
							'top-review-count' => array(
														'name' => __('Top Review Count','re') ,
														'id' => 'top-review-count'),
							'top-view' => array(
														'name' => __('Top View','re'),
														'id' => 'top-view'),
							'top-rating' => array(
														'name' => __('Top Rating','re'),
														'id' => 'top-rating'));

add_filter('rewrite_rules_array','wp_insertMyRewriteRules');
add_filter('init','flushRules');
add_filter('query_vars', 'ce_queryvars' );

// Remember to flush_rules() when adding rules
function flushRules(){
	global $wp_rewrite;
   	$wp_rewrite->flush_rules();
}

// Adding a new rule
function wp_insertMyRewriteRules($rules)
{
	global $custom_pages, $sorting_page;
	
	$newrules = array();	
	$newrules['(news)/page/(\d*)$'] 		= 'index.php?pagename=news&paged=$matches[2]';
	$newrules['(articles)/page/(\d*)$'] = 'index.php?pagename=articles&page=$matches[2]';
	$newrules['(top-price)$'] = 'index.php?sort_type=price';
	$newrules['(top-review-count)$'] = 'index.php?sort_type=top-review-count';
	$newrules['(top-view)$'] = 'index.php?sort_type=top-view';
	$newrules['(top-rating)$'] = 'index.php?sort_type=top-rating';
	$newrules['(login)$'] = 'index.php?pagename=login';
	foreach( (array)$custom_pages as $link )
	{
		$newrules[$link . '$'] = 'index.php?pagename=' . $link;
	}
	add_rewrite_tag('%step%', '[A-Z]{1}', 'step=');	
	return $newrules + $rules;
}

function ce_queryvars($qvars)
{
	$qvars[] = 'paged';
	$qvars[] = 'id';
	$qvars[] = 'action';
	$qvars[] = 'type';
	$qvars[] = 'pagename';
	$qvars[] = 'sort_type';
	return $qvars;
}

/*
 * "functions_sub.php" inlude
 */
add_action('template_redirect', 'hook_template_redirect_tgt');
function hook_template_redirect_tgt(){
	// get page name	
	global $wp_query, $wp_rewrite;
	
	if ( is_admin() || is_feed() ) return;
	
	if ( $wp_rewrite->using_permalinks() )
	{		
		$action = get_query_var('post_type') ? get_query_var('post_type') : get_query_var('pagename');
		if ( isset($_GET['action']) && $_GET['action'] == 'forgot_password' )
			$action = $_GET['action'];
	}
	else
	{
		if ( !empty($_GET['type']) && $_GET['type'] == 'articles' )
			$action = $_GET['type'];
		else
			$action = empty($_GET['action']) ? false : $_GET['action'];
			
		set_query_var('pagename', $action);	
	}
	
	// redirect
	if ( ( !empty($_GET['type']) && $_GET['type'] == 'articles' ) || (get_query_var('pagename') == 'articles') ||
			( get_query_var('post_type') == 'article' && !is_single() ) ) {
		
		if(get_option(SETTING_ENABLE_ARTICLE,true) == 1)
		{
	        include PATH_PAGES . DS. 'articles/index.php';
			exit;  
		}else
		{
		    include TEMPLATEPATH . '/404.php';
		    exit;
		}
	}
	
	if (!empty($_GET['redirect']) ){
		include PATH_PAGES . DS . 'redirect.php';
	}
	
	if ( !empty( $action ) ) {
	   switch ($action){		
			case 'register':
	            include PATH_PAGES . DS. 'register.php';
           		exit;
			
			// Toannm: message pages
			case 'message':
	            include PATH_PAGES . DS. 'message.php';
            exit;
				
			// Toannm: product suggest
			case 'product_suggest':
	            include PATH_PAGES . DS. 'product_suggest.php';
            exit;
			
			// James: Link to user's profile page
			case 'compare':
				include PATH_PAGES . DS . 'compare.php';
				exit;

            case 'login':
	            include PATH_PAGES . DS. 'login.php';
            	exit;
            case 'edit_profile':
	            include PATH_PAGES . DS. 'edit_profile.php';
            	exit;
			case 'forgot_password':
	            include PATH_PAGES . DS. 'forgot_password.php';
            	exit;
            case 'login_facebook':
	            include PATH_PAGES . DS. 'login_facebook.php';
            	exit;
            case 'logout':
	            include PATH_PAGES . DS. 'logout.php';
            	exit;
            
	   }
	}
	
}

/**
 * Retrieve custom link used in Review Engine
 */
function re_get_link($pagename, $args = array()){
	global $wp_rewrite;
	$pages = array(
		'login' 			=> 'login',
		'register' 			=> 'register',
		'forgot_password' 	=> 'forgot_password'
	);
	if ( !in_array($pagename, $pages) ) return false;

	// generate permalink
	$link = get_bloginfo('url');
	if ( $wp_rewrite->using_permalinks() )
		$link .= '/' . $pages[$pagename] ;
	else 
		add_query_arg('action',  $pages[$pagename], $link);

	// add query args
	$link = add_query_arg( $args, $link );
	return $link;
}