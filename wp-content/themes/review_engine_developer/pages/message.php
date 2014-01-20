<?php
global $helper,$wp_query,$posts;

get_header();	

/*
**James: Get Top Products
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
				<?php
					$m = getcookie('message');
					if (!empty($m)){
						$message = json_decode( stripslashes( $m ), true );
					?>
					<div class="col_right">
						<div class="message-box">
							<p <?php if ($message['type'] == 'error') echo 'class="red"' ?> >
								<?php 									
									echo $message['content'];
								?>
							</p>
						</div>
					</div>
					<?php 
					}
					deletecooke('message');
					?>
            </div>
        </div>
    </div>
    
    <!--body end here-->

<?php
	get_footer();
?>