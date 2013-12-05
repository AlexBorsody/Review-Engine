<?php
@ini_set('display_errors', 0);
/*
 * include from functions.php
 * included these files when admin loaded 
 * setup some setting when load admin site
 * setup some default value when install theme
 */

/*
 * setup some setting when load admin site
 * setup some default value when install theme
 */
add_action ('admin_init', 'hook_admin_init_tgt');
function hook_admin_init_tgt(){
	
/**
 * delete product
 */
	if ( isset($_GET['page']) && $_GET['page'] == 'review-engine-add_product' &&
		 isset($_GET['p']) &&
		 isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete' ){
		// check admin
		global $user_ID, $current_user;
		if ($user_ID){
			$user = new WP_User ($user_ID);
			if ( $user->roles[0] == 'administrator'){
				if ( isset ( $_GET['p'] )){
					$delete_post = get_post( $_GET['p'] );
					if ( !empty( $delete_post ) && $delete_post->post_type == 'product' ) {
						wp_trash_post( $_GET['p'] );
						wp_redirect(HOME_URL . '/wp-admin/admin.php?page=review-engine-list-products');
					}
				}			
			}		
		}
	}
	/**
	 *  Export data
	 *  @author: Nhu
	 */
	if(isset($_GET['page']) && $_GET['page'] == 'review-engine-admin-import' &&
		isset($_REQUEST['action']) && $_REQUEST['action'] == 'export'){
		global $user_ID, $wpdb;
		if ($user_ID){
			$user = new WP_User ($user_ID);
			if ( $user->roles[0] == 'administrator'){
				if(isset($_POST['choose_type'])){
					$choose_type = $_POST['choose_type'];
					switch ($choose_type) {
				      case "csv": $ctype="application/vnd.ms-excel"; break;
				      case "xml": $ctype="application/rss+xml"; break;
				      default: $ctype="application/force-download";
				    } 
	  		 	header( "Content-type: $ctype", true );
				$table_post = $wpdb->prefix.'posts';
				$table_term_relationship = $wpdb->prefix.'term_relationships';
				$table_term_taxonomy = $wpdb->prefix.'term_taxonomy';
				$query_Recordset = "SELECT p.post_author, p.post_title, p.post_content, tr.term_taxonomy_id, p.ID
									FROM $table_post p, $table_term_relationship tr, $table_term_taxonomy tt
									WHERE p.ID = tr.object_id AND p.post_type = 'product' AND p.post_status = 'publish' AND tr.term_taxonomy_id = tt.term_id AND tt.taxonomy = 'category' ";
				$Recordset = $wpdb->get_results($query_Recordset);
				// XML	
				if($choose_type == 'xml') {
					if($Recordset !=  '') { 
						$strXML = "<products >\n";
						foreach ( $Recordset as $record ){
							$price = get_post_meta($record->ID, 'tgt_product_price');
							$link_product = get_post_meta($record->ID, 'tgt_product_url');
							$strXML .= "<product>\n";
							$strXML .= "<title>". htmlspecialchars(strip_tags($record->post_title))."</title>\n";
							$strXML .= "<desc>". htmlspecialchars(strip_tags($record->post_content))."</desc>\n";
							$strXML .= "<categoryid>". htmlspecialchars($record->term_taxonomy_id)."</categoryid>\n";
							$strXML .= "<price>". htmlspecialchars($price[0])."</price>\n";
							$strXML .= "<linkproduct>". htmlspecialchars(strip_tags($link_product[0]))."</linkproduct>\n";
							$strXML .= "</product>\n";
						}
						$strXML = $strXML . "</products>";
						$export_file = $strXML;
						header('Content-Disposition: attachment; filename="export.xml"');
					}
					
				}
				
				// CSV
				if(isset($choose_type) && $choose_type == 'csv') {
					$strCSV = '';
					if($Recordset !=  '') { 
						foreach ( $Recordset as $record ){
							$price = get_post_meta($record->ID, 'tgt_product_price');
							$link_product = get_post_meta($record->ID, 'tgt_product_url');
							$content = htmlspecialchars($record->post_content);
							$strCSV .= '"'.$record->post_title.'"'.','.'"'.$content.'"'.','.'"'.$record->term_taxonomy_id.'"'.','.'"'.$price[0].'"'.','.'"'.$link_product[0].'"'."\n";
						}
						$export_file = $strCSV;
						header('Content-Disposition: attachment; filename="export.csv"');
					}
				  }
				echo $export_file;
				exit;
				}
			    
			}
		}
	}
}

