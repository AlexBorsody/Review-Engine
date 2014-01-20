<?php
/*
 * @Author: James. 
 */
global $wpdb,$helper;
$author = '';
$email = '';
$date_from = '';
$date_to = '';

// Get value to filter by author
if(isset($_GET['author']))
	$author = $_GET['author'];
	
// Get value to filter by email
if(isset($_GET['email']))
	$email = $_GET['email'];
	
// Get value to filter by date
if(isset($_GET['date_from']))
		$date_from = $_GET['date_from'];
if(isset($_GET['date_to']))
		$date_to = $_GET['date_to'];
if(isset($_POST['filter_date']) && !empty($_POST['filter_date']))
{
	if(isset($_POST['date_from']))
		$date_from = $_POST['date_from'];
	if(isset($_POST['date_to']))
		$date_to = $_POST['date_to'];
}
// Do action delete
if(isset($_POST['doaction']))
{
	if(isset($_POST['suggest']) && !empty($_POST['suggest']))
	{
		$status = '';
		for($i=0; $i<count($_POST['suggest']); $i++)
		{
			$status = wp_delete_comment($_POST['suggest'][$i],'deletion');
		}
		if($status == true)
		{
			$message .= __('You deleted suggestion(s) successfully!','re');
		}		
	}
}else if(isset($_GET['action']) && $_GET['action'] == 'delete')
{
	if(isset($_GET['id']) && !empty($_GET['id']))
	{
		$status = '';
		$status = wp_delete_comment($_GET['id'],'deletion');		
		if($status == true)
		{
			$message = __('You deleted suggestion successfully!','re');			
			setcookie("message_suggest", $message, time()+3600);
			echo "<script language='javascript'>window.location = '"."admin.php?page=review-engine-list-suggestions"."'</script>";
		}		
	}
}
$all_suggest = array();

if($author != '')
{
	// Filter by name 
	$query = "SELECT *
				FROM $wpdb->comments c
				WHERE c.comment_approved = 1
						AND c.comment_type = 'suggestion'
						AND c.comment_author = '$author'
				ORDER BY c.comment_date_gmt DESC
				LIMIT 0,10000";
	$all_suggest = $wpdb->get_results($query);
}
else if($date_from != '' && $date_to != '')
{
	// Filter by date
	$query = "SELECT *
				FROM $wpdb->comments c
				WHERE c.comment_approved = 1
						AND c.comment_type = 'suggestion'
						AND ( c.comment_date_gmt >= '".date('Y-m-d',strtotime($date_from))."' ) AND ( c.comment_date_gmt <= '".date('Y-m-d',strtotime($date_to))."' )
				ORDER BY c.comment_date_gmt DESC
				LIMIT 0,10000";
	$all_suggest = $wpdb->get_results($query);	
}
else if($author == '')
{
	// Filter by email and get all data withough filter
	$args = array(		
		'author_email' => $email,
		'status' => 'approve',		
		'oder'	=> 'DESC',
		'type' => 'suggestion',
		'number' => 10000		
	);
	$all_suggest= get_comments($args);
}

?>
<?php
$items_per_page = 15;

if(isset($_GET['paged']) && $_GET['paged']!="")
	$page_num= is_numeric($_GET['paged'])?$_GET['paged']:0;
else
	$page_num= 0;
if($page_num==0)
	$start= 0;
else
	$start= ($page_num-1)*$items_per_page;

$link= "admin.php?page=review-engine-list-suggestions".
		(!empty($date_from)?"&date_from=".$date_from:"").
		(!empty($date_to)?"&date_to=".$date_to:"").
		(isset($_GET['author'])?(!empty($_GET['author'])?"&author=".$_GET['author']:""):"").
		(isset($_GET['email'])?(!empty($_GET['email'])?"&categoryid=".$_GET['email']:""):"").
		"&paged=";

$numrows= count($all_suggest);
$rowsPerPage= $items_per_page;
$pageNum= ($page_num==0)?1:$page_num;
$maxPage = ceil($numrows/$rowsPerPage); 
$nav = '';
$first = '';
$last = '';
if($pageNum>7)
{
if (1 == $pageNum) 
{ 
	$nav .= '<strong style="font-size:11px; color:#284A70; font-weight:bold;">' . "1" . '</strong>...';  
} 
else 
{ 	
	$nav .= ' <a style="font-size:11px;" href="'.$link."1".(empty( $catlink )?"":"/").'" >'."1".'</a> ...'; 
} 
}
for($page = (($pageNum>3)?($pageNum-3):1); $page <= (($pageNum<$maxPage-3)?($pageNum+3):$maxPage); $page++) 
{ 
	if ($page == $pageNum) 
	{ 
		$nav .= '<strong style="font-size:11px; color:#284A70; font-weight:bold;">' . display_number($page) . '</strong>';
	} 
	else 
	{ 	
		$nav .= ' <a style="font-size:11px;" href="'.$link.$page.(empty( $catlink )?"":"/").'" >'.display_number($page).'</a> '; 
	}   
} 
if($maxPage>($pageNum+7))
{
if ($maxPage == $pageNum) 
{ 
	$nav .= '...<strong style="font-size:12px; color:#284A70; font-weight:bold;">' . display_number($maxPage) . '</strong>';
} 
else 
{ 	
	$nav .= '... <a style="font-size:11px;" href="'.$link.$maxPage.(empty( $catlink )?"":"/").'" >'.display_number($maxPage).'</a> '; 
} 
}
if ($pageNum > 1) 
{ 
	$page = $pageNum - 1; 
	$prev = ' <a style="font-size:11px;" href="'.$link.$page.(empty( $catlink )?"":"/").'" >&laquo; </a> '; 
}  
else 
{ 
	$prev  = '&nbsp;'; 
	$first = '&nbsp;'; 
} 
if ($pageNum < $maxPage) 
{ 
	$page = $pageNum + 1; 
	$next = ' <a style="font-size:11px;" href="'.$link.$page.(empty( $catlink )?"":"/").'" > &raquo;</a> '; 
}  
else 
{ 
	$next = '&nbsp;'; // we're on the last page, don't print next link 
	$last = '&nbsp;'; // nor the last page link 
} 
$page_div_str= "";
if($rowsPerPage< $numrows)
	$page_div_str= "<i style=\"font-family:Georgia,'Times New Roman','Bitstream Charter',Times,serif\">Displaying ".display_number(($pageNum-1)*$rowsPerPage+1)."-".display_number($pageNum*$rowsPerPage<$numrows?$pageNum*$rowsPerPage:$numrows)." of ".display_number($numrows)."</i>".$first . $prev . $nav . $next . $last;
// Script for calendar
$helper->css('lib/smoothness/jquery.ui.css');
$helper->js('jquery.ui.js');
?>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#from_date').datepicker();
	jQuery('#to_date').datepicker();	
	
	jQuery('#from_date').datepicker( "option" , "maxDate", jQuery('#to_date').val());
	jQuery('#to_date').datepicker("option" , "minDate", jQuery('#from_date').val());		

	jQuery('#from_date').change(function(){
		jQuery('#to_date').datepicker( "option" , "minDate", jQuery('#from_date').val());
	});
	jQuery('#to_date').change(function(){
		jQuery('#from_date').datepicker( "option" , "maxDate", jQuery('#to_date').val());	
	});
});
function confirm_delete()
{
	if(confirm('<?php _e('Are you sure want to delete this suggestion(s) ?','re'); ?>') == true)
	{
		return true;
	}else
		return false;
}
</script>
