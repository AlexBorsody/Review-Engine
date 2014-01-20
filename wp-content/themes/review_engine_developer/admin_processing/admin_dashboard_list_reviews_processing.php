<?php
if(isset($_POST['quick_approve']) && !empty($_POST['quick_approve']))
{
	if(isset($_POST['review_id']))
		wp_set_comment_status( $_POST['review_id'], 'approve' );
	$message_approve .= __('The review has been approved successfully.', 're' );
}
/**
 * Store review query
 * @var array
 */
global $review_query;

/** init review query */
function tgt_lr_init_query( ) {
	global $review_query, $review_message;
	$review_query = array();
	$review_query['product_id'] = 0;
	$review_query['review_status'] = 'all';
	$review_query['total'] = 0;
	$review_query['per_page'] = 7;
	$review_query['rpage'] = 0;
	$review_query['action'] = '';
	

}


/**
 * Get query review from user
 */
function tgt_lr_get_request( ) {
	global $review_query;

	// get product id
	if( isset( $_GET[ 'product_id' ] ) ) {
		$review_query['product_id'] = (int)$_GET[ 'product_id' ];
	}
	if ( $review_query['product_id'] < 0 ) {
		$review_query['product_id'] = 0;
	}


	// get limit
	if ( isset( $_GET[ 'rpage' ] ) ) {
		$review_query[ 'rpage' ] = (int) $_GET[ 'rpage' ];
		$review_query[ 'rpage' ]--;

		if ( $review_query[ 'rpage' ] < 0 ) {
			$review_query[ 'rpage' ] = 0;
		}
	}
}


function tgt_lr_get_review_list( $post = 0, $type = '' ) {
	global $wpdb, $review_query;
	$page = $review_query[ 'rpage' ];
	$per_page = $review_query[ 'per_page' ];
	
	$status_query = "AND (c.comment_approved = '0')";
	
	if ( $post ) {
		$post = " AND c.comment_post_ID = '$post'";
	} else {
		$post = '';
	}

	$orderby = "ORDER BY c.comment_date_gmt DESC";
	$limit = "LIMIT 0,$per_page" ;

	if( $type == 'comment' ) {
		$typesql = "AND c.comment_type = ''";
	} else {
		$typesql = "AND ( c.comment_type = 'editor_review'
			OR c.comment_type = 'review' )";
	}

	$query = "FROM $wpdb->comments c 
	JOIN $wpdb->posts p
		ON c.comment_post_ID = p.ID AND p.post_type = 'product'
	WHERE c.comment_parent >= 0
		$status_query $post $typesql";
		
	$comments = $wpdb->get_results("SELECT c.*, p.post_title $query $orderby $limit");
	$total = $wpdb->get_var("SELECT COUNT(c.comment_ID) $query");

	update_comment_cache( $comments );

	return array( $comments, $total );
}


/**
 * get review by query
 * @var string
 */
function tgt_lr_get_reviews( $product_id = '', $review_status = '', $page = 1 ) {
	global $review_query;
	// init query
	if ( ! isset( $review_query ) || empty( $review_query ) ) {
		tgt_lr_init_query();
	}

	tgt_lr_get_request();

	$reviews = array();
	list( $reviews, $total ) = tgt_lr_get_review_list( $review_query[ 'product_id' ] );
	
	$review_query[ 'total' ] = $total;
	
	return $reviews;
}

function tgt_lr_get_current_url( $local = false, $display = true ) {
	global $product_query, $review_query;
	$url = 'admin.php?page=review-engine-dashboard';
	if( $product_query[ 'cat' ] ) {
		$url .= '&amp;cat=' . $product_query[ 'cat' ];
	} elseif( $product_query[ 'author' ] ) {
		$url .= '&amp;author=' . $product_query[ 'author' ];
	} elseif( $product_query[ 's' ] ) {
		$url .= '&amp;s=' . $product_query[ 's' ];
	} 
	
	$url .= '&amp;pagenum=' . ( tgt_lp_get_page_num() + 1 );
	
	if( isset( $review_query[ 'product_id' ] ) 
	&& $review_query[ 'product_id' ] ) {
		$url .= '&amp;product_id=' . $review_query[ 'product_id' ];
	}
	
	if( $local ) {
		$url .= '&amp;review_status=' . $review_query[ 'review_status' ];
	}
	
	if( $display ) {
		echo $url;
	}
	return $url;
} 

/**
 * Get current page num message
 * @param integer $pagenum
 */
function tgt_lr_page_naging( $display = true ) {
	global $review_query;
	$pagenum = $review_query[ 'rpage' ] + 1;
	// pagenation
	$total = $review_query[ 'total' ];
	$perPage = $review_query[ 'per_page' ];
	$numOfPages = ceil( $total / $perPage );
	
	$message = paginate_links( array(
		'base' => tgt_lr_get_current_url( true, false ) . '%_%', 
		'format' =>  '&rpage=%#%', //
		'total' => $numOfPages,
		'current' => $pagenum,
		'prev_next' => true,
		'type' => 'span',
	));
	
	if( $display ) {
		echo $message;
	}
	return $message;
}