/**
 * ADD MENU ITEM FOR ADMIN
 */
get_currentuserinfo();

if($current_user->ID>0 && $current_user->has_cap('administrator'))
{
	add_action('admin_menu', 'hook_admin_menu_tgt');
}

function hook_admin_menu_tgt(){
	add_menu_page('Review Engine', 'Dailywp.com', '', 'top-level-handle', 'admin_dashboard_tgt','','3');
	
	//Review Dashboard
	add_submenu_page( 'top-level-handle', __('Dashboard', 're'), __('Dashboard', 're'), 'edit_posts', 'review-engine-dashboard', 'admin_dashboard_tgt');
	
	//Display Setting
	add_submenu_page( 'top-level-handle', __('Display Settings', 're'), __('Display Settings', 're'), 'edit_posts', 'review-engine-display-settings', 'admin_display_settings_tgt');
	
	//Display Setting
	add_submenu_page( 'top-level-handle', __('General Settings', 're'), __('General Settings', 're'), 'edit_posts', 'review-engine-general-settings', 'admin_general_settings_tgt');
	
	//Review Setting
	add_submenu_page( 'top-level-handle', __('Review Settings', 're'), __('Review Settings', 're'), 'edit_posts', 'review-engine-review_settings', 'admin_review_settings_tgt');
	
	//Article Dashboard
	add_submenu_page( 'top-level-handle', __('Mailing Settings', 're'), __('Mailing Settings', 're'), 'edit_posts', 'review-engine-mailing', 'admin_mailing_settings_tgt');
	// Seo settings
	   add_submenu_page( 'top-level-handle', __('SEO Settings', 're'), __('SEO Settings', 're'), 'edit_posts', 'review-engine-admin-seo_settings', 'admin_seo_settings_tgt');
	//Filter Manager
	add_submenu_page( 'top-level-handle', __('Filter Magagement', 're'), __('Filter Magagement', 're'), 'edit_posts', 'filter', 'admin_filter');
	
	//Specification Manager
	add_submenu_page( 'top-level-handle', __('Specification Magagement', 're'), __('Specification Magagement', 're'), 'edit_posts', 'specification', 'admin_specification');
	
	//Tab Manager
	add_submenu_page( 'edit.php?post_type=product', __('Tab Management', 're'), __('Tab Management', 're'), 'edit_posts', 'tab-management', 'admin_tab_management');

	//Rating Manager
	add_submenu_page( 'top-level-handle', __('Rating Magagement', 're'), __('Rating Magagement', 're'), 'edit_posts', 'review-engine-rating', 'admin_rating_tgt');
		
	//List reviews
	add_submenu_page( 'top-level-handle', __('Reviews', 're'), __('List Reviews', 're'), 'edit_posts', 'review-engine-list-reviews', 'admin_list_reviews_tgt');
	
	//List suggestion
	add_submenu_page( 'top-level-handle', __('Product Suggestions', 're'), __('List Suggestions', 're'), 'edit_posts', 'review-engine-list-suggestions', 'admin_list_suggestions_tgt');
   
	add_submenu_page( 'top-level-handle', __('ReviewEngine Update', 're'), __('ReviewEngine Update', 're'), 'edit_posts', 'review-engine-update', 'admin_list_update_tgt');
	
   add_submenu_page( 'top-level-handle', __('Top Products', 're'), __('Top Products', 're'), 'edit_posts', 'review-engine-top-product', 'admin_top_product_tgt');
	
	// import data
	add_submenu_page( 'top-level-handle', __('Import/Export product', 're'), __('Import/Export product', 're'), 'edit_posts', 'review-engine-admin-import', 'admin_import_tgt');
        //add_submenu_page( 'top-level-handle', __('Background', 're'), __('Background', 're'), 'edit_posts', 'review-engine-admin-background', 'admin_background_tgt');
 
	
}

/**
 * ADMIN PAGE
 */
