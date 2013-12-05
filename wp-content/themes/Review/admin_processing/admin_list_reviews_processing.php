<?php
/**
 * Store review query
 * @var array
 */
global $review_query;

/**
 * Store review message
 * @var array
 */
global $review_messages;

/** init review query */
function tgt_lr_init_query( ) {
	global $review_query, $review_message;
	$review_query = array();
	$review_query['product_id'] = 0;
	$review_query['review_status'] = 'all';
	$review_query['total'] = 0;
	$review_query['per_page'] = 10;
	$review_query['rpage'] = 0;
	$review_query['action'] = '';
	
	// init review message
	$review_messages = array();
}

/**
 * Check if has message
 */
function tgt_lr_have_messages( ) {
	global $review_messages;
	return ( is_array( $review_messages ) 
	&& ! empty( $review_messages ) );
}

/**
 * Print message to screen
 */
function tgt_lr_print_messages() {
	global $review_messages;
	foreach( $review_messages as $message ) {
		echo $message . '<br/>';
	}
}

/**
 * Process when form is submission
 */
function tgt_lr_process_form( ) {
	global $review_query, $review_messages;

	// get comment ids
	$commentIds = array();
	if ( isset( $_POST[ 'review_ids' ] ) && is_array( $_POST[ 'review_ids' ] ) ) {
		foreach( $_POST[ 'review_ids' ] as $id ) {
			$id = (int) $id;
			if ( $id < 0 ) {
				$id = 0;
			}
			$commentIds[]= $id;
		}
	}
	$commentId = isset( $_GET[ 'review_id' ] ) ? (int)$_GET[ 'review_id' ] : 0;
	if( $commentId < 0 ) {
		$commentId = 0;
	}
	
	// set status
	$action = isset( $_REQUEST[ 'subaction' ] ) ? $_REQUEST[ 'subaction' ] : '';
	$review_query[ 'action' ] = $action;

	if ( $action == 'hold' ) {
		if ( $commentId ) {
			$review_messages[] = sprintf( __( 'Product %s has been unapproved.', 're' ), $commentId );
			wp_set_comment_status( $commentId, 'hold' );
		} elseif( ! empty( $commentIds ) ) {
			foreach( $commentIds as $id ) {
				wp_set_comment_status( $id, 'hold' );
			}
			if( ! empty( $commentIds ) ) {
				$review_messages[] = __( 'Products has been unapproved successfully.', 're' );
			}
		}
	} elseif ( $action == 'approve' ) {
		if ( $commentId ) {
			$review_messages[] = sprintf( __( 'Product %s has been approved.', 're' ), $commentId );
			wp_set_comment_status( $commentId, 'approve' );
		} elseif( ! empty( $commentIds ) ) {
			foreach( $commentIds as $id ) {
				wp_set_comment_status( $id, 'approve' );
			}
			if( ! empty( $commentIds ) ) {
				$review_messages[] = __( 'Products has been approved successfully.', 're' );
			}
		}
	} elseif ( $action == 'spam' ) {
		if ( $commentId ) {
			wp_set_comment_status( $commentId, 'spam' );
			$review_messages[] = sprintf( __( 'Product %s has been marked as spam.', 're' ), $commentId );
		} elseif( ! empty( $commentIds ) ) {
			foreach( $commentIds as $id ) {
				wp_set_comment_status( $id, 'spam' );
			}
			if( ! empty( $commentIds ) ) {
				$review_messages[] = __( 'Products has been marked as spam successfully.', 're' );
			}
		}
	} elseif ( $action == 'trash' ) {
		if ( $commentId ) {
			wp_set_comment_status( $commentId, 'trash' );
			$review_messages[] = sprintf( __( 'Product %s has been move to trash.', 're' ), $commentId );
		} elseif( ! empty( $commentIds ) ) {
			foreach( $commentIds as $id ) {
				wp_set_comment_status( $id, 'trash' );
			}
			if( ! empty( $commentIds ) ) {
				$review_messages[] = __( 'Products has been moved to trash successfully.', 're' );
			}
		}
	} elseif ( $action == 'delete' ) {
		if ( $commentId ) {
			wp_delete_comment( $commentId );
			$review_messages[] = sprintf( __( 'Product %s has been deleted.', 're' ), $commentId );
		} elseif( ! empty( $commentIds ) ) {
			foreach( $commentIds as $id ) {
				wp_delete_comment( $id );
			}
			if( ! empty( $commentIds ) ) {
				$review_messages[] = __( 'Products has been deleted successfully.', 're' );
			}
		}
	} elseif ( $action == 'restore' ) {
		if ( $commentId ) {
			wp_set_comment_status( $commentId, 'hold' );
			$review_messages[] = sprintf( __( 'Product %s has been moved to pending.', 're' ), $commentId );
		} elseif( ! empty( $commentIds ) ) {
			foreach( $commentIds as $id ) {
				wp_set_comment_status( $id, 'hold' );
			}
			if( ! empty( $commentIds ) ) {
				$review_messages[] = __( 'Products has been restored successfully.', 're' );
			}
		}
	} // 	trash
}

