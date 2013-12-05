<?php
/*
 * @Author: James. 
 */
global $sorting_pages;
$errors = '';
$message = '';
require_once TEMPLATEPATH . '/admin_processing/admin_display_setting_processing.php';
?>
<div class="wrap"> <!-- #wrap 1 -->
	<div id="icon-edit" class="icon32"><br></div>
	<h2>
		<?php _e('Display Settings','re'); ?>
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
	<form method="post" name="upload_display" enctype="multipart/form-data" target="_self">
	<input name="submitted" type="hidden" value="yes" />			
		<div id="poststuff" class="has-right-sidebar"> <!-- box language setting -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('Language','re'); ?></label></h3>
						<div class="inside">						
							
							<table class="form-table"> <!-- form table -->
								<tbody>
									<tr class="form-field">
										<th scope="row"><label for="user_login"><?php _e('Current Language','re'); ?></label>										
										<td>
                                        <?php 
										$curr_lang = get_option(SETTING_LANGUAGE);
										echo $curr_lang;
										?>                  						
                                        </td>
									</tr>
									
									<tr class="form-field" id="favi_file">
										<th scope="row"><label><?php _e('Select Language','re'); ?></label>	
                                        <a href="#enable_language" class="tooltip" >[?]</a>	
                                        <div id="enable_language" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Select the language which will be shown on theme.','re'); ?></p>	
										</div>									
										<td>
                                        <?php
										$language = get_available_languages(TEMPLATEPATH.'/lang');	
										?>
										<select name="def_lang" id="def_lang" style="width:130px;">
                                        	<option value=""><?php _e('Select','re'); ?></option>
											<?php
											if($language != '')
											{												
												for($i=0;$i<count($language);$i++)
												{
												?>
													<option value="<?php echo $language[$i]; ?>" <?php if($curr_lang==$language[$i]) { echo 'selected="selected"'; } ?>>
												<?php 
													echo $language[$i];				
													echo '</option>';
												}
											}
											?>
										</select>  
                                        </td>
									</tr>									
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>									
							<div class="section-button-area">							
							    <div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="active_lang" style="float:left;" value="<?php _e('Activate','re'); ?>" />                              
									<input class="left-align button" type="submit" value="<?php _e('Reset to Default','re'); ?>" name="set_default_lang" />
								</div>
								<div class="clear"></div>
							</div>		
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- //box favicon setting -->
        
		<div id="poststuff" class="has-right-sidebar"> <!-- box post 1 -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('Favicon','re'); ?></label></h3>
						<div class="inside">						
							
							<table class="form-table"> <!-- form table -->
								<tbody>
									<tr class="form-field">
										<th scope="row"><label for="user_login"><?php _e('Current Favicon','re'); ?></label>										
										<td>
                                        <?php $curr_favi = get_option(SETTING_FAVICON); ?>					
                						<img src="<?php echo TEMPLATE_URL.'/'.$curr_favi; ?>" width="32px" height="32px" title="<?php _e('Current Favicon','re');?>" alt=""/> 
                                        </td>
									</tr>
									
									<tr class="form-field" id="favi_file">
										<th scope="row"><label><?php _e('Upload Favicon','re'); ?></label>
                                        <a href="#enable_favicon" class="tooltip" >[?]</a>	
                                        <div id="enable_favicon" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('Should be rename file as favicon.ico','re'); ?></p>	
										</div>								
										<td>
                                        <input type="file" name="your_favi" id="your_favi" value=""  style="width:200px; border:1px solid #C7C7C7;" size="35px"/>                 
                    <div class="tgt_warning">(<?php _e('Your favicon file should rename as favicon.ico and the size should be 32x32 pixel','re');?>)</div>    
                                        </td>
									</tr>									
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>										
							<div class="section-button-area">							
							    <div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="upload_favicon" style="float:left;" value="<?php _e('Upload','re'); ?>" />     		
								</div>
								<div class="clear"></div>
							</div>		
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- //post box 1 -->
		
		<!-- example  style for post box 2 -->
		<style>
			#namediv input{
				
			}
			#namediv textarea{
				cols: 10;
			}
		</style>
		
		
		<div id="poststuff" class="has-right-sidebar"> <!-- box logo header setting-->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('Logo','re'); ?></label></h3>
						<div class="inside">						
							
							<table class="form-table"> <!-- form table -->
								<tbody>
									<tr class="form-field">
										<th scope="row"><label for="user_login"><?php _e('Current Logo','re'); ?></label>										
										<td>
                                        <?php	$curr_logo = explode('/',get_option(SETTING_LOGO));?>
								<?php
								if(count($curr_logo) > 1 && $curr_logo[0] == 'images')
								{
								?>
									<img src="<?php echo TEMPLATE_URL.'/'.$curr_logo[0].'/'.$curr_logo[1]; ?>" height="80px" title="<?php _e('Current Logo','re');?>" alt=""/>									
								<?php
								}else
								{
								?>
									<img src="<?php echo WP_CONTENT_URL .'/uploads/re/'.$curr_logo[0]; ?>" height="80px" title="<?php _e('Current Logo','re');?>" alt=""/>
								<?php
								}
								?>
                                        </td>
									</tr>
									
									<tr class="form-field" id="logo_file">
										<th scope="row"><label><?php _e('Upload Logo','re'); ?></label>	
                                        <a href="#enable_logo" class="tooltip" >[?]</a>	
                                        <div id="enable_logo" style="display: none" class="tooltip-content t_wide">
											<p><?php _e('The logo image will be displayed in header of website.','re'); ?></p>	
										</div>								
										<td>
                                        <input type="file" name="your_logo" id="your_logo" value=""  style="width:200px; border:1px solid #C7C7C7;" size="35px"/>                 
                    
                                        </td>
									</tr>									
								</tbody>
							</table> <!-- //form table -->
							
							<div class="clear"></div>	
							<div class="section-button-area">							
							    <div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="upload_logo" style="float:left;" value="<?php _e('Upload','re'); ?>" />                              
									<input class="left-align button" type="submit" value="<?php _e('Reset to Default','re'); ?>" name="set_default_logo" />
								</div>
								<div class="clear"></div>
							</div>		
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 <!-- //box logo header setting-->       
        
		
		<div id="poststuff" class="has-right-sidebar"> <!-- box Analytics -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e ('Embedded Scripts', 're');?></label></h3>
						<div class="inside">						
							
							<table class="form-table"> <!-- form table -->
								<tbody>
									<tr class="form-field">
										<th scope="row"><label for="embedded_scripts"><?php _e ('Scripts', 're');?> </label>
										<a href="#embedded_scripts_description" class="tooltip">[?]</a>
										<div id="embedded_scripts_description" class="tooltip-content t_wide">
											<?php _e ('The scripts you add here will be served after the HTML on every page of your site. You can insert into analytical tools for your website such as <a href="http://www.google.com/analytics/" target="_blank">Google Analytics</a> or <a href="http://piwik.org/" target="_blank">Piwik</a>, ...etc', 're');?>
										</div>								
										<td>
											<span class="tgt_warning"><?php _e('Must include "script" tags <br>', 're');?></span>
											<textarea style="width: 100%" rows="15" name="embedded_scripts"><?php echo stripslashes(get_option('tgt_embedded_cripts'));?></textarea>
										</td>
									</tr>		
									
								</tbody>
							</table> <!-- //form table -->							
							<div class="clear"></div>							
								<div class="section-button-area">							
									<div class="section-buttons">
									  
										<input class="left-align button-primary" type="submit" name="embedded_scripts_submit" value="<?php _e ('Save', 're');?>">
									  
									</div>
									<div class="clear"></div>
								</div>			
							
							</div>
						</div>	
				
				</div>
			</div>
		</div>	 <!-- //box Analytics -->
			
		<div id="poststuff" class="has-right-sidebar"> <!-- box Analytics -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e ('Homepage Listing', 're');?></label></h3>
						<div class="inside">						
							
							<table class="form-table"> <!-- form table -->
								<tbody>
									<tr class="form-field">
										<th scope="row"><label for="embedded_scripts"><?php _e ('Product\'s Sorting Option', 're');?> </label>
										<a href="#sorting_types" class="tooltip">[?]</a>
										<div id="sorting_types" class="tooltip-content t_wide">
											<?php _e ('Check on sorting type that you want to display in homepage of review engine', 're');?>
										</div>								
										<td>
											<span class="tgt_warning"><?php _e('If you don\'t choose any type, Review Engine will display Recent Product as default', 're');?></span>
											<br />
											<?php
											$types = &get_option(SETTING_SORTING_TYPES);
											if ( !is_array($types) )  $types = array();
											
											foreach($sorting_pages as $id => $page){
												$checked = in_array( $id, $types ) ? 'checked="checked"' : '';
												?>
												<input type="checkbox" name="sorting_pages[]" value="<?php echo $id ?>" <?php echo $checked ?> />
												<label for="sorting_pages[]"><?php echo $page['name'] ?></label>
												<br />
											<?php } ?>
										</td>
									</tr>
									<tr class="form-field">
										<th scope="row"><label for="embedded_scripts"><?php _e ('Default Sorting Type', 're');?> </label>
										<a href="#sorting_types_default" class="tooltip">[?]</a>
										<div id="sorting_types_default" class="tooltip-content t_wide">
											<?php _e ('Choose default sorting type that will display first in homepage', 're');?>
										</div>								
										<td>					
											<span class="tgt_warning"><?php _e('Please only choose type that you allow to display in the upon form', 're');?></span>
											<br />
											<?php $default_sorting = &get_option(SETTING_SORTING_DEFAULT); ?>
											<select name="default_sorting" >
											<?php										
											foreach($sorting_pages as $id => $page){
												$selected = $default_sorting == $id ? 'selected="selected"' : '';
												?>
												<option value="<?php echo $id ?>" <?php echo $selected ?>><?php echo $page['name'] ?></option>
											<?php } ?>
											</select>
										</td>
									</tr>	
									
								</tbody>
							</table> <!-- //form table -->							
							<div class="clear"></div>							
								<div class="section-button-area">							
									<div class="section-buttons">
										<input class="left-align button-primary" type="submit" name="homepage_listing" value="<?php _e ('Save', 're');?>">
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