<?php
add_action('wp_ajax_nopriv_auto_complete', 	'tgt_ajax_auto_complete');
add_action('wp_ajax_auto_complete', 'tgt_ajax_auto_complete');

function tgt_ajax_auto_complete() {
	global $helper;	
	try{
		
		// process searching
		//$results = tgt_lp_get_products( 'product', 'publish', 5 );
		$args = array(
					'posts_per_page' => 5 ,
					'post_type' => 'product' 
					);
		if ( isset( $_POST['s'] ) ){
			$args['s'] = $_POST['s'];
		}
		
		if ( isset( $_POST['cat'] ) && !empty($_POST['cat']) ){
			$args['cat'] = implode( ',' , $_POST['cat'] );
		}
		
		$results = query_posts( $args );
		
		$datas = array();
		$products = array();
		
		$enable = (int) get_option( SETTING_ENABLE_AUTOCOMPLETE );
		
		if( $enable ) {
			// filter result
			foreach( $results as $result ) {
				if ( $result->post_status == 'publish' ) {
					$datas[] = $result;
				}
			}
			
			$highlightstring = isset( $_POST['s'] ) ? trim( strtolower( $_POST['s'] ) ) : ''; 
			$highlights = empty( $highlightstring ) ? array() : array_unique( explode( " ", $highlightstring ) );
			
			for( $i = 0; $i < 5 && $i < count( $datas ); $i ++ ) {
				$product = $datas[ $i ];
				
				$post_highlights = explode( " ", strtolower( $product->post_title ) );
				$product->post_highlight = array();
				foreach( $post_highlights as $post_highlight ) {
					$title_highlight = $post_highlight;
					foreach( $highlights as $highlight ) {
						$highlight = trim( $highlight );
						if( ! empty( $highlight ) ) {
							$title_highlight = str_replace( $highlight, '<strong style="font-size:12pt;">' . $highlight . '</strong>', $post_highlight );
							if( strlen( $title_highlight ) != strlen( $post_highlight ) ) {
								break;
							}
						}
					}
					$product->post_highlight[] = $title_highlight;
				}
				$product->post_highlight = implode( $product->post_highlight, ' ' );
				
				//$images = get_post_meta( $product->ID, 'tgt_product_images' );
				//$product->thumb = $images[0][0]['thumb'];
				
				if( has_post_thumbnail( $product->ID ) ) {
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ) );
					$product->thumb = $thumb[0];
				}
				else
				{
					$product->thumb = TEMPLATE_URL .'/images/no_image.jpg';
				}
				$post_tags = wp_get_post_tags( $product->ID );
				$product->tags = array();
				if (!empty( $post_tags )){
					foreach ($post_tags as $tag){
						$product->tags[] = $helper->link( $tag->name, get_tag_link($tag->term_id) );
					}
				}
				$product->rating = get_post_meta( $product->ID, 'tgt_rating', true );
				
				$product->permalink = get_post_permalink( $product->ID );
				
				$products[] = $product;
			}
		}
		// prepare response
		$response = json_encode( array( 'success' => true, 'para' => $products ) );
	} // if process fail, return error message
	catch (Exception $ex){
		$response = json_encode( array( 'success' => false, 'para' => 'Can not get article'));
	}

	//return respose
	header('HTTP/1.1 200 OK');
	header('Content-Type: application/json');
	echo $response;

	exit;
}
