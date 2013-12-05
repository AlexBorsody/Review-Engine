<?php
include_once TEMPLATEPATH . '/admin_processing/admin_top_product_processing.php';
$top_products = get_option(PRODUCT_TOP);
if(empty($top_products))
    $top_products = init_top_product ();
$tmp_posts = array();
if(!empty($top_products))
{
    $args = array(
        'post_type' => 'product',    	
        'include' => $top_products
    );
    $the_posts = get_posts($args);
}
?>
<div class="wrap"> <!-- #wrap -->
    <div id="icon-edit" class="icon32"><br></div>
    <h2>
        <?php _e( 'Top Agencies', 're' );?>
    </h2>
    <div class="tgt_atention">
            <strong><?php _e('Problems? Questions?','re');?></strong><?php _e(' Contact us at ','re');?><em><a href="http://www.dailywp.com/community/" target="_blank">Support</a></em>.
    </div>    
    <?php
    if (isset($message) && !empty($message)) { echo '<div class="updated below-h2">'.$message.'</div>'; }
    elseif (isset($error) && !empty($error)) { echo '<div class="error">'.$error.'</div>'; }
    ?>    
    <div id="poststuff" class="metabox-holder has-right-sidebar">
        <div id="wpbody-content">
            <div class="wrap">
                <div id="custom-metabox">
                    <div class="postbox " id="product-search"  style="width: 1154px; margin-left: -5px;">
                        <div class="poststuff"><h3 class="hndle"><?php _e('Top Products', 're');?></h3></div>
                        <div class="inside">
                            <form action="" method="post">
									 <?php if(!empty ($the_posts)) { ?>
                                <ul class="sortable-list">
                                    <?php 
                                    $i = 0;
                                    foreach ($top_products as $product_id)
                                    {
                                    	foreach ($the_posts as $top_product)
	                                    	if($top_product->ID == $product_id)
	                                    	{
		                                        $product_title = $top_product->post_title;
		                                        if(strlen($product_title) > 30)
		                                            $product_title = substr ($product_title, 0, 30) . '...';
		                                        $link = get_permalink($top_product->ID);
		                                        $title = ($i+1) . '. <a href="' . $link . '">' . $product_title . '</a>'. ' - ' . get_categories_name($top_product->ID);
                                    ?>
		                                        <li class="sortable-item">
		                                            <div class="list-item">
		                                                <div class="list-header">
		                                                    <span class="list-title"><?php echo $title; ?></span>
		                                                    <span class="list-controls"><a href="#" class="control-delete" title="<?php _e('Delete','re') ?>"><span>delete</span></a></span>
		                                                    <input type="hidden" name="top_product[]" value="<?php echo $top_product->ID; ?>" class="product_delete" id="product_<?php echo $top_product->ID;?>" />
		                                                </div>
		                                            </div>
		                                        </li>
                                    <?php 
                                    	$i++;
                                    	} 
                                    }?>                        
                                </ul>
										  <?php } else {
												echo '<p>'. _e('To add top product manually, please use search box below') .'</p>';
										  } ?>
										  <br>
										  <input type="checkbox" name="display_homepage" value="1" <?php if(get_option (PRODUCT_TOP_DISPLAY) == 1) echo 'checked'; ?>>&nbsp;
										  <label><?php _e('Display these products in homepage. If you uncheck this, Review Engine will display top rating product by default','re');?></label>
										  <div class="clear"></div>
										  <div class="new-group-value">
												<input type="submit" name="save-sort-product" value="<?php _e('Save','re');?>" class="button" />
										  </div>
									  </form>
                        </div>
                    </div>
                </div>
                
                        <!-- Search product -->
                    
                    <form action="" method="post">
                        <div id="custom-metabox">
                            <div class="postbox " id="product-search"  style="width: 1154px; margin-left: -5px;">
                                <div class="poststuff"><h3 class="hndle"><?php _e('Search Products', 're');?></h3></div>
                                <div class="inside"><br>
                                    <div id="titlewrap">
                                        <input type="text" name="search_product" id="search_product_article" class="regular-text code" style="border-collapse: collapse; width: 50%; margin-left: 20px;" value="<?php if(isset ($product)) echo $product;?>">
                                        <input type="button" id="search" name="search" value="<?php _e ('Search', 're');?>" class="button p-search" >
                                        <div id="table_product"></div>
                                    </div>
                                    <div id="table_product"></div>
                                    <div>
                                        <p><input type="button" class="button" value="<?php _e('Check all', 're') ?>" name="checkall" id="checkall" style="display: none">
                                        <input type="button" class="button" value="<?php _e('Uncheck all', 're') ?>" name="uncheckall" id="uncheckall" style="display: none"></p>
                                    </div>
                                    <div id="titlewrap">
                                        <p id="noresult" class="tgt_warning" style=" margin-left: 20px;"></p>
                                        <p style=" margin-left: 20px;"><label id="title_search_error" class="tgt_warning"><?php _e('No product available', 're')?></label></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <input type="submit" value="<?php _e('Add top agency', 're'); ?>" id="add_top_product" name="add_top_product" class="button-primary"/>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#top_product tr:odd').addClass('row-odd');
        search_edit_product(1);
    });
    jQuery('#search').click(function(){       
        search_edit_product(0);
        return false;
    });
    function search_edit_product(init)
    {        
        var title_search = jQuery('#search_product_article').val();
        var product = '<?php echo $product; ?>';
        if(title_search == '' && product != '')
            title_search = product;
        ajax_url = "<?php echo HOME_URL . '/?ajax=admin_top_product'?>";
        $.post(
            reviewAjax.ajaxurl,
            {
                action: 'admin_top_product',               
                product_title: title_search,
                first: init
            },
            function(data){
                if (data.success){
                    //delete old data
                    jQuery('#table_product').html('');                    
                    if(data.para !='')
                    {
                        jQuery('#noresult').html('');                        
                        jQuery('#table_product').html(data.para);
                        jQuery('#title_search_error').html('');
                        jQuery('#table_product tr:odd').addClass('row-odd');
                        jQuery('#checkall').css("display", "inline");
                        jQuery('#uncheckall').css("display", "inline");
                        jQuery('#table_product tr:odd').addClass('row-odd');
                    }
                    else
                    {
                        jQuery('#checkall').css("display", "none");
                        jQuery('#uncheckall').css("display", "none");
                        jQuery('#title_search_error').html('');
                        jQuery('#title_search_error').html('<?php _e('No product available.','re'); ?>');
                    }
                }
                else
                {
                    jQuery('#checkall').css("display", "none");
                    jQuery('#uncheckall').css("display", "none");
                    jQuery('#title_search_error').html('');
                    jQuery('#title_search_error').html('<?php _e('No product available.','re'); ?>');
                }
                jQuery('.star-disabled').rating();
            }
        )
    }
    jQuery('#checkall').click(function(){
        var values = new Array();
        $.each(jQuery("input[name='check_product[]']"), function() {
            values.push(jQuery(this).attr('id'));
        });
        for(var i=0; i< values.length; i++)
        {
            jQuery('#check_product_' + i).attr('checked', true);
        }
    });
    jQuery('#uncheckall').click(function(){
        var values = new Array();
        $.each(jQuery("input[name='check_product[]']"), function() {
            values.push(jQuery(this).attr('id'));
        });
        for(var i=0; i< values.length; i++)
        {
            jQuery('#check_product_' + i).attr('checked', false);
        }
    });
    jQuery('.control-delete').click(function(){
		  var current = jQuery(this),
				items = current.parents('.list-item');
		  items.each(function(){
    		var current = jQuery(this),    			
    			del_value = current.find('.product_delete'),
    			del_button = current.find('.control-delete');			
			var id = del_value.val();
			if ( confirm('Are you really want to remove this item?') )
			{				
				
				ajax_url = "<?php echo HOME_URL . '/?ajax=admin_delete_top_product'?>";
		        $.post(
		            reviewAjax.ajaxurl,
		            {
		                action: 'admin_delete_top_product',               
		                product_id: id		                
		            },
		            function(data){
		              if (data.success){
		                    //delete old data
		                                     
								if(data.para != -1)
								{
									 alert('<?php _e('This product deleted successfully','re')?>');
									 current.fadeOut('1000' , function(){ jQuery(this).remove()});
									// if(data.para == 0)
									// {
									//	 jQuery('#custom-metabox').fadeOut(1000);
									//	 jQuery('.updated').html('<?php _e('The product deleted successfully','re')?>');
									// }
									// else
									// {
									//	 current.fadeOut('1000' , function(){ jQuery(this).remove()});
									//	 jQuery('.error').html('<?php _e('Can not delete this product. Please try again.','re')?>');
									// }
								}
								else
								{
									 alert('<?php _e('Can not delete this product. Please try again.','re')?>');
								}
		              }
		                else
		                {
		                	alert('<?php _e('Can not delete this product. Please try again.','re')?>');
		                }
		               
		            }
		        )
			}
    	});
    	return false;
        });
</script>
