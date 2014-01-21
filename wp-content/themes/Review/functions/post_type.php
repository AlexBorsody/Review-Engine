<?php
add_theme_support( 'post-thumbnails' );
add_action("admin_init",  'custom_meta_box' );
add_action('save_post', 'save_meta_box');
function custom_meta_box()
{
	add_meta_box("article_search_product", __('Product','re'),  "search_product", "article", "normal", "high");		
	add_meta_box("product_rating", __('Rating', 're'), 'product_rating_meta_box', 'product', 'normal', 'high' );
	add_meta_box("product_detail", __('Agency Detail','re'),  "detail_product", "product", "normal", "high");
	add_meta_box("product_specification", __('Specification','re'),  "specification_product", "product", "normal", "high");
	//add_meta_box("product_filter", __('Filter','re'),  "filter_product", "product", "side");	
	add_meta_box("product_tab", __('Additional Tab','re'),  "additional_tab", "product", "normal", "low");
	if ( get_option(SETTING_SEO_POST_TYPE) == 1 && get_option(SETTING_ENABLE_SEO) == 1) {
		$post_type_support = get_option( SETTING_POST_TYPE_SUPORT);
		if( $post_type_support['product'] == 1 ) {
			add_meta_box("seo_product", __('SEO for product','re'),  "seo_function", "product", "normal", "low");
		}
		if( $post_type_support['page'] == 1 ) {
			add_meta_box("seo_page", __('SEO for page','re'),  "seo_function", "page", "normal", "low");
		}
		if( $post_type_support['post'] == 1 ) {
			add_meta_box("seo_post", __('SEO for post','re'),  "seo_function", "post", "normal", "low");
		}
		if( $post_type_support['article'] == 1 ){
			add_meta_box("seo_article", __('SEO for article','re'),  "seo_function", "article", "normal", "low");
		}
	}
}

function product_rating_meta_box()
{
	global $post;
	$rating = array(
		PRODUCT_RATING 					=> get_post_meta( $post->ID , PRODUCT_RATING, true) 					? get_post_meta( $post->ID , PRODUCT_RATING, true) : 0 ,
		PRODUCT_RATING_COUNT 			=> get_post_meta( $post->ID , PRODUCT_RATING_COUNT, true) 			? get_post_meta( $post->ID , PRODUCT_RATING_COUNT, true) : 0,
		PRODUCT_EDITOR_RATING 			=> get_post_meta( $post->ID , PRODUCT_EDITOR_RATING, true) 			? get_post_meta( $post->ID , PRODUCT_EDITOR_RATING, true) : 0,
		PRODUCT_EDITOR_RATING_COUNT 	=> get_post_meta( $post->ID , PRODUCT_EDITOR_RATING_COUNT, true) 	? get_post_meta( $post->ID , PRODUCT_EDITOR_RATING_COUNT, true) : 0
	);
	?>
	<table style="width: 500px;">
		<tr>
			<td width="30%"><label for="rating"><?php _e('Rating') ?>:</label></td>
			<td width="70%">
				<input type="text" name="rating[<?php echo PRODUCT_RATING ?>]" id="<?php echo PRODUCT_RATING ?>" value="<?php echo $rating[PRODUCT_RATING] ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="rating_count"><?php _e('Rating Count') ?>:</label>
			</td>
			<td width="70%">
				<input type="text" name="rating_info[<?php echo PRODUCT_RATING_COUNT ?>]" id="<?php echo PRODUCT_RATING_COUNT ?>" value="<?php echo $rating[PRODUCT_RATING_COUNT] ?>"/>
			</td>
		</tr>
		<tr>
			<td width="30%">
				<label for="editor_rating_count"><?php _e('Editor Rating') ?>:</label>
			</td>
			<td width="70%">
				<input type="text" name="rating[<?php echo PRODUCT_EDITOR_RATING ?>]" id="<?php echo PRODUCT_EDITOR_RATING ?>" value="<?php echo $rating[PRODUCT_EDITOR_RATING] ?>"/>
			</td>
		</tr>
		<tr>
			<td width="30%">
				<label for="rating_count"><?php _e('Editor Rating Count') ?>:</label></td>
			<td width="70%">
				<input type="text" name="rating_info[<?php echo PRODUCT_EDITOR_RATING_COUNT ?>]" id="<?php echo PRODUCT_EDITOR_RATING_COUNT ?>" value="<?php echo $rating[PRODUCT_EDITOR_RATING_COUNT] ?>"/>
			</td>
		</tr>
	</table>
	<?php 
}


