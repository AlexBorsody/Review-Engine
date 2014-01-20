<?php
/*
 * @Author: James. 
 */
if(isset($_POST['submitted']) && $_POST['submitted'] == 'yes')
{	
	//Language
	if(isset($_POST['set_default_lang']) && !empty($_POST['set_default_lang']))
	{
		$def_lang = parse_ini_file(TEMPLATEPATH.'/data/default_data.ini');
		update_option(SETTING_LANGUAGE,$def_lang[SETTING_LANGUAGE]);
		$message = __('Set default language successfully.','re');
	}
	if(isset($_POST['active_lang']) && !empty($_POST['active_lang']))
	{
		if(isset($_POST['def_lang']) && $_POST['def_lang'] != '')
		{
			update_option(SETTING_LANGUAGE,$_POST['def_lang']);
			$message = __('Activate language successfully.','re');
		}
		else
		{
			$errors .= __('Error: Please choose the language.');
		}
	}
	//Favicon	
	if(isset($_POST['upload_favicon']) && !empty($_POST['upload_favicon']))
	{
		$new_favi = $_FILES['your_favi'];
		if($new_favi['name'] != '' )
		{
			if($new_favi['error'] > 0)
			{	
				$errors .= __("Error: Can't upload your favicon.", 're')."<br>";			
			}	
			if($new_favi['type'] != 'image/x-icon')
			{
				$errors .= __("Error: The favicon type should be a *.ico file.", 're')."<br>";	
			}			
		}else if($new_favi['name'] == '')
		{
			$errors .= __("Error: Please enter your favicon path.", 're')."<br>";		
		}
		if($errors == '')
		{
			$save_to = TEMPLATEPATH.'/';
			if(file_exists(TEMPLATEPATH .'/'.$new_favi['name']))
				unlink(TEMPLATEPATH.'/'.$new_favi['name']);
			move_uploaded_file($new_favi["tmp_name"],$save_to . $new_favi["name"]);
			update_option(SETTING_FAVICON,$new_favi["name"]);	
			$message = __("Upload your new favicon successfully.", 're')."<br>";	
		}		
	}
	//Header Logo	
	if(isset($_POST['set_default_logo']) && !empty($_POST['set_default_logo']))
	{
		$curr_logo = get_option(SETTING_LOGO);		
		if(file_exists(WP_CONTENT_DIR .'/uploads/re/' . $curr_logo) && $curr_logo != '')
			unlink(WP_CONTENT_DIR .'/uploads/re/' . $curr_logo);
		$def_logo = parse_ini_file(TEMPLATEPATH.'/data/default_data.ini');
		update_option(SETTING_LOGO,$def_logo[SETTING_LOGO]);
		$message = __("Set default logo successfully.", 're')."<br>";
	}
	if(isset($_POST['upload_logo']) && !empty($_POST['upload_logo']))
	{
		$new_logo = $_FILES['your_logo'];
		if($new_logo['name'] != '' )
		{
			if($new_logo['error'] > 0)
			{	
				$errors .= __("Error: Can't upload your logo.", 're')."<br>";			
			}			
		}else if($new_logo['name'] == '')
		{
			$errors .= __("Error: Please enter your logo path.", 're')."<br>";		
		}
		if($errors == '')
		{
			$save_to = WP_CONTENT_DIR.'/uploads/re';
			
			$logo_results = move_uploaded_file($new_logo["tmp_name"],$save_to .'/'. $new_logo["name"]);
			
			if ($logo_results === false)
			{
				$errors .= __("Error: We can't upload your logo.", 're')."<br>";
			}
			else{
				$curr_logo = get_option(SETTING_LOGO);
				if(file_exists(WP_CONTENT_DIR .'/uploads/re/' . $curr_logo))
					unlink(WP_CONTENT_DIR .'/uploads/re/' . $curr_logo);
				$curr_logo = $new_logo["name"];				
				update_option(SETTING_LOGO,$curr_logo);
			}
			$message = __("Upload your new logo successfully.", 're')."<br>";						
		}		
	}
	// Save embedded scripts 
	if(!empty($_POST['embedded_scripts_submit']) && isset($_POST['embedded_scripts_submit'])){
		if(isset($_POST['embedded_scripts']))
				update_option(SETTING_EMBEDDED_SCRIPTS, $_POST['embedded_scripts']);
		$message = __("The embedded scripts had been saved", 're')."<br>";
	}
	
	// save homepage listing
	if ( !empty( $_POST['homepage_listing'] ) )
	{
		update_option(SETTING_SORTING_TYPES, $_POST['sorting_pages']);
		update_option(SETTING_SORTING_DEFAULT, $_POST['default_sorting']);
	}
}
?>