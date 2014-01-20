<?php
if (isset ($_GET['redirect'] )  ) {	
	$product_url = get_post_meta($_GET['redirect'], 'tgt_product_url', true);
	$is_publish = get_post_status($_GET['redirect']);
	if ($product_url && $is_publish == 'publish'){
		if ( 0 !== strpos($product_url, 'http://') && 0 !== strpos($product_url, 'www.'))
			$product_url = get_permalink( $_GET['redirect'] ) . $product_url;
		wp_redirect( esc_url_raw( $product_url ) );
	}
	else {
		include TEMPLATEPATH . '/404.php';
		exit;
	}	
}
else {
	setMessage (__("There're something wrong with product url, please try it again", 're'));
}
?>