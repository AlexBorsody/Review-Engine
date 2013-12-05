<?php
include PATH_ADMIN_PROCESSING . DS . 'admin_rating_processing.php';
global $helper;

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
    if(!empty($errors ))
    {
        echo '<div class="error">'.$errors.'</div>'; 
    }
    ?>	

	
	<!-- -------------- LEFT ------------------ -->
	<form id="rating_form" action="" method="post">
	<div class="tgt-left" style="width: 67%">
		<div id="poststuff" class="has-right-sidebar"> <!-- box language setting -->		
			<div id="post-body">
				<div id="post-body-content" style="margin-right: 0">
					<div id="namediv" class="stuffbox">
						<h3><label for="link_name"><?php _e('Rating Management','re'); ?></label></h3>
						<div class="inside">
							
							<table class="form-table"> <!-- form table -->
								<tbody>
									<tr class="form-field">
										<th scope="row" style="width:80px;"><label for="user_login"><?php _e('Category','re'); ?></label>										
										<td>
											<select name="category" id="category">
												<?php
												foreach ($catList as $root){
													echo '<option value="'. $root->term_id .'">' . $root->name . '</option>';
													foreach ($allCat as $cat){
														if ($cat->parent == $root->term_id){
															echo '<option value="'. $cat->term_id .'"> -- ' . $cat->name .'</option>';
														}
													}													
												}
												?>
												<!--<option value="1">Digital Camera</option>
												<option value="2">Laptop</option>
												<option value="3">TV</option>
												<option value="4">Computer</option>-->
											</select>
										</td>
									</tr>				
								</tbody>
							</table> <!-- //form table -->
							
							<div class="slit-wrapper">
								<div class="column" id="rating-group">
									<h2> <?php _e('Rating','re') ?>  </h2>
									<ul class="slit-list">
										<?php
										foreach ($globalRating as $id => $name){ ?>
											<li class="rating-global" id="<?php echo $id?>">
												<span class="r-name"><?php echo $name?></span>
												<span class="action">
													<a class="add"><?php _e('Add', 're') ?></a> - <a class="edit"><?php _e('Edit', 're') ?></a> - <a class="del red"><?php _e('Delete', 're') ?></a>
												</span>
												<div class="ajax-edit">
													<input type="hidden" name="id" value="<?php echo $id?>" />
													<input type="text" name="name" value="<?php echo $name?>" id="" style="width: auto"/>
													<input type="button" class="button-primary a-edit" name="edit" value="<?php _e('Save', 're') ?>"/>
													<input type="button" class="button a-cancel" name="edit" value="<?php _e('Cancel', 're') ?>"/>
												</div>
											</li>											
										<?php 
										}
										?>
									</ul>
									<h2><?php _e('New Rating','re') ?></h2>
									<div class="column-form" id="new_group">
											<input type="text" name="rating[name]" />
											<input class="button-primary" type="submit" name="new_rating" value="<?php _e('Add', 're') ?>" />
									</div>
								</div>
								<div class="column" id="rating-value">		
									<h2> <?php _e('Rating for category', 're') ?></h2>					
									<ul id="category-rating" class="slit-list">
										
									</ul>		
									<h2> <?php _e('Save rating of this category?', 're') ?></h2>
									<div class="column-form" id="save_rating">
										<input class="button-primary" type="button" name="save_rating" value="<?php _e('Save', 're') ?>" />										
									</div>
								</div>
							</div>
							
							<div class="clear"></div>
							
						</div>
					</div>	
				
				</div>
			</div>
		</div>	 
	</div>
	</form>

