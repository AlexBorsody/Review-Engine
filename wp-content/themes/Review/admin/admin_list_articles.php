<?php 
require( TEMPLATEPATH . '/admin_processing/admin_list_products_processing.php' );
$lastposts = tgt_lp_get_products( 'article' );

?>
<div class="wrap"> <!-- #wrap 1 -->
	<div id="icon-edit" class="icon32"><br></div>
	<h2>
		<?php _e( 'List Articles', 're' );?>
		<a class="button add-new-h2" href="<?php echo 'admin.php?page=review-engine-new-article';?>"><?php _e( 'Add New Article', 're' );?></a>
	</h2>
	<div class="tgt_atention">
		<strong><?php _e('Problems? Questions?','re');?></strong><?php _e(' Contact us at ','re');?><em><a href="http://www.dailywp.com/support/" target="_blank">Support</a></em>. 
	</div>
	<?php if ( tgt_lp_have_messages() ) : ?>
	<div class="updated below-h2">
	 	<?php tgt_lp_print_messages(); ?>
	</div>
	<?php endif; ?>
	
	
	<form method="post" action="?page=review-engine-list-articles&amp;to=1">	 <!-- form -->
	
		<ul class="subsubsub"> <!-- sub navigation -->
			<li><a <?php tgt_lp_get_current( 'all' );?> href="<?php tgt_lp_get_current_url();?>"><?php _e( 'All', 're' );?> <span class="count"></span></a> |</li>
			<li><a <?php tgt_lp_get_current( 'publish' );?> href="<?php tgt_lp_get_current_url();?>&amp;post_status=publish"><?php _e( 'Published', 're' );?> <span class="count"></span></a> |</li>
			<li><a <?php tgt_lp_get_current( 'trash' );?> href="<?php tgt_lp_get_current_url();?>&amp;post_status=trash"><?php _e( 'Trash', 're' );?> <span class="count"></span></a> |</li>
			<li><a <?php tgt_lp_get_current( 'draft' );?> href="<?php tgt_lp_get_current_url();?>&amp;post_status=draft"><?php _e( 'Draft', 're' );?> <span class="count"></span></a> |</li>
			<li><a <?php tgt_lp_get_current( 'pending' );?> href="<?php tgt_lp_get_current_url();?>&amp;post_status=pending"><?php _e( 'Pending', 're' );?> <span class="count"></span></a></li>
		</ul> <!-- //sub navigation -->
		
		<p class="search-box"> <!-- search box -->
			<label for="post-search-input" class="screen-reader-text"><?php _e( 'Search Articles', 're' );?>:</label>
			<input type="text" value="<?php echo $product_query['s'];?>" name="s" id="post-search-input" >
			<input type="submit" class="button" value="<?php _e( 'Search Articles', 're' );?>">
		</p> <!-- //search box -->
		
		<div class="tablenav"> 
			<div class="tablenav-pages"> <!-- page navigation -->
				<?php tgt_lp_page_naging( $lastposts ); ?>
			</div> <!-- //page navigation -->
			
			<div class="alignleft actions"> <!-- #selects: filter + bulk action -->
				<select name="action">
					<option selected="selected" value="-1"><?php _e( 'Bulk Actions', 're' );?></option>
					<?php if ( tgt_lp_get_current_page() != 'publish' ) { ?>
					<option value="1"><?php _e( 'Publish', 're' );?></option>
					<?php } if ( tgt_lp_get_current_page() != 'trash' ) {?>
					<option value="2"><?php _e( 'Move to trash', 're' );?></option>
					<?php } if ( tgt_lp_get_current_page() != 'draft' ) {?>
					<option value="3"><?php _e( 'Move to draft', 're' );?></option>
					<?php } if ( tgt_lp_get_current_page() != 'pending' ) {?>
					<option value="4"><?php _e( 'Pending items', 're' );?></option>
					<?php } if ( tgt_lp_get_current_page() == 'trash' ) {?>
					<option value="5"><?php _e( 'Physical Delete', 're' );?></option>
					<?php }?>
				</select>
				<input type="submit" class="button-secondary" id="doaction" name="doaction" value="<?php _e( 'Apply', 're' );?>">
				
				<select class="postform" id="cat" name="cat">
					<option value="0"><?php _e( 'View all categories', 're' );?></option>
                <?php
                	$args = array(
						'type'                     => 'post',
						'parent'                   => 0,
						'orderby'                  => 'slug',
						'order'                    => 'ASC',
						'hide_empty'               => 0,
						 'exclude'                 => 1,
						'hierarchical'             => 1,
						'pad_counts'               => false );
					$main_category = get_categories($args);
					if($main_category != '') {
						foreach ($main_category as $main) {													
							echo '<option value="'.$main->term_id.','.$main->name.'"';
							if(isset($_POST['category']) && $_POST['category'] == $main->term_id.','.$main->name) {
								echo 'selected="selected"';
							}
							echo ' class="bold" >'.$main->name.'</option>';
							$args = array (
								'type' => 'post',
								'child_of' => $main->term_id,
								'orderby' => 'slug',
								'order' => 'ASC',
								'hide_empty' => 0,
								'hierarchical' => 1,
								'pad_counts' => false 
							);														
							$sub_cate = get_categories($args);
							if($sub_cate != '') {
								foreach ($sub_cate as $sub) {
									//echo '<input type="hidden" id="cate_'.$sub->term_id.'" value="'.$sub->name.'" />';
									echo '<option value="'.$sub->term_id.','.$sub->name.'"';
									if(isset($_POST['category']) && $_POST['category'] == $sub->term_id.','.$sub->name) {
										echo 'selected="selected"';
									}
									echo '> -- '.$sub->name.'</option>';
								}
							}
						}
					}
				?>												
				</select>
				<input type="submit" class="button-secondary" value="<?php _e( 'Filter', 're' );?>">
				
			</div> <!-- //selects: filter + bulk action -->
		</div>	
		
		<table cellspacing="0" class="widefat post fixed"> <!-- list table -->
			<thead> <!-- table header -->
				<tr>				
					<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
					<th style="" class="manage-column column-title" id="title" scope="col"><?php _e( 'Title', 're' );?></th>
					<th style="" class="manage-column column-product" id="product" scope="col"><?php _e( 'Product', 're' );?></th>
					<th style="" class="manage-column column-author" id="author" scope="col"><?php _e( 'Author', 're' );?></th>
					<th style="" class="manage-column column-categories" id="categories" scope="col"><?php _e( 'Categories', 're' );?></th>
					<!-- <th style="" class="manage-column column-comments num" id="comments" scope="col"><div class="vers"><img src="<?php echo HOME_URL;?>/wp-admin/images/comment-grey-bubble.png" alt="<?php _e( 'Comment', 're' );?>"></div></th> -->
					<th style="" class="manage-column column-date" id="date" scope="col"><?php _e( 'Date', 're' );?></th>
				</tr>
			</thead> <!-- //table header -->
			
			<tfoot> <!-- table footer -->
				<tr>				
					<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
					<th style="" class="manage-column column-title" id="title" scope="col"><?php _e( 'Title', 're' );?></th>
					<th style="" class="manage-column column-product" id="product" scope="col"><?php _e( 'Product', 're' );?></th>
					<th style="" class="manage-column column-author" id="author" scope="col"><?php _e( 'Author', 're' );?></th>
					<th style="" class="manage-column column-categories" id="categories" scope="col"><?php _e( 'Categories', 're' );?></th>
					<!-- <th style="" class="manage-column column-comments num" id="comments" scope="col"><div class="vers"><img src="<?php echo HOME_URL?>/wp-admin/images/comment-grey-bubble.png" alt="<?php _e( 'Comment', 're' );?>"></div></th> -->
					<th style="" class="manage-column column-date" id="date" scope="col"><?php _e( 'Date', 're' );?></th>
				</tr>
			</tfoot> <!-- //table footer -->
			
			<tbody> <!-- table body -->
				<?php  
				$pagenum = tgt_lp_get_page_num();
				$perPage = $product_query[ 'per_page' ];
				
				if ( empty( $lastposts ) ) {
					_e( 'No Results','re' );
				} else {
					$total= $product_query[ 'total' ];
				
					foreach( $lastposts as $post ) {
					    setup_postdata( $post );
					?>	
					<tr valign="top" class="alternate author-other status-publish iedit" id="post-43">
						<th class="check-column" scope="row"><input type="checkbox" value="<?php echo $post->ID;?>" name="post[]"></th>
						<td class="post-title column-title">
	                    <strong><a title="<?php _e( 'Edit this item', 're' );?>" href="admin.php?page=review-engine-new-article&amp;p=<?php echo $post->ID;?>" class="row-title"><?php echo $post->post_title;?></a><b><?php echo ( $post->post_status == 'publish' ? '' : ' - ' . $post->post_status );?></b></strong>
						<div class="row-actions">
						<span class="edit"><a title="<?php _e( 'Edit this item', 're' );?>" href="admin.php?page=review-engine-new-article&amp;p=<?php echo $post->ID;?>"><?php _e( 'Edit', 're' );?></a> | </span>
	                    <span class="trash"><a href="?page=review-engine-list-articles&amp;productid=<?php echo $post->ID;?>&amp;post_status=<?php tgt_lp_get_current_page();?>&amp;action=<?php tgt_lp_get_action($post->post_status);?>" class="submitdelete"><?php _e( tgt_lp_get_action($post->post_status, true, false), 're' );?></a> |</span>
	                    <?php if ( tgt_lp_get_current_page(false) == 'trash') {?>
	                    <span class="trash"><a href="?page=review-engine-list-articles&amp;productid=<?php echo $post->ID;?>&amp;post_status=<?php tgt_lp_get_current_page();?>&amp;action=delete" class="submitdelete"><?php _e( 'Delete', 're' );?></a> |</span>
	                    <?php }?>
	                    <span class="view"><a rel="permalink" title="<?php _e( 'View', 're' );?> '<?php echo $post->post_title;?>'" href="<?php echo get_post_permalink( $post->ID );?>"><?php _e( 'View', 're' ); ?></a></span></div>
						</td>
							<td class="product column-product">
								<?php 
				
									/**
									 * get the product info stored in post meta tgt_product_id
									 */
									$product_ID = get_post_meta($post->ID, 'tgt_product_id', true);
									if ( ! empty ( $product_ID ) ){
										$product = get_post( $product_ID );
										if( is_object( $product ) ) {
											echo '<a href="admin.php?page=review-engine-new-article&amp;p=' . $post->ID . '#product-search">' . $product->post_title . '</a>';
										}
									}
								?>
							</td>
							<td class="author column-author"><a href="admin.php?page=review-engine-list-articles&amp;post_status=<?php tgt_lp_get_current_page(false); ?>&amp;author=<?php echo $post->post_author;?>"><?php the_author();?></a></td>
							<td class="categories column-categories">
							    <?php 
								$post_categories = wp_get_post_categories( $post->ID );
								$cats = array();
								foreach($post_categories as $c){
									$cat = get_category( $c );
									$cats[] =  '<a href="admin.php?page=review-engine-list-articles&amp;post_status=' . tgt_lp_get_current_page(false) . '&amp;cat=' . $cat->term_id . '">' . $cat->name . '</a>';
								}
								echo ( implode( ', ', $cats ) );
								?>
							</td>
							<td class="date column-date"><abbr title="<?php echo( $post->post_modified );?>"> <?php echo( $post->post_modified );?></abbr></td>	
					</tr>
				
				<?php } //end for 
				} //end if?>

			</tbody> <!-- //table body -->
		</table> <!-- //list table -->
		
		<div class="tablenav"> 
			<div class="tablenav-pages"> <!-- page navigation -->
				<?php tgt_lp_page_naging( $lastposts ); ?>
			</div> <!-- //page navigation -->
			
			<div class="alignleft actions"> <!-- #selects: filter + bulk action -->
			</div> <!-- //selects: filter + bulk action -->
		</div>	
		
		
	</form> <!-- //form -->
</div>
<script type="text/javascript">
	jQuery("#post-search-input").focus();
</script>