<?php		
class Users_Widget extends WP_Widget {	
	function Users_Widget() {
		$widget_ops = array('classname' => 'widget_users_sidebar', 'description' => __( 'Display members list in thumbnails', 're' ) );
		$this->WP_Widget('', __( 'RE Users List', 're' ), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;		
		if($instance['title']!=""){
			echo $before_title;
			echo  $instance['title'];
			echo $after_title;
		}
		
		// get users
		$sortby 		= $instance['sortby'];
		$usertypes 	= $instance['usertypes'];
		$number 		= $instance['number'];
		
		$users = $this->query_users( $sortby , $usertypes , $number);
		
		//$review_owner = get_commentdata(2);
		//echo '<pre>';
		//print_r($users);
		//echo '</pre>';
		
		if ( !empty($users) )
		{
		?>
			<div class="widget-user-list">
				<?php foreach((array)$users as $user  ) {
					$data = array(
						'thumbup' 		=> get_user_meta($user->ID,'tgt_thumbup_count',true),
						'thumbdown' 	=> get_user_meta($user->ID,'tgt_thumbdown_count',true),
						'reviews_count' => $user->reviews
					);
					$data['thumbup'] 	= empty($data['thumbup']) ? 0 : $data['thumbup'];
					$data['thumbdown'] 	= empty($data['thumbdown']) ? 0 : $data['thumbdown'];
					?>
				<div class="widget-user-thumb">
					<a class="user-thumbnail" href="<?php echo get_author_posts_url($user->ID) ?>">
						<img class="" width="60" height="60" src="<?php echo empty($user->avatar) ? TEMPLATE_URL.'/images/no_avatar.gif' : URL_UPLOAD . $user->avatar ?>" alt="" />
					</a>
					<input type="hidden" name="popup_id" value="#popup_<?php echo $user->ID ?>" />
				</div>
				<div class="info-popup tooltip" id="popup_<?php echo $user->ID ?>">
					<a href="<?php echo get_author_posts_url($user->ID) ?>"><h3> <?php echo truncate( $user->display_name, 30 )?> </h3></a>
					<p> <span class="info-date" title="<?php _e('Join Date','re') ?>"> <?php echo date(get_option('date_format'), strtotime( $user->user_registered ) ) ?> </span> </p>
					<p> <span class="info-review" title="<?php _e('Product Reviewed','re') ?>" > <?php echo $user->reviews ?> <?php _e('Reviews','re') ?> </span> </p>
					<p> <span class="info-thumbup" title="<?php _e('Total Likes','re') ?>" >  <?php echo $data['thumbup'] ?> <?php _e('Likes','re') ?> </span> </p>
					<p> <span class="info-thumbdown" title="<?php _e('Total Dislikes','re') ?>" > <?php echo $data['thumbdown'] ?> <?php _e('Dislikes','re') ?> </span> </p>
				</div>
				<?php } ?>
			</div>
		<?php
		}
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['sortby'] = $new_instance['sortby'];
		$instance['usertypes'] = $new_instance['usertypes'];
		$instance['number'] = $new_instance['number'];
		return $instance;
	}

	function form($instance) {
		$instance 	= wp_parse_args( (array) $instance, array( 'title' => 'Latest Users',
																			 'sortby' => 'latest',
																			 'usertypes' => array('subscriber','reviewer'), 
																			'number' => '3' ) );
		$title 		= $instance['title'];
		$sortby 		= $instance['sortby'];
		$usertypes 	= $instance['usertypes'];
		$number 		= $instance['number'];		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 're'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="sortby"><?php _e('Sort By:','re') ?></label> <br />
			<select name="<?php echo $this->get_field_name('sortby') ?>" id="<?php echo $this->get_field_id('title') ?>" class="widefat">
				<option value="latest" <?php echo $sortby == 'latest' ? 'selected="selected"' : ''?> ><?php _e('Latest Users','re') ?></option>
				<option value="top"  <?php echo $sortby == 'top' ? 'selected="selected"' : ''  ?> ><?php _e('Top Users','re') ?></option>
				<option value="random" <?php echo $sortby == 'random' ? 'selected="selected"' : ''?> ><?php _e('Random','re') ?></option>
			</select>
		</p>
		<p>
			<label for="usertype"><?php _e('User Types:','re') ?></label> <br />
			<input type="checkbox" name="<?php echo $this->get_field_name('usertypes') ?>[]" value="administrator" <?php echo in_array('administrator', $usertypes) ? 'checked="checked"' : ''?> /> <label for=""><?php _e('Administrator', 're') ?></label> <br />
			<input type="checkbox" name="<?php echo $this->get_field_name('usertypes') ?>[]" value="editor" <?php echo in_array('editor', $usertypes) ? 'checked="checked"' : ''?> /> <label for=""><?php _e('Editor', 're') ?></label> <br />
			<input type="checkbox" name="<?php echo $this->get_field_name('usertypes') ?>[]" value="author" <?php echo in_array('author', $usertypes) ? 'checked="checked"' : ''?> /> <label for=""><?php _e('Author', 're') ?></label> <br />
			<input type="checkbox" name="<?php echo $this->get_field_name('usertypes') ?>[]" value="contributor" <?php echo in_array('contributor', $usertypes) ? 'checked="checked"' : ''?> /> <label for=""><?php _e('Contributor', 're') ?></label> <br />
			<input type="checkbox" name="<?php echo $this->get_field_name('usertypes') ?>[]" value="subscriber" <?php echo in_array('subscriber', $usertypes) ? 'checked="checked"' : ''?> /> <label for=""><?php _e('Subscriber', 're') ?></label>	 <br />
			<input type="checkbox" name="<?php echo $this->get_field_name('usertypes') ?>[]" value="reviewer" <?php echo in_array('reviewer', $usertypes) ? 'checked="checked"' : ''?> /> <label for=""><?php _e('Reviewer', 're') ?></label> <br />
		</p>
		<p>
			<label for="usertype"><?php _e('Max number of user displayed:','re') ?></label>
			<select name="<?php echo $this->get_field_name('number') ?>" id="<?php echo $this->get_field_id('number') ?>" class="widefat">
				<option value="3" <?php echo $number == '3' ? 'selected="selected"' : ''?> >  3 (<?php _e('1 line','re') ?>)</option>
				<option value="6" <?php echo $number == '6' ? 'selected="selected"' : ''  ?> >  6 (<?php _e('2 lines','re') ?>)</option>
				<option value="9" <?php echo $number == '9' ? 'selected="selected"' : ''?> > 9 (<?php _e('3 lines','re') ?>)</option>
				<option value="12" <?php echo $number == '12' ? 'selected="selected"' : ''?> > 12 (<?php _e('4 lines','re') ?>)</option>
				<option value="15" <?php echo $number == '15' ? 'selected="selected"' : ''?> > 15 (<?php _e('5 lines','re') ?>)</option>
				<option value="18" <?php echo $number == '18' ? 'selected="selected"' : ''?> > 18 (<?php _e('6 lines','re') ?>)</option>
			</select>
		</p>
		
		<?php 
	}
	
	function query_users($sortby = 'latest', $usertypes = array('subscriber','reviewer') , $number = 9 )
	{
		global $wpdb;
		$sortby_condition 	= '';
		$usertypes_condition = '';
		$join_condition		= '';
		$review_count 			= '';
		
		switch ( $sortby ) {
			case 'top':
				$join_condition = " AND usermeta.meta_key = 'tgt_thumbup_count' ";
				$sortby_condition = ' CAST(usermeta.meta_value AS UNSIGNED ) DESC ';
				break;
			case 'latest':
				$join_condition = "  ";
				$sortby_condition = ' users.ID DESC ';
				break;
			case 'random':
				$join_condition = "  ";
				$sortby_condition = ' RAND() ';
				break;
		}
		
		if ( !empty($usertypes) && is_array($usertypes) )
		{
			$usertypes_condition = " SELECT users2.ID FROM {$wpdb->users} AS users2
									LEFT JOIN {$wpdb->usermeta} AS usermeta2 ON usermeta2.user_id = users2.ID AND usermeta2.meta_key = '{$wpdb->prefix}capabilities'
									WHERE 
									";
			$c = 0;
			foreach ( $usertypes as $role )
			{
				$c++;
				$usertypes_condition .= " usermeta2.meta_value LIKE '%%{$role}%%' ";
				if ( $c < count($usertypes) ) $usertypes_condition .= ' OR ';
			}
			$usertypes_condition .= ' GROUP BY users2.ID ';
		}
		
		$review_count = " SELECT COUNT(comments.comment_ID) FROM {$wpdb->comments} as comments
		WHERE comments.user_id = users.ID
		AND comments.comment_type = 'review' OR comments.comment_type = 'editor_review' ";
		
		
		// generate sql statement		
		$sql = " SELECT users.*, umeta_avatar.meta_value as avatar, umeta_thumbup.meta_value as thumbup, umeta_thumbdown.meta_value as thumbdown, ({$review_count}) as reviews FROM {$wpdb->users} AS users
		LEFT JOIN {$wpdb->usermeta} AS usermeta ON usermeta.user_id = users.ID {$join_condition}
		LEFT JOIN {$wpdb->usermeta} AS umeta_avatar ON umeta_avatar.user_id = users.ID AND umeta_avatar.meta_key = 'avatar'
		LEFT JOIN {$wpdb->usermeta} AS umeta_thumbup ON umeta_thumbup.user_id = users.ID AND umeta_thumbup.meta_key = 'tgt_thumbup_count'
		LEFT JOIN {$wpdb->usermeta} AS umeta_thumbdown ON umeta_thumbdown.user_id = users.ID AND umeta_thumbdown.meta_key = 'tgt_thumbdown_count'		
		WHERE users.ID IN ({$usertypes_condition})
		GROUP BY users.ID
		ORDER BY {$sortby_condition} limit 0,{$number}";
		$results = $wpdb->get_results( $wpdb->prepare( $sql ) );
		return $results;
	}
}

?>