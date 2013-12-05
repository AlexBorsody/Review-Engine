<?php
/**
 *
 */
if (get_option(SETTING_ENABLE_ARTICLE) != 1) {
	include  TEMPLATEPATH . '/404.php';
	exit;
}

/**
 * Single article query
 * @var array
 * @author thanhsangvnm
 */
global $article_query;

/**
 * Store products per page
 *
 * @author thanhsangvnm
 */
global $commentsPerPage;
$commentsPerPage = 10;

/**
 * Store product message
 * @var array
 * @author thanhsangvnm
 */
global $comment_messages;

/**
 * Single article init
 * @author thanhsangvnm
 */
function tgt_sa_init_query( ) {
	global $article_query;
	$article_query = array();
	$article_query['post_name'] = '';
	$article_query['post_type'] = '';
	$article_query['replytoid'] = 0;
	$article_query['id'] = 0;
}


/**
 * Process when form is submission
 * @author thanhsangvnm
 */
function tgt_sa_process_form( ) {
}

/**
 * Get query product from user
 * @author thanhsangvnm
 */
function tgt_sa_get_request( ) {
	global $article_query;

	// process form when SERVER REQUEST METHOD is post
	if ( strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) == 'post' ) {
		tgt_sa_process_form();
	}

	// get status
	if ( isset( $_GET[ 'article' ] ) ) {
		$article = $_GET[ 'article' ];
		if ( ! empty( $article ) ) {
			$article_query[ 'post_name' ] = $article;
			$article_query[ 'post_type' ] = 'article';
		}
	}
}


/**
 * get product by query
 * @var string
 */
function tgt_sa_get_posts( $post_name = '', $post_type = '' ) {
	global $article_query;
	//'posts_per_page=3&'

	// init query
	if ( ! isset( $article_query ) || empty( $article_query ) ) {
		tgt_sa_init_query();
	}

	tgt_sa_get_request();


	// check if delete post
	$results = array();
	if ( ! empty( $post_name ) ) {
		$article_query[ 'post_name' ] = $post_name;
	}
	if ( ! empty( $post_type ) ) {
		$article_query[ 'post_type' ] = $post_type;
	}

	// query string
	$query_string = '';

	// send post name request
	if ( ! empty( $article_query[ 'post_name' ] ) ) {
		$query_string .= 'post_name=' . $article_query[ 'post_name' ];
	}
	// send post type request
	if ( ! empty( $article_query[ 'post_type' ] ) ) {
		$query_string .= 'post_type=' . $article_query[ 'post_type' ];
	}

	if ( ! empty( $query_string ) ) {
		$results = get_posts( $query_string );
	}
	
	return $results;
}

/**
 * Current page
 */

/**
 * Template for comments and pingbacks.
 *
 */
