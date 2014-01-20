<?php
/*
 * @Author: James. 
 */

/*
 * -------------------------- Start: New version -------------------------------
 */
$tgt_filter			= $wpdb->prefix.'tgt_filter';
$tgt_filter_value 		= $wpdb->prefix.'tgt_filter_value';
$tgt_filter_category		= $wpdb->prefix.'tgt_filter_category';
$tgt_filter_relationship	= $wpdb->prefix.'tgt_filter_relationship';

// Add new group
if(isset($_POST['create_group']) && !empty($_POST['create_group']))
{
	if(empty($_POST['group_name']))
	{
		$errors .= __('Please enter filter group name!','re').'<br>';
		echo "<script language='javascript'>window.location = '"."admin.php?page=filter&errors=name"."'</script>";
	}
	if(empty($_POST['categories']))
	{
		$errors .= __('Please select the category for filter group!','re').'<br>';
		echo "<script language='javascript'>window.location = '"."admin.php?page=filter&errors=cate"."'</script>";
	}
	if($errors == '')
	{			
		if(!empty($_POST['categories']))
		{
			$sql_insert_spec_cate = '';
			
			
			
			$wpdb->insert( $tgt_filter, array('name'=> $_POST['group_name']));
			$spec_id = $wpdb->insert_id;
			
			foreach($_POST['categories'] as $k => $v)
			{
				$count = 0;
				$q_count = "SELECT group_order FROM $tgt_filter_category WHERE `term_id`= '$k' ORDER BY group_order ASC";
				$count = $wpdb->get_results($q_count,ARRAY_A);
				$count = end($count);			
				$count = $count['group_order'] +1;
				
				$sql_insert_spec_cate .= "('".$spec_id."','".$k."','".$count."'),";
			}			
			$sql_insert = "INSERT INTO $tgt_filter_category(filter_id,term_id,group_order) VALUES ".trim($sql_insert_spec_cate,',').";";
			$wpdb->query($sql_insert);			
			echo "<script language='javascript'>window.location = '"."admin.php?page=filter&message=success"."'</script>";	
		}		
	}
}

// Edit group
if(isset($_POST['edit_group']) && !empty($_POST['edit_group']))
{	
	if(empty($_POST['group_name']) || trim($_POST['group_name']) == null)
	{
		$errors .= __('The filter group name is not blank!','re').'<br>';
		echo "<script language='javascript'>window.location = '"."admin.php?page=filter&errors=name"."'</script>";
	}
	if(empty($_POST['categories']))
	{
		$errors .= __('Please select the category for filter group!','re').'<br>';
		echo "<script language='javascript'>window.location = '"."admin.php?page=filter&errors=cate"."'</script>";
	}
	if($errors == '')
	{				
		if(!empty($_POST['categories']))
		{
			if(isset($_POST['group_id']))
				$group_id = $_POST['group_id'];
			$wpdb->query(" DELETE FROM $tgt_filter_category WHERE filter_id = $group_id");
			$wpdb->update($tgt_filter,array('name' => $_POST['group_name']), array('ID' => $group_id));						
			foreach($_POST['categories'] as $k => $v)
			{
				$count = 0;
				$q_count = "SELECT group_order FROM $tgt_filter_category WHERE `term_id`= '$k' ORDER BY group_order ASC";
				$count = $wpdb->get_results($q_count,ARRAY_A);
				$count = end($count);			
				$count = $count['group_order'] +1;
				
				$sql_insert_spec_cate .= "('".$group_id."','".$k."','".$count."'),";
			}			
			$sql_insert = "INSERT INTO $tgt_filter_category(filter_id,term_id,group_order) VALUES ".trim($sql_insert_spec_cate,',').";";
			$wpdb->query($sql_insert);
			echo "<script language='javascript'>window.location = '"."admin.php?page=filter&message=success"."'</script>";	
		}		
	}else
		$message = '';
}

