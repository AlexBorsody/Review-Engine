<?php
/*
 * @Author: James. 
 */
$errors = '';
$message = '';
if(!empty($_COOKIE['message_suggest']))
{
	$message = $_COOKIE['message_suggest'];	
	unset($_COOKIE['message_suggest']);
}

require( TEMPLATEPATH . '/admin_processing/admin_list_suggestions_processing.php' );
?>
<div class="wrap"> <!-- #wrap 1 -->
	<div id="icon-edit" class="icon32"><br></div>
	<h2>
		<?php _e( 'Youngworld List Suggestions', 're' );?>		
	</h2>
	<div class="tgt_atention">
		<strong><?php _e('Problems? Questions?','re');?></strong>&nbsp;<?php _e('Contact us at ','re');?><em><a href="http://www.dailywp.com/support/" target="_blank">Support</a></em>. 
	</div>
	<?php 
    if($message != '') 
    {		
        echo '<div class="updated below-h2">'.$message.'</div>'; 
    }
    ?>
	
	<?php 
    if($errors != '') 
    {
        echo '<div class="error">'.$errors.'</div>'; 
    }
    ?>
	
	
	<form method="post" name="list_suggest_form" target="_self">	 <!-- form -->		
		<div class="tablenav"> 
			<div class="tablenav-pages"> <!-- page navigation -->
			</div> <!-- //page navigation -->
			
			<div class="alignleft actions"> <!-- #selects: filter + bulk action -->
				<select name="action">
					<option selected="selected" value="-1"><?php _e( 'Bulk Actions', 're' );?></option>					
					<option value="delete"><?php _e('Delete', 're' );?></option>					
				</select>
				<input type="submit" class="button-secondary" id="doaction" name="doaction" onclick="return confirm_delete();" value="<?php _e( 'Apply', 're' );?>">				
			</div> <!-- //selects: filter + bulk action -->		
			<div style="float:right;">		
				<label><?php _e('From:','re')?> </label>
				<input type="text" id="from_date" name="date_from" value="<?php if(isset($_POST['date_from'])) echo $_POST['date_from']; else echo '...'; ?>" style="width: 100px">
				<label><?php _e('To:','re')?> </label>
				<input type="text" id="to_date" name="date_to" value="<?php if(isset($_POST['date_to'])) echo $_POST['date_to']; else echo '...'; ?>" style="width: 100px">
				<input type="submit" class="button-secondary" id="doaction" name="filter_date" value="<?php _e('Filter','re')?>">
			</div>
			</div>	
		<table cellspacing="0" class="widefat post fixed"> <!-- list table -->
			<thead> <!-- table header -->
				<tr>				
					<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>	
					<th style="" class="manage-column column-author" id="author" scope="col"><?php _e( 'Author', 're' );?></th>
					<th style="" class="manage-column column-author" id="email" scope="col"><?php _e( 'Email', 're' );?></th>
					<th style="" class="manage-column column-content" id="content_sg" scope="col"><?php _e( 'Content', 're' );?></th>
					<th style="" class="manage-column column-date" id="date" scope="col"><?php _e( 'Date', 're' );?></th>
				</tr>
			</thead> <!-- //table header -->
			
			<tfoot> <!-- table footer -->
				<tr>				
					<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>	
					<th style="" class="manage-column column-author" id="author" scope="col"><?php _e( 'Author', 're' );?></th>
					<th style="" class="manage-column column-author" id="email" scope="col"><?php _e( 'Email', 're' );?></th>
					<th style="" class="manage-column column-content" id="content_sg" scope="col"><?php _e( 'Content', 're' );?></th>
					<th style="" class="manage-column column-date" id="date" scope="col"><?php _e( 'Date', 're' );?></th>
				</tr>
			</tfoot> <!-- //table footer -->
			<tbody> <!-- table body -->
			<?php
			if(!empty($all_suggest))
			{
				$c = 0;
				for($n=$start; ($n<count($all_suggest) && $n<$start+$items_per_page) ; $n++ )
				{
					$c++;
					$name = $all_suggest[$n]->comment_author;
					$email = $all_suggest[$n]->comment_author_email;										
					
					if($c%2 == 0)					
						echo '<tr valign="top" class="alternate" id="suggest-'.$all_suggest[$n]->comment_ID.'">';					
					else
						echo '<tr valign="top" id="suggest-'.$all_suggest[$n]->comment_ID.'">';
			?>				
					<th class="check-column" scope="row"><input type="checkbox" value="<?php echo $all_suggest[$n]->comment_ID;?>" name="suggest[]"></th>					
					
					<td class="author column-author">
						<a href="<?php echo 'admin.php?page=review-engine-list-suggestions&author='.$name; ?>"><?php  echo $name; ?></a>
						<div class="row-actions">							
							<span class="trash"><a onclick="return confirm_delete();" href="admin.php?page=review-engine-list-suggestions&amp;id=<?php echo $all_suggest[$n]->comment_ID;?>&amp;action=delete" class="submitdelete"><?php _e('Delete','re'); ?></a></span>
						</div>
					</td>
					<td class="email column-email">
						<a href="<?php echo 'admin.php?page=review-engine-list-suggestions&email='.$email; ?>"><?php echo $email; ?></a>
					</td>						
						
					<td class="content column-content">
						
						<?php						
						if(strlen($all_suggest[$n]->comment_content) > 151)
						{
							echo substr($all_suggest[$n]->comment_content,0,150);
						?>							
							<a id="link_more_<?php echo $all_suggest[$n]->comment_ID; ?>" onclick="show_all('<?php echo $all_suggest[$n]->comment_ID; ?>'); return false;" href="#" class="row-title"><strong><?php _e('more','re'); ?>&nbsp;&raquo;</strong></a>
						<?php
						}else
							echo $all_suggest[$n]->comment_content;
						?>
						<label id="show_all_content_<?php echo $all_suggest[$n]->comment_ID;?>" style="display:none;">
							<?php echo substr($all_suggest[$n]->comment_content,151); ?>
							<br/>
							<a id="link_hide" onclick="hide_all('<?php echo $all_suggest[$n]->comment_ID; ?>');" href="#" class="row-title"><strong><?php _e('Hide','re'); ?>&nbsp;&laquo;</strong></a>
						</label>						
					</td>
						
					<td class="date column-date">
						<abbr title="<?php echo $all_suggest[$n]->comment_date; ?>"><?php echo date("m/d/Y",strtotime($all_suggest[$n]->comment_date)); ?></abbr>
					</td>	
				</tr>				
			<?php
				}
			}
			?>
			</tbody> <!-- //table body -->
		</table> <!-- //list table -->
		
		<div class="tablenav"> 
			<div class="tablenav-pages"> <!-- page navigation -->
				<?php echo $page_div_str; ?>
			</div> <!-- //page navigation -->
			
			<div class="alignleft actions"> <!-- #selects: filter + bulk action -->
			</div> <!-- //selects: filter + bulk action -->
		</div>	
		
	</form> <!-- //form -->
</div>
<script type="text/javascript">
function show_all(str)
{
	jQuery("#link_more_"+str).hide();
	jQuery("#show_all_content_"+str).parent().find('#show_all_content_'+str).show();
	
}
function hide_all(str)
{
	jQuery("#link_more_"+str).show();
	jQuery("#show_all_content_"+str).hide();
	
}
</script>