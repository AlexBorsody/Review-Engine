<?php
/**
 * Store product query
 * @var array
 */
global $product_query;

/**
 * Store product message
 * @var array
 */
global $product_messages;

/** init product query */
if (!function_exists('tgt_lp_init_query') ) {
	function tgt_lp_init_query() {
		global $product_query;
		$product_query = array();
		$product_query['post_type'] = 'product';
		$product_query['title_only'] = 0;
		$product_query['post_status'] = 'all';
		$product_query['pagenum'] = 0;
		$product_query['total'] = 0;
		$product_query['cat'] = 0;
		$product_query['tag'] = 0;
		$product_query['s'] = '';
		$product_query['author'] = 0;
		$product_query['per_page'] = 20;
		$product_query['action'] = '';
		$product_query['product_id'] = 0;
	}
}
/**
 * Update status to product
 * @param integer $postId
 * @param String $newStatus
 */
function tgt_lp_update_status( $postId, $newStatus = 'publish' ) {
	global $wpdb, $product_messages;
	$postId = (int) $postId;
	$wpdb->update( $wpdb->posts, array( 'post_status' => $newStatus ),array( 'ID' => $postId ) );
}

/**
 * Check if has message
 */
function tgt_lp_have_messages( ) {
	global $product_messages;
	return ( is_array( $product_messages ) && ! empty( $product_messages ) );
}

/**
 * Print message to screen
 */
function tgt_lp_print_messages() {
	global $product_messages;
	foreach( $product_messages as $message ) {
		echo $message . '<br/>';
	}
}

/**
 * Process when form is submission
 */
function tgt_lp_process_form( ) {
	global $product_query, $product_messages;

	// get category
	if ( isset( $_POST[ 'cat' ] ) ) {
		$product_query['cat'] = (int)$_POST[ 'cat' ];
		if ( $product_query['cat'] < 0 ) {
			$product_query['cat'] = 0;
		}
	}
	
	// get tag
	if ( isset( $_POST[ 'tag' ] ) ) {
		$product_query['tag'] = (int)$_POST[ 'tag' ];
		if ( $product_query['tag'] < 0 ) {
			$product_query['tag'] = 0;
		}
	}

	// get search
	if ( isset( $_POST['s'] ) ) {
		$product_query['s'] = trim( $_POST[ 's' ] );
	}

	if ( isset( $_POST[ 'action' ] ) ) {
		$action = (int) $_POST[ 'action' ];
		switch ( $action ) {
			// publish all
			case 1:
				if ( isset( $_POST[ 'post' ] ) && is_array( $_POST[ 'post' ] ) ) {
					foreach ( $_POST[ 'post' ] as $productId ) {
						// update status
						tgt_lp_update_status( $productId, 'publish' );
					}
					// insert message
					if ( ! isset( $product_messages ) ) {
						$product_messages = array();
					}
					$product_messages[] = __( 'Updated status successfully!', 're' );
				}
				break;
				// publish all
			case 2:
				if ( isset( $_POST[ 'post' ] ) && is_array( $_POST[ 'post' ] ) ) {
					foreach ( $_POST[ 'post' ] as $productId ) {
						// update status
						tgt_lp_update_status( $productId, 'trash' );
					}
					// insert message
					if ( ! isset( $product_messages ) ) {
						$product_messages = array();
					}
					$product_messages[] = __( 'Move to trash successfully!', 're' );
				}
				break;
				// Draft all
			case 3:
				if ( isset( $_POST[ 'post' ] ) && is_array( $_POST[ 'post' ] ) ) {
					foreach ( $_POST[ 'post' ] as $productId ) {
						// update status
						tgt_lp_update_status( $productId, 'draft' );
					}
					// insert message
					if ( ! isset( $product_messages ) ) {
						$product_messages = array();
					}
					$product_messages[] = __( 'Move to draft successfully!', 're' );
				}
				break;
				// Pending all
			case 4:
				if ( isset( $_POST[ 'post' ] ) && is_array( $_POST[ 'post' ] ) ) {
					foreach ( $_POST[ 'post' ] as $productId ) {
						// update status
						tgt_lp_update_status( $productId, 'pending' );
					}
					// insert message
					if ( ! isset( $product_messages ) ) {
						$product_messages = array();
					}
					$product_messages[] = __( 'Pending successfully!', 're' );
				}
				break;
				// physical delete item
			case 5:
				if ( isset( $_POST[ 'post' ] ) && is_array( $_POST[ 'post' ] ) ) {
					foreach ( $_POST[ 'post' ] as $productId ) {
						// update status
						wp_delete_post( $productId, true );
					}
					// insert message
					if ( ! isset( $product_messages ) ) {
						$product_messages = array();
					}
					$product_messages[] = __( 'Physical delete successfully!', 're' );
				}
				break;
				// other case there is no need to process
			default:
				break;
		}
	}

}