// Edit sorting filter group
if(isset($_POST['save_sorting'],$_POST['cate_id']) && !empty($_POST['save_sorting']) && $_POST['cate_id'] > 0)
{
	$sql_update_spec_order = "  CASE `filter_id` ";
	if(isset($_POST['sorting']) && !empty($_POST['sorting']))
	{
		$position = 0;
		foreach($_POST['sorting'] as $k => $id)
		{
			$position ++;
			$sql_update_spec_order .= " WHEN ".$id." THEN '".$position."' ";			
		}
	}
	$sql_updade_spec_group = "UPDATE `".$tgt_filter_category."` SET `group_order` = ".$sql_update_spec_order." END WHERE term_id =".$_POST['cate_id'];
	$wpdb->query($sql_updade_spec_group);			
	echo "<script language='javascript'>window.location = '"."admin.php?page=filter&cat=".$_POST['cate_id']."&message=success"."'</script>";		
}

// Add filter values
if(isset($_POST['new_group_value']) && !empty($_POST['new_group_value']) && !isset($_POST['create_group']))
{	
	$spec_value = csv_explode(',',trim(stripcslashes($_POST['group_value'])));
	if(empty($_POST['group_value']) || (empty($spec_value[0]) && count($spec_value) == 1))
	{
		$errors .= __('Please enter filter value!','re');
		echo "<script language='javascript'>window.location = '"."admin.php?page=filter&errors=name"."'</script>";
	}
	if($errors == '')
	{
		if(!empty($spec_value))
		{
			$sql_insert_value_s = '';
			$q_count = "SELECT filter_order FROM $tgt_filter_value WHERE group_id = ".$_POST['group_id']." ORDER BY filter_order ASC";
			$count = $wpdb->get_results($q_count,ARRAY_A);
			$count = end($count);	
			$count = $count['filter_order'];
			foreach ($spec_value as $k => $v)
			{
				if(trim($v) != null)
				{
					$count ++;
					$sql_insert_value_s .= "('".$_POST['group_id']."','".trim($v)."','".$count."','0'),";
				}
			}
		}
		if($sql_insert_value_s == '')
		{
			$errors .= __('Please enter filter value!','re');
			echo "<script language='javascript'>window.location = '"."admin.php?page=filter&errors=name"."'</script>";
		}
		else
		{
			$sql_insert_s = "INSERT INTO $tgt_filter_value (`group_id`,`name`,`filter_order`,`filter_count`) VALUES ".trim($sql_insert_value_s,',').";";
			$wpdb->query($sql_insert_s);
			echo "<script language='javascript'>window.location = '"."admin.php?page=filter&cat=".$_POST['categories']."&message=success"."'</script>";	
		}		
	}
}

// Edit filter values
if(isset($_POST['edit_value']) && !empty($_POST['edit_value']))
{
	if(trim($_POST['value_name']) == null || empty($_POST['value_name']))	
		$errors .= __('Please enter filter value!','re');
	if($errors == '')
	{
		$wpdb->update($tgt_filter_value,array('name' => $_POST['value_name']), array('ID' => $_POST['value_id']));
		echo "<script language='javascript'>window.location = '"."admin.php?page=filter&cat=".$_POST['categories']."&message=success"."'</script>";	
	}else
		echo "<script language='javascript'>window.location = '"."admin.php?page=filter&cat=".$_POST['categories']."&errors=name"."'</script>";
}

// Edit sorting filter values of each group
if(isset($_POST['save_sorting_values'],$_POST['group_id']) && !empty($_POST['save_sorting_values']) && $_POST['group_id'] > 0)
{
	$sql_update_spec_order = "  CASE `ID` ";
	if(isset($_POST['sorting']) && !empty($_POST['sorting']))
	{
		$position = 0;
		foreach($_POST['sorting'] as $k => $id)
		{
			$position ++;
			$sql_update_spec_order .= " WHEN ".$id." THEN '".$position."' ";			
		}
	}
	$sql_updade_spec_group = "UPDATE `".$tgt_filter_value."` SET `filter_order` = ".$sql_update_spec_order." END WHERE group_id =".$_POST['group_id'];
	$wpdb->query($sql_updade_spec_group);			
	echo "<script language='javascript'>window.location = '"."admin.php?page=filter&cat=".$_POST['cate_id']."&message=success"."'</script>";		
}
/*
 * -------------------------- End: New version ---------------------------------
 */
?>