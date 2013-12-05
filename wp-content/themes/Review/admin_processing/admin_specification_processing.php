<?php
/*
 * @Author: James. 
 */

/*
 * -------------------------- Start: New version -------------------------------
 */
$tgt_spec			= $wpdb->prefix . 'tgt_spec';
$tgt_spec_category	= $wpdb->prefix . 'tgt_spec_category';
$tgt_spec_value		= $wpdb->prefix . 'tgt_spec_value';

// Add new group
if(isset($_POST['create_group']) && !empty($_POST['create_group']))
{
	if(empty($_POST['group_name']))
		$errors .= __('Please enter specification group name!','re').'<br>';
	if(empty($_POST['categories']))
		$errors .= __('Please select the category for specification group!','re').'<br>';
	if($errors == '')
	{
		if(!empty($_POST['categories']))
		{
			$sql_insert_spec_cate = '';
			
			$wpdb->insert( $tgt_spec, array('name'=> $_POST['group_name']));
			$spec_id = $wpdb->insert_id;
			
			foreach($_POST['categories'] as $k => $v)
			{
				$count = 0;
				$q_count = "SELECT group_order FROM $tgt_spec_category WHERE `term_id`= '$k' ORDER BY group_order ASC";
				$count = $wpdb->get_results($q_count,ARRAY_A);
				$count = end($count);			
				$count = $count['group_order'] +1;
				$sql_insert_spec_cate .= "('".$spec_id."','".$k."','".$count."'),";
			}
			
			$sql_insert = "INSERT INTO $tgt_spec_category(spec_id,term_id,group_order) VALUES ".trim($sql_insert_spec_cate,',').";";
			$wpdb->query($sql_insert);
			
			echo "<script language='javascript'>window.location = '"."admin.php?page=specification&message=success"."'</script>";	
		}		
	}
}

// Edit group
if(isset($_POST['edit_group']) && !empty($_POST['edit_group']))
{	
	if(empty($_POST['group_name']) || trim($_POST['group_name']) == null)
		$errors .= __('The specification group name is not blank!','re').'<br>';
	if(empty($_POST['categories']))
		$errors .= __('Please select the category for specification group!','re').'<br>';
	if($errors == '')
	{				
		if(!empty($_POST['categories']))
		{
			if(isset($_POST['group_id']))
				$group_id = $_POST['group_id'];
			$wpdb->query(" DELETE FROM $tgt_spec_category WHERE spec_id = $group_id");
			$wpdb->update($tgt_spec,array('name' => $_POST['group_name']), array('ID' => $group_id));						
			foreach($_POST['categories'] as $k => $v)
			{
				$count = 0;
				$q_count = "SELECT group_order FROM $tgt_spec_category WHERE `term_id`= '$k' ORDER BY group_order ASC";
				$count = $wpdb->get_results($q_count,ARRAY_A);
				$count = end($count);			
				$count = $count['group_order'] +1;
				
				$sql_insert_spec_cate .= "('".$group_id."','".$k."','".$count."'),";
			}			
			$sql_insert = "INSERT INTO $tgt_spec_category(spec_id,term_id,group_order) VALUES ".trim($sql_insert_spec_cate,',').";";
			$wpdb->query($sql_insert);
			echo "<script language='javascript'>window.location = '"."admin.php?page=specification&message=success"."'</script>";	
		}		
	}
}

// Edit sorting specification group
if(isset($_POST['save_sorting'],$_POST['cate_id']) && !empty($_POST['save_sorting']) && $_POST['cate_id'] > 0)
{
	$sql_update_spec_order = "  CASE `spec_id` ";
	if(isset($_POST['sorting']) && !empty($_POST['sorting']))
	{
		$position = 0;
		foreach($_POST['sorting'] as $k => $id)
		{
			$position ++;
			$sql_update_spec_order .= " WHEN ".$id." THEN '".$position."' ";
			
		}
	}
	$sql_updade_spec_group = "UPDATE `".$tgt_spec_category."` SET `group_order` = ".$sql_update_spec_order." END WHERE term_id =".$_POST['cate_id'];
	$wpdb->query($sql_updade_spec_group);			
	echo "<script language='javascript'>window.location = '"."admin.php?page=specification&cat=".$_POST['cate_id']."&message=success"."'</script>";		
}

// Add specification values
if(isset($_POST['new_group_value']) && !empty($_POST['new_group_value']) && !isset($_POST['create_group']))
{	
	$spec_value = csv_explode(",",trim(stripcslashes($_POST['group_value'])));
	if(empty($_POST['group_value']) || (empty($spec_value[0]) && count($spec_value) == 1))
		$errors .= __('Please enter specification value!','re');	
	if($errors == '')
	{
		if(!empty($spec_value))
		{
			$sql_insert_value_s = '';
			$q_count = "SELECT spec_order FROM $tgt_spec_value WHERE spec_id = ".$_POST['group_id']." ORDER BY spec_order ASC";
			$count = $wpdb->get_results($q_count,ARRAY_A);
			$count = end($count);	
			$count = $count['spec_order'];
			foreach ($spec_value as $k => $v)
			{
				if(trim($v) != null)
				{
					$count ++;
					$sql_insert_value_s .= "('".$_POST['group_id']."','".trim($v)."','".$count."'),";
				}
			}
		}
		if($sql_insert_value_s == '')
			$errors .= __('Please enter specification value!','re');
		else
		{
			$sql_insert_s = "INSERT INTO $tgt_spec_value (`spec_id`,`name`,`spec_order`) VALUES ".trim($sql_insert_value_s,',').";";
			$wpdb->query($sql_insert_s);			
			echo "<script language='javascript'>window.location = '"."admin.php?page=specification&cat=".$_POST['categories']."&message=success"."'</script>";	
		}		
	}
}

// Edit specification values
if(isset($_POST['edit_value']) && !empty($_POST['edit_value']))
{
	if(trim($_POST['value_name']) == null || empty($_POST['value_name']))
		$errors .= __('Please enter specification value!','re');
	if($errors == '')
	{
		$wpdb->update($tgt_spec_value,array('name' => $_POST['value_name']), array('spec_value_id' => $_POST['value_id']));
		echo "<script language='javascript'>window.location = '"."admin.php?page=specification&cat=".$_POST['categories']."&message=success"."'</script>";	
	}
}


// Edit sorting specification values of each group
if(isset($_POST['save_sorting_values'],$_POST['group_id']) && !empty($_POST['save_sorting_values']) && $_POST['group_id'] > 0)
{	
	$sql_update_spec_order = "  CASE `spec_value_id` ";
	if(isset($_POST['sorting']) && !empty($_POST['sorting']))
	{
		$position = 0;
		foreach($_POST['sorting'] as $k => $id)
		{
			$position ++;
			$sql_update_spec_order .= " WHEN ".$id." THEN '".$position."' ";			
		}
	}
	$sql_updade_spec_group = "UPDATE `".$tgt_spec_value."` SET `spec_order` = ".$sql_update_spec_order." END WHERE spec_id =".$_POST['group_id'];
	$wpdb->query($sql_updade_spec_group);			
	echo "<script language='javascript'>window.location = '"."admin.php?page=specification&cat=".$_POST['cate_id']."&message=success"."'</script>";		
}
/*
 * -------------------------- End: New version ---------------------------------
 */
?>