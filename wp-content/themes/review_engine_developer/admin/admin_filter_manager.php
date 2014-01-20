<?php
/*
 * @Author: James. 
 */
global $wpdb;

$errors = '';
require_once TEMPLATEPATH . '/admin_processing/admin_filter_processing.php';

if (isset($_GET['action']) && ( 'edit' == $_GET['action'] || 'sorting' == $_GET['action']))
{
	require_once TEMPLATEPATH . '/admin/admin_edit_filter.php';	
}else
{
	$categories = get_categories('exclude=1&hide_empty=0');
	
	$cate_id = $categories[0]->term_id;
	if(isset($_POST['categories']) && !empty($_POST['categories']))
		$cate_id = $_POST['categories'];
	elseif(isset($_GET['cat']) && !empty($_GET['cat']))
		$cate_id = $_GET['cat'];
	$result = get_all_data_filter_by_cat_id_tgt($cate_id);
?>
<div class="wrap">
	<div id="icon-edit" class="icon32">
		<br />
	</div>
	<h2>
		<?php _e('Filter Manager', 're') ?>
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
    if( isset($_GET['errors']) && !empty($_GET['errors']) ) 
    {
		if($_GET['errors'] == 'name')
			echo '<div class="error">'.__('The field name is not blank!','re').'</div>';
		elseif($_GET['errors'] == 'cate')
			echo '<div class="error">'.__('Please select the category for filter!','re').'</div>';
    }
    ?>
	<div id="poststuff">
		<div class="postbox" id="specification_group" >
			<h3 class="hndle">
				<label for="">
					<?php _e('Filter Group', 're') ?>
					<a href="#" id="open_group" class="button">
						<?php _e('New Group','re') ?>
					</a>					
				</label>
			</h3>
			<div class="inside">				
				<form action="" method="post" id="form_create_group">
					<div id="form_group" class="postbox">
						<h3 class="hndle">
							<label for=""> <?php _e('Add New Group', 're') ?> 
						</h3>
						<div class="inside">
							<p>
								<label for=""><?php _e('New Group Name','re') ?>:</label> <br />
								<input type="text" name="group_name"/>
							</p>
							<div class="choose_cat">
								<p><strong><?php _e('Categories', 're'); ?></strong></p>
								<p>
									<a href="#" id="link_check_all" onclick="return false;"><?php _e('Check All','re'); ?></a>&nbsp;|
									<a href="#" id="link_uncheck_all" onclick="return false;"><?php _e('Uncheck All','re'); ?></a>
								</p>
								<?php categories_checkbox( ); ?>
							</div>
							<p>
								<input type="submit" class="button" value="<?php _e('OK', 're'); ?>" name="create_group" />
								<a href="#" class="close_group"><?php _e('Cancel', 're'); ?></a>
							</p>
						</div>
					</div>
				</form>
				
				<p>
					<?php _e('Please choose one category you want to view Specification:','re'); ?>
				</p>
				<p>
					<form action="admin.php?page=filter" method="post" name="filter_by" id="filter_by">						
						<?php categories_dropdown( array( 'selected' => $cate_id )); ?>
						<a href="admin.php?page=filter&action=sorting&cat=<?php echo $cate_id; ?>"><?php _e('Sort groups for this category','re') ?></a>
					</form>
				</p>				
				<?php
				if(!empty($result))
				{
				?>
				<ul class="unsortable-list" id="spec_list">
					<?php
					foreach($result as $k_g => $v_g)
					{
					?>
					<li class="sortable-item">
						<div class="list-item">
							<div class="list-header">
								<span class="list-title"><?php echo $v_g['group_name']; ?></span>
								<span class="list-controls">
									<a href="#" class="list-toggle" title="<?php _e('Display filter item in this group','re') ?>" ><span><?php echo $v_g['group_name']; ?></span></a>
								</span>
							</div>
							<div class="list-content">
								<?php
								if(!empty($v_g['value']))
								{
								?>
								<ul class="group-list">
									<?php
									foreach($v_g['value'] as $k_s => $v_s)
									{
									?>
									<li class="group-item">
										<form action="" method="post">
											<input type="hidden" value="<?php echo $cate_id; ?>" name="categories" />
											<input type="hidden" value="<?php echo $v_s['filter_value_id']; ?>" name="value_id" />
											<span class="item-title"><?php echo $v_s['value_name']; ?></span>
											<span class="item-field">
												<input type="text" name="value_name" id="" value="<?php echo $v_s['value_name']; ?>" />
											</span>
											<span class="item-controls" style="position: inherit">
												<a href="" class="item-control-edit"><?php _e('Edit','re') ?></a> |
												<a class="item-control-delete" id="del_filter_<?php echo $v_s['filter_value_id']; ?>_group_<?php echo $v_g['filter_id']; ?>"><?php _e('Delete','re') ?></a>
											</span>										
											<span class="item-controls-edit">
												<input type="submit" class="button" value="<?php _e('OK', 're'); ?>" name="edit_value" /></a> |
												<a href="" class="item-control-cancel"><?php _e('Cancel','re') ?></a>
											</span>
										</form>
									</li>
									<?php										
									}
									?>									
								</ul>
								<?php
								}
								?>
								<div class="new-group-value">									
									<div class="form-group-value">
										<form action="" method="post">											
											<input type="hidden" name="group_id" value="<?php echo $v_g['filter_id']; ?>" />
											<label for="group_value"><?php _e('Group values (separate by comma)', 're'); ?></label> <br />
											<textarea name="group_value" cols="30" rows="10"></textarea>
											<input type="submit" class="button" value="<?php _e('OK','re') ?>" name="new_group_value" />
											<a href="#" class="link-red group-value-close"><?php _e('Cancel','re') ?></a>
										</form>
									</div>
									<p class="group-value-control">
										<a href="#" class="group-value-open"><?php _e('New Values', 're') ?></a> &nbsp;|&nbsp;
										<a href="admin.php?page=filter&action=edit&group=<?php echo $v_g['filter_id']; ?>" class="item-control-edit"><?php _e('Edit','re') ?></a> &nbsp;|&nbsp;
										<a class="item-control-delete" href="#" id="del_group_<?php echo $v_g['filter_id']; ?>"><?php _e('Delete','re'); ?></a>
										<?php
										if(!empty($v_g['value']))
										{
										?>
											&nbsp;|&nbsp;										
											<a href="admin.php?page=filter&action=sorting&cat=<?php echo $cate_id; ?>&group=<?php echo $v_g['filter_id']; ?>" class="item-control-sorting" ><?php _e('Sort values of group','re'); ?></a>
										<?php
										}
										?>
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
				}
				?>
			</div>
				<div class="clear"></div>
		</div>
	
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
	// Call Ajax when click Delete
	jQuery('.item-control-delete').click(function(){		
		if(confirm('<?php _e('Are you sure want to delete this item ?','re'); ?>') == true)
		{
			// Call ajax get category specify							
			$.post(
				reviewAjax.ajaxurl,
				{
					action: 'admin-filter-delete',
					para: this.id
				},
				function(data){
					if (data.success){
						if(data.para == 1)
						{
							alert('<?php _e('You deleted filter group successfully!','re'); ?>');
						}
						else if(data.para == 2)
						{
							alert('<?php _e('You deleted filter value successfully!','re'); ?>');
						}
						//alert(data.para);
						window.location = 'admin.php?page=filter';
					}
					else
						alert (data.para);
				}
			)
		}
		else
			return false;
	});					
	jQuery('#link_check_all').click(function(){
		jQuery('input[type=checkbox][name*="categories"]').attr('checked','checked');
	});
	jQuery('#link_uncheck_all').click(function(){
		jQuery('input[type=checkbox][name*="categories"]').attr('checked',false);
	});				
	jQuery('#categories_dropdown').change(function(){		jQuery('#filter_by').submit();	});
});
</script>
<?php
}
?>