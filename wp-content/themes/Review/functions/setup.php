<?php
require_once TEMPLATEPATH . '/functions/widgets/sidebar_advertising_widget.php';
require_once TEMPLATEPATH . '/functions/widgets/image_slider_widget.php';
//require_once TEMPLATEPATH . '/functions/widgets/recent_product_widget.php';
require_once TEMPLATEPATH . '/functions/widgets/recent_article_widget.php';
require_once TEMPLATEPATH . '/functions/widgets/notification_widget.php';
require_once TEMPLATEPATH . '/functions/widgets/users_widget.php';
require_once TEMPLATEPATH . '/functions/widgets/categories_widget.php';
require_once TEMPLATEPATH . '/functions/widgets/footer_links_widget.php';
require_once TEMPLATEPATH . '/functions/widgets/page_widget.php';
require_once TEMPLATEPATH . '/functions/widgets/products_widget.php';
// remove user's bar in the top page for WP 3.1
add_filter('show_admin_bar', 'show_admin_bar_tgt');
function show_admin_bar_tgt( $flag ){
 global $user_ID;
 $show_admin_bar_front = get_metadata('user', $user_ID, 'show_admin_bar_front', true);
 if (empty($show_admin_bar_front))
		return false;
 return $flag;
}
// Setup all default datas in the first time
add_action ('init', 'hook_init_tgt');

