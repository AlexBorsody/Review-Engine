<!--footer start here-->

<div style="clear:both;"></div>

    <div id="footer" style="margin-top:20px;">
    	<div class="footer_res">
		  <?php if ( is_active_sidebar('footer-sidebar') ){ ?>
		  <div class="footer-sidebar">
			 <ul>
				<?php
				  dynamic_sidebar('footer-sidebar');
				?>
			 </ul>
			 <div class="clear"></div>
		  </div>
		  <?php } ?>
        	<div class="footer_main">
            	<p><strong><?php _e('Copyright','re');?></strong> © <strong>2010 - <a href="http://www.dailywp.com/review-engine-theme/" target="_blank"><?php _e('WordPress Review Theme','re');?></a> </strong><?php _e(' All rights reserved.','re');?></p>
            </div>
        </div>
    </div>	 
<?php wp_footer(); ?>

<?php if( $enable_fb_login ) { ?>
<script >
jQuery(document).ready(function(){
	console.log( '<?php echo admin_url('/admin_ajax.php') ?>' );
	jQuery('#fb_login').click(function(){
		FB.login(function(response) 
		{
			if (response.authResponse) 
			{
				jQuery.setCookie('fb_auth', '1', 0.05);
				window.location.reload();
			}
		}, {scope: 'email'});
			return false;
	});
	//FB.logout(function(response) {
	//	response = null;
	//});
});
</script>
<?php } ?>

<script type="text/javascript">
  jQuery('.rating input[type=radio]').rating();
  jQuery(document).ready(function(){
	 jQuery('.sb-list-item').hover(function(){
		jQuery(this).find('.combo_box3').show();
	 }, function(){
		jQuery(this).find('.combo_box3').hide();
	 });
  });
</script>
</body>
</html>