function tgt_sa_review_comment( $comment ) {
	$GLOBALS['comment'] = $comment;
	
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<div id="comment-<?php echo (int)$comment->comment_ID;?>" class="col_box" style="border-bottom:1px #dce4e4 solid; padding-bottom:15px;">
		<div class="avatar2">
        	<p class="name">
				<?php
				if($comment->user_id > 1)
				{					
				?>
					<a href="<?php echo get_author_posts_url($comment->user_id); ?>">
						<?php echo htmlspecialchars( $comment->comment_author ); ?>
					</a>
				<?php
				}else
				{
				?>
					<font style="color:#3D4042;font:22px arial;padding:0 15px 0 0;">
				<?php
					echo htmlspecialchars( $comment->comment_author );
					echo '</font>';
				}
				?>
				<br/><?php echo date( 'M d, Y h:i A', strtotime( $comment->comment_date_gmt ) ); ?>
			</p>
        </div>
        <div class="content_text" style="border-left:1px #d9dee0 solid;">
        	<p style="padding-left:20px;">
        		<?php if( $comment->comment_approved == 1 ) { ?>
        			<?php echo htmlspecialchars( $comment->comment_content ); ?>
        		<?php } elseif( $comment->comment_approved == 0 ) { ?>
        			<strong><?php _e( 'This\'s awaiting moderation:', 're' );?> " </strong><i><?php echo htmlspecialchars( $comment->comment_content ); ?></i> <strong>"</strong>
        		<?php } ?>
        	</p>
        	
        	 <?php $child_comments = tgt_sa_get_comment_list( 0, $comment->comment_ID ); 
             foreach( $child_comments as $child_comment ) { ?>
                <!-- child comment -->
                <div id="comment-<?php echo (int)$child_comment->comment_ID;?>" class="col_box" style="width: 552px; border-top:1px #d9dee0 solid; padding-top:15px;">
			        <div class="avatar2">
			            <p class="name">
							<?php
							if($child_comment->user_id > 1)
							{					
							?>
								<a href="<?php echo get_author_posts_url($child_comment->user_id); ?>">
									<?php echo htmlspecialchars( $child_comment->comment_author ); ?>
								</a>
							<?php
							}else
							{
							?>
								<font style="color:#3D4042;font:22px arial;padding:0 15px 0 0;">
							<?php
								echo htmlspecialchars( $child_comment->comment_author );
								echo '</font>';
							}
							?>
			                <br/><?php echo date( 'M d, Y h:i A', strtotime( $child_comment->comment_date_gmt ) ); ?> </p>
			        </div>
			        <div class="content_text" style="width: 400px;  border-left:1px #d9dee0 solid;">
				        <p style="padding-left:20px;">
				            <?php if( $child_comment->comment_approved == 1 ) { ?>
			        			<?php echo htmlspecialchars( $child_comment->comment_content ); ?>
			        		<?php } elseif( $child_comment->comment_approved == 0 ) { ?>
			        			<strong><?php _e( 'This\'s awaiting moderation:', 're' );?> " </strong><i><?php echo htmlspecialchars( $comment->comment_content ); ?></i> <strong>"</strong>
			        		<?php } ?>
				        </p>
			        </div>
			    </div>
                <!--// child comment -->
             <?php }?>
            <!-- Comment Reply -->
	        <div id="comment-form-<?php echo $comment->comment_ID;?>" style="display:none; width: 552px; float:left; padding-left: 20px;" ></div>
	        <!-- // Comment Reply -->
	        <!-- Comment Button -->
		    <div id="butt_<?php echo $comment->comment_ID;?>" class="butt">
		        <input type="button" value="<?php _e( 'Reply', 're' );?>" onclick="show_reply( <?php echo $comment->comment_ID;?> );" class="reply button"/>
		        <input type="button" value="<?php _e( 'Cancel', 're' );?>" style="display:none;" onclick="show_reply(0);" class="cancel button"/>
		    </div>
		    <!-- // Comment Button -->
        </div>

        
        
	</div>

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 're' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 're'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}

function tgt_sa_get_comment_list( $post = 0, $parent_id = 0 ) {
	global $wpdb, $current_user, $wp_roles;
	wp_get_current_user();

	if( $current_user->ID == 0 ) {
		$approved = "AND ( c.comment_approved = '1' )";
	} else {
		$approved = "AND ( ( c.comment_approved = '1' ) 
		OR ( c.comment_approved = '0' AND c.user_id={$current_user->ID} )";
		if( current_user_can( 'moderate_comments' ) ) {
			$approved .= "OR ( c.comment_approved = '0' )";
		}
		$approved .= " )";
	}
	
	if ( $post ) {
		$post = " AND c.comment_post_ID = '$post'";
	} else {
		$post = '';
	}

	$orderby = "ORDER BY c.comment_date_gmt DESC";
	
	$pagenum = 1;
	if( strpos( get_post_permalink(), "?" ) ) {
		$pagenum = isset( $_GET[ 'cpage' ] ) ? ( int ) $_GET[ 'cpage' ] : 1;
	} else {
		$page_comments = get_option( 'page_comments' ) ? 1 : 0;
		if( $page_comments ) {
			global $wp_query;
			$pagenum = isset( $wp_query->query_vars[ 'page' ] ) ? ( int ) $wp_query->query_vars[ 'page' ] : 1 ;
		} else {
			$pagenum = isset( $_GET[ 'cpage' ] ) ? ( int ) $_GET[ 'cpage' ] : 1;
		}
	}
	
	if( $pagenum <= 0 ) {
		$pagenum = 1;
	}
	$pagenum --;
	$per_page = (int) get_option( 'comments_per_page' );
	if( ! $per_page ) {
		$per_page = 20;
	}
	
	$limit = ' ';
	if( $parent_id == 0 ) {
		$limit = "LIMIT " . ( $pagenum * $per_page ) . ", $per_page";
	}
	
	$typesql = "AND c.comment_type = ''";

	$query = "FROM $wpdb->comments c WHERE c.comment_parent = '$parent_id'  $post $typesql
		$approved";
	
	// comment
	$comments = $wpdb->get_results( "SELECT * $query $orderby $limit" );

	update_comment_cache( $comments );
	
	if( $parent_id ) {
		return $comments;
	}
	
	// all total
	$query_total = "FROM $wpdb->comments c WHERE c.comment_parent >= 0 $post $typesql
		$approved";
	$total = $wpdb->get_var( "SELECT COUNT(c.comment_ID) $query_total" );

	// root total
	$root_total = $wpdb->get_var( "SELECT COUNT(c.comment_ID) $query" );

	return array( $comments, $total, $root_total );
}