function seo_function() {
	global $post;
	$post_id = $post;
	if (is_object($post_id))
		$post_id = $post_id->ID;
		
 	$keywords = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'tgt_aioseop_keywords', true)));
    $title = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'tgt_aioseop_title', true)));
	$description = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'tgt_aioseop_description', true)));
   	$aiosp_meta = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'tgt_aiosp_meta', true)));
    $aiosp_disable = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'tgt_aioseop_disable', true)));
    $aiosp_titleatr = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'tgt_aioseop_titleatr', true)));
    $aiosp_menulabel = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'tgt_aioseop_menulabel', true)));	
	?>
	<script LANGUAGE="JavaScript">
	function countChars(field,cntfield) {
		cntfield.value = field.value.length;
	}
	</script>
		<input value="aiosp_edit" type="hidden" name="aiosp_edit" />
		<table style="margin-bottom:40px">
		<tr>
		<th style="text-align:left;" colspan="2">
		</th>
		</tr>
		<tr>
		<th scope="row" style="text-align:right;"><?php _e('Title:', 're') ?></th>
		<td><input value="<?php echo $title ?>" type="text" name="aiosp_title" size="62" onKeyDown="countChars(document.post.aiosp_title,document.post.lengthT)" onKeyUp="countChars(document.post.aiosp_title,document.post.lengthT)"/><br />
			<input readonly type="text" name="lengthT" size="3" maxlength="3" style="text-align:center;" value="<?php echo strlen($title);?>" />
			<?php _e(' characters. Most search engines use a maximum of 60 chars for the title.', 're') ?>
			</td>
		</tr>
		
		<tr>
		<th scope="row" style="text-align:right;"><?php _e('Description:', 're') ?></th>
		<td><textarea name="aiosp_description" rows="3" cols="60"
		onKeyDown="countChars(document.post.aiosp_description,document.post.length1)"
		onKeyUp="countChars(document.post.aiosp_description,document.post.length1)"><?php echo $description ?></textarea><br />
		<input readonly type="text" name="length1" size="3" maxlength="3" value="<?php echo strlen($description);?>" />
		<?php _e(' characters. Most search engines use a maximum of 160 chars for the description.', 're') ?>
		</td>
		</tr>

		<tr>
		<th scope="row" style="text-align:right;"><?php _e('Keywords (comma separated):', 're') ?></th>
		<td><input value="<?php echo $keywords ?>" type="text" name="aiosp_keywords" size="62"/></td>
		</tr>
	<?php if($post->post_type=='page'){ ?>
		<tr>
		<th scope="row" style="text-align:right;"><?php _e('Title Attribute:', 're') ?></th>
		<td><input value="<?php echo $aiosp_titleatr ?>" type="text" name="aiosp_titleatr" size="62"/></td>
		</tr>
		
		<tr>
		<th scope="row" style="text-align:right;"><?php _e('Menu Label:', 're') ?></th>
		<td><input value="<?php echo $aiosp_menulabel ?>" type="text" name="aiosp_menulabel" size="62"/></td>
		</tr>
	<?php } ?>
		<tr>
		<th scope="row" style="text-align:right; vertical-align:top;">
		<?php _e('Disable on this page/post:', 're')?>
		</th>
		<td>
		<input type="checkbox" name="aiosp_disable" <?php if ($aiosp_disable) echo "checked=\"1\""; ?>/>
		</td>
		</tr>
		</table>
	<?php
}
/// META BOX POST TYPE ARTICLE
function search_product($post)
{
	$post_id = $post->ID;
	if ( $post->post_type == 'article')
	{	
		$product_id = get_post_meta($post_id, 'tgt_product_id', true);		
		?>
		<input type="hidden" name="insert_nonce" value="<?php echo wp_create_nonce('insert-article') ?>" />
			<div id="custom-metabox">						
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
					
					
			<script type="text/javascript">
		
			jQuery(document).ready(function(){			
				jQuery.refreshCatCheckbox();
				
				
				jQuery('#category-add-submit').click(function(){
					jQuery(this).ajaxComplete(function(){
						jQuery.refreshCatCheckbox();
					});
				});
			});
			
			
			jQuery.refreshCatCheckbox = function(){
				var catlistdiv = jQuery( '#categorychecklist' ),
				first = catlistdiv.find( 'input:checkbox:checked' ).first();				
				catlistdiv.find( 'input:checkbox:checked' ).removeAttr( 'checked' );
				first.attr( 'checked', 'checked' );
				
				catlistdiv.find( 'input:checkbox' ).change(function(){
					var current_checkbox = jQuery(this),
						checkboxid = current_checkbox.attr( 'id' ),
						wrapper = jQuery( '#categorychecklist' );								
					wrapper.find( 'input:checkbox[id!='+checkboxid+']' ).removeAttr( 'checked' );
					
				});
			};	
			jQuery('#search').click(function(){		
				var cats = jQuery('#categorychecklist input:checkbox:checked').first(),
				cat = cats.val();					
				if(cat >= 1 )
				{	
					jQuery('#title_search_error').html('');
					search_edit_product(0);			
					
				}
				else
				{
					jQuery('#title_search_error').html('<?php _e ('Please select a category', 're');?>');
					jQuery('#noresult').html('');
					return false;
				}			
			});
			function search_edit_product(pro_id)
			{
				var cats = jQuery('#categorychecklist input:checkbox:checked').first(),
				cate = cats.val();
				var title_search = jQuery('#search_product_article').val();
				ajax_url = reviewAjax.ajaxurl;
				jQuery.post(
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
				   
				   var product_id = '<?php if(isset($product_id)) echo $product_id?>';
				   if( product_id > 0)
				   {
					   search_edit_product(product_id);
				   }				   
			});		
	</script>
	<?php 
	}
}
/* ================================= end meta box post type article */

