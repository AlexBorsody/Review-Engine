<div class="col">
<?php if ( post_password_required() ) : ?>
	<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 're' ); ?></p>
</div><!-- #comments -->
<?php
	/* Stop the rest of comments.php from being processed,
	 * but don't kill the script entirely -- we still have
	 * to fully load the template.
	 */
	return;
endif;
?>
<?php
	list( $comments, $total, $root_total ) = tgt_sa_get_comment_list( $post->ID );
	// You can start editing here -- including this comment!
?>

<?php if ( ! empty( $comments ) ) : ?>
	<div class="col_box" style="border-bottom:4px #eceeef solid;">
	<div>
		<h1 class="blue2"><?php
			printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', $total, 're' ),
			number_format_i18n( $total ), '"' . get_the_title() . '"' );
		?></h1>
	</div>
<?php
	$per_page = (int) get_option( 'comments_per_page' );
	if ( empty( $per_page ) || $per_page < 1 ) {
		$per_page = 20;
		update_option( 'comments_per_page', '20' ); 
	}

	$number_of_pages = (int) ( $root_total / $per_page );
	if ( $root_total % $per_page != 0 ) {
		$number_of_pages ++;
	}
	//$current_page = get_query_var('cpage');
	$pagenum = 1;
	if ( $number_of_pages > 1 ) : // Are there comments to navigate through? ?>	
		<div class="pagination" style="width: auto; float:right; text-align: right;">
			<?php 
			if( strpos( get_post_permalink(), "?" ) ) {
				$format =  '&cpage=%#%';
				$pagenum = isset( $_GET[ 'cpage' ] ) ? ( int ) $_GET[ 'cpage' ] : 1;
			} else {
				$page_comments = get_option( 'page_comments' ) ? 1 : 0;
				if( $page_comments ) {
					global $wp_query;
					$pagenum = isset( $wp_query->query_vars[ 'page' ] ) ? ( int ) $wp_query->query_vars[ 'page' ] : 1 ;
					$format =  '%#%/'; 
				} else {
					$format =  '?cpage=%#%';
					$pagenum = isset( $_GET[ 'cpage' ] ) ? ( int ) $_GET[ 'cpage' ] : 1;
				}
			}
			
			echo paginate_links( array(
				'base' => get_post_permalink() . '%_%', 
				'format' =>  $format, //
				'total' => $number_of_pages,
				'current' => $pagenum,
				'prev_next' => false,
				'type' => 'list',
			));
			?>
		</div> <!-- .navigation -->
	<?php endif; // check for comment navigation?>

	</div>
	<?php
	// show comment
	foreach( $comments as $comment ) {
		tgt_sa_review_comment( $comment );
	}
	?>
<?php if ( $number_of_pages > 1 ) : // Are there comments to navigate through? ?>
		<div class="pagination" style="width: auto; float:right; text-align: right;">
			<?php 
			echo paginate_links( array(
				'base' => get_post_permalink() . '%_%', 
				'format' =>  $format, //
				'total' => $number_of_pages,
				'current' => $pagenum,
				'prev_next' => false,
				'type' => 'list',
			));
			?>
		</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<p class="nocomments"><?php _e( 'Comments are closed.', 're' ); ?></p>
<?php else : // end ! comments_open()
?>
	<p class="nocomments"><?php _e( 'There is no comment.', 're' ); ?></p>
<?php
	endif;  
endif; // end have_comments() ?>

