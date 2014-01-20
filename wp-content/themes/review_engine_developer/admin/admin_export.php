<?php 
global $helper;

//require_once PATH_ADMIN_PROCESSING . '/admin_export_processing.php';

?>
<div class="wrap"> <!-- #wrap -->
    <div id="icon-edit" class="icon32"><br></div>
    <h2>
        <?php _e( 'Export Products', 're' );?>
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
                       <div class="poststuff"><h3 class="hndle"><?php _e('Export products', 're');?></h3></div>
                           <div class="inside">
	                            <p >
									<?php _e("Export help you get products from your site. ",'re') ?>							
								</p>
							<form action="" method="post" enctype="multipart/form-data" >
							<?php _e('Choose type of export file ', 're');?>
								<select name="choose_type">
									<option value="xml"><?php _e('XML file', 're');?></option>
									<option value="csv"><?php _e('CSV file', 're');?></option>
								</select>
								<input type="submit" name="export_file" value="Export file" class="button-primary ex_file" />
							</form>
                         </div>
                  	</div>
                </div>
            </div>
        </div>
    </div>
</div>