////// META BOX POST TYPE PRODUCT
function detail_product($post)
{
	$post_id = $post->ID;
	if ( $post->post_type == 'product')
	{
	if ($post_id > 0) {
		$product['url'] = get_post_meta($post->ID, 'tgt_product_url', true);
		$product['price'] = get_post_meta($post->ID, 'tgt_product_price', true);
	}
	?>
		<input type="hidden" name="insert_nonce" value="<?php echo wp_create_nonce('insert-product') ?>" />
		<div class="inside">
			<!--<p>
			<label for="link_product"> <?php _e('Price','re') ?>:  </label><br />			
			<input type="text" name="product[price]" value="<?php if (!empty($product['price'])) echo $product['price'] ?>"/>
			</p>
			<p class="howto"> <?php _e('Specify product price. You can freely specify price format like $1000, $1.000 ... ','re') ?> </p>-->
			
			<p>
				<label for="link_product"> <?php _e('Link agency','re') ?>:  </label><br />
				<input type="text" id="link_product" name="product[url]" size="40px;" value="<?php if (!empty($product['url'])) echo $product['url'];?>"/>
			</p>
			<?php 
			/*$checked = '';
			$arr_featured_postid = array();
			$arr_featured_postid = get_option(FEATURED_PRODUCTS,true);
			if ( array_key_exists ( $post_id, (array)$arr_featured_postid ) ){
				$checked = 'checked="checked"';
			}*/
			?>
			<?php /*
			<p>
				<input type="checkbox" name="isfeatured" id="" <?php echo $checked; ?> />
				<label for=""><?php _e('Set product as featured' , 're') ?> </label>
			</p>
					*/
			?>
		</div>
		
		
		
		<script type="text/javascript">
		var ajaxURL = '<?php echo HOME_URL . '/?do=ajax' ?>';
			jQuery(document).ready(function(){			
				jQuery.refreshCatCheckbox();
				if ( jQuery('#categorychecklist input:checkbox:checked').length != 0 )
				{
				refreshCategory();
				}else{
					jQuery('#filterdiv .inside').html('');
					jQuery('#specdiv .inside').html('');
				}
				jQuery('#category-add-submit').click(function(){
					jQuery(this).ajaxComplete(function(){
						jQuery.refreshCatCheckbox();
					});
				});
			});
			
			
			jQuery.refreshCatCheckbox = function(){
				var catlistdiv = jQuery( '#categorychecklist' ),
				first = catlistdiv.find( 'input:checkbox:checked' ).first();				
				catlistdiv.find( 'input:checkbox:checked' ).removeAttr( 'checked' );
				first.attr( 'checked', 'checked' );
				
				catlistdiv.find( 'input:checkbox' ).change(function(){
					var current_checkbox = jQuery(this),
						checkboxid = current_checkbox.attr( 'id' ),
						wrapper = jQuery( '#categorychecklist' );								
					wrapper.find( 'input:checkbox[id!='+checkboxid+']' ).removeAttr( 'checked' );
					if ( jQuery('#categorychecklist input:checkbox:checked').length != 0 )
					{
						refreshCategory();
					}else{
						jQuery('#filterdiv .inside').html('');
						jQuery('#specdiv .inside').html('');
					}
				});
			};	



			function refreshCategory(){
				var cats = jQuery('#categorychecklist input:checkbox:checked').first(),
				catId = cats.val();					
				getFilterByCat(catId);
				getSpecByCat(catId);
			}
			
			/**
			 * get filter by category id
			 */
			function getFilterByCat(catId){				
				jQuery.ajax({
					type: 'post',
					url: reviewAjax.ajaxurl,
					data: {
						action: 'get_filter_by_category',
						cat_id: catId
					},
					success: function(data){
						if (data.success){						
							jQuery('#filterdiv .inside').html('');
							jQuery('#filterdiv').show();
							//
							jQuery('#filterdiv .inside').html(data.filters);							
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
			function getSpecByCat(catId){				
				jQuery.ajax({
					type: 'post',
					url: reviewAjax.ajaxurl,
					data: {
						action: 'get_spec_by_category',
						cat_id: catId
					},
					success: function(data){
						if (data.success){							
							jQuery('#specdiv .inside').html('');
							jQuery('#specdiv').show();	
							jQuery('#specdiv .inside').html(data.specs);							
							// add class odd - row for the odd row
							jQuery('#spectable tr:odd').addClass('odd-row');
							
							getSpecByPost();
						} 	
					}
				});
			}
			
			// get filter relationship
			function getFilterRelationship(){
				if (<?php echo $post_id; ?> != '' ){
					jQuery.ajax({
					type: 'post',
					url: reviewAjax.ajaxurl,
					data: {
						action: 'get_filter_relationship',
						post_id: <?php echo $post_id; ?>
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
				if (<?php echo $post_id; ?> != '' ){
					jQuery.ajax({
					type: 'post',
					url: reviewAjax.ajaxurl,
					data: {
						action: 'get_spec_by_post',
						post_id: <?php echo $post_id; ?>
					},
					success: function(data){
						if (data.success){
							for (var i = 0; i < data.specs.length; i++){
								jQuery('#' + data.specs[i].ID).attr('value', data.specs[i].value);								
							}					
						} // end if (data.success)				
					}// end success function
				});
				}
			}
	</script>
		
		
	<?php 
	}
}


function filter_product($post)
{	
	$post_id = $post->ID;
	if ( $post->post_type == 'product')
	{
	?>	
			<div id="filterdiv">					
				<div class="inside">
					
				</div>
				<div class="clear"></div>
			</div>	
	<?php 
	}
}

function specification_product($post)
{
	$post_id = $post->ID;
	if ( $post->post_type == 'product')
	{
	?>	
			<div  id="specdiv">							
				<div class="inside">
					<p>
						
					</p>
				</div>
			</div>
	<?php 
	}
}

function additional_tab($post)
{	
	$post_id = $post->ID;
	if ( $post->post_type == 'product')
	{
	?>	
			<div id="tabdiv">					
				<div class="inside">
				<?php
				$result = get_tab_data_tgt();
				if(!empty($result))
				{
				?>
					
					<?php
					foreach($result as $k_g => $v_g)
					{
					?>						
						<p style="font-size:12px;"><strong><?php echo $v_g['name']; ?></strong></p>
						<?php
						$detail = '';
						$content = '';
						if(get_post_meta($post_id,'tgt_tab',true) != '')
						{
							$detail = get_post_meta($post_id,'tgt_tab',true);
							$content = $detail['tab_'.$v_g['ID']];
						}
						?>
						<?php wp_editor( $content, 'content_'.$k_g, array('wpautop' => false ,'media_buttons' => false)  ); ?>	
				<?php
					}	
				}
				?>
				</div>
				<div class="clear"></div>
			</div>	
	<?php 
	}
}

/* ================================= end meta box post type product */

function save_meta_box($post_id)
{	
		global $wpdb, $post;		
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		   return $post_id;
		
		// Check permissions
		if ( isset($_POST['post_type']) &&  'page' == $_POST['post_type'] ) 
		{
		  if ( isset($post_id) && !current_user_can( 'edit_page', $post_id ) )
				return;
		}
		else
		{
		  if ( isset($post_id) && !current_user_can( 'edit_post', $post_id ) )
				return;
		}
		
		// when user submit article, set their first image as a feature image
		$attachments = array();
		if ( !has_post_thumbnail( $post_id ) )
		{
			$attachments = &get_children( 'post_type=attachment&post_mime_type=image&post_parent='.$post_id.'&numberposts=1&order=DESC&orderby=ID' );
			//set thumbnail
			if ( !empty( $attachments ) )
			{
				$attach = reset($attachments);
				set_post_thumbnail( $post_id, $attach->ID );
			}
		}
			
			if (!is_admin()){
				return $post_id;	
			}	
					
			if ( isset($_POST['post_type']) && $_POST['post_type'] == 'article')
			{
				$nonce = isset( $_POST['insert_nonce'] ) ? $_POST['insert_nonce'] : '';	
				if (! wp_verify_nonce($nonce, 'insert-article') ) return;
				
				if (isset($_POST['radio_product']) && !empty($_POST['radio_product'])){
					update_post_meta($post_id, 'tgt_product_id', $_POST['radio_product']);
				}
				if( isset($_POST['aiosp_title']) && $_POST['aiosp_title'] != '') {
					update_post_meta($post_id, 'tgt_aioseop_title', $_POST['aiosp_title']);
				}
				if( isset($_POST['aiosp_description']) && $_POST['aiosp_description'] != '') {
					update_post_meta($post_id, 'tgt_aioseop_description', $_POST['aiosp_description']);
				}
				if( isset($_POST['aiosp_keywords']) && $_POST['aiosp_keywords'] != '') {
					update_post_meta($post_id, 'tgt_aioseop_keywords', $_POST['aiosp_keywords']);
				}
				$aiosp_disable = 0;
				if( isset($_POST['aiosp_disable']) && $_POST['aiosp_disable'] != '') {
					$aiosp_disable = $_POST['aiosp_disable'];
				}
				update_post_meta($post_id, 'tgt_aioseop_disable', $aiosp_disable);
			}
			elseif ( isset($_POST['post_type']) && $_POST['post_type'] == 'product'){
				
			// check if post is product
			//if ( !isset( $_POST['post_type'] ) || $_POST['post_type'] != 'product' ) return;
		
				$nonce = isset( $_POST['insert_nonce'] ) ? $_POST['insert_nonce'] : '';	
				if (! wp_verify_nonce($nonce, 'insert-product') ) return;
			
				$product = array();
				
				if (isset($_POST['product'])){
				foreach ($_POST['product'] as $key => $value){
					$product[$key] = $value;
				}
				
				/*
				  Rating Count
				*/
				$product_info = array(
					PRODUCT_VIEW_COUNT 				=> get_post_meta( $post_id, PRODUCT_VIEW_COUNT, true ),
					PRODUCT_EDITOR_RATING_COUNT 	=> get_post_meta( $post_id, PRODUCT_EDITOR_RATING_COUNT, true ),
					PRODUCT_EDITOR_RATING 			=> get_post_meta( $post_id, PRODUCT_EDITOR_RATING, true ),
					PRODUCT_RATING_COUNT				=> get_post_meta( $post_id, PRODUCT_RATING_COUNT, true ),
					PRODUCT_RATING					=> get_post_meta( $post_id, PRODUCT_RATING, true ),
											 );
				foreach ( $product_info as $key => $info )
				{
					if ( !is_numeric($info) || $info == '' )
					{
						update_post_meta( $post_id, $key, 0 );
					}
				}
				
				if ( !empty($_POST['rating']) && is_array( $_POST['rating'] ) )
				{
					foreach( $_POST['rating'] as $meta_key => $item )
					{
						if ( is_numeric($item) )
						{
							update_post_meta( $post_id, $meta_key, $item );
						}
					}					
				}
				
				update_post_meta( $post_id , PRODUCT_EDITOR_RATING_COUNT , (int)$_POST['rating_info']['tgt_editor_rating_count'] );
				update_post_meta( $post_id , PRODUCT_RATING_COUNT , (int)$_POST['rating_info']['tgt_rating_count'] );
				
				update_post_meta($post_id, 	'tgt_product_url', 				$product['url']);
				update_post_meta($post_id, 	'tgt_product_price', 			$product['price']);
				$view_count = get_post_meta($post_id, 'tgt_view_count', true);
				if(empty ($view_count))
					 update_post_meta($post_id, 'tgt_view_count', 0);
				$view_count = get_post_meta($post_id, 'tgt_rating', true);
				if(empty ($view_count))
					 update_post_meta($post_id, 'tgt_rating', 0);
                	if( isset($_POST['aiosp_title']) && $_POST['aiosp_title'] != '') {
						update_post_meta($post_id, 'tgt_aioseop_title', $_POST['aiosp_title']);
					}
					if( isset($_POST['aiosp_description']) && $_POST['aiosp_description'] != '') {
						update_post_meta($post_id, 'tgt_aioseop_description', $_POST['aiosp_description']);
					}
					if( isset($_POST['aiosp_keywords']) && $_POST['aiosp_keywords'] != '') {
						update_post_meta($post_id, 'tgt_aioseop_keywords', $_POST['aiosp_keywords']);
					}
					$aiosp_disable = 0;
					if( isset($_POST['aiosp_disable']) && $_POST['aiosp_disable'] != '') {
						$aiosp_disable = $_POST['aiosp_disable'];
					}
					update_post_meta($post_id, 'tgt_aioseop_disable', $aiosp_disable);
				/**
				 * Update filter
				 */
				// delete old records
				$del_result = deleteRelatioship($post_id);
				// insert new records

				if (!empty($product['filter'])){
					global $wpdb;
					$table_relationship = $wpdb->prefix . 'tgt_filter_relationship';
					$sql = "INSERT INTO $table_relationship
					(filter_value_id, post_id) VALUES ";
					$t = 0;
					foreach($product['filter'] as $filter_group ){
						if(!empty($filter_group))
						{
							foreach($filter_group as $filter)
							{
								$sql .= $wpdb->prepare("  ( %d, %d )  ", $filter, $post_id);
								$sql .= ',';								
							}
						}						
					}
					$wpdb->query(rtrim($sql,','));
				}
				
				/**
				 * Update spec
				 */
				if (isset($product['spec'])){
					update_post_meta($post_id, 'tgt_product_spec', $product['spec']);
					update_post_meta($post_id, 'tgt_new_spec_version', 1);
				}				
				
				}
				/**
				 * Update additional tab
				 */
				$tab_detail = array();
				$result = get_tab_data_tgt();
				if(!empty($result))
				{
					foreach($result as $k_g => $v_g)
					{
						if(isset($_POST['content_'.$k_g]))
						{
							$tab_detail['tab_'.$v_g['ID']] = $_POST['content_'.$k_g];							
						}
					}
					update_post_meta($post_id, 'tgt_tab', $tab_detail);
				}
				/**
				 * Update option featured product
				 */
				
				//$arr_feature_postid = get_option(FEATURED_PRODUCTS,true );
				//if (!is_array($arr_feature_postid)){
				//	$arr_feature_postid = array();
				//}
				//if (isset($_POST['isfeatured'])){
				//	if (!array_key_exists($post_id, (array)$arr_feature_postid)){
				//		$arr_feature_postid[$post_id][] = $post_id;
				//	}
				//}else {
				//	if (array_key_exists($post_id, (array)$arr_feature_postid)){
				//		unset($arr_feature_postid[$post_id]);
				//	}
				//}
				//update_option(FEATURED_PRODUCTS, $arr_feature_postid);
			}
			elseif ( isset($_POST['post_type']) && $_POST['post_type'] == 'post'){
				if( isset($_POST['aiosp_title']) && $_POST['aiosp_title'] != '') {
					update_post_meta($post_id, 'tgt_aioseop_title', $_POST['aiosp_title']);
				}
				if( isset($_POST['aiosp_description']) && $_POST['aiosp_description'] != '') {
					update_post_meta($post_id, 'tgt_aioseop_description', $_POST['aiosp_description']);
				}
				if( isset($_POST['aiosp_keywords']) && $_POST['aiosp_keywords'] != '') {
					update_post_meta($post_id, 'tgt_aioseop_keywords', $_POST['aiosp_keywords']);
				}
				$aiosp_disable = 0;
				if( isset($_POST['aiosp_disable']) && $_POST['aiosp_disable'] != '') {
					$aiosp_disable = $_POST['aiosp_disable'];
				}
				update_post_meta($post_id, 'tgt_aioseop_disable', $aiosp_disable);
			}
			elseif ( isset($_POST['post_type']) && $_POST['post_type'] == 'page'){
				if( isset($_POST['aiosp_title']) && $_POST['aiosp_title'] != '') {
					update_post_meta($post_id, 'tgt_aioseop_title', $_POST['aiosp_title']);
				}
				if( isset($_POST['aiosp_description']) && $_POST['aiosp_description'] != '') {
					update_post_meta($post_id, 'tgt_aioseop_description', $_POST['aiosp_description']);
				}
				if( isset($_POST['aiosp_keywords']) && $_POST['aiosp_keywords'] != '') {
					update_post_meta($post_id, 'tgt_aioseop_keywords', $_POST['aiosp_keywords']);
				}
				if( isset($_POST['aiosp_titleatr']) && $_POST['aiosp_titleatr'] != ''){
					update_post_meta($post_id, 'tgt_aioseop_titleatr', $_POST['aiosp_titleatr']);
				}
				if( isset($_POST['aiosp_menulabel']) && $_POST['aiosp_menulabel'] != ''){
					update_post_meta($post_id, 'tgt_aioseop_menulabel', $_POST['aiosp_menulabel']);
				}
				$aiosp_disable = 0;
				if( isset($_POST['aiosp_disable']) && $_POST['aiosp_disable'] != '') {
					$aiosp_disable = $_POST['aiosp_disable'];
				}
				update_post_meta($post_id, 'tgt_aioseop_disable', $aiosp_disable);
			}
			
			
		
		
}
// Custom manager article --------------------------------------------------------------------
if ( !function_exists( 'array_insert' ) ) {
function array_insert(&$array, $insert, $position) {
settype($array, "array");
settype($insert, "array");
settype($position, "int");

if($position==0) {
    $array = array_merge($insert, $array);
} else {
    if($position >= (count($array)-1)) {
        $array = array_merge($array, $insert);
    } else {
        $head = array_slice($array, 0, $position);
        $tail = array_slice($array, $position);
        $array = array_merge($head, $insert, $tail);
    }
}
}}

add_filter( 'manage_posts_columns', 'add_article_column');
add_action( 'manage_posts_custom_column', 'add_article_value',10, 2);

if ( !function_exists( 'add_article_column' ) ) {
function add_article_column($cols) {
	if(isset($_GET['post_type']) && $_GET['post_type'] =='article'){
	$args_col = array(
	'col_product' => '<a href="edit.php?post_type=product"><span>'.__('Products').'</span></a>'
	//'col_author' => '<a href="javascript:"><span>'.__('Author').'</span></a>',
	//'col_price' => '<a href="javascript:"><span>'.__('Price').'</span></a>'	
	);		
	array_insert($cols, $args_col, 2);		
	 
	}
		return $cols;
    
}}
if ( !function_exists( 'add_article_value' ) ) {
function add_article_value($column_name, $post_id) {
	if(isset($_GET['post_type']) && $_GET['post_type'] =='article'){				
	global $post;
		if($column_name == 'col_product' ){
			if(get_post_meta($post->ID,'tgt_product_id',true) == ''){
				echo '';
			}else{
				$product_ID = get_post_meta($post->ID, 'tgt_product_id', true);
				if ( ! empty ( $product_ID ) ){					
					echo get_post_field('post_title', $product_ID);					
				}
				
			}			
		}		
		/*if($column_name == 'col_author' ){
			$userdata = get_userdata($post->post_author);
				  echo $userdata->user_login;
		}*/
	}			
		
}}
add_filter( 'manage_pages_columns', 'add_article_column');
add_action( 'manage_pages_custom_column', 'add_article_value',10, 2);

// End Custom manager article ***********************************
// Custom manager product --------------------------------------------------------------------

add_filter( 'manage_posts_columns', 'add_product_column');
add_action( 'manage_posts_custom_column', 'add_product_value',10, 2);

if ( !function_exists( 'add_product_column' ) ) {
function add_product_column($cols) {
	if(isset($_GET['post_type']) && $_GET['post_type'] =='product'){
	$args_col = array(	
	//'col_author' => '<a href="javascript:"><span>'.__('Author').'</span></a>',
	'col_price' => '<a href="javascript:"><span>'.__('Price').'</span></a>'	
	);		
	array_insert($cols, $args_col, 2);		
	 
	}
		return $cols;
    
}}
if ( !function_exists( 'add_product_value' ) ) {
function add_product_value($column_name, $post_id) {
	if(isset($_GET['post_type']) && $_GET['post_type'] =='product'){				
	global $post;
		if($column_name == 'col_price' ){			
				echo tgt_format_currency_symbol(get_post_meta($post_id, 'tgt_product_price', true));					
		}		
		/*if($column_name == 'col_author' ){
			$userdata = get_userdata($post->post_author);
				  echo $userdata->user_login;
		}*/
	}			
		
}}
add_filter( 'manage_pages_columns', 'add_product_column');
add_action( 'manage_pages_custom_column', 'add_product_value',10, 2);

// End Custom manager product ***********************************




?>