function hook_init_tgt(){
	global $wp_rewrite;
	//---------------	some setup
	$lang = get_option('tgt_language', 'default');
	load_textdomain('re', TEMPLATEPATH . "/lang/$lang.mo");
	
	$is_installed = get_option('tgt_data_installed');
	
	if (!$is_installed){
		
		set_default_value();
		// Setup captcha form
		if(get_option(SETTING_ENABLE_CAPTCHA) == '')
		{
				$curr_enable_captcha = array('register'=>'1', 'login'=>'0', 'forgot_pass'=>'0', 'edit_acc'=>'0');
				update_option(SETTING_ENABLE_CAPTCHA,$curr_enable_captcha);
		}
		//tgt_set_default_menu();
		/***
		 * Setup table database 
		 */
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); //for dbDelta function
		global $wpdb; 			
		$table_spec = $wpdb->prefix . 'tgt_spec';
		$table_filter = $wpdb->prefix . 'tgt_filter';
		$table_filter_relationship = $wpdb->prefix . 'tgt_filter_relationship';
		$table_filter_value = $wpdb->prefix . 'tgt_filter_value';
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_spec . " (
			`ID` BIGINT(20) UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
			`term_id` BIGINT(20) NOT NULL,
			`name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
			`value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
			PRIMARY KEY id (`ID`) 
		);";
	   	dbDelta($sql); //create table specification
		
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_filter . " (
			`ID` BIGINT(20) UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
			`term_id` BIGINT(20) NOT NULL,
			`name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,			
			PRIMARY KEY id (`ID`) 
		);";
	   	dbDelta($sql); //create table filter
		
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_filter_value . " (
			`ID` BIGINT(20) UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,	
			`group_id` BIGINT(20) NOT NULL,
			`name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
			`filter_order` bigint(20) Default '0',
			`filter_count` bigint(20),
			PRIMARY KEY id (`ID`) 
		);";
	   	dbDelta($sql); //create table filter value
		
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_filter_relationship . " (
			`ID` BIGINT(20) UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,			
			`filter_value_id` BIGINT(20),
			`post_id` BIGINT(20),
			PRIMARY KEY id (`ID`) 
		);";
	   	dbDelta($sql); //create table filter relationship
			
		$table_spec_category = $wpdb->prefix.'tgt_spec_category';
		$sql = "CREATE TABLE IF NOT EXISTS ". $table_spec_category ." (		
						`spec_id` bigint(20) NOT NULL,
						`term_id` bigint(20) NOT NULL,
						`group_order` bigint(20) ,
						FOREIGN KEY (`spec_id`) REFERENCES $table_spec(`ID`)  ON DELETE CASCADE ON UPDATE CASCADE,
						FOREIGN KEY (`term_id`) REFERENCES ".$wpdb->prefix."terms (`term_id`) ON DELETE CASCADE ON UPDATE CASCADE
						
		);";	
		dbDelta($sql);
		
		$table_spec_value = $wpdb->prefix . 'tgt_spec_value';
		$sql = "CREATE TABLE IF NOT EXISTS ". $table_spec_value ." (
			`spec_value_id` bigint(20) unsigned NOT NULL UNIQUE AUTO_INCREMENT,
						`spec_id` bigint(20) NOT NULL,
						`name` longtext,
						`spec_order` bigint(20),					
						PRIMARY KEY (`spec_value_id`)
		);";	
		dbDelta($sql);
			
		$table_filter_category = $wpdb->prefix.'tgt_filter_category';
		$sql = "CREATE TABLE IF NOT EXISTS ". $table_filter_category ." (		
						`filter_id` bigint(20) NOT NULL,
						`term_id` bigint(20) NOT NULL,
						`group_order` bigint(20) ,
						FOREIGN KEY (`filter_id`) REFERENCES $table_filter(`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
						FOREIGN KEY (`term_id`) REFERENCES ".$wpdb->prefix."terms (`term_id`) ON DELETE CASCADE ON UPDATE CASCADE
		);";	
		dbDelta($sql);
		
		$table_tab = $wpdb->prefix . 'tgt_tab';
		$sql = "CREATE TABLE IF NOT EXISTS ". $table_tab ." (
					`ID` bigint(20) unsigned NOT NULL UNIQUE AUTO_INCREMENT,			
					`name` longtext,
					`tab_order` bigint(20),					
					PRIMARY KEY (`ID`)
		);";	
		dbDelta($sql);
		
		// add new role
		remove_role('reviewer');
		add_role('reviewer', 'Reviewer', array(
			'read' => false,
			'edit_posts' => false,
			'delete_posts' => false));
		// Reset subscriber role
	    remove_role('subscriber');
		add_role('subscriber','Subscriber', array('read'=>false));
		update_option('tgt_data_installed',1);
		update_option('users_can_register', 1);
		// Setup Break comments into pages with data is 1 for paginate of comments
		update_option('page_comments',1);
		
		// action update version 2
		//do_action('tgt_update_version_2');
	}
	/**
	 * create upload folder
	 */
	createUploadFolder();

	/**
	 * Register product type
	 */
	$labels = array(
	    'name' => _x('Agency', 'Post type general name'),
	    'singular_name' => _x('Agency', 'Post type singular name'),
	    'add_new' => _x('Add New', 'Agency'),
	    'add_new_item' => __('Add New Agency'),
	    'edit_item' => __('Edit Agency'),
	    'new_item' => __('New Agency'),
	    'view_item' => __('View Agency'),
	    'search_items' => __('Search Agency'),
	    'not_found' =>  __('No Agency found'),
	    'not_found_in_trash' => __('No Agency found in Trash'), 
	    'parent_item_colon' => ''    ,	 
	  ); 
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array('slug' => get_option('tgt_product_slug') ? get_option('tgt_product_slug') : 'product' ),
		'capability_type' => 'post',		 
		'hierarchical' => false,
		'menu_position' => 4,
		'taxonomies' => array('category','post_tag'),			 
		'supports' => array('title','editor','thumbnail','excerpt','comments','author'),
		'menu_icon' => TEMPLATE_URL . '/images/box.png' 		
	  ); 
	  register_post_type('product', $args);
	
	/**
	 * Register article type
	 */
	 $labels = array(
	    'name' => _x('Article', 'Post type general name'),
	    'singular_name' => _x('Article', 'Post type singular name'),
	    'add_new' => _x('Add New', 'Article'),
	    'add_new_item' => __('Add New Article'),
	    'edit_item' => __('Edit Article'),
	    'new_item' => __('New Article'),
	    'view_item' => __('View Article'),
	    'search_items' => __('Search Article'),
	    'not_found' =>  __('No Article found'),
	    'not_found_in_trash' => __('No Article found in Trash'), 
	    'parent_item_colon' => ''    ,	 
	  ); 
	  $args = array(
		 'labels' => $labels,
		 'public' => true,
		 'publicly_queryable' => true,
		 'show_ui' => true, 
		 'show_in_menu' => true, 
		 'query_var' => true,
		 'rewrite' => 'articles',
		 'capability_type' => 'post',		 
		 'hierarchical' => false,
		 'menu_position' => 5,
	  	 'taxonomies' => array('category'),
		 'has_archive' => true,
		 'supports' => array('title','editor', 'comments'),
	  	 'menu_icon' => TEMPLATE_URL . '/images/article.png' 
	  ); 
		register_post_type('article', $args);
		flush_rewrite_rules();// Permit permalink with new post type. Must to put after register post type.
	/*
	 * Register Nav Menu
	 * @author: Thinking
	 */
		register_nav_menus( array(
		'header_menu' => __( 'Header Menu', 're' ),
		) );
	/*
	 * Register Style
	 * @author: Nhu
	 */
	wp_register_style( 'mainStylesheet', get_bloginfo('stylesheet_url') );
	wp_register_style( 'customStylesheet', TEMPLATE_URL . '/css/custom.css' );
	wp_register_style( 'jqueryratingStylesheet', TEMPLATE_URL . '/css/jquery.rating.css' );
	wp_register_style( 'adminStylesheet', TEMPLATE_URL . '/css/admin.css' );
	wp_register_style( 'jquery_lightbox', TEMPLATE_URL . '/css/jquery.lightbox.css' );
	
	/*
	 * Register Script
	 * @author: Nhu
	 */
	wp_register_script('explode_script', TEMPLATE_URL . '/js/explode.js');
	wp_register_script('function_script', TEMPLATE_URL . '/js/functions.js');
	wp_register_script('jquery_script', TEMPLATE_URL . '/js/jquery.js' );
	wp_register_script('jquery_meta_script', TEMPLATE_URL . '/js/jquery.meta.js' , 'jquery' );
	wp_register_script('jquery_metadata_script', TEMPLATE_URL . '/js/jquery.metadata.js');
	wp_register_script('jquery_rating_script', TEMPLATE_URL . '/js/jquery.rating.js');	
	wp_register_script('jquery_tooltip_script', TEMPLATE_URL . '/js/jquery.tooltip.js');
	wp_register_script('jquery_ui_script', TEMPLATE_URL . '/js/jquery.ui.js');
	wp_register_script('jquery_lightbox_min_script', TEMPLATE_URL . '/js/scripts/jquery.lightbox.min.js');
	wp_register_script('jquery_lightbox', TEMPLATE_URL . '/js/jquery.lightbox.min.js');
   wp_register_script('jquery_validate', TEMPLATE_URL . '/js/validate.js');
   wp_register_script('jquery_jquery_tool', TEMPLATE_URL . '/js/jquery.tools.min.js');
   wp_register_script('script', TEMPLATE_URL . '/js/script.js');
   wp_register_script('jquery_scroll', TEMPLATE_URL . '/js/tiny_scrolbar.js');
	
	/**
	 * add custom feed
	 */
	add_feed('rss2', 'review_custom_feed');
	
	//test
	global $wp_query ;
}


/**
 * customize the feed display
 * @author: toannm
 */
function review_custom_feed()
{
	//var_dump(TEMPLATEPATH . '/feed-rss2.php');
	include ( TEMPLATEPATH . '/feed-rss2.php' ); 
}

/*
 * if admin embedded scripts, wp_footer called and  
 * these script will insert at footer every page
 */
add_action( 'widgets_init', 're_widgets_init' );
function re_widgets_init() {
	
	register_sidebar( array(
		'name' => __( 'Everypage Sidebar', 're' ),
		'id' => 'sidebar-left-widget-area',
		'description' => __( 'This sidebar display in Homepage, Category, Tags ...', 're'),
		'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>'
	) );
	register_sidebar( array(
		'name' => __( 'Homepage Sidebar', 're' ),
		'id' => 'sidebar-hompage-widget-area',
		'description' => __( 'This sidebar display in Homepage only', 're'),
		'before_widget' => '<div class="sidebar-widget">',
		'after_widget' => '</div>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>'
	) );
	register_sidebar( array(
		'name' => __( 'Category Sidebar', 're' ),
		'id' => 'sidebar-category-widget-area',
		'description' => __( 'This sidebar display in Category page only', 're'),
		'before_widget' => '<div class="sidebar-widget">',
		'after_widget' => '</div>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>'
	) );
	register_sidebar( array(
		'name' => __( 'Notification', 're' ),
		'id' => 'homepage-widget-area',
		'description' => __( 'Notification displays at the top of the Homepage, single product page, article list page and category page', 're'),
		'before_widget' => '<div class="notice-sidebar"><div class="notice-widget-wrapper"><div class="notice-widget">',
		'before_title' => '<h2>',	
		'after_title' => '</h2>',
		'after_widget' => '</div></div></div>'
	) );
	register_sidebar( array(
		'name' => __( 'Footer Sidebar', 're' ),
		'id' => 'footer-sidebar',
		'description' => __( 'Located in footer', 're'),
		'before_widget' => '<li id="%1$s" class="%2$s footer-widget">',
		'before_title' => '<h3>',	
		'after_title' => '</h3>',
		'after_widget' => '</li>'
	) );
	//register_sidebar( array(
	//	'name' => __( 'Everypage Notification', 're' ),
	//	'id' => 'homepage-widget-area',
	//	'description' => __( 'Sidebar display at the top of the Homepage, Category page, Tags page', 're'),
	//	'before_widget' => '<div class="notice-sidebar"><div class="notice-widget-wrapper"><div class="notice-widget">',
	//	'before_title' => '<h2>',	
	//	'after_title' => '</h2>',
	//	'after_widget' => '</div></div></div>'
	//) );
	register_widget('Advertising_Sidebar_Widget');  
	register_widget('Image_slider_Widget');
	//register_widget('Recent_Product_Widget');
	register_widget('Recent_Article_Widget');
	register_widget('Notification_Widget');
	register_widget('Users_Widget');
	register_widget('Categories_Widget');
	register_widget('Products_Widget');
}


function facebook_login(){
	// facebook login
	global $user_ID;
	global $cookie;
	//global $is_logout;
	$cookie = null;
	$enable_fb_login = get_option('tgt_fb_login');
	if($enable_fb_login)
	{
		if($user_ID > 0)
		{
			$cookie = null;
			setcookie('fbs_'.FACEBOOK_APP_ID,'');
		}
		elseif($user_ID < 1)
		{
			$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
			if (!empty($cookie)) {
				$fb_user_contents = file_get_contents('https://graph.facebook.com/'.$cookie['uid'].'?access_token='. $cookie['access_token'], true);
					if(!empty($fb_user_contents))
					{
						tgt_login_facebook($fb_user_contents);
						exit;
					}
			}
		}
	}
}

function tgt_login_facebook_auto(){
 
	// if auth enable
	$fb_auth = isset($_COOKIE['fb_auth']) ? $_COOKIE['fb_auth'] : false;
	if ( !$fb_auth ) return;
	
	//delete facebook authecation
	unset( $_COOKIE['fb_auth'] );
	setcookie( 'fb_auth', '0', time() - 3600, '/' );

	$facebook = new Facebook( array(
		'appId' 	=> FACEBOOK_APP_ID,
		'secret'	=> FACEBOOK_SECRET
	));
	
	$fb_userId = $facebook->getUser();
	
	$fb_user_info = $facebook->api('/'.$fb_userId);
	
	// get review User
	$reviewUsers = new WP_User_Query( array(
		'meta_key' 		=> 'tgt_facebook_email',
		'meta_value'	=> $fb_user_info['email']
	));
	
	$result = $reviewUsers->get_results();
	$user = false;
	
	if ( count( $result ) ){	
		foreach( $result as $u ){
			$user = $u;
			break;
		}
	}
	
	// if user has been linked
	if ( isset( $user->ID ) ){
		do_action('auto_login', $user->user_login);
	}
	else{
		global $wp_version;
		if (version_compare($wp_version, '3.1', '<')) {
			require_once("wp-includes/registration.php");
		}
		$password = wp_generate_password(10);	
		$user_nice= str_replace(' ','',$fb_user_info['name']);		
		$new_user = array(
			'user_login' => $fb_user_info['email'],
			'user_nicename' => $user_nice,
			'user_pass' => $password,
			'user_email' => $fb_user_info['email'],
			'display_name' => $fb_user_info['name'],
			'first_name' =>  $fb_user_info['first_name'],
			'last_name' => $fb_user_info['last_name'],
			'show_admin_bar_front' => 'false',
			'show_admin_bar_admin' => 'false',
			'user_url' => $fb_user_info['link']
		);
		$userid = wp_insert_user($new_user);
		if($userid > 0)
		{
			tgt_mailing_facebook_login($user_email, $password);
			update_user_meta($userid, 'tgt_facebook_email', json_decode($fb_user)->email);			
			do_action('auto_login', $fb_user_info['email']);	
		}
	}
 
}

/*
 * @author: James 
 * If admin embedded scripts, wp_footer called and  
 * these script will insert at footer every page
 */
function add_embedded_scripts(){
	$enable_embedded_scripts = &get_option(SETTING_EMBEDDED_SCRIPTS);
	echo $enable_embedded_scripts;
	if (( strpos( stripcslashes( $enable_embedded_scripts ) , '<script') == 0) && $enable_embedded_scripts)
	{
		echo stripcslashes( $enable_embedded_scripts );	
	}
}
add_action('wp_footer', 'add_embedded_scripts');

function tgt_re_update_version_2(){
	tgt_add_more_tables();
}
add_action('tgt_update_version_2', 'tgt_re_update_version_2');

add_custom_background();

add_action('wp_print_scripts' , 'review_print_scripts' );
function review_print_scripts(){
	$url = admin_url( 'admin-ajax.php' );
	$titles = array(__("Not Rating Yet",'re'),
						 __('Abysmal','re'),
						 __('Terrible','re'),
						 __('Poor','re'),
						 __('Mediocre','re'),
						 __('OK','re'),
						 __('Good','re'),
						 __('Very Good','re'),
						 __('Excellent','re'),
						 __('Outstanding','re'),
						 __('Spectacular','re'));
	?>
	<script type="text/javascript">
		//<![CDATA[
		var reviewAjax = {
			ajaxurl: "<?php echo $url ?>"
		};
		var ratingTitles = [
			'<?php _e("Not Rating Yet",'re') ?>',
			'<?php _e("Abysmal",'re') ?>',
			'<?php _e("Terrible",'re') ?>',
			'<?php _e("Poor",'re') ?>',
			'<?php _e("Mediocre",'re') ?>',
			'<?php _e("OK",'re') ?>',
			'<?php _e("Good",'re') ?>',
			'<?php _e("Very Good",'re') ?>',
			'<?php _e("Excellent",'re') ?>',
			'<?php _e("Outstanding",'re') ?>',
			'<?php _e("Spectacular",'re') ?>'
		]
	 //]]>
	</script>
	<?php
	if ( is_admin() ) return ; 
	
	wp_enqueue_script( 'jquery');	
	wp_enqueue_script( 'jquery_lightbox');
	wp_enqueue_script( 'jquery_jquery_tool');
	wp_enqueue_script( 'jquery_meta_script');
	wp_enqueue_script( 'jquery_rating_script');
	wp_enqueue_script( 'jquery_scroll');
	wp_enqueue_script( 'function_script');
	wp_enqueue_script( 'script');
	
	?>
	<?php
}

add_action('wp_print_styles', 'review_print_styles');
function review_print_styles(){
	if ( is_admin() ) return;
	
	wp_enqueue_style( 'jqueryratingStylesheet');
	wp_enqueue_style( 'jquery_lightbox');
	wp_enqueue_style( 'mainStylesheet');
	wp_enqueue_style( 'customStylesheet');
}

add_action('wp_head', 'review_custom_layout');
function review_custom_layout(){
	
	
	//$layout = get_option('tgt_layout');
	$layout = array(
		'nav' => array(
			'bg_url' => '',
			'bg_repeat' => '',
			'bg_color' => '',
			'bg_position' => ''
		),
		'header' => array(
			'bg_url' => '',
			'bg_repeat' => '',
			'bg_color' => '',
			'bg_position' => '',
			'border_color' => '',
			'border_width' => '',
		),
		'sidebar' => array(
			'font_style' => 'italic',
			'font_weight' => 'normal',
			'color' => '#333333',
			'border_position' => array('bottom'),
			'border_color' => '',
			'border_width' => ''
		),
		'title' => array(
			'font_size' => '30',
			'color' => '#4B8DB6',
			'border_position' => array('bottom'),
			'border_color' => '#C8E0EF',
			'border_width' => '4px',
			'border_style' => 'solid',
		)
	);
	?>
	<style type="text/css">
		<?php
		// title
		$border = '';
		foreach( array('top' , 'right', 'bottom' , 'left') as $edge ){
			if ( in_array( $edge, $layout['title']['border_position'] ) )
				$border .= $layout['title']['border_width'] . ' ';
			else
				$border .= " 0px ";
		}
		
		echo ".section-title h1 {
			font-size: {$layout['title']['font_size']}px;
			color: {$layout['title']['color']};
			border-width: {$border} ;
			border-color: {$layout['title']['border_color']};
			border-style: {$layout['title']['border_style']};
			}";
		?>
	</style>
	<?php 
}

add_action('init','review_add_ajax_files');
function review_add_ajax_files()
{
	$path = TEMPLATEPATH . '/ajax';
	$files = array(
		'admin_article_auto_save_trash',
		'ajax_admin_delete_top_product',
		'ajax_admin_filter_delete',
		'ajax_admin_filter_rename',
		'ajax_admin_get_rating',
		'ajax_admin_product_spec_get',
		'ajax_admin_rating_delete',
		'ajax_admin_rating_edit',
		'ajax_admin_search_product',
		'ajax_admin_specification_delete',
		'ajax_admin_specification_rename',
		'ajax_admin_tab_delete',
		'ajax_admin_top_product',
		'ajax_auto_complete',
		'ajax_filter_get',
		'ajax_filter_relationship_get',
		'ajax_front_post_comment',
		'ajax_like_review',
		'ajax_spec_get',
		'ajax_spec_value_get',		
	);
	foreach( $files as $file ){
		include $path . '/' . $file . '.php';
	}
}