<?php
if (  comments_open() ){
	tgt_sa_comment_form();
}
?>
</div><!-- #comments -->
<script type="text/javascript">  
	jQuery('.current').attr( 'class', 'selected' );
    function show_reply( comment_id ) {
    	// comment id
    	comment_id = parseInt( comment_id );
    	if( isNaN( comment_id ) ) {
    	    comment_id = 0;
    	}

    	// get current id
    	var current_form_id = jQuery('#comment_parent').val();

    	// set default current form id
    	current_form_id = parseInt( current_form_id );
    	if( isNaN( current_form_id ) ) {
    	    current_form_id = 0;
    	}
    	
    	// get form by current id
    	var reply_form = jQuery("#comment-form-" + current_form_id ).html();

    	if( reply_form == null || reply_form == '' ) {
        	// previous 
    	    reply_form = jQuery("#comment-form-0" ).html();
    	    current_form_id = 0;
    	}

    	if( comment_id == current_form_id ) {
    		return false;
    	} 

    	// set error when can not read reply_form
    	if( reply_form == null || reply_form == '' ) {
    	    alert( "<?php _e ( 'Your browser and memory has limited this function.' , 're' ); ?>" );
    	    return false;
    	}	

    	// hidden current form
    	jQuery("div[id=comment-form-" + current_form_id + "]").fadeOut(500);

    	// clear current form	    	
    	jQuery("div[id=comment-form-" + current_form_id + "]").html( '' );

    	// turn on current id
    	var location = jQuery( "#comment-form-" + comment_id ).html( );
    	if ( location == null ) {
    	    alert( "<?php _e( 'Ohs, Something has been working wrong. We will check this for you.', 're' );?>" );
    	    return false;
    	}

    	// set value for comment form
    	jQuery( "#comment-form-" + comment_id ).html( reply_form );
    	// show reply form
    	jQuery( "#comment-form-" + comment_id ).fadeIn( 500 );

    	// turn on all reply button
    	jQuery( ".butt .reply").show();
    	// turn off all can cal button
    	jQuery( ".butt .cancel").hide();

    	if ( comment_id > 0 ) { 
    		// set width
    		jQuery( "#comment-form-" + comment_id ).attr( 'width', '510px' );
    		// turn of reply button
    		jQuery( "#butt_" + comment_id + " .reply").hide();
    		// turn on cancel button
    		jQuery( "#butt_" + comment_id + " .cancel").show();
    	} else {
    		// set width
    		jQuery( "#comment-form-" + comment_id ).attr( 'width', '560px' );
    	}
    	jQuery("#comment_parent").val( comment_id );
    	return true;
    }

    // default value for input
    function clearText( field ){
        if ( field.defaultValue == field.value ) {
        	field.value = '';
        } else if (field.value == '') {
        	field.value = field.defaultValue;
        }

    }

    function validate( commentForm ) {
        // email
        var email = jQuery("input[name='email']").val();
    	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    	// check for user has logged in 
    	if ( email == null ) {
    		var authorName = jQuery("input[name='author']").val();
    		if ( authorName == null ) {
        		var commentContent = jQuery("textarea[name='comment']").val();
        		if ( commentContent == '<?php _e( 'Comment', 're' )?>' ) {
        			alert( "<?php _e( "Please insert your comment.", 're' );?>" );
        		} else if ( commentContent.length < 10 ) {
        			alert( "<?php _e( "Your comment is too short. Your comment is at least 10 characters.", 're' );?>" );
        		} else if ( commentContent.length > 1000 ) {
        			alert( "<?php _e( "Your comment is too long. Your comment is maximum 1000 characters.", 're' );?>" );
        		} else {
        			commentForm.submit();
        		}
    		}
    		// checking if user has not logged in
    	} else if ( emailPattern.test( email ) == false ) {
        	alert( "<?php _e( 'Your email is incorrect. Ex: nickname@wordpress.com', 're' );?>" );
    	} else {
        	// author name
        	var authorName = jQuery("input[name='author']").val();
        	// author name must not empty
        	if ( authorName == '' ) {
            	alert( "<?php _e( "Author name must be not null.", 're' );?>" );
        	} else if( authorName == '<?php _e( 'Name', 're' )?>' ) {
        		alert( "<?php _e( "Please insert your name.", 're' );?>" );
        	} else {
        		if ( authorName.length < 3 ) {
        			alert( "<?php _e( "Your name is too short. Your name is at least 3 characters.", 're' );?>" );
        		} else if ( authorName.length > 100 ) {
            		alert( "<?php _e( "Your name is too long. Your name is maximum 100 characters.", 're' );?>" );
        		} else {
            		var commentContent = jQuery("textarea[name='comment']").val();
            		if ( commentContent == '<?php _e( 'Comment', 're' )?>' ) {
            			alert( "<?php _e( "Please insert your comment.", 're' );?>" );
            		} else if ( commentContent.length < 10 ) {
            			alert( "<?php _e( "Your comment is too short. Your comment is at least 10 characters.", 're' );?>" );
            		} else if ( commentContent.length > 1000 ) {
            			alert( "<?php _e( "Your comment is too long. Your comment is maximum 1000 characters.", 're' );?>" );
            		} else {
            			commentForm.submit();
            			//form.submit();
            		}
        		}
        	}
    	}
    }
</script>
<?php
