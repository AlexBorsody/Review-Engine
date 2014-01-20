<?php 
	include PATH_ADMIN_PROCESSING . DS. 'admin_add_article_processing.php';
	$post_id;
	$status;
	$term_id = 0;
	$product_id;
	$category_search;
	$preview;
	$error;
?>
<div class="wrap">
	<div id="icon-edit" class="icon32"><br></div>
	<h2><?php 
		if(isset($post_id) && $post_id > 0)
		{
			_e ('Edit article', 're');
			$post = get_post($post_id);			
			$term_id = get_query_var('cat');
			$cate_temp = get_the_category($post_id);			
			$term_id = $cate_temp[0]->term_id;
			$product_id = get_post_meta($post_id, 'tgt_product_id', true);
		}
		else if(isset($_GET['p']))
		{			
			$post_id = $_GET['p'];
			_e ('Edit article', 're');
			$post = get_post($post_id);			
			$cate_temp = get_the_category($post_id);
			$term_id = $cate_temp[0]->term_id;
			$product_id = get_post_meta($post_id, 'tgt_product_id', true);
		}
		else 
			_e ('Create article', 're');		
		?></h2>		
	<!--MESSAGE -->
	<?php 
		if(isset($post_id) && $post_id > 0)
		{
	?>
	<div class="updated below-h2" id="message">
		<p><?php echo  $status;?> <a href="<?php if(isset($post_id) && $post_id > 0) echo get_permalink($post_id);?>"><?php _e (' View article', 're');?></a></p>
	</div>
	<?php } ?>
	<?php 
		if(!empty($error))
		{	
			echo '<div class="error below-h2">';
			echo $error['title_error'].'<br>';
			echo $error['content_error'].'<br>';
			echo $error['category_error'].'<br>';
			echo '</div>';	 		
		}
	?>
	<div id="input_error" class="error below-h2">	
	</div>
	<form action="" method="post" name="post_article" id="post_article">
		<div id="poststuff" class="metabox-holder has-right-sidebar">
			<div id="side-info-column" class="inner-sidebar">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
					<div class="postbox" id="submitdiv">
						<div class="handlediv" title="Click to toggle">
							<br />
						</div>
						<h3 class="hndle">
							<span><?php _e ('Publish', 're');?></span>
						</h3>
						<div class="inside">
							<div id="submitpost" class="submitbox">
								<div id="minor-publishing">
									<div id="minor-publishing-actions">
										<?php 
											if(!isset($post_id) || $post_id < 1)
											{
										?>											
										<div id="save-action">
											<input type="submit" id="save-post" class="button button-highlighted" tabindex="4" value="<?php _e ('Save Draft', 're');?>" name="save" />
										</div>
										<?php 
											} 
											if(isset($post_id) && $post_id > 0)
											{
												global $helper;
										?>
										<div id="preview-action">
											<?php //echo $helper->link( __('Preview', 're'), get_permalink($post_id), array('id' => 'post-preview', 'class' => 'preview button', 'tabindex' => '4', 'target' => 'wp-preview') );?>
											<div id="preview-action">
											<a href="<?php  echo HOME_URL.'/?post_type=article&p='.$post_id;?>" id="post-preview" class="preview button" tabindex="4" target="wp-preview"> <?php _e('Preview', 're'); ?> </a>
											</div>
										</div>
										<?php } ?>
										<div class="clear"></div>
									</div>
									<div id="misc-publishing-actions">
										<div class="misc-pub-section misc-pub-section-last">
											<label for="post_status"><?php _e('Status:','re') ?></label>
											<span id="post-status-display"> <?php if(isset($post_id) && $post_id> 0) echo $post->post_status; else _e('Draft', 're') ?> </span>
										</div>
									</div>									
								</div>
								<div id="major-publishing-actions">								
									<div id="delete-action">
										<a href="http://localhost/review_engine/wp-admin/post.php?post=526&action=trash&_wpnonce=5a06cca38a" class="submitdelete deletion">
											<?php _e('Move to Trash', 're') ?>
										</a>
									</div>									
									<div id="publishing-action">
										<img src="<?php echo HOME_URL?>/wp-admin/images/wpspin_light.gif" alt="" id="ajax-loading" style="visibility: hidden;" />
										<input id="publish" class="button-primary" type="submit" value="<?php 
																										if(isset($post_id) && $post_id > 0)
																										{
																											if($post->post_status=='draf' || $post->post_status=='trash' || $post->post_status=='pending')
																												_e ('Publish', 're');
																											elseif($post->post_status == 'publish') 
																												_e ('Update', 're');
																										} 
																										else _e ('Publish', 're');
																										?>" accesskey="p" name="publish"/>
									</div>
										<div class="clear"></div>
								</div>
							</div>							
						</div>
						<div class="clear"></div>
					</div>
					<div class="postbox" id="categorydiv">
						<div class="handlediv" title="Click to toggle">
							<br />
						</div>
						<h3 class="hndle">
							<span><?php _e ('Category', 're');?></span>
						</h3>
						<div class="inside">
						<select name="category_search">
							<option value="0"><?php _e (' Please select a category...  ', 're');?></option>
							<?php 
											$args = array(
            	                            		'type' => 'post',
													'parent' => 0,
            	                            		'hide_empty' => 0,
	 												'exclude' => 1,
            	                            		'taxonomy' => 'category'
														);
											$category = get_categories($args);
											if(count($category)>0)
											{			
												foreach ($category as $value) 
												{
													$cate_name = esc_html($value->name);
													$cat_id = $value->term_id; 
										?>			
							 			<option value="<?php echo $cat_id ?>" <?php if(isset($post_id)) if($cat_id==$term_id) echo "selected='selected'"; ?> class="bold"><?php echo $cate_name;?></option>
				 			<?php
											// Get sub category
												$args_sub = array(
            	                            		'type' => 'post',
													'parent' => $cat_id,
            	                            		'hide_empty' => 0,
	 												'exclude' => 1,
            	                            		'taxonomy' => 'category'
													);
												$sub_category = get_categories($args_sub);
												if(!empty($sub_category))
												{
													foreach ($sub_category as $sub_cate)
													{
														$sub_cate_name = esc_html($sub_cate->name);
														$sub_cate_id = $sub_cate->term_id;
									?>
												<option value="<?php echo $sub_cate_id ?>" <?php if(isset($post_id)) if($sub_cate_id==$term_id) echo "selected='selected'";  ?>><?php echo '---'.$sub_cate_name?></option>
							<?php 
											}
										}
									}
								}
				 			?>
						</select>						
						<p id="category_error" class="tgt_warning"></p>
						</div>
					</div>
				</div>
			</div>
			<div id="post-body">
				<div id="post-body-content">
					<div id="titlediv">
						<div id="titlewrap">
							<label for="title" id="title-prompt-text" class="hide-if-no-js"><?php if(!isset($post_id) || $post_id < 1)  _e ('Enter title here', 're');?></label>
							<input type="text"  id="title" autocomplete="off" size="30" name="posttitle" value="<?php if(isset($post_id) && $post_id > 0) echo $post->post_title;?>"/>
							<input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id;?>"> 
							<p class="tgt_warning" id="title_error"></p>
						</div>
						<div class="inside">
							<div id="edit-slug-box"></div>
						</div>						
					</div>
					<div id="postdivrich" class="postarea">
						<div id="editorcontainer">
							<textarea name="content" class="post_content" id="post_content" cols="30" rows="10"><?php if(isset($post_id) && $post_id > 0) echo $post->post_content;?></textarea>
							<?php
								add_filter('mce_buttons', 'add_image_button');
								function add_image_button($buttons){
									array_push($buttons, 'image');
									array_push($buttons, 'code');
									return $buttons;
								}
								$args = array('extended_valid_elements' => "iframe[title|width|height|src]");
								add_filter('tiny_mce_before_init', 'add_iframe');
								function add_iframe($args){
									$args['extended_valid_elements'] = "iframe[title|width|height|src]";
									return $args;
								}
							?>
							<?php
								wp_tiny_mce(false, array(
									'editor_selector' => 'post_content'									
								));								
							?>
						</div>
						<p class="tgt_warning" id="content_error"></p>
					</div>					
					<div id="custom-metabox">
						<div class="postbox" id="product-search">
							<h3 class="hndle">
								<?php _e('Product', 're');?>
							</h3>
							<div class="inside"><br>
								<div id="titlewrap">
									<label for="title" id="title_search"><?php _e ('Title Search', 're');?></label>
									<input type="text" name="search_product" id="search_product_article" class="regular-text code" style="border-collapse: collapse; width: 50%">									
									<input type="button" id="search" name="search" value="<?php _e ('Search Products', 're');?>" class="button p-search" >
									<div id="table_product"></div>
									<br><p id="noresult" class="tgt_warning"></p>
									<label id="title_search_error" class="tgt_warning"></label>
								</div>								
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		// input clicked, hide the label
		jQuery('#title').focusin(function(){
			jQuery('#title-prompt-text').hide();
		});
		jQuery('#title').focusout(function(){
			if ( jQuery('#title').val() == '' )
				jQuery('#title-prompt-text').show();
		});
		jQuery('#search').click(function(){
			var cat = jQuery('select[name=category_search]').val();
			if(cat < 1)
			{
				jQuery('#title_search_error').html('<?php _e ('Please select a category', 're');?>');
				jQuery('#noresult').html('');
				return false;
			}
			else
			{
				jQuery('#title_search_error').html('');
				search_edit_product(0);
			}			
		});
		jQuery('#save-post').click(function(){
			return check_input();
			});
		jQuery('#post-preview').click(function(){
			return check_input();
		});
		jQuery('#publish').click(function(){
			return check_input();
			});
		function check_input()
		{
			var title = jQuery('#title').val();			
			var post_content = tinyMCE.get('post_content').getContent();
			var cate = jQuery('select[name=category_search]').val();
			var count = 0;
			var input_error = '';
			if(title=='')
			{
				count += 1;			
				input_error += "<?php _e ('Error: Title article can\'t be empty', 're')?>";
			}
			else
				jQuery('#title_error').html('');
			if(post_content=='')
			{				
				count += 1;
				if(input_error !== '')
				{
					input_error += '<br>';					
				}
				input_error += "<?php _e ('Error: Content article can\'t be empty', 're')?>";
			}
			else
				jQuery('#content_error').html('');
			if(cate < 1)
			{
				if(input_error !== '')
				{
					input_error += '<br>';					
				}
				input_error += "<?php _e ('Error: Please select a category', 're');?>";
				count += 1;
			}
			else
				jQuery('#category_error').html('');
			if(count > 0)
			{
				jQuery('#input_error').html(input_error);
				jQuery('#input_error').show();
				return false;
			}
			else
			{
				jQuery('#input_error').html('');
			}
			return true;
		}
		jQuery('.p-search').click(function(){
			 search_edit_product(0);
			});
		jQuery('#delete-action').click(function(){
			var error = check_input();
			if(!error)
				return false;
			var title = jQuery('#title').val();
			var content = tinyMCE.get('post_content').getContent();			
			var cate = jQuery('select[name=category_search]').val();
			var post_id = 0;
			post_id = "<?php if(isset($post_id) && $post_id>0) echo $post_id;?>";
			auto_save_trash(cate, title, content, post_id);			
			return false;
			});
		function auto_save_draf(cate, title, content, post_status)
		{
			ajax_url = "<?php echo HOME_URL . '/?ajax=admin_article_auto_save_draf'?>";
			$.post(
					reviewAjax.ajaxurl,
					{
						action: 'admin_article_auto_save_draf',
						category: cate,
						article_title: title,
						article_content: content						
					},
					function(data){
						if (data.success){
							if(data.para != '' || data.para > 0)
							{								
								var url = "<?php get_permalink() ?>)?>";								
								url += data.para;
								url += "<?php echo '&preview=true'?>";
								window.location = url;								
								return false;
							}	
							else
								return false;
						}
						else
							return false;
					}
				)
		}
		function auto_save_trash(cate, title, content, post_id)
		{
			ajax_url = "<?php echo HOME_URL . '/?ajax=admin_article_auto_save_trash'?>";
			$.post(
					reviewAjax.ajaxurl,
					{
						action: 'admin_article_auto_save_trash',
						category: cate,
						article_title: title,
						article_content: content,
						article_post_id: post_id
					},
					function(data){
						if (data.success){
							if(data.para != '' || data.para > 0)
							{
								var url = "<?php echo HOME_URL . '/wp-admin/admin.php?page=review-engine-new-article&p='?>";								
								url += data.para;
								window.location = url;						
								return false;
							}	
							else
								return false;
						}
						else
							return false;
					}
				)
		}
		function search_edit_product(pro_id)
		{
			var cate = jQuery('select[name=category_search]').val();
			var title_search = jQuery('#search_product_article').val();
			ajax_url = "<?php echo HOME_URL . '/?ajax=admin_article_search_product'?>";
			$.post(
				reviewAjax.ajaxurl,
				{
					action: 'admin_article_search_product',
					category: cate,
					product_title: title_search,
					product_id: pro_id
				},
				function(data){
					if (data.success){							
						//delete old data
						jQuery('#table_product').html('');
						
						if(data.para !='')
						{
							jQuery('#noresult').html('');
							jQuery('#table_product').html(data.para);
							jQuery('#table_product tr:odd').addClass('row-odd');
						}
						else
						{
							if(cate > 0)
								jQuery('#noresult').html('<?php _e ('Not product available', 're');?>');
						}
					}
					else
						jQuery('#noresult').html('<?php _e ('Not product available', 're');?>');
				}
			)
		}
		jQuery(document).ready(function(){
			   var term_id = '<?php if(isset($post_id)) echo $term_id;?>';
			   var product_id = '<?php if(isset($product_id)) echo $product_id?>';
			   if(term_id > 0 && product_id > 0)
			   {
				   search_edit_product(product_id);
			   }
			   jQuery('#input_error').hide();
		});		
	</script>
</div>