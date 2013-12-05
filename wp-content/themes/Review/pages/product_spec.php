<?php
$cat = get_the_category();
//var_dump($cat[0]);
$spec = get_post_meta($post->ID, 'tgt_product_spec', true);
$categorySpec = get_all_data_spec_by_cat_id_tgt($cat[0]->term_id);
?>

<?php
foreach ($categorySpec as $group){
	$is_empty = true;
	foreach( $group['value'] as $spec_name)
	{
		$id = 'g_' . $group['spec_id'] . '_' . $spec_name['spec_value_id'];
		if (!empty($spec[$id]))
		{
			$is_empty = false;
			break;
		}
	}
	if($is_empty == false)
	{
?>
<div class="general">
	<h4><?php echo $group['group_name'] ?></h4>
	<table cellspacing="0" width="100%" class="product-spec">
		 <tbody>
			<?php
			$count = 0;
			foreach( $group['value'] as $spec_name)
			{
				$id = 'g_' . $group['spec_id'] . '_' . $spec_name['spec_value_id'];
				if (!empty($spec[$id]))
				{
				$count++;
				if ($count > 1) $count = 0;
				?>
				<tr <?php if ($count == 0) echo 'class="even"'?>>
					 <td><strong> <?php echo  $spec_name['value_name'] ?> </strong></td>
					 <td>
						<?php echo nl2br($spec[$id]);	?>
					 </td>
				</tr>
				<?php
				}
			}
			?>
		 </tbody>
	</table>
</div>
<?php
	}
}
?>