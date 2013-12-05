<?php
if(isset ($_COOKIE['view_product']))
    setcookie ("view_product", "", time() - 3600, "/");
$_SESSION['fb_logout'] = 1;
wp_logout();
wp_redirect(HOME_URL);
?>