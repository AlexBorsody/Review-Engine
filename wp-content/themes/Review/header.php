<?php
global $user_ID;
$enable_fb_login = get_option('tgt_fb_login');
$is_fb_logout = 0;
if(session_is_registered('fb_logout'))
{
	$is_fb_logout = $_SESSION['fb_logout'];
	session_unregister('fb_logout');
}
if($enable_fb_login && !$is_fb_logout)
{
	if($user_ID > 0)
	{
		$cookie = null;		
		$_COOKIE['fbs_'.FACEBOOK_APP_ID] = '';
	}
	elseif($user_ID < 1)
	{
		$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);		
		if (!empty($cookie)) {
			$fb_user_contents = file_get_contents('https://graph.facebook.com/'.$cookie['uid'].'?access_token='. $cookie['access_token'], true);
			if(!empty($fb_user_contents))
		   	{
		   		tgt_login_facebook($fb_user_contents);
		   		exit;
		   	}
		}
	}
}
global $helper,$current_user; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php
$helper->favicon();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php wp_head(); ?>
<?php
$args = array(
	'type'                     => 'post',
	'parent'                   => 0,
	'orderby'                  => 'slug',
	'order'                    => 'ASC',
	'hide_empty'               => 0,
	'exclude'                  => 1,
	'hierarchical'             => 1,
	'pad_counts'               => false );
$main_category = get_categories($args);
?>
<title><?php wp_title(); ?></title>
</head>
<body <?php body_class(); ?>>
	<div id="header">
    	<div class="header_res">
        	<div class="header_main">
            <div class="top navbar">
					<div class="menu" style="max-width: 520px">
					<?php
						//echo $helper->link( $helper->image('icon_home.png', 'test') , HOME_URL , array('style' => 'float:left; margin:5px 20px 0 0;'));								
						?>                       
                              <div class="logo">
                                   <a href="<?php echo HOME_URL; ?>">
                                   <?php
                                   $curr_logo = '/images/logo.png';
                                   $curr_logo = explode('/',get_option(SETTING_LOGO));
                                   ?>
                                   <?php
                                   if(count($curr_logo) > 1 && $curr_logo[0] == 'images')
                                   {
                                   ?>
	                                   <img src="<?php echo TEMPLATE_URL.'/'.$curr_logo[0].'/'.$curr_logo[1]; ?>" title="<?php _e('Current Logo','re');?>" alt=""/>									
                                   <?php
                                   }else
                                   {
                                   ?>
	                                   <img src="<?php echo WP_CONTENT_URL .'/uploads/re/'.$curr_logo[0]; ?>" title="<?php _e('Current Logo','re');?>" alt=""/>
                                   <?php
                                   }
                                   ?>
                                   </a>
                              </div>		
					</div>
                    
               <div class="navi_list" style="max-width: 420px">
                 		<?php                    		  
							if($user_ID < 1)
							{
								if($enable_fb_login)
								{
						?>
								<div id="fb-root"></div>								
								<script src="https://connect.facebook.net/en_US/all.js"></script>
								<script>
								  window.fbAsyncInit = function() {
								    FB.init({
								      appId  : '<?php echo FACEBOOK_APP_ID ?>',
								      status : true,
								      cookie : true,
								      xfbml  : true
								    });
								    FB.Event.subscribe('auth.login', function(response) {								    	  
										window.location.reload();										
										response = null;
									});
								    FB.Event.subscribe('auth.logout', function(response) {
										response = null;
									});
								  };
								  (function() {
								    var e = document.createElement('script');
								    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
								    e.async = true;
								    document.getElementById('fb-root').appendChild(e);										    
								  }());
								</script>
								<!--<div id="fb-root"></div>
                                        <script>(function(d, s, id) {
                                          var js, fjs = d.getElementsByTagName(s)[0];
                                          if (d.getElementById(id)) return;
                                          js = d.createElement(s); js.id = id;
                                          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=222511274539894";
                                          fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));</script>-->
								<?php } ?>
								<ul>
								<li><?php echo $helper->link('<strong>'.__('Login', 're').'</strong>', tgt_get_permalink('login') );?>
								<?php echo $helper->image('li_arrow1.gif', 'arrow')?>
								</li>
						<?php if($enable_fb_login) {?>
								<li id="fb_login"><?php echo $helper->link($helper->image('icon_facebook.gif', 'fb_login'), ''); ?></li>
								<!--<div class="fb-login-button" data-max-rows="1" data-show-faces="false"></div>-->
						<?php }?>
								<li><?php echo $helper->link('<strong>'.__('Register','re').'</strong>', tgt_get_permalink('register') )?>
								<?php echo $helper->image('li_arrow1.gif', 'arrow')?></li>
								
								</ul>
						<?php
							}
                    		elseif ($user_ID > 0){
                    		?>
                   			<ul>
                    		<li><?php _e ('Hi, ', 're'); echo '<a href="'.get_author_posts_url($user_ID).'"><strong>'.get_userdata($user_ID)->display_name.'</strong></a>';?></li>
							<li><?php echo $helper->link( '<strong>' . __('Edit Profile', 're') . '</strong>', tgt_get_permalink('edit_profile') , array('style' => 'padding-right:7px;') ) ?>							
							<?php echo $helper->image('li_arrow1.gif', 'arrow') ?></li>
							<li>
								<?php echo $helper->link( '<strong>' . __('Logout', 're') . '</strong>',  tgt_get_permalink('logout'), array('style' => 'padding-right:7px;') ) ?>
								<?php echo $helper->image('li_arrow1.gif', 'arrow')?>
							</li>
							</ul>
							<?php } ?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
			<div class="header_search">
			<div class="searchbar">
               <!--<div class="logo">
					<a href="<?php echo HOME_URL; ?>">
					<?php
					$curr_logo = '/images/logo.png';
					$curr_logo = explode('/',get_option(SETTING_LOGO));
					?>
					<?php
					if(count($curr_logo) > 1 && $curr_logo[0] == 'images')
					{
					?>
						<img src="<?php echo TEMPLATE_URL.'/'.$curr_logo[0].'/'.$curr_logo[1]; ?>" title="<?php _e('Current Logo','re');?>" alt=""/>									
					<?php
					}else
					{
					?>
						<img src="<?php echo WP_CONTENT_URL .'/uploads/re/'.$curr_logo[0]; ?>" title="<?php _e('Current Logo','re');?>" alt=""/>
					<?php
					}
					?>
				</a>
			</div>-->
				<div class="search-box">
				 <?php include PATH_PAGES . DS . 'search_form.php' ?>
				 
				 <div class="review_link"><a class="" href="#home">Write a review</a></div>
				 				 
				 <div class="review_linkn"><a class="" href="#home">Write a review</a></div>

				</div>
		  </div>
		</div>
</div>
<!-- Header end here -->