/**
 * Get query review from user
 */
function tgt_lr_get_request( ) {
	global $review_query;

	// process form when SERVER REQUEST METHOD is post
	if ( strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) == 'post' ) {
		tgt_lr_process_form();
	}
	
	// get product id
	if( isset( $_GET[ 'product_id' ] ) ) {
		$review_query['product_id'] = (int)$_GET[ 'product_id' ];
	}
	if ( $review_query['product_id'] < 0 ) {
		$review_query['product_id'] = 0;
	}

	// get status
	if ( isset( $_GET[ 'review_status' ] ) ) {
		switch ( $_GET[ 'review_status' ] ) {
			case 'hold' :
				$review_query[ 'review_status' ] = 'hold';
				break;
			case 'approve' :
				$review_query[ 'review_status' ] = 'approve';
				break;
			case 'spam' :
				$review_query[ 'review_status' ] = 'spam';
				break;
			case 'trash' :
				$review_query[ 'review_status' ] = 'trash';
				break;
			case '' :
				$review_query[ 'review_status' ] = '';
				break;
			default :
				break;
		}
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
/**
 * Get current post
 *
 * @author thanhsangvnm
 *
 * @param string $status
 * @param boolean $display
 */
function tgt_lr_get_current( $status = 'all', $display = true ) {
	global $review_query;

	$message = '';
	if ( isset( $review_query[ 'review_status' ] )
	&& $review_query[ 'review_status' ] == $status ) {
		$message .= ' class="current" ';
	}
	if ( $display ) {
		echo $message;
	}
	return $message;
}

function tgt_lr_get_review_list( $post = 0, $type = '' ) {
	global $wpdb, $review_query;
	$page = $review_query[ 'rpage' ];
	$per_page = $review_query[ 'per_page' ];
	
	$status_query = '';
	if ( ! empty( $review_query[ 'review_status' ] ) ) {
		$status = $review_query[ 'review_status' ];
		if( $status == 'all'  ) {
			$status_query = "AND ( c.comment_approved = '1'
			OR c.comment_approved = '0')";
		} elseif( $status == 'hold' ) {
			$status_query = "AND (c.comment_approved = '0')";
		} elseif( $status == 'approve' ) {
			$status_query = "AND (c.comment_approved = '1')";
		} elseif( $status == 'spam' ) {
			$status_query = "AND (c.comment_approved = 'spam')";
		} elseif( $status == 'trash' ) {
			$status_query = "AND (c.comment_approved = 'trash')";
		}
	}

	if ( $post ) {
		$post = " AND c.comment_post_ID = '$post'";
	} else {
		$post = '';
	}

	$orderby = "ORDER BY c.comment_date_gmt DESC";
	$limit = "LIMIT " . ( $page * $per_page ) . ", $per_page";

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
	$url = 'admin.php?page=review-engine-list-reviews';
	if( $product_query[ 'cat' ] ) {
		$url .= '&amp;cat=' . $product_query[ 'cat' ];
	} elseif( $product_query[ 'tag' ] ) {
		$url .= '&amp;tag=' . $product_query[ 'tag' ];
	} elseif( $product_query[ 'author' ] ) {
		$url .= '&amp;author=' . $product_query[ 'author' ];
	} elseif( $product_query[ 's' ] ) {
		$url .= '&amp;s=' . $product_query[ 's' ];
		if( $product_query[ 'title_only' ] ) {
			$url .= '&amp;to=' . $product_query[ 'title_only' ];
		}
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