<?php
include_once TEMPLATEPATH . '/admin_processing/admin_update_post_processing.php';
$rating = get_option(PRODUCT_TOP);
$args = array(
    'post_type' => 'post'
);
$posts = get_posts($args);
?>
<div class="wrap"> <!-- #wrap -->
	<div id="icon-edit" class="icon32"><br></div>
	<h2>
            <?php _e( 'Review Engine Update', 're' );?>
	</h2>
	<div class="tgt_atention">
		<strong><?php _e('Problems? Questions?','re');?></strong><?php _e(' Contact us at ','re');?><em><a href="http://www.dailywp.com/community/" target="_blank">Support</a></em>.
	</div>
	<?php
	if (isset($message) && !empty($message)) { echo '<div class="updated below-h2">'.$message.'</div>'; }
        else if (isset($error) && !empty($error)) { echo '<div class="error">'.$error.'</div>'; }
	?>
	<div id="poststuff">
		<form action="" method="post">
			<div class="postbox" id="convert_post">
				<h3 class="hndle"> <label for="convert_post"><?php _e('Convert from Posts to Articles','re') ?></label></h3>
				<div class="inside">
					<p><strong><?php _e('Convert these post type to article type:','re') ?></strong></p>
						<div class="re-field-wrap">
							<ul>
								<?php if(!empty($posts))
									$i=0;
									foreach ($posts as $post)
									{
									?>
									<li>
										 <input type="checkbox" name="check_post[]" id="check_post_<?php echo $i; ?>" class="check_post" value="<?php echo $post->ID; ?>"/> <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title ?></a> - <?php echo get_categories_name($post->ID); ?>
									</li>
									<?php 
									$i++;
								} ?>
							</ul>
					</div>
					<p>
						<input type="checkbox" name="check_all" id="check_all" /> <label for=""><?php _e('Check All','re'); ?></label> &nbsp;
						<input type="checkbox" name="uncheck_all" id="uncheck_all" /> <label for=""><?php _e('Uncheck All','re'); ?></label> &nbsp;
					</p>
					<input type="submit" class="button-primary" value="Convert" name="convert_post" />
				</div>
			</div>
			<?php
			if(check_exists_tables_tgt() == false)
			{
			?>
				<div class="postbox" id="convert_post">
					<h3 class="hndle"> <label for="convert_post"><?php _e('Convert Specification and Filter database (version 2.0)','re') ?></label></h3>
					<div class="inside">
						<p><strong><?php _e('Please click the below button to convert old Specification & Filter database to new Specification & Filter database:','re') ?></strong></p>
						<p><i><?php _e('NOTE: Your old Specification and pictures have been lost, please back up your database before converting', 'jobpress') ?></i></p>
						<form action="" method="post">
							<input type="submit" class="button-primary" name="convert_specification" value="Convert Database" />
						</form>
					</div>
				</div>
			<?php
			}
			?>
		</form>
	</div>
	 <!-- //settings -->
</div> <!-- //end wrap -->
<script type="text/javascript">
    jQuery('#check_all').click(function(){
       var current = jQuery(this);
        if(current.is(':checked'))
        {
            jQuery('#uncheck_all').attr('checked', false);
            check_post_all(true);
        }
        else
        {
            check_post_all(false);
        }
       
    });
    jQuery('#uncheck_all').click(function(){
       var current = jQuery(this);
        if(current.is(':checked'))
        {
            jQuery('#check_all').attr('checked', false);
            check_post_all(false);
        }
        else
        {
            check_post_all(false);
        }
    });
    function check_post_all(bol)
    {
        var max_id = <?php echo count($posts);?>;
        for(var i=0; i< max_id; i++)
            {
                jQuery('#check_post_' + i).attr('checked', bol);
            }       
    }
    jQuery('.check_post').click(function(){
        var current = jQuery(this),
            id = current.attr('id');
        if(!current.is(':checked'))
        {            
            jQuery('#check_all').attr('checked', false);                
        }
        else if(check())
        {
            jQuery('#check_all').attr('checked', true);
            jQuery('#uncheck_all').attr('checked', false);
        }
    });
    function check()
    {
        var max_id = <?php echo count($posts);?>;
        var count = 0;
        for(var i=0; i< max_id; i++)
        {
            if(jQuery('#check_post_' + i).is(':checked'))
            {
                count++;
            }
        }
        if(max_id == count)
            return true;
        else return false;
    }
</script>
<?php
function get_categories_name1($post_id)
{
    $post_categories = wp_get_post_categories( $post_id );
    $cats = array();
    foreach($post_categories as $c){
            $cat = get_category( $c );
            $cats[] =  $cat->name;
    }
    return implode($cats);
}
?>