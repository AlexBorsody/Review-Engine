<?php
global $current_user, $user_ID, $post, $wpdb, $helper, $wp_query;

/**
 * show product
 */
$product = array(
	'rating' => array(
	'user' => array(
		'count' => 0,
		'rating' => 0
	),
	'editor' => array(
		'count' => 0,
		'rating' => 0
	)
));
$product['rating']['user']['count'] 	= get_post_meta($post->ID, PRODUCT_RATING_COUNT, true);
$product['rating']['user']['rating'] 	= get_post_meta($post->ID, PRODUCT_RATING, true);
$product['rating']['editor']['count'] 	= get_post_meta($post->ID, PRODUCT_EDITOR_RATING_COUNT, true);
$product['rating']['editor']['rating'] = get_post_meta($post->ID, PRODUCT_EDITOR_RATING, true);

///////*** review
///////***

/**
 * check user role, if user is an reviewer enable rich text document for him
 */
$user_have_editor  = get_option('tgt_user_have_editor');
$editor_enable = false;
$curr_user = new WP_User ( $user_ID );
$role = empty ( $curr_user->roles[0] ) ? '' : $curr_user->roles[0];

if ( !empty($role) && $role != ROLE_MEMBER ){
	$editor_enable = true;
}
if ($role == ROLE_MEMBER && !empty($user_have_editor)) {
	$editor_enable = true;
}
/**
 * check if user has review this or not
 */
$has_reviewed = has_reviewed( $user_ID, $post->ID );

/**
 * error message define
 */

$error_title_empty = __('Title can not be empty','re'); 
$error_title_short = __('Title is too short','re');

$error_con_empty = __('Please tell us what make you like about this product','re'); 
$error_con_short = __('Your reason is too short','re');

$error_pro_empty = __('Please tell us what make you dislike about this product','re');
$error_pro_short = __('Your reason is too short','re');

$error_not_rating = __('You have forgotten rating for this product ','re');

$error_username_empty = __('Your name can not be empty','re');
$error_useremail_empty = __('Your email can not be empty','re');
$error_useremail_invalid = __('Your email invalid.','re');
        
$limitation = array();
$limitation['title'] = get_option('tgt_title_limit');
$limitation['pro'] = get_option('tgt_pro_limit');
$limitation['con'] = get_option('tgt_con_limit');
$limitation['bottomline'] = get_option('tgt_bottom_line_limit');
$limitation['review'] = get_option('tgt_review_limit');
		
/**
 * post processing
 */
$error = '';
$review = array();
$success = false;
$allowed_tags = '<p><a><table><tr><td><th><ul><ol><li><dt><dl><br><img><b><i><u><strong><h1><h2><h3><h4><h5><h6><code><pre><span><em>';

if (!empty($_POST['submit_review'])){
	try{
		if ($has_reviewed) 
			throw new Exception(__('You have reviewed this product already ','re'));
				
		$review['title'] 	= empty($_POST['title']) 		? '' : strip_tags( $_POST['title'] );
		$review['pro'] 		= empty($_POST['pro']) 			? '' : strip_tags(  $_POST['pro'] );
		$review['con'] 		= empty($_POST['con']) 			? '' : strip_tags( $_POST['con'] );
		$review['bottomline'] 	= empty($_POST['bottomline']) ? '' : strip_tags( $_POST['bottomline'] );
		$review['review'] 	= empty($_POST['review']) 		? '' : strip_tags( $_POST['review'], $allowed_tags );
      $review['username']     = empty($_POST['user_name']) ? '' : strip_tags( $_POST['user_name'] );
      $review['user_email']   = empty($_POST['user_email']) ? '' : strip_tags( $_POST['user_email'] );                
		
		//set post id
		$review['id'] = '';
		if (!empty ( $post->ID) )
			$review['id'] = $post->ID;
		else {
			throw new Exception(__('There is error occurred, please try again later','re'));
		}
		
		//set author
		if (empty ($current_user))
			throw new Exception(__('There is error occurred, please try again later','re'));
		
		$review['author'] = $current_user;
		
		// get rating
		$rates = array();
		if (isset($_POST['rating'])){
		$rates = $_POST['rating'];
		}
		$rating = array();
		$rating['rates'] 	= array();
		$rating['sum'] 	= 0;
		$total_rate = 0;
		$count = 0;
		if (is_array($rates) && !empty($rates)){
		foreach ( (array)$rates as $key => $rate){
			$rating['rates'][$key] = floatval($rate);
			$total_rate += floatval($rate);
			$count++;
		}}
		if ($count)
			$rating['sum'] = $total_rate / $count;
		else
			$rating['sum'] = 0;		
		
		/**
		 * validate
		 */
		
		if ( isset($_POST['title']) && empty ($review['title'] )){
			$error .= ' - ' . $error_title_empty . '<br />';
		}
		
		if ( isset($_POST['pro']) && empty ( $review['pro'] )){
			$error .= ' - ' . $error_pro_empty . '<br />';			
		}
		
		if ( isset($_POST['con']) && empty ( $review['con'] )){
			$error .= ' - ' . $error_con_empty . '<br />';			
		}		
		
		/**
		 * get limitation for validate
		 */
		
		$limit_validate = array(
                        'title'         => __('Title is too long','re'),
                        'pro'           => __('"The Good" of product is too long','re'),
                        'con'           => __('"The Bad" of product is too long','re'),
                        'bottomline'	=> __('"Bottom line" of product is too long','re'),
                        'review'        => __('Review content of prroduct is too long','re')
                    );
		foreach( $limit_validate as $key => $msg )
		{
			if ( count($review[ $key ]) > $limitation[ $key ] )
				$error .= ' - ' . $msg . '<br />';
		}
		
		if (empty($error)){
			// if there is no wrong
			// add review conetnt
			$time = current_time('mysql');
			$type = '';
			if ($role == ROLE_EDITOR){
				$type = 'editor_review';
			}
			else {
				$type = 'review';		
			}
                        $author_comment = '';
                        $author_email = '';
                        $author_url = '';
			if($current_user->ID < 1)
                        {
                            $author_comment = $review['username'];
                            $author_email = $review['user_email'];
                        }
                        else {
                            $author_comment = $current_user->display_name;
                            $author_email = $current_user->user_email;
                            $author_url = $current_user->user_url;
                        }
			$data = array(
				'comment_post_ID' => $review['id'],
				'comment_author' => $author_comment,
				'comment_author_email' => $author_email,
				'comment_author_url' => $current_user->user_url,
				'comment_content' => nl2br($review['bottomline']),
				'comment_type' => $type,
				'comment_parent' => 0,
				'comment_approved' => 0,
				'user_id' => $user_ID
			);			
			
			$review_ID = wp_insert_comment($data);
			if (!empty($review_ID)){
				//insert 
				$review_data = array(
					'title' => nl2br( $review['title'] ),
					'pro' => nl2br( $review['pro'] ),
					'con' => nl2br( $review['con'] ),
					'review' => nl2br( $review['review'] )
				);
				update_comment_meta( $review_ID ,'tgt_review_data', 	$review_data);				
				//insert rating for review
				update_comment_meta( $review_ID ,'tgt_review_rating', $rating);
				
				// if auto publish
				$is_auto_publish = get_option( SETTING_AUTO_PUBLISH );
				if ($is_auto_publish && is_trusted_user($user_ID)) {
					wp_set_comment_status($review_ID, 'approve');
				}
			}
			else {
			throw new Exception(__('There is error occurred, please try again later','re'));		
			}
		}
		
	}catch (Exception $ex){
		if ( !$ex->getMessage()  )
			$error .= $ex->getMessage();
		$success = false;
	}
	/**
	 * Display message to user
	 */
	
	$link = $helper->link('here', get_permalink($post->ID) );
	$back_link = '<br />' . __('click ','re') . $link . __(" to go back product's page",'re');
	if (!empty($error)){
		$message = $error . $back_link;
		setMessage($message, 'error');
	}
	else{
		$message = __('You have submit a review successfully', 're') . $back_link;
		setMessage($message);
	}
}

