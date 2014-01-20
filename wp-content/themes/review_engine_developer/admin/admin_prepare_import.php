<?php 
if (isset($_GET['action']) && ( 'import' == $_GET['action']) )
{
	require_once TEMPLATEPATH . '/admin/admin_import.php';
}
else if (isset($_GET['action']) && ( 'import-spec' == $_GET['action']) )
{
	require_once TEMPLATEPATH . '/admin/admin_import_spec.php';
}
else if( isset($_GET['action']) && ( 'export' == $_GET['action'])) {
	require_once TEMPLATEPATH . '/admin/admin_export.php';
}
else {
?>
<div class="wrap"> <!-- #wrap -->
    <div id="icon-edit" class="icon32"><br></div>
    <h2>
        <?php _e( 'Import/Export Products', 're' );?>
    </h2>
    <div class="tgt_atention">
       <strong><?php _e('Problems? Questions?','re');?></strong><?php _e(' Contact us at ','re');?><em><a href="http://www.dailywp.com/community/" target="_blank">Support</a></em>.
    </div>
    <?php
    if (isset($message) && !empty($message)) { echo '<div class="updated below-h2">'.$message.'</div>'; }
    elseif (isset($error) && !empty($error)) { echo '<div class="error">'.$error.'</div>'; }
    ?>
    <table class="widefat" cellspancing="0">
       <tbody>
     	 <tr class="alternate">
     	   <td class="import_system_row_title">
     	   	 <a class="thickbox" title="Import" href="admin.php?page=review-engine-admin-import&action=import"><?php _e('Import products', 're');?></a>
     	   </td>
     	   <td class="desc">
     	     <?php _e('Get data from external file. It fill informations in your sites the fastest','re');?>
     	   </td>
     	 </tr>
		  <tr class="alternate">
     	   <td class="import_system_row_title">
     	   	 <a class="thickbox" title="Import" href="admin.php?page=review-engine-admin-import&action=import-spec"><?php _e('Import products with Specification', 're');?></a>
     	   </td>
     	   <td class="desc">
     	     <?php _e('Get data from external file. It fill informations in your sites the fastest','re');?>
     	   </td>
     	 </tr>
     	 <tr class="alternate">
     	   <td class="import_system_row_title">
     	   	 <a class="thickbox" title="Export" href="admin.php?page=review-engine-admin-import&action=export"><?php _e('Export products', 're');?></a>
     	   </td>
     	   <td class="desc">
     	     <?php _e('Get data from your system','re');?>
     	   </td>
     	 </tr>
       </tbody>
    </table>
</div>
<?php
} 
?>