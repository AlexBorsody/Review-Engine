<?php
/*
 * @Author: James. 
 */

/*
 * -------------------------- Start: New version -------------------------------
 */
$tgt_tab	= $wpdb->prefix . 'tgt_tab';

// Add new tab
if(isset($_POST['create_group']) && !empty($_POST['create_group']))
{
	if(empty($_POST['group_name']))
		$errors .= __('Please enter the name for new tab!','re').'<br>';	
	if($errors == '')
	{
		$count = 0;
		$q_count = "SELECT tab_order FROM $tgt_tab ORDER BY tab_order ASC";
		$count = $wpdb->get_results($q_count,ARRAY_A);
		$count = end($count);
		$position = $count['tab_order'] + 1;
		
		$wpdb->insert( $tgt_tab, array('name'=> $_POST['group_name'],'tab_order' => $position));				
		echo "<script language='javascript'>window.location = '"."admin.php?page=tab-management&message=success"."'</script>";					
	}
}

// Edit tab
if(isset($_POST['edit_group']) && !empty($_POST['edit_group']))
{	
	if(empty($_POST['group_name']) || trim($_POST['group_name']) == null)
		$errors .= __('The tab name is not blank!','re').'<br>';	
	if($errors == '')
	{	
		if(isset($_POST['group_id']))
			$group_id = $_POST['group_id'];
		$wpdb->update($tgt_tab,array('name' => $_POST['group_name']), array('ID' => $group_id));	
		echo "<script language='javascript'>window.location = '"."admin.php?page=tab-management&message=success"."'</script>";	
	}
}

// Edit sorting tab
if(isset($_POST['save_sorting']) && !empty($_POST['save_sorting']))
{
	$sql_update_tab_order = "  CASE `ID` ";
	if(isset($_POST['sorting']) && !empty($_POST['sorting']))
	{
		$position = 0;
		foreach($_POST['sorting'] as $k => $id)
		{
			$position ++;
			$sql_update_tab_order .= " WHEN ".$id." THEN '".$position."' ";
			
		}
	}
	$sql_updade_tab = "UPDATE `".$tgt_tab."` SET `tab_order` = ".$sql_update_tab_order." END";
	$wpdb->query($sql_updade_tab);			
	echo "<script language='javascript'>window.location = '"."admin.php?page=tab-management&message=success"."'</script>";		
}
/*
 * -------------------------- End: New version ---------------------------------
 */
?>