function admin_dashboard_tgt()			{require_once TEMPLATEPATH . '/admin/admin_dashboard.php';}
function admin_display_settings_tgt()	{require_once TEMPLATEPATH . '/admin/admin_display_setting.php';}
function admin_general_settings_tgt()	{require_once TEMPLATEPATH . '/admin/admin_general_setting.php';}
function admin_rating_tgt()				{require_once TEMPLATEPATH . '/admin/admin_rating.php';}

function admin_add_example_tgt()		{require_once TEMPLATEPATH . '/admin/admin_add_example.php';}
function admin_list_example_tgt()		{require_once TEMPLATEPATH . '/admin/admin_list_example.php';}
function admin_mailing_settings_tgt()	{require_once TEMPLATEPATH . '/admin/admin_mailing_settings.php';}
function admin_review_settings_tgt()	{require_once TEMPLATEPATH . '/admin/admin_review_settings.php';}

function admin_add_product_tgt()		{require_once TEMPLATEPATH . '/admin/admin_add_product.php';}

function admin_list_products_tgt()		{require_once TEMPLATEPATH . '/admin/admin_list_products.php';}
function admin_list_articles_tgt()		{require_once TEMPLATEPATH . '/admin/admin_list_articles.php';}
function admin_list_reviews_tgt()		{require_once TEMPLATEPATH . '/admin/admin_list_reviews.php';}
function admin_list_suggestions_tgt()	{require_once TEMPLATEPATH . '/admin/admin_list_suggestions.php';} 
function admin_new_article_tgt()		{require_once TEMPLATEPATH . '/admin/admin_add_article.php';} 
function admin_list_bak_tgt()			{require_once TEMPLATEPATH . '/admin/admin_add_product_bak.php';} 
function admin_list_update_tgt()		{require_once TEMPLATEPATH . '/admin/admin_update.php';}
function admin_top_product_tgt()		{require_once TEMPLATEPATH . '/admin/admin_top_product.php';}

function admin_specification()			{require_once TEMPLATEPATH . '/admin/admin_spec.php';}
function admin_filter()					{require_once TEMPLATEPATH . '/admin/admin_filter_manager.php';}
function admin_tab_management()			{require_once TEMPLATEPATH . '/admin/admin_tab_manager.php';}

function admin_import_tgt()		{require_once TEMPLATEPATH . '/admin/admin_prepare_import.php';}
//function admin_background_tgt()		{require_once TEMPLATEPATH . '/admin/admin_background.php';}
function admin_seo_settings_tgt()		{require_once TEMPLATEPATH . '/admin/admin_seo_settings.php';}
/**
 * ADD CSS TO ADMIN SITE
 */
add_action('admin_head', 'hook_admin_head_tgt');
function hook_admin_head_tgt(){
}

add_action('admin_print_styles', 're_admin_print_styles');
function re_admin_print_styles()
{
	wp_register_style('admin-styles', TEMPLATE_URL . '/css/admin.css');
	wp_enqueue_style('admin-styles');
	wp_enqueue_style( 'jqueryratingStylesheet');
}

add_action('admin_print_scripts' , 're_admin_print_scripts');
function re_admin_print_scripts()
{
	$pages = array('top-level-handle',
						'review-engine-dashboard',
						'review-engine-display-settings',
						'review-engine-admin-seo_settings',
						'review-engine-general-settings',
						'review-engine-review_settings',
						'review-engine-mailing',
						'review-engine-filter',
						'review-engine-spec',
						'review-engine-rating',
						'review-engine-add_product',
						'review-engine-list-products',
						'review-engine-new-article',
						'review-engine-list-articles',
						'review-engine-list-reviews',
						'review-engine-list-suggestions',
						'review-engine-update',
						'review-engine-top-product',
						'specification',
						'filter',
						'tab-management',
						'review-engine-admin-import');
	if ( !empty($_GET['page']) && in_array( $_GET['page'], $pages ) )
	{
		//wp_enqueue_script('jquery_script');
		wp_enqueue_script('jquery_ui_script');
		wp_enqueue_script('jquery_tooltip_script');
		wp_enqueue_script('jquery_meta_script');
		wp_enqueue_script('jquery_metadata_script');
		wp_enqueue_script('jquery_rating_script');
		wp_enqueue_script('function_script');	
		wp_register_script('admin-script', TEMPLATE_URL . '/js/admin_script.js');
		wp_enqueue_script('admin-script');
	}
	?>	
	<?php
}
