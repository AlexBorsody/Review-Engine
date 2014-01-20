<?php
add_action('wp_ajax_nopriv_front_post_comment', 	'tgt_ajax_post_comment');
add_action('wp_ajax_front_post_comment', 'tgt_ajax_post_comment');
function tgt_ajax_post_comment() {
	try {
		// check auth

		// get parameter
		$authorName = isset( $_POST['author_name'] ) ? htmlspecialchars( trim( $_POST['author_name'] ) ) : '';
		$authorEmail = isset( $_POST['author_email'] ) ? htmlspecialchars( trim( $_POST['author_email'] ) ) : '';
		$authorUrl = isset( $_POST['author_url'] ) ? htmlspecialchars( trim( $_POST['author_url'] ) ) : 'http://';
		$commentContent = isset( $_POST['comment_content'] ) ? htmlspecialchars( trim( $_POST['comment_content'] ) ) : '';
		$commentPost = isset( $_POST['comment_post_id'] ) ? (int) $_POST['comment_post_id'] : 0;
		$commentParent = isset( $_POST['comment_parent'] ) ? (int) $_POST['comment_parent'] : 0;
		if ( $commentPost < 0 ) {
			$commentPost = 0;
		}

		// process data
		$time = current_time( 'mysql' );

		$data = array(
		    'comment_post_ID' => $commentPost,
		    'comment_author' => $authorName,
		    'comment_author_email' => $authorEmail,
		    'comment_author_url' => $authorUrl,
			'comment_parent' => $commentParent,
		    'comment_content' => $commentContent,
		    'comment_date' => $time,
		);

		// insert new comment
		$commentId = wp_insert_comment( $data );

		// get comment
		$comment = get_comment( $commentId );
		// prepare response
		$response = json_encode( array('success' => true, 'para' => $comment ) );

	} // if process fail, return error message
	catch (Exception $ex){
		$response = json_encode( array('success' => false, 'message' => $ex->getMessage() ) );
	}

	//return respose
	header('HTTP/1.1 200 OK');
	header('Content-Type: application/json');
	echo $response;

	exit;
}
