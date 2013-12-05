<?php
/*
 * @Author: James. 
 */
global $wpdb;
$categories = get_categories();
if(isset($_GET['action']) && ($_GET['action'] == 'sorting' || $_GET['action'] == 'edit' ))
{	
	if( $_GET['action'] == 'sorting' && !empty( $_GET['cat'] ) )
		$title = __('Sorting Group','re');
	elseif( $_GET['action'] == 'sorting' && !empty( $_GET['group'] ) )
		$title = __('Sorting Values','re');
	else
		$title = __('Edit Group', 're');
	
	if(isset($_GET['cat']) && $_GET['cat'] > 0 && !isset($_GET['group']))
	{
		$cate_id = $_GET['cat'];
		$result = get_all_data_filter_by_cat_id_tgt($cate_id);
		$cate_name = get_cat_name($cate_id);
	}elseif(isset($_GET['group']) && $_GET['group'] > 0)
	{
		$result = get_all_data_filter_tgt($_GET['group']);
		$cate_name = $result['group_name'];
	}
	$title .= ': ' . $cate_name;
?>
	<div class="wrap">
		<div id="icon-edit" class="icon32">
			<br />
		</div>
		<h2>
			<?php _e('Filter Manager', 're') ?>
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
						<a href="admin.php?page=filter" class="button">
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
						$spec_data = get_all_data_filter_tgt($group_id);
						
					?>
					<form action="" method="post" id="form_edit_group">
						<input type="hidden" name="group_id" value="<?php echo $group_id; ?>" />
						<p>
							<label for=""><?php _e('New Group Name','re') ?>:</label> <br />
							<input type="text" name="group_name" value="<?php echo $spec_data['group_name']; ?>"/>
						</p>
						<div class="choose_cat">
							<p><strong><?php _e('Categories', 're'); ?></strong></p>
							<p>
								<a href="#" id="link_check_all" onclick="return false;"><?php _e('Check All','re'); ?></a>&nbsp;|
								<a href="#" id="link_uncheck_all" onclick="return false;"><?php _e('Uncheck All','re'); ?></a>
							</p>
							<?php categories_checkbox(array('selected' => explode(',', $spec_data['term_id']))); ?>
						</div>
						<p>
							<input type="submit" class="button" value="<?php _e('OK', 're'); ?>" name="edit_group" />
							<a href="admin.php?page=filter" class="close_group"><?php _e('Cancel', 're'); ?></a>
						</p>
					</form>
					<script type="text/javascript">
					jQuery(document).ready(function(){						
						jQuery('#link_check_all').click(function(){
							jQuery('input[type=checkbox][name*="categories"]').attr('checked','checked');
						});
						jQuery('#link_uncheck_all').click(function(){
							jQuery('input[type=checkbox][name*="categories"]').attr('checked',false);
						});
					});
					</script>
					<?php
					}else
					{
						if($_GET['action'] != 'sorting')
							echo "<script language='javascript'>window.location = '"."admin.php?page=filter"."'</script>";
					}
					/**
					 * IF action is sorting, show sorting form
					 */
					if ( $_GET['action'] == 'sorting')
					{
						if ( empty( $_GET['group'] ) )
							printf( '<p>' . __('You are sorting filter groups in category <b>%s</b>. Drag and drop groups and click save','re') . '</p>', $cate_name );
						else
							printf( '<p>' . __('You are sorting filter values in group <b>%s</b>. Drag and drop groups and click save','re') . '</p>', $cate_name );
						//echo $cate_name;
					?>
						
					<?php
						if(!empty($_GET['cat']) && $_GET['cat'] > 0 && !isset($_GET['group']))
						{
							if(!empty($result))
							{							
					?>
							<form method="post" action="">
							<input type="hidden" name="cate_id" value="<?php echo $_GET['cat']; ?>" />
							<ul class="sortable-list" id="spec_list">
							<?php
								foreach($result as $k_g => $v_g)
								{							
							?>
									<li class="sortable-item">
										<div class="list-item">
											<div class="list-header">
												<span class="list-title"><?php echo $v_g['group_name']; ?></span>										
												<input type="hidden" name="sorting[]" value="<?php echo $v_g['filter_id']; ?>" />
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
						}elseif(!empty($_GET['group']) && $_GET['group'] > 0)
						{
							if(!empty($result))
							{
					?>
							<form method="post" action="">
							<input type="hidden" name="cate_id" value="<?php echo $_GET['cat']; ?>" />
							<input type="hidden" name="group_id" value="<?php echo $_GET['group']; ?>" />
							<ul class="sortable-list" id="spec_list">
							<?php
								foreach($result['values_id'] as $k_g => $v_g)
								{							
							?>
									<li class="sortable-item">
										<div class="list-item">
											<div class="list-header">
												<span class="list-title"><?php echo $result['values_name'][$k_g]; ?></span>										
												<input type="hidden" name="sorting[]" value="<?php echo $v_g; ?>" />
											</div>
										</div>
									</li>
							<?php } ?>
							</ul>
							<div class="clear"></div>
							<div class="section-button-area">							
								<div class="section-buttons">
									<input type="submit" class="left-align button-primary" name="save_sorting_values" style="float:left;" value="<?php _e('Save','re'); ?>" />
								</div>
								<div class="clear"></div>
							</div>
							</form>
					<?php
							}
						}
					?>
						
					<?php
					}
					?>
				</div>
					<div class="clear"></div>
			</div>
		
		</div>
	</div>	
<?php
}else
	echo "<script language='javascript'>window.location = '"."admin.php?page=filter"."'</script>";
?>