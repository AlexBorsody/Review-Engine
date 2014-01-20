<?php
/*
 * @Author: James. 
 */
global $wpdb;

$errors = '';
require_once TEMPLATEPATH . '/admin_processing/admin_tab_processing.php';

if (isset($_GET['action']) && ( 'edit' == $_GET['action'] || 'sorting' == $_GET['action']))
{
	require_once TEMPLATEPATH . '/admin/admin_edit_tab.php';
}else
{
	$categories = get_categories('exclude=1&hide_empty=0');
	
	$cate_id = $categories[0]->term_id;
	if(isset($_POST['categories']) && !empty($_POST['categories']))
		$cate_id = $_POST['categories'];
	$result = get_tab_data_tgt();
?>
<div class="wrap">
	<div id="icon-edit" class="icon32">
		<br />
	</div>
	<h2>
		<?php _e('Tab Manager', 're') ?>
	</h2>
	<div class="tgt_atention">
		<strong><?php _e('Problems? Questions?','re');?></strong>&nbsp;<?php _e('Contact us at ','re');?><em><a href="http://www.dailywp.com/support/" target="_blank">Support</a></em>. 
	</div>
	<?php 
    if( isset($_GET['message']) && $_GET['message'] == 'success' )  
    {		
        echo '<div class="updated below-h2">'.__('Your setting has been saved','re').'</div>'; 
    }
    ?>
	
	<?php 
    if($errors != '') 
    {
        echo '<div class="error">'.$errors.'</div>'; 
    }
    ?>
	<div id="poststuff">
		<div class="postbox" id="specification_group" >
			<h3 class="hndle">
				<label for="">
					<?php _e('Tab List', 're') ?>
					<a href="#" id="open_group" class="button">
						<?php _e('Add New','re') ?>
					</a>					
				</label>
			</h3>
			<div class="inside">				
				<form action="" method="post" id="form_create_group">
					<div id="form_group" class="postbox">
						<h3 class="hndle">
							<label for=""> <?php _e('Add New Tab', 're') ?> 
						</h3>
						<div class="inside">
							<p>
								<label for=""><?php _e('New Tab Name','re') ?>:</label> <br />
								<input type="text" name="group_name"/>
							</p>							
							<p>
								<input type="submit" class="button" value="<?php _e('OK', 're'); ?>" name="create_group" />
								<a href="#" class="close_group"><?php _e('Cancel', 're'); ?></a>
							</p>
						</div>
					</div>
				</form>	
				<?php
				if(!empty($result))
				{
				?>
				<a href="admin.php?page=tab-management&action=sorting&cat=<?php echo $cate_id; ?>" style="padding-left: 4px;">
					<?php _e('Sort the tabs below','re') ?>
				</a>
				<br>
				<ul class="unsortable-list" id="spec_list">
					<?php
					foreach($result as $k_g => $v_g)
					{
					?>
					<li class="sortable-item">
						<div class="list-item">
							<div class="list-header">
								<span class="list-title">
									<?php echo $v_g['name']; ?>
								</span>
								<span class="list-controls">
									<a href="#" class="list-toggle" title="<?php _e("Display tab's control",'re') ?>" ><span><?php echo $v_g['name']; ?></span></a>
								</span>
							</div>	
							<div class="list-content">
								<div>
									<p class="group-value-control">						
										<a href="admin.php?page=tab-management&action=edit&group=<?php echo $v_g['ID']; ?>" class="item-control-edit"><?php _e('Edit','re') ?></a> &nbsp;|&nbsp;
										<a class="item-control-delete" href="#" id="<?php echo $v_g['ID']; ?>"><?php _e('Delete','re'); ?></a>
									</p>
								</div>
							</div>
						</div>
					</li>
					<?php						
					}
					?>					
				</ul>				
				<?php
				}else
					_e('The additional tab for products is empty','re');
				?>
			</div>
				<div class="clear"></div>
		</div>
	
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	// Call Ajax when click Delete
	jQuery('.item-control-delete').click(function(){		
		if(confirm('<?php _e('Are you sure want to delete this item ?','re'); ?>') == true)
		{			
			// Call ajax get category specify		
			ajax_url = '<?php echo HOME_URL . '/?ajax=admin_tab_delete'?>';			
			$.post(
				reviewAjax.ajaxurl,
				{
					action: 'admin_tab_delete',
					para: this.id
				},
				function(data){					
					if (data.success){
						if(data.para == 1)
						{
							alert('<?php _e('You deleted tab successfully!','re'); ?>');
						}
						window.location = 'admin.php?page=tab-management';
					}
					else
						alert (data.para);
				}
			)
		}
		else
			return false;
	});
});
</script>
<?php
}
?>