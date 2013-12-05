<?php
global $helper,$wp_query,$posts;

get_header();
/*
**James: Page 404
*/

?>
	 
	 <!-- Body start here -->
	 
    <div id="container">
    	<div class="container_res">
        	<div class="container_main">
				<!-- side bar start here -->
            	
					<?php
						get_sidebar();
					?>
            
				<!--sidebar end here-->    
				
                <div class="col_right">  
                     <h2><?php _e ('Page', 're');?> <span><?php _e ('not found!', 're');?></span></h2>
					 <?php _e ('Sorry! This page not found.','re'); ?>&nbsp;<?php _e ('Return to the','re'); ?>&nbsp;<a style="color:red" href="<?php echo HOME_URL; ?>"><?php _e ('Home page','re'); ?></a>
                </div>
            </div>
        </div>
    </div>
    
    <!--body end here-->
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.star-disabled').rating();	
});
</script>
<?php
	get_footer();
?>