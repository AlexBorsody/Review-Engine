<?php
global $user_ID;
$error = '';

$product = array();
$post = null;

$success = false;

/**
 * if edit product
 */
if (!empty($_GET['p'])){
	$post = get_post($_GET['p']);
	if (!empty($post) && $post->post_type != 'product'){
		$error = __('Invalid product ID','re');
	}
	$product['id'] = $post->ID;
	$product['title'] = $post->post_title;
	$product['desc'] = $post->post_content;
	$product['desc'] = $post->post_content;
	$product['status'] = $post->post_status;
	$product['images'] = get_post_meta($post->ID, 'tgt_product_images', true);
	$product['url'] = get_post_meta($post->ID, 'tgt_product_url', true);
	$product['price'] = get_post_meta($post->ID, 'tgt_product_price', true);
	$category = wp_get_post_categories($post->ID);
	$product['category'] = $category[0];
	//get tags
	$product['tags'] = '';
	$tags = wp_get_post_tags($post->ID);
	$i = 0;
	foreach($tags as $tag){
		$product['tags'] .= $tag->name ;
		$i++;
		if ($i < count($tags)) $product['tags'] .= ', ';
	}
	
	if (empty($product['images'])) {
		$product['images'] = array();
	}
	
	// get spec 
	$product['spec'] = get_post_meta( $post->ID , 'tgt_product_spec' , true ) ;
	
	
	$product['filter'] = array();
	$fil = getRelationship($post->ID);
	foreach($fil as $item){
		$product['filter'][$item['group_id']] = $item['ID'];
	}
	
}

if (isset($_POST['save_product']) || isset($_POST['publish'])){
	try{
		if ( !empty( $product['id'] ) ){
			$post = get_post( $product['id']);
		}
		foreach ($_POST['product'] as $key => $value){
			$product[$key] = $_POST['product'][$key];
		}
		$product['title'] = stripcslashes(trim($product['title']));
		$product['desc'] = stripcslashes(trim($product['desc']));
		if (empty($_POST['product']['images']))
			$product['images'] = array();
			
		// change status to draft when create product at the first time
		// if publish product
		if (!empty($_POST['publish']) ){ 
			$product['status'] = 'publish';
		}
		
		/**
		 * Validate
		 */
		if ($product['category'] == 0)
			throw new Exception(__('Please choose category', 're'));
				
		$insert_arg = array(
			'post_title' => $product['title'],
			'post_content' => $product['desc'],
			'post_status' => $product['status'],
			'post_category' => array($product['category']),			
			'post_type' => 'product',
			'tags_input' => $product['tags']
		);
		
		if (!empty($product['id'])){
			$insert_arg['ID'] = $product['id'];
			$insert_arg['post_date'] = $post->post_date;
			$insert_arg['post_modified'] = current_time('mysql');
		}
		
		// insert new post
		$post_id = wp_insert_post($insert_arg);
		$product['id'] = $post_id;
		
		/**
		 * insert product link
		 */
		if (!empty($product['url']) && $post_id > 0)
			update_post_meta($post_id, 'tgt_product_url', $product['url']);
			
		/**
		 * update product price
		 */
		if (!empty($product['price']) && $post_id > 0){
			update_post_meta($post_id, 'tgt_product_price', $product['price']);			
		}
		
		/**
		 * Remove old image
		 */
		
		// delete remove image
		$old_images = get_post_meta($post_id, 'tgt_product_images', true);
		if (!empty( $old_images ) && empty($product['images'])){
			foreach( $old_images as $image ) {
				unlink( PATH_UPLOAD . '/' .$image['thumb']);
				unlink( PATH_UPLOAD . '/' . $image['url']);
			}
		}
		elseif (!empty($old_images)){
			foreach( $old_images as $image ) {
				if (!in_array($image, $product['images'])){
					unlink( PATH_UPLOAD . '/' .$image['thumb']);
					unlink( PATH_UPLOAD . '/' . $image['url']);
				}
			}
		}
		
		/**
		 * Insert Image
		 */
		$images_result = array();
		if(!empty($_FILES['images']["size"][0]) && $post_id > 0)
		{
			$images_result = array();
			$imagesList = array();
			for($i=0; $i<count($_FILES['images']['name']); $i++)
			{
				if (empty ( $_FILES['images']['tmp_name'][$i]) ) break;
				$saveto = "/images/product_images";
				$saveto = "product_images";
				$thumbpath = 'product_thumb';
				
				// calculate the size
				$max_width = 800;
				$max_heigth = 600;
				$image_info = getimagesize($_FILES['images']['tmp_name'][$i]);
				$current_width = $image_info[0];
				$current_height = $image_info[1];
				$resized_width = $current_width;
				$resized_heigth = $current_height;
				if ($current_width > $max_width){
					$resized_width = $max_width;
					$resized_heigth = round ( $resized_width * $current_height / $resized_width);
				}
				
				if ($current_height > $max_heigth){
					$resized_heigth = $max_heigth;
					$resized_width = round ( $resized_heigth * $current_width / $current_height);
				}
				$image = array();
				$image['url'] =  resizeImage($_FILES['images']['tmp_name'][$i],
														 $saveto,
														 $_FILES['images']['type'][$i],
														 $product['title'] . '_' . $i ,
														 800);
				$image['thumb'] =  resizeImage($_FILES['images']['tmp_name'][$i],
														 $thumbpath,
														 $_FILES['images']['type'][$i],
														 $product['title'] . '_' . $i ,
														 330);
				$product['images'][] = $image;
			}
		}
		update_post_meta($post_id, 'tgt_product_images', $product['images']);
		
		/**
		 * Update filter
		 */
		// delete old records
		$del_result = deleteRelatioship($post_id);
		// insert new records
		if (!empty($product['filter'])){
			global $wpdb;
			$table_relationship = $wpdb->prefix . 'tgt_filter_relationship';
			$sql = "INSERT INTO $table_relationship
			(filter_value_id, post_id) VALUES ";
			$t = 0;
			foreach($product['filter'] as $filter ){
				$sql .= $wpdb->prepare("  ( %d, %d )  ", $filter, $product['id']);
				$t++;
				if ($t < count($product['filter']))
					$sql .= ', ';
			}
			$wpdb->query($sql);
		}
		
		/**
		 * Update spec
		 */
		if (isset($product['spec'])){
			update_post_meta($post_id, 'tgt_product_spec', $product['spec']);
		}
		
		$success = true;
	}
	catch (Exception $ex){
		$error = $ex->getMessage();
	}
}


/**
 * Set Title
 */
$page_title = __('Add Product','re');
if (!empty( $product['id'] )){
	$page_title = __('Edit Product','re');
}

/**
 * Get category
 */
$categories = get_categories(array('hide_empty' => false));
$catList = array();

foreach($categories as $category){
	if (empty($category->parent)){
		$cat = array();
		$cat['data'] = $category;
		$cat['children'] = array();
		foreach($categories as $subCat) {
			if ($subCat->parent == $category->term_id ){
				$cat['children'][] = $subCat;
			}
		}
		$catList[] = $cat;
	}
}

if (!empty( $product['category'] ) ){
	/**
	 * Get the filter list
	 */
	$filters = getFilterByCatId($product['category']);
	
	/**
	 * Get the specification list
	 */
	$specs = getSpecByCatId($product['category']);
}
?>