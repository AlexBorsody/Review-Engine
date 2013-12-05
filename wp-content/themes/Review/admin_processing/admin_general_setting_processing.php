<?php
/*
 * @Author: James. 
 */
if(isset($_POST['submitted']) && $_POST['submitted'] == 'yes')
{
	// Save item per page setting
	if(isset($_POST['save_item_per_page']) && !empty($_POST['save_item_per_page']))
	{
		if(isset($_POST['top_count']) && !is_numeric($_POST['top_count']))
				$errors .= __('The limited number of top products should be numeric','re').'<br>';
		if(isset($_POST['recent_count']) && !is_numeric($_POST['recent_count']))
				$errors .= __('The limited number of recent products should be numeric','re').'<br>';
		if(!is_numeric($_POST['articles_nums']))	
				$errors .= __('The articles field should be numeric','re').'<br>';
		if(!is_numeric($_POST['comments_nums']))	
				$errors .= __('The comments for article field should be numeric','re').'<br>';
		if(!is_numeric($_POST['products_nums']))	
				$errors .= __('The products field should be numeric','re').'<br>';
		if(!is_numeric($_POST['reviews_nums']))	
				$errors .= __('The reviews for product field should be numeric','re').'<br>';
				
		if(isset($_POST['top_count']) && $_POST['top_count'] < 0)		
				$errors .= __('The limited number of top products should be equal or greater than 0','re').'<br>';
		if(isset($_POST['recent_count']) && $_POST['recent_count'] < 0)		
				$errors .= __('The limited number of recent products should be equal or greater than 0','re').'<br>';
		if(isset($_POST['articles_nums']) && $_POST['articles_nums'] < 1)		
				$errors .= __('The articles field should be equal or greater than 1','re').'<br>';
		if(isset($_POST['comments_nums']) && $_POST['comments_nums'] < 1)		
				$errors .= __('The comments for article field should be equal or greater than 1','re').'<br>';
		if(isset($_POST['products_nums']) && $_POST['products_nums'] < 1)		
				$errors .= __('The products field should be equal or greater than 1','re').'<br>';
		if(isset($_POST['reviews_nums']) && $_POST['reviews_nums'] < 1)		
				$errors .= __('The reviews for product field should be equal or greater than 1','re').'<br>';
		
		if($errors == '')
		{
				if(isset($_POST['top_count']))
					update_option(SETTING_TOP_NUMBER_PRODUCT,$_POST['top_count']);
				if(isset($_POST['recent_count']))
					update_option(SETTING_RECENT_NUMBER_PRODUCT,$_POST['recent_count']);
				if(isset($_POST['articles_nums']))
					update_option('posts_per_page',$_POST['articles_nums']);// store articles per page
				if(isset($_POST['comments_nums']))
					update_option('comments_per_page',$_POST['comments_nums']);// store comments number for articles
				if(isset($_POST['products_nums']))
					update_option(SETTING_PRODUCTS_PER_PAGE,$_POST['products_nums']);// store products per page
				if(isset($_POST['reviews_nums']))
					update_option(SETTING_REVIEWS_PER_PRODUCT,$_POST['reviews_nums']);// store reviews number for product
				$message .= __('Your items per page settings had been saved.','re').'<br>';
				$_POST = '';
		}
	}
	
	// Save Currency Symbol
	if(isset($_POST['save_currency_symbol']) && !empty($_POST['save_currency_symbol']))
	{	
		$list_symbol = array();	
		
			if (isset($_POST['price_symbol'])){
				$list_symbol['symbol'] = $_POST['price_symbol'];
			}
			if (isset($_POST['position_symbol'])){
				$list_symbol['position'] = $_POST['position_symbol'];
			}
				update_option(SETTING_CURRENCY_SYMBOL, $list_symbol);				
		$message .= __('Your currency symbol had been saved.','re').'<br>';
		$_POST = '';
		
	}
	
// Save tips search
	if(isset($_POST['save_tips_search']) && !empty($_POST['save_tips_search']))
	{	
		$tips_search = '';	
		
			if (isset($_POST['tips_search'])){
				$tips_search = stripslashes(strip_tags($_POST['tips_search']));
			}
			update_option(SETTING_TIPS_SEARCH, $tips_search);				
		$message .= __('Your search example text had been saved.','re').'<br>';
		$_POST = '';
		
	}
	
	// Save Facebook App API informations
	if(isset($_POST['save_fb_api']) && !empty($_POST['save_fb_api']))
	{
		
		if(isset($_POST['fb_id']))
				update_option(SETTING_FB_API_ID,$_POST['fb_id']);// store articles per page
		if(isset($_POST['fb_secret']))
				update_option(SETTING_FB_API_SECRET,$_POST['fb_secret']);// store comments number for articles
		$message .= __('Your facebook API informations had been saved.','re').'<br>';
		$_POST = '';
		
	}
	// Save SEO setting
	if(isset($_POST['save_seo']) && !empty($_POST['save_seo']))
	{
		/*echo '<pre>';
		print_r ($_POST);
		echo '</pre>';
		exit;*/
		// For SEO keywords Old version
		
				update_option(SETTING_ENABLE_KEYWORD,$_POST['permit_keywords']);	
				update_option(SETTING_DEFAULT_KEYWORD,$_POST['keywords_list']);
				
		// For SEO description
				update_option(SETTING_ENABLE_DESC,$_POST['permit_desc']);		
				update_option(SETTING_DEFAULT_DESC,$_POST['default_desc']);		
		
		// For SEO keywords new version
				$curr_type_support = array();
				
				// Captcha for register form		
				if(isset($_POST['product']))
				{
						$curr_type_support['product'] = $_POST['product'];
				}else
						$curr_type_support['product'] = 0;
				// Captcha for login form		
				if(isset($_POST['post']))
				{
						$curr_type_support['post'] = $_POST['post'];
				}else
						$curr_type_support['post'] = 0;
				// Captcha for forgot password form		
				if(isset($_POST['page']))
				{
						$curr_type_support['page'] = $_POST['page'];
				}else
						$curr_type_support['page'] = 0;
				// Captcha for edit account form		
				if(isset($_POST['article']))
				{
						$curr_type_support['article'] = $_POST['article'];
				}else
						$curr_type_support['article'] = 0;
						
				update_option(SETTING_POST_TYPE_SUPORT, $curr_type_support);
				
				update_option(SETTING_HOME_TITLE,$_POST['home_title_list']);	
				update_option(SETTING_HOME_DESC,$_POST['home_description_list']);
				update_option(SETTING_HOME_KEYWORD,$_POST['home_keyword_list']);
				update_option(SETTING_CANONICAL,$_POST['canonical']);	
				update_option(SETTING_REWRITE_TITLE,$_POST['rewrite_title']);
				update_option(SETTING_POST_TITLE_FORMAT,$_POST['post_title_format']);
				update_option(SETTING_PAGE_TITLE_FORMAT,$_POST['page_title_format']);	
				update_option(SETTING_ACHIVE_TITLE_FORMAT,$_POST['achive_title_format']);
				update_option(SETTING_TAG_TITLE_FORMAT,$_POST['tag_title_format']);
				update_option(SETTING_SEARCH_TITLE_FORMAT,$_POST['search_title_format']);	
				update_option(SETTING_DESC_FORMAT,$_POST['description_format']);
				update_option(SETTING_CAT_TITLE_FORMAT,$_POST['category_title_format']);
				update_option(SETTING_404_TITLE_FORMAT,$_POST['404_title_format']);	
				update_option(SETTING_SEO_PAGE_FORMAT,$_POST['page_format']);
				update_option(SETTING_SEO_POST_TYPE,$_POST['seo_post_type']);
				update_option(SETTING_ADD_CAT_KEYWORD,$_POST['add_category_keyword']);
				update_option(SETTING_ADD_TAG_KEYWORD,$_POST['add_tag_keyword']);
				update_option(SETTING_DYNAMICALLY_GENERATE_POST_TYPE,$_POST['dynamid_generate_post_page']);
				update_option(SETTING_NOINDEX_CAT,$_POST['noindex_category']);
				update_option(SETTING_NOINDEX_ACHIVE,$_POST['noindex_achive']);
				update_option(SETTING_NOINDEX_TAG_ACHIVE, $_POST['noindex_tag_achive']);
				update_option(SETTING_AUTO_DESC, $_POST['auto_description']);
				update_option(SETTING_ADDITIONAL_POST_HEADER, $_POST['additional_post_header']);
				update_option(SETTING_ADDITIONAL_PAGE_HEADER, $_POST['additional_page_header']);
				update_option(SETTING_ADDITIONAL_HOME_HEADER, $_POST['additional_home_header']);
				update_option(SETTING_REGISTER_TITLE, $_POST['register_title_format']);
				update_option(SETTING_LOGIN_TITLE, $_POST['login_title_format']);
				update_option(SETTING_LOGOUT_TITLE, $_POST['logout_title_format']);
				update_option(SETTING_EDIT_PROFILE, $_POST['profile_title_format']);
				update_option(SETTING_FORGOT_PASS, $_POST['forgot_pass_title_format']);
				update_option(SETTING_LOGIN_FACEBOOK, $_POST['facebook_title_format']);
				update_option(SETTING_MESSAGE, $_POST['message_title_format']);
				update_option(SETTING_PRODUCT_SUGGEST, $_POST['suggest_title_format']);
				update_option(SETTING_COMPARE_TITLE, $_POST['compare_title_format']);
				update_option( SETTING_ARTICLE_TITLE, $_POST['article_title_format']);
		
		$message .= __('Your SEO settings had been saved.','re').'<br>';
		$_POST = '';
	}
	// Save feature redirect link setting
	if(isset($_POST['save_redirect']) && !empty($_POST['save_redirect']))
	{		
		if(isset($_POST['enable_redirect']))
				update_option(SETTING_ENABLE_REDIRECT_LINK,$_POST['enable_redirect']);
		$message .= __('Your feature redirect link setting had been saved.','re').'<br>';
		$_POST = '';
		
	}
	// Save MISC setting
	if(isset($_POST['save_misc']) && !empty($_POST['save_misc']))
	{
		// Save the permit article display
		if(isset($_POST['enable_article']))
		{
				update_option(SETTING_ENABLE_ARTICLE,$_POST['enable_article']);
		}
		
		// Permit autocomplete
		if(isset($_POST['permit_autocomplete']))
		{
				update_option(SETTING_ENABLE_AUTOCOMPLETE,$_POST['permit_autocomplete']);			
		}
		
		$curr_enable_captcha = array();
		
		// Captcha for register form		
		if(isset($_POST['register']))
		{
				$curr_enable_captcha['register'] = $_POST['register'];
		}else
				$curr_enable_captcha['register'] = 0;
		// Captcha for login form		
		if(isset($_POST['login']))
		{
				$curr_enable_captcha['login'] = $_POST['login'];
		}else
				$curr_enable_captcha['login'] = 0;
		// Captcha for forgot password form		
		if(isset($_POST['forgot_pass']))
		{
				$curr_enable_captcha['forgot_pass'] = $_POST['forgot_pass'];
		}else
				$curr_enable_captcha['forgot_pass'] = 0;
		// Captcha for edit account form		
		if(isset($_POST['edit_acc']))
		{
				$curr_enable_captcha['edit_acc'] = $_POST['edit_acc'];
		}else
				$curr_enable_captcha['edit_acc'] = 0;
		update_option(SETTING_ENABLE_CAPTCHA,$curr_enable_captcha);
		
		
		// Save the permit article display
		if(isset($_POST['product_slug']))
		{
			update_option( SETTING_PRODUCT_SLUG ,$_POST['product_slug']);
		}
		
		// Save public/private keys for google recaptcha
		if ( isset( $_POST['recaptcha_public_key'] ) )
		{
			update_option( 'recaptcha_public_key' , $_POST['recaptcha_public_key'] );
		}
		if ( isset( $_POST['recaptcha_private_key'] ) )
		{
			update_option( 'recaptcha_private_key' , $_POST['recaptcha_private_key'] );
		}
		
		$message .= __('Your miscellaneous settings had been saved.','re').'<br>';
		$_POST = '';
		
	}
	if (isset($_POST['save_feed']) && !empty($_POST['save_feed']))
	{
		if(isset($_POST['feed_link_cat']))
		{
			update_option(SETTING_FEED_LINK_CATEGORY, $_POST['feed_link_cat']);
		}
		else update_option(SETTING_FEED_LINK_CATEGORY, 0);
		if(isset($_POST['feed_link_article']))
		{
			update_option(SETTING_FEED_LINK_ARTICLE, $_POST['feed_link_article']);
		}
		else update_option(SETTING_FEED_LINK_ARTICLE, 0);
		if(isset($_POST['feed_link_menu']))
		{
			update_option(SETTING_FEED_LINK_MENU, $_POST['feed_link_menu']);
		}
		$message .= __('Your feed settings had been saved.','re').'<br>';
		$_POST = '';
	}
}
?>