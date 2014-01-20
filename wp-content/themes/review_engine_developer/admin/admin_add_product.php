<?php 
	include PATH_ADMIN_PROCESSING . DS. 'admin_add_product_processing.php';
?>
<?php
global $helper;
?>
<div class="wrap">
	<div class="tgt_atention">
		<strong><?php _e('Problems? Questions?','re');?></strong><?php _e(' Contact us at ','re');?><em><a href="http://www.dailywp.com/support/" target="_blank">Support</a></em>. 
	</div>
	<!--// header -->
	<div id="icon-edit" class="icon32">
		<br />
	</div>
	<h2> <?php echo $page_title ?>  </h2>
	
	<!--MESSAGE -->
	<?php if ($success){ ?>
	<div class="updated below-h2" id="message">
		<p>
			<?php _e('Product updated!', 're') ?>
			<?php
			if (isset($product['id'] ) ){
				echo $helper->link( __('View product', 're'), get_permalink($product['id']) , array('target' => 'preview') ) ;				
			}?>
		</p>
	</div>
	<?php }	?>
	<?php if ($error){ ?>
	<div class="error below-h2" id="message-error">
		<p>
			<?php echo $error ?>
		</p>
	</div>
	<?php }	?>
	
	<form action="" method="post" name="post" id="post" enctype="multipart/form-data">
		<input type="hidden" id="product_id" name="product[id]" value="<?php if (isset($product['id'])) echo $product['id']?>"/>
		<div id="poststuff" class="metabox-holder has-right-sidebar">
			<div id="side-info-column" class="inner-sidebar">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
					<div class="postbox" id="submitdiv">
						<div class="handlediv" title="Click to toggle">
							<br />
						</div>
						<h3 class="hndle">
							<span> <?php _e('Publish', 're') ?> </span>
						</h3>
						<div class="inside">
							<div id="submitpost" class="submitbox">
								<div id="minor-publishing">
									<div id="minor-publishing-actions">
										<div id="save-action">
											<input type="submit" id="save-post" class="button button-highlighted" tabindex="4" value="<?php _e('Save','re') ?>" name="save_product" />
										</div>
										<?php if (!empty($product['id'])) { ?>
										<div id="preview-action">
											<?php  if (isset ($product['id']) ) {
												echo $helper->link( __('Preview', 're'), get_permalink($product['id']), array('id' => 'post-preview', 'class' => 'preview button', 'tabindex' => '4', 'target' => 'wp-preview') );
											}?>											
										</div>
										<?php } ?>
										<div class="clear"></div>
									</div>
									<div id="misc-publishing-actions">
										<div class="misc-pub-section misc-pub-section-last">
											<label for="post_status"><?php _e('Status:','re') ?></label>
											<span id="post-status-display" style="text-transform: capitalize"> <?php echo empty($product['status']) ? 'Draft' : $product['status']?> </span>
											<a tabindex="4" class="edit-post-status hide-if-no-js" href="#post_status"> <?php _e('Edit','re'); ?></a>
											<div class="hide-if-js" id="post-status-select" style="display: hidden;">
												<input type="hidden" value="<?php echo empty($product['status']) ? 'draft' : $product['status'] ?>" id="hidden_post_status" name="product[status]">
												<select tabindex="4" id="post_status" name="post_status">
													<option value="pending"><?php _e('Pending Review','re') ?></option>
													<option value="draft"><?php _e('Draft','re') ?></option>
													<option value="publish"><?php _e('Publish','re') ?></option>
												</select>
												<a class="save-post-status hide-if-no-js button" href="#post_status"><?php _e('OK','re') ?></a>
												<a class="cancel-post-status hide-if-no-js" href="#post_status"><?php _e('Cancel','re') ?></a>
											</div>
										</div>
									</div>
									
								</div>
								<div id="major-publishing-actions">
									<div id="delete-action">
										<?php if (isset($product['id'])) {?>
										<a href="<?php echo HOME_URL ?>/wp-admin/admin.php?page=review-engine-add_product&p=<?php echo $product['id'] ?>&action=delete" id="delete_product" class="submitdelete deletion">
											<?php _e('Move to Trash', 're') ?>
										</a>
										<?php } ?>
									</div>
									<div id="publishing-action">
										<?php
										$publish_button = __('Publish','re');
										if ($product['status'] = 'publish') $publish_button = __('Update','re');
										?>
										<img src="<?php echo HOME_URL?>/wp-admin/images/wpspin_light.gif" alt="" id="ajax-loading" style="visibility: hidden;" />
										<input id="publish" class="button-primary" type="submit" value="<?php echo $publish_button ?>" accesskey="p" name="publish"/>
									</div>
										<div class="clear"></div>
								</div>
							</div>							
						</div>
						<div class="clear"></div>
					</div>
					
					<?php
					/**
					 * PRICE
					 */
					?>					
					<div class="postbox" id="tagsdiv">
						<div class="handlediv" title="Click to toggle">
							<br />
						</div>
						<h3 class="hndle">
							<span> <?php _e('Price', 're'); ?> </span>
						</h3>
						<div class="inside">
							<input style="font-size: 20px" type="text" name="product[price]" value="<?php if (!empty($product['price'])) echo $product['price'] ?>"/>
							<p class="howto"> <?php _e('Specify product price. You can freely specify price format like $1000, $1.000 ... ','re') ?> </p>
						</div>
						<div class="clear"></div>
					</div>

					
					<div class="postbox" id="categorydiv">
						<div class="handlediv" title="Click to toggle">
							<br />
						</div>
						<h3 class="hndle">
							<span> <?php _e('Category', 're'); ?> </span>
						</h3>
						<div class="inside">
							<select id="selectcat" name="product[category]" style="width: auto">
								<option value="0"><?php _e('Please choose category','re') ?></option>
								<?php
								foreach ($catList as $cat){
									if (!empty($product['category']) && $product['category'] == $cat['data']->term_id)
										echo '<option selected="selected" value="' . $cat['data']->term_id . '">' . $cat['data']->name . '</option>';
									else 
										echo '<option value="' . $cat['data']->term_id . '">' . $cat['data']->name . '</option>';
									if (!empty($cat['children'])){
										foreach($cat['children'] as $child){
											if (!empty($product['category']) && $product['category'] == $child->term_id)
												echo '<option selected="selected" value="' . $child->term_id . '">---' . $child->name . '</option>';
											else
												echo '<option value="' . $child->term_id . '">---' . $child->name . '</option>';
												
										}
									}
								}
								?>
							</select>
							<?php echo $helper->image('loading.gif', '...', array('id'=>'loading_cat', 'style'=> 'hidden')); ?>
						</div>
						<div class="clear"></div>
					</div>
					
					<?php
					/**
					 * TAG
					 */
					?>					
					<div class="postbox" id="tagsdiv">
						<div class="handlediv" title="Click to toggle">
							<br />
						</div>
						<h3 class="hndle">
							<span> <?php _e('Tags', 're'); ?> </span>
						</h3>
						<div class="inside">
							<textarea name="product[tags]" id="producttags" cols="30" rows="3"><?php if (!empty($product['tags'])) echo $product['tags'] ?></textarea>
							<p class="howto"> <?php _e('Separate tags with commas', 're')?> </p>
						</div>
						<div class="clear"></div>
					</div>
					
					<?php
					/**
					 * Filter Box
					 */
					?>
					<div class="postbox" id="filterdiv">
						<div class="handlediv" title="Click to toggle">
							<br />
						</div>
						<h3 class="hndle">
							<span> <?php _e('Filter', 're'); ?> </span>
						</h3>
						<div class="inside">
							<?php
							if (!empty($product['filter'])){
								foreach ($filters as $filter){?>
									<div id="group_<?php echo $filter['ID'] ?>">
										<h4> <?php echo $filter['name'] ?> <span>[+]</span></h4>
										<?php
										if (!empty($filter['children']) ){
											echo '<ul id="'. $filter['ID'] .'">';
											foreach ($filter['children'] as $child){?>
												<li>
													<?php if ($product['filter'][$filter['ID']] == $child['ID']) { ?>
														<input type="radio" name="product[filter][<?php echo $filter['ID'] ?>]" value="<?php $child['ID']?>" checked="checked" />
													<?php } else { ?>
														<input type="radio" name="product[filter][<?php echo $filter['ID'] ?>]" value="<?php $child['ID']?>"/>
													<?php } ?>
													<label for="<?php echo $filter['ID'] ?>"> <?php echo $child['name']?> </label>
												</li>	
											<?php
											}
											echo '</ul>';
										}
										?>
									</div>									
								<?php
								}
							}
							?>
						</div>
						<div class="clear"></div>
					</div>
					
				</div>
			</div>
			
			<!--LEFT CONTENT-->
			
			<div id="post-body">
				<div id="post-body-content">
					<div id="titlediv">
						<div id="titlewrap">
							<label for="title" id="title-prompt-text" class="hide-if-no-js"><?php  _e('Enter title here','re')?></label>
							<input type="text" id="title" autocomplete="off" size="30" name="product[title]" value="<?php if(!empty($product['title'])) echo $product['title'] ?>" />
						</div>
						<div class="inside">
							<div id="edit-slug-box"></div>
						</div>
					</div>
					<div id="postdivrich" class="postarea">
						<div id="editorcontainer">
							<?php
								add_filter('mce_buttons', 'add_image_button');
								function add_image_button($buttons){
									array_push($buttons, 'image');
									return $buttons;
								}
								wp_tiny_mce(false);
								wp_enqueue_script('page');
								wp_enqueue_script('editor');
								do_action('admin_print_scripts');
								wp_enqueue_style('thickbox');
								wp_enqueue_script('thickbox');
								add_thickbox();
								add_action( 'admin_head', 'wp_tiny_mce' );
								wp_enqueue_script('media-upload');
								wp_enqueue_script('word-count');
								if (!empty($product['desc'])){
									the_editor( $product['desc'] , 'product[desc]'); 
								}
								else {
									the_editor( '' , 'product[desc]'); 
								}
								//wp_tiny_mce(false, array(
								//	'editor_selector' => 'post_content'
								//) );
							?>
						</div>
					</div>
					
					<?php
					/**
					 * Product link 
					 */
					?>
					<div id="link_product-metabox">
						<div class="postbox" id="product-link">
							<h3 class="hndle">
								<?php _e('Product Link', 're')  ?>
							</h3>
							<div class="inside">
								<p class="classname">
									<label for="link_product"> <?php _e('Link product:','re') ?>  </label>
									<input type="text" id="link_product" name="product[url]" class="full-size" value="<?php if (!empty($product['url'])) echo $product['url'];?>"/>
								</p>
							</div>
						</div>
					</div>
					
					<?php
					/**
					 * Images
					 */
					?>					
					<div id="link_product-metabox">
						<div class="postbox" id="imagediv">
							<h3 class="hndle">
								<?php _e('Product Images', 're')  ?>
							</h3>
							<div class="inside">
								<p>
									<label for="image"> <?php _e('Product images:','re') ?> <i> <?php _e('.jpg file only', 're') ?></i>  </label>
									<ul id="old_image">
									<?php
										if (!empty($product['images']) && is_array($product['images'])){
											$i = 0;
											foreach ($product['images'] as $image){
											?>
											<li>
												<a href="<?php echo URL_UPLOAD . '/'. $image['url'] ?>">
													<?php echo $helper->image(URL_UPLOAD . '/'. $image['thumb'], 'dailywp.com', array('height' => '50')) ?>
												</a>
												<input type="button" class="button deleteimage" value="Delete" onclick="javascript:del_image(this)" />
												<input type="hidden" name="product[images][<?php echo $i ?>][thumb]" value="<?php echo $image['thumb'] ?>">
												<input type="hidden" name="product[images][<?php echo $i ?>][url]" value="<?php echo $image['url'] ?>">
											</li>
										<?php $i++;
										} }
										?>
									</ul>
									<ul id="imagelist">										
										<li class="lastimage"> <input class="image-loc" type="file" name="images[]"/> </li>
									</ul>
								</p>
							</div>
						</div>
					</div>
				
				<?php
					/**
					 * Specification
					 */
					?>					
					<div id="specification-metabox">
						<div class="postbox" id="specdiv">
							<h3 class="hndle">
								<?php _e('Specification', 're')  ?>
							</h3>
							<div class="inside">
								<p>
									
								</p>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</form>
	<script type="text/javascript">
	var ajaxURL = '<?php echo HOME_URL . '/?do=ajax' ?>';
	var error_choose_category = '<?php _e('You must choose category', 're') ?>';
	var error_empty_title = '<?php _e('You must enter the title', 're') ?>';
	var error_empty_desc = '<?php _e('You must enter the description', 're') ?>';
	
	jQuery(document).ready(function(){
		jQuery('#loading_cat').hide();
		if (jQuery('#product_id').val() == '' ){
			jQuery('#filterdiv').hide();
			jQuery('#specdiv').hide();
		}
		jQuery('#media-buttons').remove();
		
		refresh_image();
		
		if (jQuery('#title').val() != ''){
			jQuery('#title-prompt-text').hide();
		}
		
		// input clicked, hide the label
		jQuery('#title').focusin(function(){
			jQuery('#title-prompt-text').hide();
		});
		jQuery('#title').focusout(function(){
			if ( jQuery('#title').val() == '' )
				jQuery('#title-prompt-text').show();
		});
		
		// edit status
		jQuery('.edit-post-status').click(function(){
			jQuery('#edit-post-status').hide();
			jQuery('#post-status-select').slideDown();
			jQuery('#post_status option').removeAttr('selected');
			jQuery('#post_status option[value=' + jQuery('#hidden_post_status').val() + ']').attr('selected','selected');
			return false;
		});
		jQuery('.save-post-status').click(function(){
			jQuery('#post-status-select').slideUp();
			jQuery('#hidden_post_status').val(jQuery('#post_status').val());
			jQuery('#edit-post-status').show();
			return false;
		});
		jQuery('.cancel-post-status').click(function(){
			jQuery('#post-status-select').slideUp();
			jQuery('#edit-post-status').show();
			return false;
		});
		
		//save-post
		jQuery('#post').submit(function(){
			/**
			 * validate
			 */
			if (jQuery('#title').val() == '' ){
				if (jQuery('#message-error p').length == 0 ){
					jQuery('#post').before(
						jQuery('<div class="error below-h2" id="message-error>"').append('<p>' + error_empty_title + '</p>')
					);
				}else
					jQuery('#message-error p').html(error_empty_title);
				return false;
			}
			
			if (tinyMCE.get('product[desc]').getContent()  == '' ){
				if (jQuery('#message-error p').length == 0 ){
					jQuery('#post').before(
						jQuery('<div class="error below-h2" id="message-error>"').append('<p>' + error_empty_desc + '</p>')
					);
				}else
					jQuery('#message-error p').html(error_empty_desc);
				return false;
			}
			
			if (jQuery('#selectcat').val() == 0 ){
				if (jQuery('#message-error p').length == 0 ){
					jQuery('#post').before(
						jQuery('<div class="error below-h2" id="message-error>"').append('<p>' + error_choose_category + '</p>')
					);
				}else
				jQuery('#message-error p').html(error_choose_category);
				return false;
			}
			//return false;
		});
		
		// insert add button
		jQuery('li.lastimage input.image-loc').change(function(){
			if (jQuery('li.lastimage input[type=file]').val() != '' )
				jQuery('li.lastimage').append( jQuery('<input class="button addimage" id="addbutton" type="button" value="More images" onclick="add_image()" />') );
		});
		
		//
		// hide box content when click on the title
		//
		jQuery('.postbox h3.hndle').toggle(function(){
			jQuery(this).parent().find('.inside').hide();
		}, function(){
			jQuery(this).parent().find('.inside').show();
		});
		
		jQuery('#selectcat').change(function(){
			refreshCategory();
		});
		
		refreshCategory();
	});
	
	function refreshCategory(){
		catId = jQuery('#selectcat').val();
		getFilterByCat(catId);
		getSpecByCat(catId);
	}
	
	/**
	 * get filter by category id
	 */
	function getFilterByCat(catId){
		$.ajax({
			type: 'post',
			url: reviewAjax.ajaxurl,
			data: {
				action: 'get_filter_by_category',
				cat_id: catId
			},
			beforeSend:function(){
				// show the loading image
				jQuery('#loading_cat').show();
			},
			success: function(data){
				if (data.success){
					// hide the loading image
					jQuery('#loading_cat').hide();
					jQuery('#filterdiv .inside').html('');
					jQuery('#filterdiv').show();
					//
					
					for(var i = 0; i < data.filters.length; i++){
						// echo group
						jQuery('#filterdiv .inside').append(jQuery('<div id="group_' + data.filters[i].ID + '">'));
						idDiv = '#filterdiv .inside div#group_' + data.filters[i].ID;
						jQuery(idDiv).append('<h4 class="filter_title">' + data.filters[i].name + '&nbsp; <span>[+]</span></h4>');
						if (data.filters[i].children.length > 0){
							jQuery(idDiv).append(jQuery('<ul id="g_' + data.filters[i].ID + '">'))
							for (var j = 0; j < data.filters[i].children.length; j++){
								jQuery(idDiv).append(
									jQuery('ul#g_'+ data.filters[i].ID ).append(
										jQuery('<li>').append(
											'<input type="radio" class="filtervalue" name="product[filter][g'+data.filters[i].ID+']" value="'+data.filters[i].children[j].ID+'"/>' +
											'<label for="product[filter]['+data.filters[i].ID+']"> '+ data.filters[i].children[j].name +' </label>'
										)
									)
								);
							}
						}
					}
					
					//
					jQuery('.filter_title').toggle(function(){
						jQuery(this).parent().find('ul').hide();
						jQuery(this).find('span').html('[-]');
					}, function(){
						jQuery(this).parent().find('ul').show();
						jQuery(this).find('span').html('[+]');
					}
					);
					
					// check old records
					getFilterRelationship()
				}
			}
		});
	}
	
	/**
	 *
	 */
	function getSpecByCat(){
		$.ajax({
			type: 'post',
			url: reviewAjax.ajaxurl,
			data: {
				action: 'get_spec_by_category',
				cat_id: catId
			},			
			beforeSend:function(){
				// show the loading image
				jQuery('#loading_cat').show();
			},
			success: function(data){
				if (data.success){
					jQuery('#loading_cat').hide();
					jQuery('#specdiv .inside').html('');
					jQuery('#specdiv').show();
					
					if (data.specs.length > 0){
						id_inside = '#specdiv .inside';
						spec_data = jQuery('<table id="spectable" class="speclist" cellpadding="0" cellspacing="0" >');
						for (var i = 0; i < data.specs.length; i++){
							jQuery('#specdiv .inside')
							
							// print the group title
							jQuery(spec_data).append(
								jQuery('<tr>').append(
									'<td colspan="2" class="group-title"><label for="' + data.specs[i].name + '"> ' + data.specs[i].name + ' </label></td>'
								)
							)
							
							// get the spec values
							if (data.specs[i].value.length > 0){
								for (var j = 0; j < data.specs[i].value.length; j++){
									jQuery(spec_data).append(
										jQuery('<tr>').append(
											'<td> <label for="' + data.specs[i].value[j].name + '">' + data.specs[i].value[j].name + '</label> </td>'
										).append(
											'<td> <input type="text" class="specvalue" id="g_' + data.specs[i].ID + '_' + data.specs[i].value[j].ID + '" name="product[spec][g_' + data.specs[i].ID + '_' + data.specs[i].value[j].ID + ']" value="" </td>'
										)
									);
								} // end for j to data.specs[i].value.length
							} // end if (data.specs[i].value.length > 0)
							else {
								jQuery(spec_data).append(
										jQuery('<tr>').append(
											'<td colspan="2"> This specification has no specification value </td>'
										)
								);
							} // end else
						}// end for
						jQuery(id_inside).append(spec_data);
					} // end if (data.specs.length > 0)
					
					// add class odd - row for the odd row
					jQuery('#spectable tr:odd').addClass('odd-row');
					
					getSpecByPost();
				} // end if (data.success)				
			}// end success function
		});
	}
	
	// get filter relationship
	function getFilterRelationship(){
		if (jQuery('#product_id').val() != '' ){
			$.ajax({
			type: 'post',
			url: reviewAjax.ajaxurl,
			data: {
				action: 'get_filter_relationship',
				post_id: jQuery('#product_id').val()
			},			
			beforeSend:function(){
				// show the loading image
				//jQuery('#loading_cat').show();
			},
			success: function(data){
				if (data.success){
					for (var i = 0; i < data.filters.length; i++){
						
						jQuery('.filtervalue[value='+ data.filters[i].ID +']').attr('checked','checked');
					}					
				} // end if (data.success)				
			}// end success function
		});
		}
	}
	
	// get spec by post id
	function getSpecByPost(){
		if (jQuery('#product_id').val() != '' ){
			$.ajax({
			type: 'post',
			url: reviewAjax.ajaxurl,
			data: {
				action: 'get_spec_by_post',
				post_id: jQuery('#product_id').val()
			},			
			beforeSend:function(){
				// show the loading image
				//jQuery('#loading_cat').show();
			},
			success: function(data){
				if (data.success){
					for (var i = 0; i < data.specs.length; i++){
						jQuery('#' + data.specs[i].ID).attr('value', data.specs[i].value);
						//alert('#' + data.specs[i].ID);
						//alert('#g_' + data.specs[i].groud_id + '_' + data.specs[i].ID);
					}					
				} // end if (data.success)				
			}// end success function
		});
		}
	}
	
	// click add button		
	function add_image(){
		jQuery('#imagelist li').removeClass('lastimage')
		jQuery('#imagelist li .addimage').remove();
		jQuery('#imagelist li .deleteimage').remove();
		
		jQuery('#imagelist').append(
			jQuery('<li class="lastimage">').append(
				'<input class="image-loc" type="file" name="images[]"/> '
			));
		
		jQuery('#imagelist li:not(li.lastimage)').append( ' <input class="button deleteimage" type="button" value="Delete" onclick="del_image()" />' );
		
		jQuery('li.lastimage input.image-loc').change(function(){
			if (jQuery('li.lastimage input[type=file]').val() != '' ){
				if (jQuery('#old_image li').length + jQuery('#imagelist li').length < 4){
					jQuery('li.lastimage').append( jQuery('<input class="button addimage" id="addbutton" type="button" value="More images" onclick="add_image()" />') );
				}
				else {
					jQuery('li.lastimage').append( ' <input class="button deleteimage" type="button" value="Delete" onclick="del_image()" />' );
				}
			}
		});
	}
	
	function refresh_image(){
		jQuery('#imagelist li').removeClass('lastimage')
		jQuery('#imagelist li .addimage').remove();
		jQuery('#imagelist li .deleteimage').remove();
		jQuery('#imagelist li:last').addClass('lastimage');
		
		if (jQuery('#old_image li').length >= 4){
			jQuery('#imagelist').hide();
		}
		else{
			jQuery('#imagelist').show();			
		}
		jQuery('#imagelist li:not(li.lastimage)').append( ' <input class="button deleteimage" type="button" value="Delete" onclick="del_image()" />' );
	}
	
	//click on delete button
	function del_image(t){
		jQuery(t).parent().remove();
		refresh_image();
	}
	
	
	</script>
</div>