/**
 * Get query product from user
 */
function tgt_lp_get_request( ) {
	global $product_query;

	// process form when SERVER REQUEST METHOD is post
	if ( strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) == 'post' ) {
		tgt_lp_process_form();
	}

	// get status
	if ( isset( $_GET[ 'post_status' ] ) ) {
		switch ( $_GET[ 'post_status' ] ) {
			case 'publish' :
				$product_query[ 'post_status' ] = 'publish';
				break;
			case 'trash' :
				$product_query[ 'post_status' ] = 'trash';
				break;
			case 'draft' :
				$product_query[ 'post_status' ] = 'draft';
				break;
			case 'pending' :
				$product_query[ 'post_status' ] = 'pending';
				break;
			case '' :
				$product_query[ 'post_status' ] = 'all';
				break;
			default :
				break;
		}
	}

	// get limit
	if ( isset( $_GET[ 'pagenum' ] ) ) {
		$product_query[ 'pagenum' ] = (int) $_GET[ 'pagenum' ];
		$product_query[ 'pagenum' ]--;

		if ( $product_query[ 'pagenum' ] < 0 ) {
			$product_query[ 'pagenum' ] = 0;
		}
	}

	// get limit
	if ( isset( $_GET[ 'cat' ] ) ) {
		$product_query[ 'cat' ] = (int) $_GET[ 'cat' ];
		if ( $product_query[ 'cat' ] < 0 ) {
			$product_query[ 'cat' ] = 0;
		}
	}
	
	if ( isset( $_GET[ 'tag' ] ) ) {
		$product_query[ 'tag' ] = (int) $_GET[ 'tag' ];
		if ( $product_query[ 'tag' ] < 0 ) {
			$product_query[ 'tag' ] = 0;
		}
	}

	// get search query
	if ( isset( $_GET['key'] ) ) {
		$product_query['key'] = $_GET[ 'key' ];
	}
	// get search
	if ( isset( $_GET['s'] ) ) {
		$product_query['s'] = trim( $_GET[ 's' ] );
	}
	
	// get type
	if( isset( $_GET[ 'to' ] ) ) {
		$product_query[ 'title_only' ] = empty( $_GET[ 'to' ] ) ? 0 : 1;
	}

	// get action
	if ( isset( $_GET[ 'action' ] ) ) {
		// get action trash
		if ( $_GET[ 'action' ] == 'trash' ) {
			$product_query[ 'action' ] = 'trash';
		} elseif ( $_GET[ 'action' ] == 'publish' ) { // get action publish
			$product_query[ 'action' ] = 'publish';
		} elseif ( $_GET[ 'action' ] == 'draft' ) { // get action publish
			$product_query[ 'action' ] = 'draft';
		} elseif ( $_GET[ 'action' ] == 'pending' ) { // get action publish
			$product_query[ 'action' ] = 'pending';
		} elseif ( $_GET[ 'action' ] == 'pending' ) { // get action publish
			$product_query[ 'action' ] = 'pending';
		} elseif ( $_GET[ 'action' ] == 'delete' ) { // get action publish
			$product_query[ 'action' ] = 'delete';
		}

		// get product id
		if ( isset( $_GET[ 'productid' ] ) ) {
			$product_query[ 'product_id' ] = (int) $_GET[ 'productid' ];
		} else {
			$product_query[ 'action' ] = '';
			// TODO: set error
		}
	}

	// get @author Home
	if ( isset( $_GET['author'] ) ) {
		$product_query[ 'author' ] = (int) $_GET[ 'author' ];
		if ( $product_query[ 'author' ] < 0 ) {
			$product_query[ 'author' ] = 0;
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
function tgt_lp_get_current( $status = 'all', $display = true ) {
	global $product_query;

	$message = '';
	if ( isset( $product_query[ 'post_status' ] )
	&& $product_query[ 'post_status' ] == $status ) {
		$message .= ' class="current" ';
	}
	if ( $display ) {
		echo $message;
	}
	return $message;
}

/**
 * Get current page
 *
 * @author thanhsangvnm
 *
 * @param boolean $display
 */
function tgt_lp_get_current_page( $display = true ) {
	global $product_query;

	$message = $product_query[ 'post_status' ];

	if ( $display ) {
		echo $message;
	}
	return $message;
}

/**
 * Get action, when status is publish, action is trash and otherwise
 *
 * @author thanhsangvnm
 *
 * @param String $status
 */
function tgt_lp_get_action( $status = 'publish', $ucwords = false, $display = true ) {
	$message = 'trash';
	if ( $status == 'trash' ) {
		$message = 'publish';
	}

	if ( $ucwords ) {
		$message = ucwords( $message );
	}
	if ( $display ) {
		echo $message;
	}
	return $message;
}

/**
 * get product by query
 * @var string
 */
function tgt_lp_get_products( $post_type = '', $post_status = '', $postsPerPage = 0 ) {
	global $product_query, $wpdb,$wp_query;
	$wp_query = new WP_Query();   
    
	// init query
	if ( ! isset( $product_query ) || empty( $product_query ) ) {
		tgt_lp_init_query();
	}

	tgt_lp_get_request();


	// check if delete post
	if ( $product_query['action'] == 'trash' ) {
		if ( $product_query['product_id'] ) {
			$product_id = $product_query['product_id'];
			tgt_lp_update_status( $product_id, 'trash' );
			$product_messages[] = 'Move to trash successfully!';
		}
	} elseif( $product_query['action'] == 'publish' ) {
		if ( $product_query['product_id'] ) {
			$product_id = $product_query['product_id'];
			tgt_lp_update_status( $product_id, 'publish' );
			$product_messages[] = 'Publish successfully!';
		}
	} elseif( $product_query['action'] == 'draft' ) {
		if ( $product_query['product_id'] ) {
			$product_id = $product_query['product_id'];
			tgt_lp_update_status( $product_id, 'draft' );
			$product_messages[] = 'Draft successfully!';
		}
	} elseif( $product_query['action'] == 'pending' ) {
		if ( $product_query['product_id'] ) {
			$product_id = $product_query['product_id'];
			tgt_lp_update_status( $product_id, 'pending' );
			$product_messages[] = 'Pending successfully!';
		}
	} elseif( $product_query['action'] == 'delete' ) {
		if ( $product_query['product_id'] ) {
			$product_id = $product_query['product_id'];
			wp_delete_post( $product_id, true );
			$product_messages[] = 'Deleted successfully!';
		}
	}

	// post type
	if ( ! empty( $post_type ) ) {
		$product_query[ 'post_type' ] = $post_type;
	}

	// get parameter
	remove_filter( 'posts_where', 'filter_where_top' );
	add_filter('posts_where', 'tgt_lp_post_where' );

	// product status
	if ( ! empty( $post_status ) ) {
		$product_query[ 'post_status' ] = $post_status;
	}

	if ( $product_query[ 'cat' ] > 0 || $product_query[ 'tag' ] > 0 ) {
		add_filter( 'posts_join', 'tgt_lp_post_join' );
	}

	// product limit
	remove_filter( 'post_limits', 'filter_limits' );
	if( $postsPerPage > 0 ) {
		$product_query['per_page'] = (int) $postsPerPage;
	}

	add_filter('post_limits', 'tgt_lp_post_limits' );
	
	
	remove_filter( 'posts_orderby', 'filter_order_top' );
	add_filter( 'posts_orderby', 'tgt_lp_post_order' );
	
	$posts = query_posts( '' );
	
	// get total product
	$join = tgt_lp_post_join();
	$where = tgt_lp_post_where();
	$limit = tgt_lp_post_limits();
	
	$product_query[ 'total' ] = 
		$wpdb->get_var(
			"SELECT COUNT({$wpdb->posts}.ID) 
			FROM {$wpdb->posts} 
			$join 
			WHERE {$wpdb->posts}.post_parent >= 0 $where" );
	
	return $posts;
}

// Lmit
function tgt_lp_post_limits( $limits = '' ) {
	global $product_query;
	$pagenum = $product_query[ 'pagenum' ];
	$per_page = $product_query[ 'per_page' ];
	return ' LIMIT ' . ( $pagenum * $per_page ) . ',' . $per_page ;
}

function tgt_lp_post_order( $order = '' ) {
	return '' ;
}

function tgt_lp_post_join( $join = '' ) {
	global $product_query, $wpdb;
	$join = '';
	if ( $product_query[ 'cat' ] > 0 ) {
		$parents = get_category_parents( $product_query[ 'cat' ], false );
		$join = " 
		INNER JOIN $wpdb->term_relationships 
		ON ( 
			( $wpdb->posts.ID = $wpdb->term_relationships.object_id )  
		) 
		INNER JOIN $wpdb->term_taxonomy 
		ON (
			( $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id ) 
			AND ( $wpdb->term_taxonomy.taxonomy='category' )
			AND ( $wpdb->term_taxonomy.term_id='" . $product_query[ 'cat' ] . "' ) 
		)";
	} elseif ( $product_query[ 'tag' ] > 0 ) {
		$parents = get_category_parents( $product_query[ 'cat' ], false );
		$join = " 
		INNER JOIN $wpdb->term_relationships 
		ON ( 
			( $wpdb->posts.ID = $wpdb->term_relationships.object_id )  
		) 
		INNER JOIN $wpdb->term_taxonomy 
		ON (
			( $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id ) 
			AND ( $wpdb->term_taxonomy.taxonomy='post_tag' ) 
			AND ( $wpdb->term_taxonomy.term_id='" . $product_query[ 'tag' ] . "' )
		)";
	}

	return $join;
}

function tgt_lp_post_where( $where = '' ) {
	global $product_query, $wpdb;

	$where = '';

	// post status
	if ( $product_query[ 'post_status' ] == 'all' ) {
		$where .= "AND ( {$wpdb->posts}.post_status = 'pending' "
		. " OR {$wpdb->posts}.post_status = 'publish'"
		. " OR {$wpdb->posts}.post_status = 'draft')";
	} else {
		$where .= "AND ( {$wpdb->posts}.post_status = '"
		. $product_query[ 'post_status' ] . "' )";
	}

	// post type
	if ( $product_query[ 'post_type' ] == 'product' ) {
		$where .= " AND ( {$wpdb->posts}.post_type = 'product' )";
	} elseif( $product_query[ 'post_type' ] == 'article' ) {
		$where .= " AND ( {$wpdb->posts}.post_type = 'article' )";
	}

	// post search
	if ( $product_query[ 's' ] ) {
		$search_conditions = array();
		// get search array
		$search = explode( ' ', $product_query[ 's' ] );
		if ( ! empty( $search ) ) {
			foreach( $search as $search_query ) {
				if ( ! empty( $search_query ) ) {
					if( $product_query[ 'title_only' ] ) {
						$where .= " AND (  {$wpdb->posts}.post_title LIKE '%$search_query%' )";
					} else {
						$where .= " AND ( ( {$wpdb->posts}.post_title LIKE '%$search_query%')
						OR ( {$wpdb->posts}.post_content LIKE '%$search_query%') )";
					}
				}
			}
			if ( count( $search ) != 1 ) {
				if( $product_query[ 'title_only' ] ) {
					$where .= " OR ( {$wpdb->posts}.post_title LIKE '%" . $product_query[ 's' ] . "%' )";
				} else {
					$where .= " OR ( ( {$wpdb->posts}.post_title LIKE '%" . $product_query[ 's' ] . "%')
						OR ( {$wpdb->posts}.post_content LIKE '%" . $product_query[ 's' ] . "%') )";
				}
			}
		}
	}

	// author
	if( $product_query[ 'author'] > 0 ) {
		$where .= " AND ( {$wpdb->posts}.post_author = '" . $product_query[ 'author'] . "' )";
	}

	return $where;
}

function tgt_lp_get_page_num() {
	global $product_query;
	return $product_query[ 'pagenum' ];
}

function tgt_lp_get_current_url( $display = true ) {
	global $product_query;
	$currentPage = $_GET['page'];
	$url = 'admin.php?page=' . $currentPage;
	if( $product_query[ 'cat' ] ) {
		$url .= '&amp;cat=' . $product_query[ 'cat' ];
	} elseif( $product_query[ 'tag' ] ) {
		$url .= '&amp;tag=' . $product_query[ 'tag' ];
	} elseif( $product_query[ 'author' ] ) {
		$url .= '&amp;author=' . $product_query[ 'author' ];
	} elseif( $product_query[ 's' ] ) {
		if( $product_query[ 'title_only' ] ) {
			$url .= '&amp;to=' . $product_query[ 'title_only' ];
		}
		$url .= '&amp;s=' . $product_query[ 's' ];
	} elseif( $product_query[ 'post_status' ] ) {
		$url .= '&amp;post_status=' . $product_query[ 'post_status' ];
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
function tgt_lp_page_naging( $display = true ) {
	global $product_query;
	$pagenum = $product_query[ 'pagenum' ] + 1;
	// pagenation
	$total = $product_query[ 'total' ];
	$perPage = $product_query[ 'per_page' ];

	$numOfPages = ceil( $total / $perPage );
	
	$message = paginate_links( array(
		'base' => tgt_lp_get_current_url( false ) . '%_%', 
		'format' =>  '&pagenum=%#%', //
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

/**
 * Current page
 */
