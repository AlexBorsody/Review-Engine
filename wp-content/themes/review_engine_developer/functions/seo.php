<?php
add_filter('wp_title', 'add_title');
add_action('wp_head', 'add_header');

function add_title( $title ) {
	if( get_option(SETTING_ENABLE_SEO) == 1 ) {
		global $wpdb, $wp_query, $post;
			$post_login = '';
			$post_firstname = '';
			$post_lastname = '';
			$post_nicename = '';
			
			$page_login = '';
			$page_firstname = '';
			$page_lastname = '';
			$page_nicename = '';
		if (isset($post)) {
			$id_user = $post->post_author;
			$post_firstname = get_user_meta($id_user, 'first_name');
			$post_lastname = get_user_meta($id_user, 'last_name');
			$post_login = get_user_meta($id_user, 'nickname');
			$post_nicename = get_user_meta($id_user, 'nickname');
			
			$post_login = ($post_login[0]) ? $post_login[0] : '';
			$post_firstname = ($post_firstname[0]) ? $post_firstname[0] : '';
			$post_lastname = ($post_lastname[0]) ? $post_lastname[0] : '';
			$post_nicename = ($post_nicename[0]) ? $post_nicename[0] : '';
			
			$page_login = ($post_login) ? $post_login : '';
			$page_firstname = ($post_firstname) ? $post_firstname : '';
			$page_lastname = ($post_lastname) ? $post_lastname : '';
			$page_nicename = ($post_nicename) ? $post_nicename : '';
		}
		
		$titles = get_bloginfo('name');
		$m = get_query_var('m');
		$array = array ( '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05'=> 'May', '06' => 'June',
							'07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
						);
		if( $m != 0 ) {
			$my_year = substr($m, 0, 4);
			$my_month = substr($m, 4, 2) ;
		}
		else {
			$my_year = get_query_var( 'year');
			$my_month = get_query_var('monthnum');
			if( $my_month < 10 ){
				$my_month = '0'.$my_month;
			}
		}
		if(isset( $my_month) && $my_month != '00') {
			$monthString = $array[$my_month];
			$date_achive = $my_year .' '. ($my_month ? $monthString : "");
		}
		else 
			 $date_achive = '';
		
		$search_page = get_query_var('s');	
		$title_search = sprintf(__('Search Results %1$s '), strip_tags($search_page));
		
		if(get_option(SETTING_HOME_TITLE) != '') {
			$home_tit = get_option(SETTING_HOME_TITLE);
		}
		else{
			$home_tit = get_option('blogname');
		}
		
		if( get_option(SETTING_HOME_DESC) != ''){
			$des = get_option(SETTING_HOME_DESC);
		}
		else{
			$des = get_option('blogdescription');
		}
		
		$title = array( '%blog_title%'       		=> $home_tit,
						'%blog_description%' 		=> $des,
						'%post_title%'      		=> single_post_title( '', false ),
						'%category_title%'   		=> single_term_title( '', false ),
						'%category%'         		=> single_term_title('', false),
						'%post_author_login%'		=> $post_login,
						'%post_author_nicename%'	=> $post_nicename,
						'%post_author_firstname%'  => $post_firstname,
						'%post_author_lastname%'    => $post_lastname,
						'%page_title%'              => single_post_title( '', false ),
						'%page_author_login%'       => $page_login,
						'%page_author_nicename%'    => $page_nicename,
						'%page_author_firstname%'   => $page_firstname,
						'%page_author_lastname%'    => $page_lastname,
						'%category_title%'          => single_term_title( '', false ),
						'%date%'                    => $date_achive,
						'%tag%'                     => single_term_title( '', false ),
						'%search%'                  => $title_search,
						'%description%'             => get_option('blogdescription'),
						'%404_title%'               =>__('Page not pound', 're'),
						'%page%'                   => get_query_var('paged'),
						'%articles%'               => __('List Articles page', 're'),
						'%profile%'				   => __('Edit your profile', 're'),
						'%login%'				   => __('Login Page', 're'),
				);
			
		if(is_home()){
			$titles = get_bloginfo('name');
			$action = get_query_var('action');
			
			if ( isset($action) && $action == 'register') {
				$titles = get_option(SETTING_REGISTER_TITLE);
				if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
					$titles = __('Register', 're');
				}
			}
			else if ( isset( $action ) && $action == 'login' ){
				$titles = get_option(SETTING_LOGIN_TITLE);
				if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
					$titles = __('Login', 're');
				}
			}
			else if ( isset( $action ) && $action == 'logout'){
				$titles = get_option(SETTING_LOGOUT_TITLE);
				if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
					$titles = __('Logout', 're');
				}
			}
			else if ( isset( $action ) && $action == 'edit_profile'){
				$titles = get_option(SETTING_EDIT_PROFILE);
				if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
					$titles = __('Edit profile', 're');
				}
			}
			else if ( isset( $action) && $action == 'forgot_password') {
				$titles = get_option(SETTING_FORGOT_PASS);
				if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
					$titles = __('Forgot password', 're');
				}
			}
			else if ( isset( $action ) && $action == 'login_facebook'){
				$titles = get_option(SETTING_LOGIN_FACEBOOK);
				if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
					$titles = __('Login Facebook', 're');
				}
			}
			else if( isset( $action ) && $action == 'message'){
				$titles = get_option(SETTING_MESSAGE);
				if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
					$titles = __('Message', 're');
				}
			}
			else if( isset( $action ) && $action == 'product_suggest') {
				$titles = get_option(SETTING_PRODUCT_SUGGEST);
				if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
					$titles = __('Suggest product', 're');
				}
			}
			else if ( isset( $action ) && $action == 'compare') {
				$titles = get_option(SETTING_ARTICLE_TITLE);
				if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
					$titles = __('List articles page', 're');
				}
			}
			else{
				$titles = '';
			}
			
			if( $titles != ''){
				$titles = $titles;
			}
			else{
				$titles = $home_tit;
			}
		}
		else if ( is_404() ){
			$page_name_list =  get_query_var('pagename');
			$get_post_name = get_query_var('post_type');
			if( $page_name_list != '' || $get_post_name != '') {
				if( $page_name_list == 'register') {
					$titles = get_option(SETTING_REGISTER_TITLE);
					if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1){
						$titles = __('Register Page', 're');
					}
				}
				if( $page_name_list == 'login') {
					$titles = get_option(SETTING_LOGIN_TITLE);
					if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1){
						$titles = __('Login Page', 're');
					}
				}
				if( $page_name_list == 'logout') {
					$titles = get_option(SETTING_LOGOUT_TITLE);
					if ($titles == ''|| get_option(SETTING_REWRITE_TITLE) != 1 ){
						$titles = __('Logout Page', 're');
					}
				}
				if( $page_name_list == 'edit_profile') {
					$titles = get_option(SETTING_EDIT_PROFILE);
					if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1){
						$titles = __('Edit Profile Page', 're');
					}
				}
				if( $page_name_list == 'forgot_password') {
					$titles = get_option(SETTING_FORGOT_PASS);
					if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1){
						$titles = __('Porgot Password Page', 're');
					}
				}
				if( $page_name_list == 'login_facebook') {
					$titles = get_option(SETTING_SEO_PAGE_FORMAT);
					if ($titles == ''|| get_option(SETTING_REWRITE_TITLE) != 1 ){
						$titles = __('Login Facebook Page', 're');
					}
				}
				if( $page_name_list == 'message') {
					$titles = get_option(SETTING_MESSAGE);
					if ($titles == ''|| get_option(SETTING_REWRITE_TITLE) != 1 ){
						$titles = __('Message Page', 're');
					}
				}
				if( $page_name_list == 'product_suggest') {
					$titles = get_option(SETTING_PRODUCT_SUGGEST);
					if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1){
						$titles = __('Product Suggest Page', 're');
					}
				}
				if( $page_name_list == 'compare') {
					$titles = get_option(SETTING_COMPARE_TITLE);
					if ($titles == ''|| get_option(SETTING_REWRITE_TITLE) != 1 ){
						$titles = __('Compare Page', 're');
					}
				}
				if( $page_name_list == 'articles' || $get_post_name == 'article') {
					$titles = get_option(SETTING_ARTICLE_TITLE);
					if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1){
						$titles = __('List Articles Page', 're');
					}
				}
			}
			else {
				$titles = get_option(SETTING_404_TITLE_FORMAT);
				if ($titles == ''){
					$titles = __('Page not pound', 're');
				}
			}
		} 
		elseif ( is_category()) {
			$titles = get_option(SETTING_CAT_TITLE_FORMAT);
			if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
				$titles = single_cat_title('', false);
			}			
		}
		else if ( is_author()) {
			$user = get_query_var('author');
			$firstname = get_user_meta($user, 'first_name');
			$lastname = get_user_meta($user, 'last_name');
			
			$titles = $firstname[0].' '.$lastname[0].' '.__('page', 're');
		}
		else if ( is_tag() ){
			$titles = get_option(SETTING_TAG_TITLE_FORMAT);
			if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
				$titles = single_term_title( '', false);
			}
		}
		else if ( is_archive() ) {
			$titles = get_option(SETTING_ACHIVE_TITLE_FORMAT);
			if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
				$titles = get_bloginfo('name');
			}
		}
		else if ( is_search() ) {
			$titles = get_option(SETTING_SEARCH_TITLE_FORMAT);
			if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
				$titles = $title_search;
			}
		}
		else if ( is_single() ) {
			$post_id = $post->ID;
			$allow_post = get_post_meta($post_id, 'tgt_aioseop_disable', true);
			if( $allow_post != 'on' && get_option(SETTING_DYNAMICALLY_GENERATE_POST_TYPE) == 1) {
				$cat_name = get_categories_name($post_id);
				
				$tag_name = get_tags();
				
				//echo $descriptions;
				$titles = get_option(SETTING_POST_TITLE_FORMAT);
				$product_title = get_post_meta($post_id, 'tgt_aioseop_title', true);
				
				if( empty($product_title) ) { 
					if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
						$titles = single_post_title( '', false );
					}
				}
				else {
					$titles = $product_title;
				}
			}else if( get_option(SETTING_REWRITE_TITLE) == 1 ) {
				$titles =	get_option(SETTING_POST_TITLE_FORMAT);
			}
			else {
				$titles = single_post_title( '', false );
			}
		}
		else if ( is_page() ){
			$page_id = $post->ID;
			$allow_page = get_post_meta($page_id, 'tgt_aioseop_disable', true);
			if( $allow_page != 'on') {
				$titles = get_option(SETTING_PAGE_TITLE_FORMAT);
				if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1 ){
					$titles = single_post_title( '', false );
				}
			}
		}
		
		else if( get_query_var('post_type') == 'article') {
			$page_article = get_query_var('post_type');
			
			if( $page_article == 'article') {
				$titles = get_option(SETTING_ARTICLE_TITLE);
				if ($titles == '' || get_option(SETTING_REWRITE_TITLE) != 1){
					$titles = __('List Articles Page', 're');
				}
			}
		}
	
		foreach ( $title as $title_detail => $value) {
			$titles = str_replace($title_detail , $value, $titles);
		}
	}
	else {
		$titles = '';
		$page_name_list =  get_query_var('pagename');
		$page_action = get_query_var('action');
		$post_type = get_query_var('post_type');
		
		if( $page_name_list != '' || $page_action != '' || $post_type != '') {
			if( $page_name_list == 'register' || $page_action == 'register') {
					$titles = __('Register Page', 're');
			}
			if( $page_name_list == 'login' || $page_action == 'login') {
					$titles = __('Login Page', 're');
			}
			if( $page_name_list == 'logout' || $page_action == 'logout') {
					$titles = __('Logout Page', 're');
			}
			if( $page_name_list == 'edit_profile' || $page_action == 'edit_profile') {
					$titles = __('Edit Profile Page', 're');
			}
			if( $page_name_list == 'forgot_password' || $page_action == 'forgot_password') {
					$titles = __('Porgot Password Page', 're');
			}
			if( $page_name_list == 'login_facebook' || $page_action == 'login_facebook') {
					$titles = __('Login Facebook Page', 're');
			}
			if( $page_name_list == 'message' || $page_action == 'message') {
					$titles = __('Message Page', 're');
			}
			if( $page_name_list == 'product_suggest' || $page_action == 'product_suggest') {
					$titles = __('Product Suggest Page', 're');
			}
			if( $page_name_list == 'compare' || $page_action == 'compare') {
					$titles = __('Compare Page', 're');
			}
			if ( $page_name_list == 'articles' || $page_action == 'articles' || $post_type == 'article') {
					$titles = __('List articles page', 're');
			}
		}
				if( isset($titles) && $titles == '') {
					$titles = get_bloginfo('name');
				}
				else {
					$titles = get_bloginfo('name'). ' | '.$titles;
				}
	}
	return $titles;
}

