<?php
/**
 * Importation has 2 step
 */
global $helper;

require_once PATH_ADMIN_PROCESSING . '/admin_import_processing.php';

$data = (object) array('step' => 1, 'title' => '');
$data->step = empty($_REQUEST['step']) ? 1 : $_REQUEST['step'];
$data->title = __( 'Step 1' , 're' );
switch($data->step)
{
	case '1':
		$data->title = __( 'Step 1' , 're' );
		break;
	case '2':
		$data->title = __( 'Step 2' , 're' );
		break;
	case '3':
		$data->title = __( 'Finish' , 're' );
		break;
}

?>

<div class="wrap"> <!-- #wrap -->
    <div id="icon-edit" class="icon32"><br></div>
    <h2>
        <?php _e( 'Import Products', 're' );?>
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
                       <div class="poststuff"><h3 class="hndle"><?php echo $data->title;?></h3></div>
                           <div class="inside"><br>
	                            <p >
									<?php _e("Importation help you insert new products from an external file. You can choose two file type: <b>SCV</b> and <b>XML</b>. Whatever you choose, you must follow the format of the imporation or this feature doesn't work. About specification fields and filter fields you must fill them later when importation's completed",'re') ?>							
								</p>
								<?php
									$importation->display();
								?>
							
                         </div>
                  	</div>
                </div>
            </div>
        </div>
    </div>
</div>