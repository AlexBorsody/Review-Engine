<?php 
global $helper,$wp_query, $artile_query, $post;

get_header();

$order = get_option( 'comment_order' );
?>
<div id="container">
    	<div class="container_res">
        	<div class="container_main">
            	<div class="col_left">
                    <?php get_sidebar();?>
                </div>
                
                <div class="col_right">
                	<div class="col">
								<?php
								wp_reset_query();
								if ( have_posts() ) {
								the_post() ?>
                        <div class="col_box" style="border-bottom:1px #dce4e4 solid;">
                            <h1 class="blue"><?php the_title(); ?></h1>
                            
                            <div class="reply">
                            	<!--<img style="float:left; margin:0 10px;" src="images/icon_reply.png" alt=""/>-->										
                              <!--<p><a id="go_reply"> <?php //comments_number( __( 'no reply', 're' ), __( 'one reply', 're') , __( '% reply', 're' ) );?></a></p>-->
                            </div>
                        </div>                        
                        
                        <div class="col_box post_content" style="border-bottom:4px #dce4e4 solid;">
                            <p class="textt"><?php the_content() ?></p>
                         </div>
								<?php
								}
								?>
                     </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#go_reply').click(function(){			
			jQuery('html, body').animate({'scrollTop' : jQuery('#commentform').offset().top }, 'slow');
		});
	});
</script>
<?php 
get_footer();