function add_header () {
	global $wpdb, $wp_query, $post;
	$keywords = '';
	$descriptions = '';
	$post_login = '';
	$post_firstname = '';
	$post_lastname = '';
	$post_nicename = '';
	
	$page_login = '';
	$page_firstname = '';
	$page_lastname = '';
	$page_nicename = '';
	
	if (isset($post)) {
		$id_user = $post->post_author;
		$post_firstname = get_user_meta($id_user, 'first_name');
		$post_lastname = get_user_meta($id_user, 'last_name');
		$post_login = get_user_meta($id_user, 'nickname');
		$post_nicename = get_user_meta($id_user, 'nickname');
		
		$post_login = ($post_login[0]) ? $post_login[0] : '';
		$post_firstname = ($post_firstname[0]) ? $post_firstname[0] : '';
		$post_lastname = ($post_lastname[0]) ? $post_lastname[0] : '';
		$post_nicename = ($post_nicename[0]) ? $post_nicename[0] : '';
		
		$page_login = ($post_login) ? $post_login : '';
		$page_firstname = ($post_firstname) ? $post_firstname : '';
		$page_lastname = ($post_lastname) ? $post_lastname : '';
		$page_nicename = ($post_nicename) ? $post_nicename : '';
	}
	if( get_option(SETTING_ENABLE_SEO) == 1 ) {
		function strleft($s1, $s2) {
			return substr($s1, 0, strpos($s1, $s2));
		}
		$s = empty($_SERVER["HTTPS"]) ? ''
			: ($_SERVER["HTTPS"] == "on") ? "s"
			: "";
		$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? ""
			: (":".$_SERVER["SERVER_PORT"]);
		$canonical = $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
		
		$descriptions .= get_option('blogdescription');
			
		if(is_home()){
			$home_description = get_option(SETTING_HOME_DESC);
			$addition_home_header = get_option(SETTING_ADDITIONAL_HOME_HEADER);
			$action = get_query_var('action');
			
			if( $home_description != ''){
				$descriptions = $home_description;
			}
			
			if(isset($addition_home_header)) echo stripslashes($addition_home_header);
		}
		elseif ( is_category()) {
		   if( get_option(SETTING_ADD_CAT_KEYWORD) == 1) {
				$keywords .= ', '.single_cat_title( ',', false );
		   }					
		}
		else if ( is_tag() ){
		    if( get_option(SETTING_ADD_TAG_KEYWORD) == 1) {
				$keywords .= ', '.single_term_title( ',', false );
		    }
		}
		else if ( is_single() ) {
			$post_id = $post->ID;
			$allow_post = get_post_meta($post_id, 'tgt_aioseop_disable', true);
			if( $allow_post != 'on' ) {
				$cat_name = get_categories_name($post_id);
				$new_description = get_post_meta($post_id, 'tgt_aioseop_description', true);
				$new_keyword = get_post_meta($post_id, 'tgt_aioseop_keywords', true);
				$tag_name = get_tags();
				
				if ( get_option(SETTING_AUTO_DESC) == 1  ){
					$descriptions = $post->post_content;
				}
				if( get_option(SETTING_DYNAMICALLY_GENERATE_POST_TYPE) == 1 && $new_description != '') {
					$descriptions = $new_description;
				}
				//echo $descriptions;
				$post_additional = get_option(SETTING_ADDITIONAL_POST_HEADER);
				
				if ( isset( $post_additional ) ) echo $post_additional;
				
				if( get_option(SETTING_ADD_CAT_KEYWORD) == 1) {
					$keywords .= ', '.$cat_name;
			    }
			    if( get_option(SETTING_ADD_TAG_KEYWORD) == 1) {
			    	$tag_namses = '';
				    foreach ($tag_name as $tag){
				    	$tag_namses .= ', '. $tag->name;
				    }
				    $keywords .= $tag_namses;
			    }
			    if( $new_keyword != ''){
			    	$keywords .= $new_keyword;
			    }
			}
		}
		else if ( is_page() ){
			$page_id = $post->ID;
			$allow_page = get_post_meta($page_id, 'tgt_aioseop_disable', true);
			if( $allow_page != 'on') {
				$new_description = get_post_meta($page_id, 'tgt_aioseop_description', true);
				$new_keyword = get_post_meta($page_id, 'tgt_aioseop_keywords', true);
				if ( get_option(SETTING_AUTO_DESC)== 1 ){
					$descriptions = $post->post_content;
				}
				if( get_option(SETTING_DYNAMICALLY_GENERATE_POST_TYPE) == 1 && $new_description != '') {
					$descriptions = $new_description;
				}
				$page_additional = get_option(SETTING_ADDITIONAL_PAGE_HEADER);
				
				if ( isset( $page_additional ) ) echo $page_additional;
			 	if( $new_keyword != ''){
			    	$keywords .= $new_keyword;
			    }
			}
		}
		$des_detail = strip_tags($descriptions);
		?>
		<meta name="description" content="<?php echo $des_detail; ?>" />
		<meta name="keywords" content="<?php  echo $keywords;   ?> " />
		<?php if( get_option(SETTING_CANONICAL) == 1) {?>
		<link rel= "canonical" href="<?php echo $canonical;?>" />							   
	<?php 
		}
	}
	else {
		the_meta_tags();
	}
}
?>
