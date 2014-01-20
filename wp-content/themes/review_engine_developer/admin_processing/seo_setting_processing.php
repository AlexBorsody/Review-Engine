<?php 
if(isset($_POST['submitted']) && $_POST['submitted'] == 'yes')
{
	// Save SEO setting
	if(isset($_POST['save_seo']) && !empty($_POST['save_seo']))
	{
		// For SEO keywords new version
				$curr_type_support = array();	
				if(isset($_POST['product']))
				{
						$curr_type_support['product'] = $_POST['product'];
				}else
						$curr_type_support['product'] = 0;
				if(isset($_POST['post']))
				{
						$curr_type_support['post'] = $_POST['post'];
				}else
						$curr_type_support['post'] = 0;
				if(isset($_POST['page']))
				{
						$curr_type_support['page'] = $_POST['page'];
				}else
						$curr_type_support['page'] = 0;
				if(isset($_POST['article']))
				{
						$curr_type_support['article'] = $_POST['article'];
				}else
						$curr_type_support['article'] = 0;
				update_option(SETTING_ENABLE_SEO, $_POST['permit_seo']);	
				update_option(SETTING_POST_TYPE_SUPORT, $curr_type_support);
				
				update_option(SETTING_HOME_TITLE,stripslashes(trim($_POST['home_title_list'])));	
				update_option(SETTING_HOME_DESC,stripslashes(trim($_POST['home_description_list'])));
				update_option(SETTING_HOME_KEYWORD,stripslashes(trim($_POST['home_keyword_list'])));
				$canonial = 0;
				if( isset( $_POST['canonical']) && $_POST['canonical'] != '') {
					$canonial = $_POST['canonical'];
				}
				update_option(SETTING_CANONICAL,$canonial);	
				
				$rewrite_rule = 0;
				if( isset( $_POST['rewrite_title']) && $_POST['rewrite_title'] != '') {
					$rewrite_rule = $_POST['rewrite_title'];
				}
				update_option(SETTING_REWRITE_TITLE,$rewrite_rule);
				update_option(SETTING_POST_TITLE_FORMAT,stripslashes(trim($_POST['post_title_format'])));
				update_option(SETTING_PAGE_TITLE_FORMAT,stripslashes(trim($_POST['page_title_format'])));	
				update_option(SETTING_ACHIVE_TITLE_FORMAT,stripslashes(trim($_POST['achive_title_format'])));
				update_option(SETTING_TAG_TITLE_FORMAT,stripslashes(trim($_POST['tag_title_format'])));
				update_option(SETTING_SEARCH_TITLE_FORMAT,stripslashes(trim($_POST['search_title_format'])));	
				update_option(SETTING_DESC_FORMAT,stripslashes(trim($_POST['description_format'])));
				update_option(SETTING_CAT_TITLE_FORMAT,stripslashes(trim($_POST['category_title_format'])));
				update_option(SETTING_404_TITLE_FORMAT,stripslashes(trim($_POST['404_title_format'])));	
				update_option(SETTING_SEO_PAGE_FORMAT,stripslashes(trim($_POST['page_format'])));
				
				$post_type_ss = 0;
				if( isset( $_POST['seo_post_type']) && $_POST['seo_post_type'] != '') {
					$post_type_ss = $_POST['seo_post_type'];
				}
				update_option(SETTING_SEO_POST_TYPE,$post_type_ss);
				
				$add_meta_cat = 0;
				if( isset( $_POST['add_category_keyword']) && $_POST['add_category_keyword'] != '') {
					$add_meta_cat = $_POST['add_category_keyword'];
				}
				update_option(SETTING_ADD_CAT_KEYWORD,$add_meta_cat);
				
				$add_tag_meta = 0;
				if( isset( $_POST['add_tag_keyword']) && $_POST['add_tag_keyword'] != '') {
					$add_tag_meta = $_POST['add_tag_keyword'];
				}
				update_option(SETTING_ADD_TAG_KEYWORD,$add_tag_meta);
				
				$add_dymamid = 0;
				if( isset( $_POST['dynamid_generate_post_page']) ) {
					$add_dymamid = $_POST['dynamid_generate_post_page'];
				}
				update_option(SETTING_DYNAMICALLY_GENERATE_POST_TYPE, $add_dymamid);
				/*
				update_option(SETTING_NOINDEX_CAT,$_POST['noindex_category']);
				update_option(SETTING_NOINDEX_ACHIVE,$_POST['noindex_achive']);
				update_option(SETTING_NOINDEX_TAG_ACHIVE, $_POST['noindex_tag_achive']);*/
				$auto_des = 0;
				if( isset( $_POST['auto_description']) && $_POST['auto_description'] != '') {
					$auto_des = $_POST['auto_description'];
				}
				update_option(SETTING_AUTO_DESC, $auto_des);
				
				update_option(SETTING_ADDITIONAL_POST_HEADER, stripslashes(trim($_POST['additional_post_header'])));
				update_option(SETTING_ADDITIONAL_PAGE_HEADER, stripslashes(trim($_POST['additional_page_header'])));
				update_option(SETTING_ADDITIONAL_HOME_HEADER, stripslashes(trim($_POST['additional_home_header'])));
				update_option(SETTING_REGISTER_TITLE, stripslashes(trim($_POST['register_title_format'])));
				update_option(SETTING_LOGIN_TITLE, stripslashes(trim($_POST['login_title_format'])));
				update_option(SETTING_LOGOUT_TITLE, stripslashes(trim($_POST['logout_title_format'])));
				update_option(SETTING_EDIT_PROFILE, stripslashes(trim($_POST['profile_title_format'])));
				update_option(SETTING_FORGOT_PASS, stripslashes(trim($_POST['forgot_pass_title_format'])));
				update_option(SETTING_LOGIN_FACEBOOK, stripslashes(trim($_POST['facebook_title_format'])));
				update_option(SETTING_MESSAGE, stripslashes(trim($_POST['message_title_format'])));
				update_option(SETTING_PRODUCT_SUGGEST, stripslashes(trim($_POST['suggest_title_format'])));
				update_option(SETTING_COMPARE_TITLE, stripslashes(trim($_POST['compare_title_format'])));
				update_option( SETTING_ARTICLE_TITLE, stripslashes(trim($_POST['article_title_format'])));
		
		$message .= __('Your SEO settings had been saved.','re').'<br>';
		$_POST = '';
	}
}
?>
