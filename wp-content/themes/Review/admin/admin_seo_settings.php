<?php
/*
 * @Author: Nhu
 */
$errors = '';
$message = '';
require_once TEMPLATEPATH . '/admin_processing/seo_setting_processing.php';
?>
<div class="wrap"> <!-- #wrap 1 -->
	<div id="icon-edit" class="icon32"><br></div>
	<h2>
		<?php _e('SEO Settings','re'); ?>
	</h2>	
	<div class="tgt_atention">
		<strong><?php _e('Problems? Questions?','re');?></strong><?php _e(' Contact us at ','re');?><em><a href="http://www.dailywp.com/support/" target="_blank">Support</a></em>. 
	</div>
	
	<?php 
    if($message != '') 
    {
        echo '<div class="updated below-h2">'.$message.'</div>'; 
    }
    ?>
	
	<?php 
    if($errors != '') 
    {
        echo '<div class="error">'.$errors.'</div>'; 
    }
    ?>	

	<form method="post" name="general_form" target="_self">
	<input name="submitted" type="hidden" value="yes" />	
	<!-- Start box SEO setting -->	
        <div id="poststuff" class="has-right-sidebar">	
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('SEO','re'); ?></label></h3>
						<div class="inside">						
							
							<table class="form-table"> <!-- form table -->
								<tbody>	
									<tr class="form-field"><!-- //Permit Keywords Private For Each Page ? -->
										<th scope="row">
                                        <label><?php _e('Allow SEO settings','re'); ?></label>	                                        
                                        </th>								
										<td>
                                        <select name="permit_seo" id="permit_seo" style="width:100px;">
                                        	<option value="1" <?php if(get_option(SETTING_ENABLE_SEO) == 1) echo 'selected="selected"'; ?>><?php _e('Enable','re'); ?></option>
                                            <option value="0" <?php if(get_option(SETTING_ENABLE_SEO) == 0) echo 'selected="selected"'; ?>><?php _e('Disable','re'); ?></option>
                                        </select>
                                        </td>
									</tr>
									<!-- Start new version SEO -->
									<tr class="form-field">
										<th scope="row">
                                        <label><?php _e('Home Title','re'); ?></label>	
                                         <a href="#key_list26" class="tooltip" >[?]</a>	
                                        <div id="key_list26" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('As the name implies, this will be the title of your homepage. This is independent of any other option. If not set, the default blog title will get used.','re'); ?></p>	
										</div>	                                        
                                        </th>								
										<td>
                                           <textarea name="home_title_list" id="home_title_list" rows="2"><?php if(isset($_POST['home_title_list'])) echo $_POST['home_title_list']; else { if(get_option(SETTING_HOME_TITLE) != '') echo get_option(SETTING_HOME_TITLE); } ?></textarea>
                                        </td>
									</tr>
                                    <tr class="form-field" >
										<th scope="row"><label><?php _e('Home Description','re'); ?></label>	
                                        <a href="#key_list1" class="tooltip" >[?]</a>	
                                        <div id="key_list1" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The META description for your homepage. Independent of any other options, the default is no META description at all if this is not set.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                           <textarea name="home_description_list" id="home_description_list" rows="2"><?php if(isset($_POST['home_description_list'])) echo $_POST['home_description_list']; else { if(get_option(SETTING_HOME_DESC) != '') echo get_option(SETTING_HOME_DESC); } ?></textarea>
                                        </td>
									</tr>	
                                    <tr class="form-field">
										<th scope="row">
                                        <label><?php _e('Home Keywords (comma separated)','re'); ?></label>	  
                                         <a href="#key_list2" class="tooltip" >[?]</a>	
                                        <div id="key_list2" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('A comma separated list of your most important keywords for your site that will be written as META keywords on your homepage. Don\'t stuff everything in here.','re'); ?></p>	
										</div>	                                      
                                        </th>								
										<td>
                                            <textarea name="home_keyword_list" id="home_keyword_list" rows="2"><?php if(isset($_POST['home_keyword_list'])) echo $_POST['home_keyword_list']; else { if(get_option(SETTING_HOME_KEYWORD) != '') echo get_option(SETTING_HOME_KEYWORD); } ?></textarea>
                                        </td>
									</tr>
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Canonical URLs ','re'); ?></label>	
                                        <a href="#key_list3" class="tooltip" >[?]</a>	
                                        <div id="key_list3" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('This option will automatically generate Canonical URLS for your entire WordPress installation. This will help to prevent duplicate content penalties by Google.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        	<input type="checkbox" name="canonical" value="1" <?php $ca = get_option(SETTING_CANONICAL); if(isset($ca) && $ca == 1) echo 'checked="checked"'; ?> />
                                        </td>
									</tr>		
									<tr class="form-field" ><!-- //Default Description -->
										<th scope="row"><label><?php _e('Rewrite Titles','re'); ?></label>	
                                        <a href="#key_list4" class="tooltip" >[?]</a>	
                                        <div id="key_list4" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Note that this is all about the title tag. This is what you see in your browser\'s window title bar. This is NOT visible on a page, only in the window title bar and of course in the source. If set, all page, post, category, search and archive page titles get rewritten. You can specify the format for most of them.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        	<input type="checkbox" name="rewrite_title" value="1" <?php $rerite = get_option(SETTING_REWRITE_TITLE); if(isset($rerite) && $rerite == 1) echo 'checked="checked"'; ?> />
                                        </td>
									</tr>		
                                    <tr class="form-field" >
										<th scope="row"><label><?php _e('Post Title Format','re'); ?></label>	
                                        <a href="#key_list5" class="tooltip" >[?]</a>	
                                        <div id="key_list5" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
													    %blog_title% - Your blog title
													    %blog_description% - Your blog description
													    %post_title% - The original title of the post
													    %category_title% - The (main) category of the post
													    %category% - Alias for %category_title%
													    %post_author_login% - This post\'s author\' login
													    %post_author_nicename% - This post\'s author\' nicename
													    %post_author_firstname% - This post\'s author\' first name (capitalized)
													    %post_author_lastname% - This post\'s author\' last name (capitalized)','re'); 
    											?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="post_title_format" id="post_title_format" style="width:450px;" value="<?php if(isset($_POST['post_title_format'])) echo $_POST['post_title_format']; else { if(get_option(SETTING_POST_TITLE_FORMAT) != '') echo get_option(SETTING_POST_TITLE_FORMAT); } ?>" />
                                        </td>
									</tr>	
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Page Title Format','re'); ?></label>	
                                        <a href="#key_list6" class="tooltip" >[?]</a>	
                                        <div id="key_list6" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
															%blog_title% - Your blog title
														    %blog_description% - Your blog description
														    %page_title% - The original title of the page
														    %page_author_login% - This page\'s author\' login
														    %page_author_nicename% - This page\'s author\' nicename
														    %page_author_firstname% - This page\'s author\' first name (capitalized)
														    %page_author_lastname% - This page\'s author\' last name (capitalized)','re'); 
    											?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="page_title_format" id="page_title_format" style="width:450px;" value="<?php if(isset($_POST['page_title_format'])) echo $_POST['page_title_format']; else { if(get_option(SETTING_PAGE_TITLE_FORMAT) != '') echo get_option(SETTING_PAGE_TITLE_FORMAT); } ?>" />
                                        </td>
									</tr>		
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Achive Title Format','re'); ?></label>	
                                        <a href="#key_list7" class="tooltip" >[?]</a>	
                                        <div id="key_list7" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%date% - The original archive title given by wordpress, e.g. "2007" or "2007 August"','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="achive_title_format" id="achive_title_format" style="width:450px;" value="<?php if(isset($_POST['achive_title_format'])) echo $_POST['achive_title_format']; else { if(get_option(SETTING_ACHIVE_TITLE_FORMAT) != '') echo get_option(SETTING_ACHIVE_TITLE_FORMAT); } ?>" />
                                        </td>
									</tr>
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Register Title Format','re'); ?></label>	
                                        <a href="#key_list27" class="tooltip" >[?]</a>	
                                        <div id="key_list27" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%register% - register title or any words you want','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="register_title_format" id="register_title_format" style="width:450px;" value="<?php if(isset($_POST['register_title_format'])) echo $_POST['register_title_format']; else { if(get_option(SETTING_REGISTER_TITLE) != '') echo get_option(SETTING_REGISTER_TITLE); } ?>" />
                                        </td>
									</tr>	
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Login Title Format','re'); ?></label>	
                                        <a href="#key_list36" class="tooltip" >[?]</a>	
                                        <div id="key_list36" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%login% - login title or any words you want','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="login_title_format" id="login_title_format" style="width:450px;" value="<?php if(isset($_POST['login_title_format'])) echo $_POST['login_title_format']; else { if(get_option(SETTING_LOGIN_TITLE) != '') echo get_option(SETTING_LOGIN_TITLE); } ?>" />
                                        </td>
									</tr>	
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Logout Title Format','re'); ?></label>	
                                        <a href="#key_list28" class="tooltip" >[?]</a>	
                                        <div id="key_list28" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%logout% - logout title or any words you want','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="logout_title_format" id="logout_title_format" style="width:450px;" value="<?php if(isset($_POST['logout_title_format'])) echo $_POST['logout_title_format']; else { if(get_option(SETTING_LOGOUT_TITLE) != '') echo get_option(SETTING_LOGOUT_TITLE); } ?>" />
                                        </td>
									</tr>	
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Edit Profile Title Format','re'); ?></label>	
                                        <a href="#key_list29" class="tooltip" >[?]</a>	
                                        <div id="key_list29" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%profile% - Profile title or any words you want','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="profile_title_format" id="profile_title_format" style="width:450px;" value="<?php if(isset($_POST['profile_title_format'])) echo $_POST['profile_title_format']; else { if(get_option(SETTING_EDIT_PROFILE) != '') echo get_option(SETTING_EDIT_PROFILE); } ?>" />
                                        </td>
									</tr>	
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Forgot Password Title Format','re'); ?></label>	
                                        <a href="#key_list30" class="tooltip" >[?]</a>	
                                        <div id="key_list30" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%forgot_pass% - forgot password title','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="forgot_pass_title_format" id="forgot_pass_title_format" style="width:450px;" value="<?php if(isset($_POST['forgot_pass_title_format'])) echo $_POST['forgot_pass_title_format']; else { if(get_option(SETTING_FORGOT_PASS) != '') echo get_option(SETTING_FORGOT_PASS); } ?>" />
                                        </td>
									</tr>	
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Login Facebook Title Format','re'); ?></label>	
                                        <a href="#key_list31" class="tooltip" >[?]</a>	
                                        <div id="key_list31" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%facebook% - Facebook login title','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="facebook_title_format" id="facebook_title_format" style="width:450px;" value="<?php if(isset($_POST['facebook_title_format'])) echo $_POST['facebook_title_format']; else { if(get_option(SETTING_LOGIN_FACEBOOK) != '') echo get_option(SETTING_LOGIN_FACEBOOK); } ?>" />
                                        </td>
									</tr>	
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Message Title Format','re'); ?></label>	
                                        <a href="#key_list32" class="tooltip" >[?]</a>	
                                        <div id="key_list32" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%message% - Message title','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="message_title_format" id="message_title_format" style="width:450px;" value="<?php if(isset($_POST['message_title_format'])) echo $_POST['message_title_format']; else { if(get_option(SETTING_MESSAGE) != '') echo get_option(SETTING_MESSAGE); } ?>" />
                                        </td>
									</tr>	
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Product Suggest Title Format','re'); ?></label>	
                                        <a href="#key_list33" class="tooltip" >[?]</a>	
                                        <div id="key_list33" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%suggest% - suggest product title','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="suggest_title_format" id="suggest_title_format" style="width:450px;" value="<?php if(isset($_POST['suggest_title_format'])) echo $_POST['suggest_title_format']; else { if(get_option(SETTING_PRODUCT_SUGGEST) != '') echo get_option(SETTING_PRODUCT_SUGGEST); } ?>" />
                                        </td>
									</tr>	
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Compare Title Format','re'); ?></label>	
                                        <a href="#key_list34" class="tooltip" >[?]</a>	
                                        <div id="key_list34" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%compare% - compare page title','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="compare_title_format" id="compare_title_format" style="width:450px;" value="<?php if(isset($_POST['compare_title_format'])) echo $_POST['compare_title_format']; else { if(get_option(SETTING_COMPARE_TITLE) != '') echo get_option(SETTING_COMPARE_TITLE); } ?>" />
                                        </td>
									</tr>
									<tr class="form-field" >
										<th scope="row"><label><?php _e('List Articles Title Format','re'); ?></label>	
                                        <a href="#key_list35" class="tooltip" >[?]</a>	
                                        <div id="key_list35" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%articles% - list articles page title','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="article_title_format" id="article_title_format" style="width:450px;" value="<?php if(isset($_POST['article_title_format'])) echo $_POST['article_title_format']; else { if(get_option(SETTING_ARTICLE_TITLE) != '') echo get_option(SETTING_ARTICLE_TITLE); } ?>" />
                                        </td>
									</tr>
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Tag Title Format','re'); ?></label>	
                                        <a href="#key_list8" class="tooltip" >[?]</a>	
                                        <div id="key_list8" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
   															%blog_description% - Your blog description
    														%tag% - The name of the tag','re');
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="tag_title_format" id="tag_title_format" style="width:450px;" value="<?php if(isset($_POST['tag_title_format'])) echo $_POST['tag_title_format']; else { if(get_option(SETTING_TAG_TITLE_FORMAT) != '') echo get_option(SETTING_TAG_TITLE_FORMAT); } ?>" />
                                        </td>
									</tr>		
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Search Title Format','re'); ?></label>	
                                        <a href="#key_list9" class="tooltip" >[?]</a>	
                                        <div id="key_list9" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
   															%search% - What was searched for','re'); 
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="search_title_format" id="search_title_format" style="width:450px;" value="<?php if(isset($_POST['search_title_format'])) echo $_POST['search_title_format']; else { if(get_option(SETTING_SEARCH_TITLE_FORMAT) != '') echo get_option(SETTING_SEARCH_TITLE_FORMAT); } ?>" />
                                        </td>
									</tr>		
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Description Format','re'); ?></label>	
                                        <a href="#key_list10" class="tooltip" >[?]</a>	
                                        <div id="key_list10" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
    														%description% - The original description as determined by the plugin, e.g. the excerpt if one is set or an auto-generated one','re'); 
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="description_format" id="description_format" style="width:450px;" value="<?php if(isset($_POST['description_format'])) echo $_POST['description_format']; else { if(get_option(SETTING_DESC_FORMAT) != '') echo get_option(SETTING_DESC_FORMAT); } ?>" />
                                        </td>
									</tr>		
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Category Title Format','re'); ?></label>	
                                        <a href="#key_list11" class="tooltip" >[?]</a>	
                                        <div id="key_list11" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
    														%category_title% - The original title of the category','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="category_title_format" id="category_title_format" style="width:450px;" value="<?php if(isset($_POST['category_title_format'])) echo $_POST['category_title_format']; else { if(get_option(SETTING_CAT_TITLE_FORMAT) != '') echo get_option(SETTING_CAT_TITLE_FORMAT); } ?>" />
                                        </td>
									</tr>		
									<tr class="form-field" >
										<th scope="row"><label><?php _e('404 Title Format','re'); ?></label>	
                                        <a href="#key_list12" class="tooltip" >[?]</a>	
                                        <div id="key_list12" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The following macros are supported:
    														%blog_title% - Your blog title
    														%blog_description% - Your blog description
    														%404_title% - Additional 404 title input','re'); 
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="404_title_format" id="404_title_format" style="width:450px;" value="<?php if(isset($_POST['404_title_format'])) echo $_POST['404_title_format']; else { if(get_option(SETTING_404_TITLE_FORMAT) != '') echo get_option(SETTING_404_TITLE_FORMAT); } ?>" />
                                        </td>
									</tr>
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Page Format','re'); ?></label>	
                                        <a href="#key_list13" class="tooltip" >[?]</a>	
                                        <div id="key_list13" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('This string gets appended/prepended to titles when they are for paged index pages (like home or archive pages).The following macros are supported: %page% - The page number','re'); 
    											 ?>
    										</p>	
										</div>		
                                        </th>							
										<td>
                                            <input type="text" name="page_format" id="page_format" style="width:450px;" value="<?php if(isset($_POST['page_format'])) echo $_POST['page_format']; else { if(get_option(SETTING_SEO_PAGE_FORMAT) != '') echo get_option(SETTING_SEO_PAGE_FORMAT); } ?>" />
                                        </td>
									</tr>
									<tr class="form-field" >
										<th scope="row"><label><?php _e('SEO for Custom Post Types','re'); ?></label>	
                                        <a href="#key_list14" class="tooltip" >[?]</a>	
                                        <div id="key_list14" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Check this if you want your enable SEO support for Custom Post Types on this site.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        	<input type="checkbox" name="seo_post_type" value="1" <?php $seo_posts = get_option(SETTING_SEO_POST_TYPE);  if(isset($seo_posts) && get_option(SETTING_SEO_POST_TYPE) == 1) echo 'checked="checked"'; ?> />
                                        </td>
									</tr>		
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Custom Post Types for SEO Column Support','re'); ?></label>	
                                        <a href="#key_list15" class="tooltip" >[?]</a>	
                                        <div id="key_list15" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Choose which post types you want to have SEO columns on the screen. You can select as many as you like.','re'); ?></p>	
										</div>		
                                        </th>	
                                        <?php 
                                        $type_support = '';
										if(get_option(SETTING_POST_TYPE_SUPORT) != '')
											$type_support = get_option(SETTING_POST_TYPE_SUPORT,true);
                                        ?>						
										<td >
                                        	<input type="checkbox" name="product" value="1" <?php if(isset($type_support['product']) && $type_support['product'] == 1) echo 'checked="checked"'; ?>  />
                                        	<label><?php _e('Product','re');?></label>
                                        	<br />
                                        	<input type="checkbox" name="post" value="1" <?php if(isset($type_support['post']) && $type_support['post'] == 1) echo 'checked="checked"'; ?> />
                                        	<label><?php _e('Post','re');?></label>
                                        	<br />
                                        	<input type="checkbox" name="page" value="1" <?php if(isset($type_support['page']) && $type_support['page'] == 1) echo 'checked="checked"'; ?> />
                                        	<label><?php _e('Page','re');?></label>
                                        	<br />
                                        	<input type="checkbox" name="article" value="1" <?php if(isset($type_support['article']) && $type_support['article'] == 1) echo 'checked="checked"'; ?> />
                                        	<label><?php _e('Article','re');?></label>
                                        </td>
									</tr>		
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Use Categories for META keywords','re'); ?></label>	
                                        <a href="#key_list16" class="tooltip" >[?]</a>	
                                        <div id="key_list16" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Check this if you want your categories for a given post used as the META keywords for this post (in addition to any keywords and tags you specify on the post edit page).','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        	<input type="checkbox" name="add_category_keyword" value="1" <?php $add_cat_key = get_option(SETTING_ADD_CAT_KEYWORD); if(isset($add_cat_key) && get_option(SETTING_ADD_CAT_KEYWORD) == 1) echo 'checked="checked"'; ?> />
                                        </td>
									</tr>		
									<tr class="form-field">
										<th scope="row"><label><?php _e('Use Tags for META keywords','re'); ?></label>	
                                        <a href="#key_list17" class="tooltip" >[?]</a>	
                                        <div id="key_list17" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Check this if you want your tags for a given post used as the META keywords for this post (in addition to any keywords you specify on the post edit page).','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        	<input type="checkbox" name="add_tag_keyword" value="1" <?php $add_tag_key = get_option(SETTING_ADD_TAG_KEYWORD); if(isset($add_tag_key) && get_option(SETTING_ADD_TAG_KEYWORD) == 1) echo 'checked="checked"'; ?> />
                                        </td>
									</tr>		
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Dynamically Generate keywords for Posts Page','re'); ?></label>	
                                        <a href="#key_list18" class="tooltip" >[?]</a>	
                                        <div id="key_list18" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Check this if you want your keywords on a custom posts page (set it in options->reading) to be dynamically generated from the keywords of the posts showing on that page. If unchecked, it will use the keywords set in the edit page screen for the posts page.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        	<input type="checkbox" name="dynamid_generate_post_page" value="1" <?php $dymnamid = get_option(SETTING_DYNAMICALLY_GENERATE_POST_TYPE); if(isset($dymnamid) && get_option(SETTING_DYNAMICALLY_GENERATE_POST_TYPE) == 1) echo 'checked="checked"'; ?> />
                                        </td>
									</tr>
									<!-- 		
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Use noindex for Categories','re'); ?></label>	
                                        <a href="#key_list19" class="tooltip" >[?]</a>	
                                        <div id="key_list19" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Check this for excluding category pages from being crawled. Useful for avoiding duplicate content.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        	<input type="checkbox" name="noindex_category" value="1" <?php $noindex_cat = get_option(SETTING_NOINDEX_CAT); if(isset($noindex_cat) && get_option(SETTING_NOINDEX_CAT) == 1) echo 'checked="checked"'; ?> />
                                        </td>
									</tr>
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Use noindex for Achives','re'); ?></label>	
                                        <a href="#key_list20" class="tooltip" >[?]</a>	
                                        <div id="key_list20" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Check this for excluding archive pages from being crawled. Useful for avoiding duplicate content.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        	<input type="checkbox" name="noindex_achive" value="1" <?php $noindex_achive = get_option(SETTING_NOINDEX_ACHIVE); if(isset($noindex_achive) && get_option(SETTING_NOINDEX_ACHIVE) == 1) echo 'checked="checked"'; ?> />
                                        </td>
									</tr>		
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Use noindex for Tag Achives','re'); ?></label>	
                                        <a href="#key_list21" class="tooltip" >[?]</a>	
                                        <div id="key_list21" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Check this for excluding tag pages from being crawled. Useful for avoiding duplicate content.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        	<input type="checkbox" name="noindex_tag_achive" value="1" <?php $noindex_tag = get_option(SETTING_NOINDEX_TAG_ACHIVE); if(isset($noindex_tag) && get_option(SETTING_NOINDEX_TAG_ACHIVE) == 1) echo 'checked="checked"'; ?> />
                                        </td>
									</tr>		
									-->
									<tr class="form-field" >
										<th scope="row"><label><?php _e('Autogenerate Descriptions','re'); ?></label>	
                                        <a href="#key_list22" class="tooltip" >[?]</a>	
                                        <div id="key_list22" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Check this and your META descriptions will get autogenerated if there\'s no excerpt.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        	<input type="checkbox" name="auto_description" value="1" <?php $auto_des = get_option(SETTING_AUTO_DESC); if(isset($auto_des) && get_option(SETTING_AUTO_DESC) == 1) echo 'checked="checked"'; ?> />
                                        </td>
									</tr>
									 <tr class="form-field" >
										<th scope="row"><label><?php _e('Additional Post Headers','re'); ?></label>	
                                        <a href="#key_list23" class="tooltip" >[?]</a>	
                                        <div id="key_list23" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('What you enter here will be copied verbatim to your header on post pages. You can enter whatever additional headers you want here, even references to stylesheets.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
											<textarea name="additional_post_header" id="additional_post_header" rows="2"><?php if(isset($_POST['additional_post_header'])) echo $_POST['additional_post_header']; else { if(get_option(SETTING_ADDITIONAL_POST_HEADER) != '') echo get_option(SETTING_ADDITIONAL_POST_HEADER); } ?></textarea>
									   </td>
									</tr>	
									 <tr class="form-field" >
										<th scope="row"><label><?php _e('Additional Page Headers','re'); ?></label>	
                                        <a href="#key_list24" class="tooltip" >[?]</a>	
                                        <div id="key_list24" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('What you enter here will be copied verbatim to your header on pages. You can enter whatever additional headers you want here, even references to stylesheets.','re'); ?></p>	
										</div>		
                                        </th>
                                        <td>
											<textarea name="additional_page_header" id="additional_page_header" rows="2"><?php if(isset($_POST['additional_page_header'])) echo $_POST['additional_page_header']; else { if(get_option(SETTING_ADDITIONAL_PAGE_HEADER) != '') echo get_option(SETTING_ADDITIONAL_PAGE_HEADER); } ?></textarea>
									   </td>
									</tr>	
									 <tr class="form-field" >
										<th scope="row"><label><?php _e('Additional Home Headers','re'); ?></label>	
                                        <a href="#key_list25" class="tooltip" >[?]</a>	
                                        <div id="key_list25" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('What you enter here will be copied verbatim to your header on the home page. You can enter whatever additional headers you want here, even references to stylesheets.','re'); ?></p>	
										</div>		
                                        </th>
                                        <td>
											<textarea name="additional_home_header" id="additional_home_header" rows="2"><?php if(isset($_POST['additional_home_header'])) echo $_POST['additional_home_header']; else { if(get_option(SETTING_ADDITIONAL_HOME_HEADER) != '') echo get_option(SETTING_ADDITIONAL_HOME_HEADER); } ?></textarea>
									   </td>	
									</tr>										
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>
							
							<p/>		
										
							<div class="section-button-area">							
							    <div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="save_seo" style="float:left;" value="<?php _e('Save','re'); ?>" />
								</div>
								<div class="clear"></div>
							</div>		
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- // End box SEO setting  -->
	</form> <!-- //form -->	
</div> <!-- //end wrap 1 -->