// Submit comment for product
if (!empty($_POST['submit_comment'])){
	try{
		global $current_user;
		$review['username']     = empty($_POST['user_name']) ? '' : strip_tags( $_POST['user_name'] );
		$review['user_email']   = empty($_POST['user_email']) ? '' : strip_tags( $_POST['user_email'] );
		$review['comment_pro'] 		= empty($_POST['comment_pro']) 	? '' : strip_tags(  $_POST['comment_pro'] );
		
		//set post id
		$review['id'] = '';
		if (!empty ( $post->ID) )
			$review['id'] = $post->ID;
		else {
			throw new Exception(__('There is error occurred, please try again later','re'));
		}
		
		//set author
		$review['author'] = 0;
		if(!empty($current_user))
			$review['author'] = $current_user;
		
		/**
		 * validate
		 */		
		
		if ( isset($_POST['comment_pro']) && empty ( $review['comment_pro'] )){
			$error .= ' - ' . $error_pro_empty . '<br />';			
		}
		
		/**
		 * get limitation for validate
		 */		
	
		if (empty($error)){
			// if there is no wrong
			// add review conetnt
			$time = current_time('mysql');
			$type = 'comment';
			
			$author_comment = '';
			$author_email = '';
			$author_url = '';
			if($current_user->ID < 1)
			{
				$author_comment = $review['username'];
				$author_email = $review['user_email'];
			}
			else {
				$author_comment = $current_user->display_name;
				$author_email = $current_user->user_email;
				$author_url = $current_user->user_url;
			}
			$data = array(
				'comment_post_ID' => $review['id'],
				'comment_author' => $author_comment,
				'comment_author_email' => $author_email,
				'comment_author_url' => ($current_user->user_url != '')?$current_user->user_url:'',
				'comment_content' => nl2br($review['comment_pro']),
				'comment_type' => $type,
				'comment_parent' => (isset($_POST['parent_id']) && $_POST['parent_id'] > 0)?$_POST['parent_id']:0,
				'comment_approved' => 0,
				'user_id' => $user_ID
			);			
			
			$review_ID = wp_insert_comment($data);
			if (!empty($review_ID)){				
				$is_auto_publish = get_option( SETTING_AUTO_PUBLISH );
				if ($is_auto_publish && is_trusted_user($user_ID)) {
					wp_set_comment_status($review_ID, 'approve');
				}
			}
			else {
			throw new Exception(__('There is error occurred, please try again later','re'));		
			}
		}
		
	}catch (Exception $ex){
		if ( !$ex->getMessage()  )
			$error .= $ex->getMessage();
		$success = false;
	}
	/**
	 * Display message to user
	 */	
	if (!empty($error)){
		$message = $error . $back_link;
		setMessage($message, 'error');
	}
}
?>