<script type="text/javascript">
	var msg_add_already = '<?php _e('You have add this rating already!','re') ?>';
	var ratingList = <?php echo json_encode( $jsonCat )?>;

	jQuery(document).ready(function($){		
		//
		jQuery.fn.exists = function(){return jQuery(this).length>0;}
		
		addRatingByCat();
		refreshView();
		
		jQuery('.rating-global a.add').click(function(){
			
			// get id of the item
			var div_id = 's' + jQuery(this).parents()[1].id;
			var rating_name = jQuery(this).parent().parent().children('.r-name').html();
			var rating_id = div_id.substring(3);
			
			// add item to category's rating sr-1
			if (!jQuery('#category-rating li#'+ div_id).exists()){
				
				//add item
				jQuery('#category-rating').append(
					jQuery('<li>').addClass('c-rating').attr('id', div_id).append('<span class="r-name">' + rating_name + '</span> <span class="action" style="display:none"><a class="remove red">' + 'remove' + '</a></span')
				);				
				refreshView();
			}
			else {
				alert(msg_add_already);
			}
		});

		// submit save list
		jQuery('input[name=save_rating]').click(function(){
			//remove all old value
			jQuery('input[name="cat_rating[]"]').remove();
			jQuery('input[name=save_rate]').remove();
			
			var ratingList = jQuery('#category-rating li.c-rating');
			
			for (var i = 0; i < ratingList.length; i++){
				var name = jQuery('li#'+ratingList[i].id+' span.r-name').html();
				var id = ratingList[i].id.substring(1);
				jQuery('<input type="hidden" name="cat_rating[]" value="'+ id +'">').insertBefore('#save_rating input[name=save_rating]');
			}
			jQuery('<input type="hidden" name="save_rate" value="1">').insertBefore('#save_rating input[name=save_rating]');
			jQuery('#rating_form').submit();
		});
		
		// event category chosen
		jQuery('select[name=category]').change(function(){
			addRatingByCat();
			refreshView();
		});
		
		//delete global rating
		ajax_del_url = '<?php echo HOME_URL . '/?ajax=admin_rating_delete'?>';
		jQuery('.rating-global a.del').click(function(){
			if ( !confirm("<?php _e('Do you really want to delete this rating', 're') ?>") )
				return false;
			var div_id = jQuery(this).parents()[1].id;
			
			$.post(
				reviewAjax.ajaxurl,
				{
					action: 'admin_rating_delete',
					rating_id: div_id
				},
				function(data){
					if (data.success){
						ajax_get_url = '<?php echo HOME_URL . '/?ajax=admin_get_rating'?>';
						//
						$.post(
							reviewAjax.ajaxurl,
							{
								action: 'admin_get_rating',
							},
							function(getData){
								if (getData.success){
									ratingList = getData.rating;
								}
							}
						);
						//da
						jQuery('li#'+div_id).fadeOut('slow', function(){
							jQuery('li#'+div_id).remove();
						});
						
						jQuery('li#s'+div_id).fadeOut('slow', function(){
							jQuery('li#s'+div_id).remove();
						});
						refreshView();
					}
					else
						alert (data.message);
				}
			);
		});
		
		// click on save button to save editing
		ajaxEditUrl = '<?php echo HOME_URL . '/?ajax=admin_rating_edit' ?>';
		jQuery('.ajax-edit .a-edit').click(function(){
			//get the form data
			var idRating = jQuery(this).parent().find('input[name=id]').val();
			var nameRating = jQuery(this).parent().find('input[name=name]').val();
			
			$.ajax({
				type: 'post',
				url : reviewAjax.ajaxurl,
				data: {
					action: 'admin_rating_edit',
					id_rating: idRating,
					name_rating: nameRating
				},
				
				beforeSend: function() {
					jQuery( '<?php echo $helper->image('loading.gif', '...', array('class'=>'loading')) ?>' ).appendTo(
						jQuery('.ajax-edit')
					);
				},
				
				success: function(data){
					if (data.success){
						//jQuery(this).parents('.rating-global').find('.r-name').html(data.name);
						jQuery("#" + idRating).find('.r-name').html(data.name);
						jQuery("#s" + idRating).find('.c-name').html(data.name);	
					}
					else{
						alert(data.message);
					}
					
					get_rating($);
					// hide all the textbox, button
					jQuery('.loading').remove();
					jQuery('.rating-global').removeClass('editing');
					jQuery('.rating-global .r-name').show();
					jQuery('.ajax-edit').hide();
				}
			});
		});
	});
	
	function addRatingByCat(){			
		var cat_id = jQuery('select[name=category]').val();
		
		jQuery('#category-rating').empty();
		if (ratingList[cat_id]){
			for (var i = 0; i < ratingList[cat_id].length; i++ ){
				
				jQuery('#category-rating').append(
					jQuery('<li class="c-rating">').attr('id', 's' + ratingList[cat_id][i].id).append(
						'<span class="r-name">'+ ratingList[cat_id][i].name +'</span><span class="action"> <a class="remove red"><?php _e('remove','re') ?></a></span>'
						)
				);
			}
		}
	}
	
	function refreshView(){
		jQuery('.rating-global *').show();
		jQuery('.ajax-edit').hide();
		jQuery('.action').hide();
		jQuery('.sub-list').hide();
		jQuery('.loading').remove();
		
		jQuery('.li-label').toggle(function(){
			jQuery(this).find('img').attr('src', '<?php echo $helper->url( TEMPLATE_URL . '/images/expand.gif') ?>' );
			jQuery(this).parent().parent().find('.sub-list').show();
		}, function(){			
			jQuery(this).find('img').attr('src', '<?php echo $helper->url( TEMPLATE_URL . '/images/collapse.gif') ?>' );
			jQuery(this).parent().parent().find('.sub-list').hide();
		});
		
		jQuery('.list-label').hover(function(){
				jQuery(this).children('.action').show();
			}, function(){
				jQuery(this).children('.action').hide();
			});
		
		jQuery('.rating-global').hover(function(){
				if (!jQuery(this).hasClass('editing')){
					jQuery(this).children('.action').show();
				}
			}, function(){
				jQuery(this).children('.action').hide();
			});
		
		jQuery('.c-rating').hover(function(){
			jQuery(this).children('.action').show();
		}, function(){
			jQuery(this).children('.action').hide();
		});
		
		jQuery('.c-rating a.remove').click(function(){
			//remove from list
			rating_id = jQuery(this).parents()[1].id;
			rating_id = rating_id.substring(3);
			
			jQuery(this).parent().parent().remove();
			jQuery('#save_rating input[name=rating[]][value='+rating_id+']').remove();
		});
		
		// when click on edit		
		jQuery('.action .edit').click(function(){			
			jQuery('.rating-global .r-name').show();
			jQuery('.ajax-edit').hide();
			
			root = jQuery(this).parents('.rating-global');
			jQuery(root).addClass('editing');
			jQuery(root).children('*').hide();
			jQuery(root).find('.ajax-edit').show();
		});
		
		// click on cancel button
		jQuery('.ajax-edit .a-cancel').click(function(){
			jQuery('.rating-global').removeClass('editing');
			jQuery('.rating-global .r-name').show();
			jQuery('.ajax-edit').hide();
		});		
		
	}
	
	//
	function get_rating($){
		ajax_get_url = '<?php echo HOME_URL . '/?ajax=admin_get_rating'?>';
		$.post(
			reviewAjax.ajaxurl,
			{
				action: 'admin_get_rating',
			},
			function(getData){
				if (getData.success){
					ratingList = getData.rating;
				}
			}
		);
	}
	
	//refresh right column
	function refreshRightCol(){
		for (var i = 0; i < ratingList.length; i++){
			
		}
	}
</script>