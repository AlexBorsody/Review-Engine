<?php
/*
 * @Author: James. 
 */
global $wpdb;
$categories = get_categories();
if(isset($_GET['action']) && ($_GET['action'] == 'sorting' || $_GET['action'] == 'edit' ))
{	
	if( $_GET['action'] == 'sorting')
	{
		$title = __('Sorting Tabs','re');
		$result = get_tab_data_tgt();
	}
	elseif( $_GET['action'] == 'edit' && !empty( $_GET['group'] ) )
		$title = __('Edit Tab','re');
?>
	<div class="wrap">
		<div id="icon-edit" class="icon32">
			<br />
		</div>
		<h2>
			<?php _e('Specification Manager', 're') ?>
		</h2>
		<div class="tgt_atention">
			<strong><?php _e('Problems? Questions?','re');?></strong>&nbsp;<?php _e('Contact us at ','re');?><em><a href="http://www.dailywp.com/support/" target="_blank"><?php _e('Support','re');?></a></em>. 
		</div>
		
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
						<?php echo $title; ?>
						<a href="admin.php?page=tab-management" class="button">
							<?php _e('Back','re') ?>
						</a>
					</label>
				</h3>
				<div class="inside">
					<?php
					/**
					 * IF action is edit, show edit form
					 */
					if ($_GET['action'] == 'edit' && isset($_GET['group']) && !empty($_GET['group']) ) {
						$group_id = $_GET['group'];
						$spec_data = get_tab_data_tgt($group_id);						
					?>					
					<form action="" method="post" id="form_edit_group">
						<input type="hidden" name="group_id" value="<?php echo $group_id; ?>" />
						<p>
							<label for=""><?php _e('Group Name','re') ?>:</label> <br />
							<input type="text" name="group_name" value="<?php echo $spec_data[0]['name']; ?>"/>
						</p>						
						<p>
							<input type="submit" class="button" value="<?php _e('OK', 're'); ?>" name="edit_group" />
							<a href="admin.php?page=tab-management" class="close_group"><?php _e('Cancel', 're'); ?></a>
						</p>
					</form>
					<?php
					}else
					{
						if($_GET['action'] != 'sorting')
							echo "<script language='javascript'>window.location = '"."admin.php?page=tab-management"."'</script>";
					}
					/**
					 * IF action is sorting, show sorting form
					 */
					if ( $_GET['action'] == 'sorting')
					{
						_e('You are sorting the additional tabs for product. Drag and drop tabs and click save','re');
					?>
						
					<?php
						if(!empty($result))
						{							
					?>
							<form method="post" action="">							
							<ul class="sortable-list" id="spec_list">
							<?php
								foreach($result as $k_g => $v_g)
								{							
							?>
									<li class="sortable-item">
										<div class="list-item">
											<div class="list-header">
												<span class="list-title"><?php echo $v_g['name']; ?></span>										
												<input type="hidden" name="sorting[]" value="<?php echo $v_g['ID']; ?>" />
											</div>
										</div>
									</li>
							<?php } ?>
							</ul>
							<div class="clear"></div>
							<div class="section-button-area">							
								<div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="save_sorting" style="float:left;" value="<?php _e('Save','re'); ?>" />
								</div>
								<div class="clear"></div>
							</div>
							</form>
					<?php							
						}
						else
							echo "<script language='javascript'>window.location = '"."admin.php?page=tab-management"."'</script>";
					}
					?>
				</div>
					<div class="clear"></div>
			</div>
		
		</div>
	</div>	
<?php
}else
	echo "<script language='javascript'>window.location = '"."admin.php?page=tab-management"."'</script>";
?>