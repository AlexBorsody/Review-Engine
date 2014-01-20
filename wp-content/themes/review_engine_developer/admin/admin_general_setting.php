<?php
/*
 * @Author: James. 
 */
$errors = '';
$message = '';
require_once TEMPLATEPATH . '/admin_processing/admin_general_setting_processing.php';
?>
<div class="wrap"> <!-- #wrap 1 -->
	<div id="icon-edit" class="icon32"><br></div>
	<h2>
		<?php _e('General Settings','re'); ?>
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
	<div id="poststuff" class="has-right-sidebar"> <!-- box Symbol setting -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('Currency Symbol','re'); ?></label> <a href="#enable_symbol" class="tooltip" >[?]</a></h3>
						<div id="enable_symbol" style="display: none" class="tooltip-content t_wide">
							<p><?php _e('eg, ','re'); ?> : &pound;, &euro;, &yen; ...</p>	
						</div>	
						<div class="inside">	
						<?php $list_symbol = get_option(SETTING_CURRENCY_SYMBOL); ?>
							<table class="form-table"> <!-- form table -->
								<tbody>		
								<tr class="form-field">
										<th scope="row"><label><?php _e('Symbol','re'); ?></label>	                                       
                                        </th>								
										<td>
                                        <input type="text" name="price_symbol" id="price_symbol" maxlength="3"  style="width: 36px"   value="<?php if(isset($_POST['price_symbol'])) echo $_POST['price_symbol']; else { if( is_array($list_symbol) && $list_symbol['symbol'] != '') echo $list_symbol['symbol']; } ?>" />
                                        </td>
									</tr>
									<tr class="form-field">
										<th scope="row"><label><?php _e('Symbol Position','re'); ?></label>	                                        
                                        </th>								
										<td>
                                        <select name="position_symbol" id="position_symbol" >
											<option value="before" <?php echo (is_array($list_symbol) && $list_symbol['position'] == 'before')?'selected="selected"':' '; ?>><?php _e('Before Currency','re'); ?></option>
											<option value="after" <?php echo (is_array($list_symbol) && $list_symbol['position'] == 'after')?'selected="selected"':' '; ?>><?php _e('After Currency','re'); ?></option>
											<option value="beforespace" <?php echo (is_array($list_symbol) && $list_symbol['position'] == 'beforespace')?'selected="selected"':' '; ?>><?php _e('Before Currency With Space','re'); ?></option>
											<option value="afterspace" <?php echo (is_array($list_symbol) && $list_symbol['position'] == 'afterspace')?'selected="selected"':' '; ?>><?php _e('After Currency With Space','re'); ?></option>
										</select>
                                        </td>
									</tr>				    							
								</tbody>
							</table> <!-- //form table -->
																
							
							<div class="clear"></div>
							
							<p/>		
										
							<div class="section-button-area">							
							    <div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="save_currency_symbol" style="float:left;" value="<?php _e('Save','re'); ?>" />  								</div>
								<div class="clear"></div>
							</div>		
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- //box Symbol setting  -->
	
		<div id="poststuff" class="has-right-sidebar"> <!-- box Search example setting -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('Tips Search','re'); ?></label> <a href="#enable_tips_search" class="tooltip" >[?]</a></h3>
						<div id="enable_tips_search" style="display: none" class="tooltip-content t_wide">
							<p><?php _e('Example text for the search box','re'); ?></p>	
						</div>	
						<div class="inside">	
						<?php $tips_search = get_option(SETTING_TIPS_SEARCH); ?>
							<table class="form-table"> <!-- form table -->
								<tbody>		
								<tr class="form-field">
										<th scope="row"><label><?php _e('Search example text','re'); ?>:</label>	                                       
                                        </th>								
										<td>
                                        <input type="text" name="tips_search" id="tips_search"  style="width: 350px"   value="<?php if(isset($_POST['tips_search'])) echo htmlspecialchars($_POST['tips_search']); else { if($tips_search != '') echo htmlspecialchars($tips_search); } ?>" />
                                        <p><?php _e('e.g. "Apple Macbook Pro", "Canon EOS 60D", etc.','re') ?></p>
                                        </td>
									</tr>										    							
								</tbody>
							</table> <!-- //form table -->
																
							
							<div class="clear"></div>
							
							<p/>		
										
							<div class="section-button-area">							
							    <div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="save_tips_search" style="float:left;" value="<?php _e('Save','re'); ?>" />  								</div>
								<div class="clear"></div>
							</div>		
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- //box Symbol example setting  -->
	
				
		<div id="poststuff" class="has-right-sidebar"> <!-- box Items Per Page setting -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('Items Per Page','re'); ?></label></h3>
						<div class="inside">						
							
							<table class="form-table"> <!-- form table -->
								<tbody>
									<tr class="form-field"><!-- //Top Products Limitation -->
										<th scope="row"><label><?php _e('Top Products Limitation','re'); ?></label>	
                                        <a href="#top_product" class="tooltip" >[?]</a>	
                                        <div id="top_product" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Enter the limited number of top products can be displayed at the homepage.','re'); ?></p>	
										</div>	
                                        </th>								
										<td>
                                        <input type="text" name="top_count" id="top_count" style="width:100px;" onkeypress="return NumbersPrice(event);"  value="<?php if(isset($_POST['top_count'])) echo $_POST['top_count']; else { if(get_option(SETTING_TOP_NUMBER_PRODUCT) != '') echo get_option(SETTING_TOP_NUMBER_PRODUCT); } ?>" />
                                        </td>
									</tr>
									<tr class="form-field"><!-- //Latest Products Limitation -->
										<th scope="row"><label><?php _e('Recent Products Limitation','re'); ?></label>	
                                        <a href="#recent_product" class="tooltip" >[?]</a>	
                                        <div id="recent_product" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Enter the limited number of recent products can be displayed at the homepage.','re'); ?></p>	
										</div>	
                                        </th>								
										<td>
                                        <input type="text" name="recent_count" id="recent_count" style="width:100px;" onkeypress="return NumbersPrice(event);"  value="<?php if(isset($_POST['recent_count'])) echo $_POST['recent_count']; else { if(get_option(SETTING_RECENT_NUMBER_PRODUCT) != '') echo get_option(SETTING_RECENT_NUMBER_PRODUCT); } ?>" />
                                        </td>
									</tr>
									<tr class="form-field"><!-- //Articles per page -->
										<th scope="row"><label><?php _e('Articles','re'); ?></label>	
                                        <a href="#enable_articles" class="tooltip" >[?]</a>	
                                        <div id="enable_articles" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('How many articles per page do you want to show ? And must be numeric.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        <input type="text" name="articles_nums" id="articles_nums" style="width:100px;" onkeypress="return NumbersPrice(event);" value="<?php if(isset($_POST['articles_nums'])) echo $_POST['articles_nums']; else { if(get_option('posts_per_page') != '') echo get_option('posts_per_page'); else echo 1;} ?>" />
                                        </td>
									</tr>
                                    <tr class="form-field"><!-- //Comments per page -->
										<th scope="row"><label><?php _e('Comments Number','re'); ?></label>	
                                        <a href="#enable_comments" class="tooltip" >[?]</a>	
                                        <div id="enable_comments" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('How many comments number for each article do you want to show ? And must be numeric.','re'); ?></p>	
										</div>	
                                        </th>								
										<td>
                                        <input type="text" name="comments_nums" id="comments_nums" style="width:100px;" onkeypress="return NumbersPrice(event);" value="<?php if(isset($_POST['comments_nums'])) echo $_POST['comments_nums']; else { if(get_option('comments_per_page') != '') echo get_option('comments_per_page'); else echo 1;} ?>" />
                                        </td>
									</tr>	
                                    <tr class="form-field"><!-- //Products per page -->
										<th scope="row"><label><?php _e('Products','re'); ?></label>	
                                        <a href="#enable_products" class="tooltip" >[?]</a>	
                                        <div id="enable_products" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('How many product per page do you want to show ? And must be numeric.','re'); ?></p>	
										</div>	
                                        </th>								
										<td>
                                        <input type="text" name="products_nums" id="products_nums" style="width:100px;" onkeypress="return NumbersPrice(event);" value="<?php if(isset($_POST['products_nums'])) echo $_POST['products_nums']; else {if(get_option(SETTING_PRODUCTS_PER_PAGE) != '') echo get_option(SETTING_PRODUCTS_PER_PAGE); else echo 1;} ?>" />
                                        </td>
									</tr>	
                                    <tr class="form-field"><!-- //Reviews per product -->
										<th scope="row"><label><?php _e('Reviews Number','re'); ?></label>	
                                        <a href="#enable_reviews" class="tooltip" >[?]</a>	
                                        <div id="enable_reviews" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('How many reviews number for each product do you want to show ? And must be numeric.','re'); ?></p>	
										</div>	
                                        </th>								
										<td>
                                        <input type="text" name="reviews_nums" id="reviews_nums" style="width:100px;" onkeypress="return NumbersPrice(event);" value="<?php if(isset($_POST['reviews_nums'])) echo $_POST['reviews_nums']; else { if(get_option(SETTING_REVIEWS_PER_PRODUCT) != '') echo get_option(SETTING_REVIEWS_PER_PRODUCT); else echo 1;} ?>" />
                                        </td>
									</tr>							
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>
							
							<p/>		
										
							<div class="section-button-area">							
							    <div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="save_item_per_page" style="float:left;" value="<?php _e('Save','re'); ?>" />  								</div>
								<div class="clear"></div>
							</div>		
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- //box Items Per Page setting  -->
		<div id="poststuff" class="has-right-sidebar"> <!-- box Facebook API setting -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('Facebook Application API','re'); ?></label>&nbsp;<a href="#enable_fb_app" class="tooltip" >[?]</a>	</h3>
						<div id="enable_fb_app" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Provide some informations to use facebook login button in front-end. If you have not facebook API account, you can register at','re');?>&nbsp;<a href="http://developers.facebook.com/setup/" target="_blank"><?php _e('here','re'); ?></a>.</p>	
										</div>
						<div class="inside">	
							<table class="form-table"> <!-- form table -->
								<tbody>									
				    <tr class="form-field"><!-- //FB app ID -->
										<th scope="row"><label><?php _e('Facebook App ID','re'); ?></label>	
                                        <a href="#enable_fb_id" class="tooltip" >[?]</a>	
                                        <div id="enable_fb_id" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Enter your facebook application API ID after you register facebook application successfully.','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        <input type="text" name="fb_id" id="fb_id" style="width:250px;" value="<?php if(isset($_POST['fb_id'])) echo $_POST['fb_id']; else { if(get_option(SETTING_FB_API_ID) != '') echo get_option(SETTING_FB_API_ID); } ?>" />
                                        </td>
									</tr>
                                    <tr class="form-field"><!-- //FB app secret code -->
										<th scope="row"><label><?php _e('Facebook App Secret Code','re'); ?></label>	
                                        <a href="#enable_fb_secret" class="tooltip" >[?]</a>	
                                        <div id="enable_fb_secret" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Enter your facebook application secret code after you register facebook application successfully.','re'); ?></p>	
										</div>	
                                        </th>								
										<td>
                                        <input type="text" name="fb_secret" id="fb_secret" style="width:250px;" value="<?php if(isset($_POST['fb_secret'])) echo $_POST['fb_secret']; else { if(get_option(SETTING_FB_API_SECRET) != '') echo get_option(SETTING_FB_API_SECRET); } ?>" />
                                        </td>
									</tr>	
                                    						
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>
							
							<p/>		
										
							<div class="section-button-area">							
							    <div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="save_fb_api" style="float:left;" value="<?php _e('Save','re'); ?>" />  								</div>
								<div class="clear"></div>
							</div>		
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- //box Facebook API setting  -->	

		<div id="poststuff" class="has-right-sidebar"> <!-- box feature redirect link setting -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('Feature Redirect Link','re'); ?></label></h3>
						<div class="inside">								
							<table class="form-table"> <!-- form table -->
								<tbody>									
									<tr class="form-field" id="show_desc"><!-- //Default Description -->
										<th scope="row"><label><?php _e('Enable Redirect Link','re'); ?></label>	
                                        <a href="#redirect_link" class="tooltip" >[?]</a>	
                                        <div id="redirect_link" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Redirect link help you to hide all the externallink (product url). Example: review engine will display "www.reviewengine.com/?redirect=12" instead of "www.apple.com/iPhone/".','re'); ?></p>	
										</div>		
                                        </th>							
										<td>
                                        <select name="enable_redirect">
											<option value="1" <?php if(get_option(SETTING_ENABLE_REDIRECT_LINK) == 1) echo 'selected="selected"'; ?>><?php _e('Yes','re'); ?></option>
											<option value="0" <?php if(get_option(SETTING_ENABLE_REDIRECT_LINK) == 0) echo 'selected="selected"'; ?>><?php _e('No','re'); ?></option>
										</select>
                                        </td>
									</tr>                                    					
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>
							
							<p/>		
										
							<div class="section-button-area">							
							    <div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="save_redirect" style="float:left;" value="<?php _e('Save','re'); ?>" />
								</div>
								<div class="clear"></div>
							</div>		
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- box feature redirect link setting -->
		<div id="poststuff" class="has-right-sidebar"> <!-- box MISC setting -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('Miscellaneous','re'); ?></label></h3>
						<div class="inside">						
							
							<table class="form-table"> <!-- form table -->
								<tbody>
									<tr class="form-field"><!-- //Permit enable autocomplete searching or not ? -->
										<th scope="row">
                                 <label><?php _e('Permit Enable Article Feature','re'); ?></label>
										<a href="#permit_article" class="tooltip" >[?]</a>	
                              <div id="permit_article" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Allow article pages display at the front end.','re'); ?></p>	
										</div>
                                        </th>								
										<td>
                                        <select name="enable_article" id="enable_article" style="width:100px;">
                                        	<option value="0" <?php if(get_option(SETTING_ENABLE_ARTICLE) == 0) echo 'selected="selected"'; ?>><?php _e('No','re'); ?></option>
                                            <option value="1" <?php if(get_option(SETTING_ENABLE_ARTICLE) == 1) echo 'selected="selected"'; ?>><?php _e('Yes','re'); ?></option>
                                        </select>
                                        </td>
									</tr>
									<tr class="form-field"><!-- //Permit enable autocomplete searching or not ? -->
										<th scope="row">
                                        <label><?php _e('Permit Enable Auto-Complete Search','re'); ?></label>	                                        
                                        </th>								
										<td>
                                        <select name="permit_autocomplete" id="permit_autocomplete" style="width:100px;">
                                        	<option value="0" <?php if(get_option(SETTING_ENABLE_AUTOCOMPLETE) == 0) echo 'selected="selected"'; ?>><?php _e('No','re'); ?></option>
                                            <option value="1" <?php if(get_option(SETTING_ENABLE_AUTOCOMPLETE) == 1) echo 'selected="selected"'; ?>><?php _e('Yes','re'); ?></option>
                                        </select>
                                        </td>
									</tr>                                    
                                    <tr class="form-field"><!-- //Permit show captcha on some form or not ? -->
										<th scope="row">
                                        <label><?php _e('Choose Form That Will Be Displayed Captcha','re'); ?></label>	                                        
                                        </th>								
										<td>
										<?php
										$captcha_form = '';
										if(get_option(SETTING_ENABLE_CAPTCHA) != '')
											$captcha_form = get_option(SETTING_ENABLE_CAPTCHA,true);										
										?>
                                        <input type="checkbox" name="register" value="1" <?php if(isset($captcha_form['register']) && $captcha_form['register'] == 1) echo 'checked="checked"'; ?> />&nbsp;<label><?php _e('Registration Form','re'); ?></label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="checkbox" name="login" value="1" <?php if(isset($captcha_form['login']) && $captcha_form['login'] == 1) echo 'checked="checked"'; ?> />&nbsp;<label><?php _e('Login Form','re'); ?></label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="checkbox" name="forgot_pass" value="1" <?php if(isset($captcha_form['forgot_pass']) && $captcha_form['forgot_pass'] == 1) echo 'checked="checked"'; ?> />&nbsp;<label><?php _e('Forgot Password Form','re'); ?></label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="checkbox" name="edit_acc" value="1" <?php if(isset($captcha_form['edit_acc']) && $captcha_form['edit_acc'] == 1) echo 'checked="checked"'; ?> />&nbsp;<label><?php _e('Edit Account Form','re'); ?></label>
										</td>
									</tr>
									<tr class="form-field">
										<th scope="row">
											<label for=""> <?php _e('Google reCaptcha public key' , 're') ?> </label>
										</th>
										<td>
											<input type="text" name="recaptcha_public_key" style="width: 250px" value="<?php echo get_option('recaptcha_public_key' , '') ?>" />
											<p class="note"><?php echo __('Note', 're') . ':' . __('You can register for public/private keys at ' , 're') . '<a href="https://www.google.com/recaptcha/">'.__('reCaptcha website' , 're' ).'</a>'; ?></p>
										</td>
									</tr>
									<tr class="form-field">
										<th scope="row">
											<label for=""> <?php _e('Google reCaptcha private key' , 're') ?> </label>
										</th>
										<td>
											<input type="text" name="recaptcha_private_key" style="width: 250px" value="<?php echo get_option('recaptcha_private_key' , '') ?>" />
										</td>
									</tr>
												
									<tr class="form-field"><!-- //Permalink -->
										<th scope="row">
											<label><?php _e('Product Slug','re'); ?></label>
											<a href="#product_slug" class="tooltip" >[?]</a>	
											<div id="product_slug" style="display: none" class="tooltip-content t_wide">
												<p><?php _e('Change type of product url when in viewing permalink. Default is "Product". Example: product slug is "item" which mean the product url is "www.yoursite.com/item/item-name"','re'); ?></p>	
											</div>
										</th>
										<td>
                                 <input type="text" style="width: 250px" name="product_slug" id="product_slug" value="<?php echo get_option('tgt_product_slug') ? get_option('tgt_product_slug') : 'product' ?>"/>
										</td>
									</tr>           
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>
							
							<p/>		
										
							<div class="section-button-area">							
							    <div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="save_misc" style="float:left;" value="<?php _e('Save','re'); ?>" />
								</div>
								<div class="clear"></div>
							</div>		
							
						</div>
					</div>					
				</div>
			</div>
		</div>	 <!-- //box MISC setting  -->
		<div id="poststuff" class="has-right-sidebar"> <!-- box feature redirect link setting -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('Feed','re'); ?></label></h3>
						<div class="inside">								
							<table class="form-table"> <!-- form table -->
								<tbody>									
									<tr class="form-field" id="show_desc"><!-- //Default Description -->
										<th scope="row"><label><?php _e('Display feed link at','re'); ?></label>	
											<a href="#feed_link" class="tooltip" >[?]</a>	
											<div id="feed_link" style="display: none" class="tooltip-content t_wide">
												<p><?php _e('Check on page that you want the feed link to display','re'); ?></p>	
											</div>		
                                        </th>							
										<td>										
											<input type="checkbox" name="feed_link_cat" value="1" <?php if(get_option(SETTING_FEED_LINK_CATEGORY)==1) echo "checked";?>>&nbsp;<label><?php _e ('Category page', 're'); ?></label><br>
											<input type="checkbox" name="feed_link_article" value="1" <?php if(get_option(SETTING_FEED_LINK_ARTICLE)==1) echo "checked";?>>&nbsp;<label><?php _e ('Article archive page', 're'); ?></label>
                                        </td>
									</tr>
									<tr>
										<th scope="row"><label><?php _e('Display feed link in menu','re'); ?></label>	
	                                        <a href="#feed_link_menu" class="tooltip" >[?]</a>	
	                                        <div id="feed_link_menu" style="display: none" class="tooltip-content t_wide">
												<p><?php _e('.','re'); ?></p>	
											</div>		
                                        </th>
                                        <td>
                                        	<select name="feed_link_menu">
                                        		<option value="1" <?php if(get_option(SETTING_FEED_LINK_MENU)==1) echo "selected='selected'"?>><?php _e ('Yes', 're');?></option>
                                        		<option value="0" <?php if(get_option(SETTING_FEED_LINK_MENU)==0) echo "selected='selected'"?>><?php _e ('No', 're');?></option>
                                        	</select>
                                        </td>
									</tr>
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>							
							<p/>
							<div class="section-button-area">							
							    <div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="save_feed" style="float:left;" value="<?php _e('Save','re'); ?>" />
								</div>
								<div class="clear"></div>
							</div>		
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>  
	</form> <!-- //form -->	
</div> <!-- //end wrap 1 -->