/**
 * Create comment form
 * 
 */
function tgt_sa_comment_form( $replytoid = 0 ) {
	global $article_query, $current_user;
    get_currentuserinfo();
    
    // current user login
    if( ! isset( $current_user->user_login ) ) {
    	$current_user->user_login = '';
    }
    
	$article_query['replytoid'] = (int) $replytoid;
	$aria_req = '<span class="red">*</span>';
	$fields =  array(
			'author' => '<div class="review-input">' .
						'<input type="text" onblur="clearText(this);" onfocus="clearText(this);" class="comment-text" name="author" value="' . __( 'Name', 're' ) . '" size="29px"/>' . $aria_req . '</div>',
			'email'  => '<div class="review-input">' .
						'<input type="text" onblur="clearText(this);" onfocus="clearText(this);" class="comment-text" name="email" value="' . __( 'Email', 're' ) . '" size="29px"/>' . $aria_req . '</div>',
			'url'    => '<div class="review-input">' .
						'<input type="text" onblur="clearText(this);" onfocus="clearText(this);" class="comment-text" name="url" value="' . __( 'Website', 're' ) . '" size="29px"/></div>',
		);
	$args = array( 
		'fields'               => $fields,
		'comment_field'        => '<div class="review-input"><textarea rows="15" class="comment-text" cols="30" onblur="clearText(this);" onfocus="clearText(this);" id="comment" name="comment">' . __( 'Comment', 're' ) . '</textarea><span class="red">*</span></div>',
		'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 're' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $article_query[ 'id' ] ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 're' ), tgt_get_permalink('edit_profile'), $current_user->user_login, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $article_query[ 'id' ] ) ) ) ) . '</p>',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Leave a Reply', 're' ),
		'title_reply_to'       => __( 'Leave a Reply to %s', 're' ),
		'cancel_reply_link'    => __( 'Cancel reply', 're' ),
		'label_submit'         => __( 'Submit', 're' ) . ''
	);
	
	//'comment_id_fields'
	add_filter( 'comment_id_fields', 'tgt_sa_comment_id_fields' );
	
	?>
	<div id="comment-form-0" class="col_box">
		<h1 class="blue2" style="font-size:25px; float:none;"><?php _e( 'Add a comment', 're' );?></h1>
	<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
		<?php echo $args['must_log_in']; ?>
		<?php do_action( 'comment_form_must_log_in_after' ); ?>
	<?php else : ?>
		<form class="comment-reply-form" action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
			<?php do_action( 'comment_form_top' ); ?>
			<?php if ( is_user_logged_in() ) : ?>
				<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as']); ?>
				<?php do_action( 'comment_form_logged_in_after'); ?>
			<?php else : ?>
				<?php echo $args['comment_notes_before']; ?>
				<?php
				do_action( 'comment_form_before_fields' );
				foreach ( (array) $args['fields'] as $name => $field ) {
					echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
				}
				do_action( 'comment_form_after_fields' );
				?>
			<?php endif; ?>
			<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
			<?php echo $args['comment_notes_after']; ?>
			<div class="butt_search" style="margin-top:15px; float:left;">  
                <div class="butt_search_left"></div>  
                <div class="butt_search_center">
					<input name="dsfsdfssfdds" type="button" onclick="validate( this.form );" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
					<?php comment_id_fields(); ?>
				</div>
				<div class="butt_search_right"></div>
			</div>
			<?php do_action( 'comment_form', $article_query[ 'id' ] ); ?>
		</form>
	<?php endif;?>
				
	</div>
	<?php

}


/**
 * Retrieve hidden input HTML for replying to comments.
 *
 * @since 3.0.0
 *
 * @return string Hidden input HTML for replying to comments
 */
function tgt_sa_comment_id_fields() {
	global $article_query;
	$result  = "<input type='hidden' name='comment_post_ID' value='" . $article_query[ 'id' ] . "' id='comment_post_ID' />\n";
	$result .= "<input type='hidden' name='comment_parent' id='comment_parent' value='" . $article_query['replytoid'] . "' />\n";
	$result .= "<input type='hidden' name='redirect_to' id='redirect_to' value='" . HOME_URL ."/?article=" . $article_query[ 'post_name' ] . "' />\n";
	return $result;
}


