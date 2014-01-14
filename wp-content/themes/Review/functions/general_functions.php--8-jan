<?php
define('FACEBOOK_APP_ID', get_option('tgt_fb_app_id'));
define('FACEBOOK_SECRET', get_option('tgt_fb_app_secret'));

/*******
 *
 * REGULAR METHOD
 *
 */

/**
 * This will get all default setting of the theme and return as an array
 * @author toannm
 * @return array $result: default settings
 */
function get_default_settings(){
	// parse deault data from file
	$result = parse_ini_file(TEMPLATEPATH . '/data/default_data.ini');	
	//return the default settings array
	return $result;	
}

/**
 * set default value setting for website
 * @author James
 */
function set_default_value(){
	$arr_default = parse_ini_file(TEMPLATEPATH.'/data/default_data.ini');
	foreach ($arr_default as $k=>$v)
	{
		if (get_option($k) == false)
			update_option($k,$v);
	}
}

/**
 * Cookie manipulation
 */
// retrieve cookie
function getcookie($name){
	if (!empty($_COOKIE[$name])) {
		return $_COOKIE[$name];
	}
	else return false;
}
//delete cookie
function deletecooke($name){
	unset($_COOKIE[$name]);
}

/**
 * save cookie for message
 * @param $message message
 * @param $ype message or error
 *
 */
function setMessage($message, $type = 'message'){
	//set cookie
	$m = json_encode(array('content' => $message, 'type' => $type));
	if (!setcookie('message', $m, time() + 3600, '/')) {
		$_COOKIE['message'] = $m;
	}
	
	//redirect
	//wp_redirect(HOME_URL . '/?action=message');
	wp_redirect(tgt_get_permalink('message'));	
}

/**
 * this function will print out the meta for the website
 * @Author: James
 */
function the_meta_tags(){
	global $helper;
	// if current page is a article, display it's own keyword & desc
	if (is_single()) {
		global $post;
		
		$post_id = $post->ID;
		if (!empty($post_id)){
				//for keyword SEO
				if(get_option(SETTING_ENABLE_KEYWORD) == 1)
						$keys = get_the_tags($post_id);
				else if(get_option(SETTING_ENABLE_KEYWORD) == 0)						
						$keys = get_option(SETTING_DEFAULT_KEYWORD,true);
				//for description SEO		
				if(get_option(SETTING_ENABLE_DESC) == 1)
						$desc = $post->post_title;
				else if(get_option(SETTING_ENABLE_DESC) == 0)						
						$desc = get_option(SETTING_DEFAULT_DESC,true);						
		} 
		$key_list = '';
		if (!empty($keys) && get_option(SETTING_ENABLE_KEYWORD) == 1){
			foreach ($keys as $key){
				$key_list .= $key->name;
				$key_list .= ', ';
			}
			//strripos($key_list, ', ')
			$key_list = substr($key_list, 0, strlen($key_list) - 2);
		}else
				$key_list = get_option(SETTING_DEFAULT_KEYWORD,true);
		$helper->meta('keywords', $key_list);		
		$helper->meta('description', $desc);		
	}
	else{
		$helper->meta('keywords', get_option(SETTING_DEFAULT_KEYWORD, true));
		$helper->meta('description', get_option(SETTING_DEFAULT_DESC, true));
	}
}

/**
 * add tiny mce
 */

function addtinymce() {
    echo '<script language="javascript" type="text/javascript" src="'. HOME_URL .'/wp-includes/js/tinymce/tiny_mce.js"></script>';
    echo '<script language="javascript" type="text/javascript">';
    echo 'tinyMCE.init({
	 mode : "textareas", theme : "advanced",
	 theme_advanced_buttons1 : "bold,italic,strikethrough,bullist,numlist,outdent,indent,link,unlink",
	 theme_advanced_buttons2 : "",
	 theme_advanced_buttons3 : "",
	 language : "en",
	 theme_advanced_toolbar_location : "top",
	 theme_advanced_toolbar_align : "left",
	 width: 97%,
	 });';
    echo '</script>';
}

/***
 * Specticular method
 *
 */

/**
 * display rating star html code
 * @author: toannm
 */
function tgt_display_rating($rating, $name='rating', $disable = true, $class = "star-disabled", $title = ''){
	$round = intval( round ( $rating, 0 ) );
	$titles = array(__("There is no user's rating yet",'re'),
						 __('Abysmal','re'),
						 __('Terrible','re'),
						 __('Poor','re'),
						 __('Mediocre','re'),
						 __('OK','re'),
						 __('Good','re'),
						 __('Very Good','re'),
						 __('Excellent','re'),
						 __('Outstanding','re'),
						 __('Spectacular','re'));
	?>
	<div class="rating_star" title="<?php echo $titles[$round] ?>">
		<div class="amount" style="width: <?php echo $round*10 ?>%"></div>
	</div>
	<?php
	
	/*
	for($i = 1; $i <= 10; $i++){
		if ($i == $round) $check = 'checked="checked"';
		else $check = '';
		if ($disable) $readonly = 'disabled="disabled"';
		else $readonly = '';
		
		if ( empty( $title )) {
			switch ($round){
				case 1: $title = __('Abysmal','re');
					break;
				case 2: $title = __('Terrible','re');
					break;
				case 3: $title = __('Poor','re');
					break;
				case 4: $title = __('Mediocre','re');
					break;
				case 5: $title = __('OK','re');
					break;
				case 6: $title = __('Good','re');
					break;
				case 7: $title = __('Very Good','re');
					break;
				case 8: $title = __('Excellent','re');
					break;
				case 9: $title = __('Outstanding','re');
					break;
				case 10: $title = __('Spectacular','re');
					break;
				default:
					$title = __("There is no user's rating yet",'re');
					break;
			}
		}
		?>		
		<input title="<?php echo $title ?>" type="radio" name="<?php echo $name?>" class="<?php echo $class ?> {split:2}" value="<?php echo $i?>" <?php echo $readonly . '  ' . $check ?> />
	
	<?php }
	*/
}

/**
 * get rating star html code
 * @author: toannm
 */
function tgt_get_rating($rating, $name='rating', $disable = true, $class = "star-disabled", $title = ''){
	$html = '';
	$round = intval( round ( $rating, 0 ) );
	
	$titles = array(__("There is no user's rating yet",'re'),
						 __('Abysmal','re'),
						 __('Terrible','re'),
						 __('Poor','re'),
						 __('Mediocre','re'),
						 __('OK','re'),
						 __('Good','re'),
						 __('Very Good','re'),
						 __('Excellent','re'),
						 __('Outstanding','re'),
						 __('Spectacular','re'));
	
	$html .= '<div class="rating_star"title="'. $titles[$round].">";
	$html .= '<div class="ammount" style="width:"'. $round*10 .'px"></div>';
	$html .= '</div>';
	
	/*$round = intval( round ( $rating, 0 ) );
	$html = '';
	for($i = 1; $i <= 10; $i++){
		if ($i == $round) $check = 'checked="checked"';
		else $check = '';
		if ($disable) $readonly = 'disabled="disabled"';
		else $readonly = '';
		
		if ( empty( $title )) {
			switch ($round){
				case 1: $title = __('Abysmal','re');
					break;
				case 2: $title = __('Terrible','re');
					break;
				case 3: $title = __('Poor','re');
					break;
				case 4: $title = __('Mediocre','re');
					break;
				case 5: $title = __('OK','re');
					break;
				case 6: $title = __('Good','re');
					break;
				case 7: $title = __('Very Good','re');
					break;
				case 8: $title = __('Excellent','re');
					break;
				case 9: $title = __('Outstanding','re');
					break;
				case 10: $title = __('Spectacular','re');
					break;
				default:
					$title = __("There is no user's rating yet",'re');
					break;
			}
		}
		
		$html .= '<input title="'.$title.'" type="radio" name="'. $name .'" class="'. $class .' {split:2}" value="'.$i.'" '. $readonly . '  ' . $check .' />';
		
	}*/
	return $html;
}

/**
 * get the limit of content of posts
 * @author James
 */
function tgt_limit_content($str, $length) {	
	$str = strip_tags($str);
	$str = str_replace('[/', '[', $str);	
	$str = strip_shortcodes($str);
	$str = explode(" ", $str);	
	return implode(" " , array_slice($str, 0, $length));
}
/**
 * 
 * Check the user's role when login and return true / false
 * @param string $id
 * @param string $link default is "http://dailywp.com/dailywp/xml/versions.xml"
 * @param string $type default is "theme", have 2 value: "theme" or "plugin"
 * @return false if link not exist or no version. If succesful return array name & version of product
 */
function tgt_check_role()
{
	global $current_user;	
	get_currentuserinfo();
	$user_id		= $current_user->ID;
	if($user_id>0 && $current_user->has_cap('administrator'))
	{
		return true;
	}
	else
		return false;
}

/**
 * 
 * Get current version of product from dailywp.com 
 * @param string $id
 * @param string $link default is "http://dailywp.com/dailywp/xml/versions.xml"
 * @param string $type default is "theme", have 2 value: "theme" or "plugin"
 * @return false if link not exist or no version. If succesful return array name & version of product
 */
function tgt_get_version($id, $type="theme", $link="http://dailywp.com/xml/versions.xml")
{
	$name = '';
	$version = '';
	$version = false;
	$handle = @fopen($link,'r');
	if(!$handle)
		return false;	
		
	$doc = new DOMDocument();
	
  	$doc->load( $link );
  
 	$products = $doc->getElementsByTagName( "product" );

  	foreach( $products as $product )
  	{
		$types = $product->getElementsByTagName( "type" );	  
		$ids = $product->getElementsByTagName( "id" );	  
		$versions = $product->getElementsByTagName('version');
		  
		if($types->item(0)->nodeValue==$type && $ids->item(0)->nodeValue==$id){
			$version = $versions->item(0)->nodeValue;
			$name = $product->getElementsByTagName("name")->item(0)->nodeValue;
			break;
		}
	}		
	return array ('name'=>$name, 'version'=>$version);
}




/**
 * use to resize image, this will keep the ratio of the image
 * @author: toannm
 * @param: array $arg array contain the setting of the action
 *   - source: path of source file 
 *   - destination: path to destination folder in "wp-include/uploads/images/"
 *   - name_prefix : prefix of the file name, we will generate rand number at the end of the name
 *   - width: width of the resized image
 *   - height: height of the resized image
 *   - type: file type
 *   - crop: yes or no
 */
function tgt_resize($arg){
	$link = '';
	try{	
		if (empty($arg['source']))
			return false;
		
		if (empty($arg['type']))
			return false;
		
		if (empty($arg['crop']))
			$arg['crop'] = false;
	
		if (empty($arg['destination'])){
			$arg['destination'] = '';
		}
			
		if (empty($arg['name_prefix'])) $arg['name_prefix'] = '';
		
		$image = '';		
		
		switch ($arg['type']){
			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
				$image = imagecreatefromjpeg($arg['source']);
				break;
			case 'image/png':
				$image = imagecreatefrompng($arg['source']);
				break;
			case 'image/gif':
				$image = imagecreatefromgif($arg['source']);
				break;
			default:
				return false;
		}
		
		$default_width = imagesx($image);
		$default_height = imagesy($image);
		
		if ($arg['crop']){
			if (!empty($arg['width']) && !empty($arg['height']) ){
				$crop_height = intval( round( $default_width * $arg['height'] / $arg['width'] ) );
				$crop_width = intval( round( $default_height * $arg['width'] / $arg['height']) );
				if ($crop_height < $default_height){
					$default_height = $crop_height;
				}else{
					$default_width = $crop_width;
				}				
			}
		}
		else {
				//create image size
			if (empty($arg['width']) && !empty($arg['height'])){
				$arg['width'] = intval(round( $default_width * $arg['height'] / $default_height ));
			}
			
			if (empty($arg['height']) && !empty($arg['width'])){
				$arg['height'] = intval(round( $default_height * $arg['width'] / $default_width ));
			}
			
			if ($arg['width'] > $default_width){
				$arg['width'] = $default_width;
				$arg['height'] = $default_height;
			}		
		}
		
		
		$resized_image = imageCreateTrueColor($arg['width'], $arg['height']);
		
		do{
			$image_name = $arg['name_prefix'] . rand(0,999999);
			$name_image = sanitize_file_name($image_name);
			$file_path = '';
			switch ($arg['type']){
				case 'image/jpg':
				case 'image/jpeg':
				case 'image/pjpeg':
					$file_path =  PATH_UPLOAD . '/' . $arg['destination'] . '/' .  $name_image . '.jpg';
					$name_image .= '.jpg';
					break;
				case 'image/png':
					$file_path = PATH_UPLOAD . '/'. $arg['destination'] . '/' . $name_image . '.png';
					$name_image .= '.png';
					break;
				case 'image/gif':
					$file_path = PATH_UPLOAD . '/'. $arg['destination'] . '/' . $name_image . '.gif';
					$name_image .= '.gif';
					break;
			}
		} while (file_exists($file_path) )	   ;
		
		imagecopyresampled ($resized_image, $image, 0, 0, 0, 0, $arg['width'], $arg['height'], $default_width, $default_height);
				
		$link = $arg['destination'] . '/' . $name_image;
		if ( ! file_exists ($arg['destination']) ){
			createUploadFolder();
		}		
		
		switch ($arg['type']){
			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($resized_image, $file_path);
				break;
			case 'image/png':
				imagepng($resized_image, $file_path);
				break;
			case 'image/gif':
				imagegif($resized_image, $file_path);
				break;
			default:
				return false;
		}
		
	}
	catch (Exception $ex){
		imagedestroy($image);   // Destroying The Temporary Image
    	imagedestroy($resized_image);   // Destroying The Other Temporary Image
	}
	
	imagedestroy($image);   // Destroying The Temporary Image
	imagedestroy($resized_image);   // Destroying The Other Temporary Image
	return $link;
}

function createUploadFolder(){
	
	if (!file_exists( PATH_ROOT_UPLOAD ) ){
		mkdir(PATH_ROOT_UPLOAD, 0777);		
	}
	if (!file_exists( PATH_UPLOAD ) ){
		mkdir(PATH_UPLOAD, 0777);
	}
	if (!file_exists( PATH_PRODUCT_IMAGE_UPLOAD ) ){
		mkdir(PATH_PRODUCT_IMAGE_UPLOAD, 0777);
	}
	if (!file_exists( PATH_PRODUCT_THUMB_UPLOAD ) ){
		mkdir(PATH_PRODUCT_THUMB_UPLOAD, 0777);
	}	
	if (!file_exists( PATH_AVATAR_UPLOAD ) ){
		mkdir(PATH_AVATAR_UPLOAD, 0777);
	}
}

/*******
 *
 * IRREGULAR METHOD
 *
 */

/**
 * rezise image 
 * @param string $ipath : path image
 * @param string $tdir : thumbnail directory. Example: /images/thumbnail
 * @param int $twidth	: thumbnail width
 * @param int $theight	: thumbnail height
 * @param string $type_image: ~ $_FILES['file']['type'];
 * @param string $name_image: name resize image.
 * @return string path to resized image if success,  return false if defeat
 */
function tgt_resize_image($ipath, $tdir, $twidth, $theight, $image_type, $name_image){
	try{	
		$simg = '';
		//check image type
		$type_arr = array('image/jpg', 'image/jpeg', 'image/pjpeg');
		if (in_array($image_type, $type_arr))
		{		
			$simg = imagecreatefromjpeg($ipath);
		}
		elseif($image_type == 'image/png'){
			$simg = imagecreatefrompng($ipath);
		}
		elseif($image_type == 'image/gif'){
			$simg = imagecreatefromgif($ipath);
		}
		else return false;
		
		$currwidth = imagesx($simg);   // Current Image Width
	    $currheight = imagesy($simg);
	   /* if ($twidth == 0) $twidth = $currwidth;
	    if ($theight == 0) $theight = $theight;*/
	    
		$dimg = imageCreateTrueColor($twidth, $theight);   // Make New Image For Thumbnail
	 
	    $name_image .= rand(1, 100);
	    $name_image = sanitize_file_name($name_image);	    
		
	    
	    imagecopyresampled ($dimg, $simg, 0, 0, 0, 0, $twidth, $theight, $currwidth, $currheight);	    
		$link =  $tdir . '/' . $name_image;
		if (in_array($image_type, $type_arr))
		{		
			imagejpeg($dimg, PATH_UPLOAD . "$tdir/" . $name_image . '.jpg');
			$link .= '.jpg';
		}
		elseif($image_type == 'image/png'){
			imagepng($dimg, PATH_UPLOAD . "$tdir/" . $name_image . '.png');
			$link .= '.png';
		}
		elseif($image_type == 'image/gif'){
			imagegif($dimg, PATH_UPLOAD . "$tdir/" . $name_image . '.gif');
			$link .= '.gif';
		}
	}
	catch (exception $e){
		imagedestroy($simg);   // Destroying The Temporary Image
    	imagedestroy($dimg);   // Destroying The Other Temporary Image
    	return false;
	}
	
    imagedestroy($simg);   // Destroying The Temporary Image
    imagedestroy($dimg);   // Destroying The Other Temporary Image    return $link;
 
}

/**
 * get filter by category id
 * @author: toannm
 * @param: (string/integer) cat_id category id
 * @return: array filter
 */
function getFilterByCatId($cat_id){
	global $wpdb;
	$prefix = $wpdb->prefix;
	$table_filter = $prefix . 'tgt_filter';
	$table_filter_re = $prefix . 'tgt_filter_relationship';
	$table_filter_value = $prefix . 'tgt_filter_value';
	
	// get the group first
	$sql = "SELECT filter.ID, filter.term_id, filter.name
		FROM $table_filter as filter
		WHERE filter.term_id = $cat_id";
		
	$sql_value = "SELECT val.ID, val.group_id, val.name
	FROM $table_filter AS filter, $table_filter_value AS val
	WHERE (filter.term_id = $cat_id) AND (val.group_id = filter.id)";
	$groups = $wpdb->get_results($sql, ARRAY_A);
	$values = $wpdb->get_results($sql_value, ARRAY_A);
	$result = array();
	
	foreach($groups as $group){
		$filter = array();
		
		$filter['ID'] = $group['ID'];
		$filter['term_id'] = $group['term_id'];
		$filter['name'] = $group['name'];
		$filter['children'] = array();
		
		//child		
		foreach ($values as $value){
			$child = array();
			if ( $value['group_id']  == $group['ID'] ) {
				$child['ID'] = $value['ID'];
				$child['name'] = $value['name'];
				$filter['children'][] = $child;
			}			
		}
		$result[] = $filter;
	}
	return $result;
}

/*
 * get Specification by category id
 * @author: toannm
 * @param: (string/integer) cat_id category id
 * @return: array filter
 */
function getSpecByCatId($cat_id){
	global $wpdb;
	$prefix = $wpdb->prefix;
	$table_spec = $prefix . 'tgt_spec';	
	
	$sql = "SELECT *
	FROM $table_spec as spec
	WHERE (spec.term_id = $cat_id)
	ORDER BY spec.ID ASC";
	
	$specs = $wpdb->get_results($sql, ARRAY_A);
	
	$result = array();
	foreach ($specs as $group){
		$spec = array();
		$spec['ID'] = $group['ID'];
		$spec['name'] = $group['name'];
		$spec['value'] = array();			
		if ( !empty( $group['value'] ) )
		{
			$values = json_decode($group['value']);
			foreach( $values as $id => $val ){
				$value_item = array();
				$value_item['ID'] = $id;
				$value_item['name'] = $val;
				$spec['value'][] = $value_item;
			}
		}
		$result[] = $spec;
	}
	
	return $result;
}

/**
 * @method tgt_get_pagination
 * @author James
 * @param int $range: display range of pagination
 * Print out the pagination of page
 * It's used to print out the current page, last page and the first page.
 * It will also print out the two nearest page of current page. 
 *  
 */
function tgt_get_pagination($range = 2){ 

   // $paged - number of the current page   
   global $paged, $wp_query, $max_page; 
   
   $paged = $wp_query->query['paged'];
  // How much pages do we have?   
  if ( !$max_page ) {   
    $max_page = $wp_query->max_num_pages;   
  }   
 // We need the pagination only if there are more than 1 page   
 if($max_page > 1){   
?>
<div class="pagination">
		<p><?php _e('Pages','re'); ?>:</p>
		<ul>
<?php
    if(!$paged){   
      $paged = 1;   
    } 
   // We need the sliding effect only if there are more pages than is the sliding range   
   if($max_page > $range){   
     // When closer to the beginning   
   if($paged < $range){   
     for($i = 1; $i <= ($range + 1); $i++){ 
	  if($i== $paged){echo "<li><a> $i</a></li>";} else{
        echo " <li><a href='" . get_pagenum_link($i) ."'";            
         echo ">$i</a></li> ";   
            }   
	 }
     }   
     // When closer to the end   
     elseif($paged >= ($max_page - ceil(($range/2)))){   
        for($i = $max_page - $range; $i <= $max_page; $i++){ 
		 if($i== $paged){echo "<li><a> $i</a></li>";} else{
         echo " <li><a href='" . get_pagenum_link($i) ."'";             
         echo ">$i</a></li> ";   
       }   }
     }   
     // Somewhere in the middle   
    elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){   
      for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){  
	   if($i== $paged){echo "<li><a> $i</a></li>";} else{
        echo " <li><a href='" . get_pagenum_link($i) ."'";             
         echo ">$i</a></li> ";   
      }   }
     }   
    }   
    // Less pages than the range, no sliding effect needed   
    else{   
     for($i = 1; $i <= $max_page; $i++){   
	 	 if($i== $paged){echo "<li><a> $i</a></li>";} else{
        echo " <li><a href='" . get_pagenum_link($i) ."'";   
        if($i==$paged) echo "class='selected'";   
        echo ">$i</a> </li>";   
      }   }
    } 
?>
	</ul>
</div>
<?php
  }   
}

/**
 * 
 * function used to generate the pagination box
 * @param string $type
 * @param int $range
 */
function tgt_generate_pagination($type = 'paged', $range = 2){
	global $helper;
	$paginator = new tgt_pagination($type, $range);
	$pages = $paginator->get_paginated_pages();	
	if (count($pages) > 1){
	?>
	<div class="pagination" style="width: auto">
		<p><?php _e('Pages','re'); ?>:</p>
		<ul>
	<?php
	foreach ($pages as $page){
		if ($page === '...'){
			echo '<li style="padding: 20px 5px 0 5px">...</li>';
		}
		elseif ($page == $paginator->current_page) {
			echo '<li><a href="#" class="selected" >' . $page . '</a></li> ';
		}
		else {
			echo '<li>';
			if ($type == 'cpage'){				
				echo $helper->link($page , esc_url(get_comments_pagenum_link($page))) . '&nbsp';
			}
			else {
				echo $helper->link($page , esc_url(get_pagenum_link($page))) . '&nbsp';
			}
			echo '</li>';
		}
	}
	?>
		</ul>
		<div class="clear"></div>
		</div>
	<?php
	}	
}

function tgt_the_pagination_links( $args )
{
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	
	$pagination = array(
		'base' => @add_query_arg('page','%#%'),
		'format' => '',
		'total' => $wp_query->max_num_pages,
		'current' => $current,
		'show_all' => true,
		'type' => 'list'
		);
	
	if( $wp_rewrite->using_permalinks() )
		$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	
	if( !empty($wp_query->query_vars['s']) )
		$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
	
	echo paginate_links( $args );
}

/**
 * Author: James
 * function used to paginate in the user profile page
 * @param int $total
 * @param int $item_nember
 * @param string $link
 * @param int $paged
 */
function tgt_paginate_user_profile($total,$item_number,$link,$paged)
{
	$result = array();
	$items_per_page= $item_number;
	if(isset($paged) && $paged !="")
		$page_num= is_numeric($paged)?$paged:0;
	else
		$page_num= 0;
	if($page_num==0)
		$start= 0;
	else
		$start= ($page_num-1)*$items_per_page;
	
	$link = $link."&paged=";
	
	$numrows= $total;
	$rowsPerPage= $items_per_page;
	$pageNum= ($page_num==0)?1:$page_num;
	$maxPage = ceil($numrows/$rowsPerPage); 
	$nav = '';
	$nav .= '<div class="pagination" style="width: auto">';
	$nav .= '<p >'.__('Pages','re').':</p>';
	$nav .= '<ul>'; 
	if($pageNum>7)
	{
	if (1 == $pageNum) 
	{ 
		$nav .= '<li><a class="selected">' . "1" . '</a></li>';  
	} 
	else 
	{ 	
		$nav .= '<li> <a href="'.$link.'1" >'."1".'</a></li>'; 
	} 
	}
	for($page = (($pageNum>3)?($pageNum-3):1); $page <= (($pageNum<$maxPage-3)?($pageNum+3):$maxPage); $page++) 
	{ 
		if ($page == $pageNum) 
		{ 
			$nav .= '<li><a class="selected">' . display_number($page) . '</a></li>';
		} 
		else 
		{ 	
			$nav .= '<li><a href="'.$link.$page.'" >'.display_number($page).'</a></li>'; 
		}   
	} 
	if($maxPage>($pageNum+7))
	{
	if ($maxPage == $pageNum) 
	{ 
		$nav .= ' ... <li><a class="selected">' . display_number($maxPage) . '</a></li>';
	} 
	else 
	{ 	
		$nav .= ' ... <li><a  href="'.$link.$maxPage.'" >'.display_number($maxPage).'</a></li>'; 
	} 
	}
	
	$nav .= "</ul></div>";
	$page_div_str = "";
	if($rowsPerPage< $numrows)
		$page_div_str=  $nav ;
	$result['start'] = $start;	
	$result['page_div_str'] = $page_div_str;
	return $result;
}
function display_number($numrows=0)
{
	if(strlen($numrows)<=3)
		return $numrows;
	$numrows_str= "";
	$numrows_arr= array();
	if($numrows>0)
	{
		for($k=0; $k<strlen($numrows); $k++)
			$numrows_arr[]= substr($numrows,$k,1);
		$i= 0;
		for($k=count($numrows_arr); $k>=0; $k--)
		{
			if($i!=0 && $i%3==0)
				$numrows_str.= $numrows_arr[$k]."|".","."|";
			else
				$numrows_str.= $numrows_arr[$k]."|";
			$i++;
		}
	}
	$numrows_arr_tmp= explode("|",substr($numrows_str,1,(strlen($numrows_str)-1)));
	$numrows_arr= array();
	for($k=count($numrows_arr_tmp)-1; $k>=0; $k--)
		$numrows_arr[]= $numrows_arr_tmp[$k];
	return implode("",$numrows_arr);
}
/*
 * Sending mail for registration
 */
function tgt_mailing_register($user_email, $display_name)
{
	$sender_name = get_bloginfo('name');
	$admin_email = get_bloginfo('admin_email');
	$header = "From: ".$sender_name." <".$admin_email.">";	
	
	$message = get_option('tgt_mailing_register_content');		
	$home_page = get_bloginfo('url');
	$author_panel = $home_page . '/?action=login';	
	$website_url = get_bloginfo('url');
 	
	$message[1] = str_replace("[customer]",$display_name, $message[1]);
	$message[1] = str_replace("[website_url]",$website_url, $message[1]);
	$message[1] = str_replace("[author_panel]",$author_panel, $message[1]);
	$message[1] = str_replace("[website_name]",$sender_name, $message[1]);
 
	wp_mail($user_email, $message[0], $message[1], $header);
}
/**
 * Reset password confirm mailing
 */
function tgt_mailing_forgot_password_confirm($user_email)
{
	global $wp_rewrite;
	$sender_name = get_bloginfo('name');
	$admin_email = get_bloginfo('admin_email');
	$header = "From: ".$sender_name." <".$admin_email.">";
	
	$message = get_option('tgt_mailing_forgot_content');	
	
	if(!empty($message))
	{		
		$user = get_user_by('email',$user_email);
		$display_name = $user->display_name;
		$active_key = tgt_active_key();
		global $wpdb;
		$query = "UPDATE $wpdb->users SET user_activation_key='".$active_key."' WHERE id=".$user->ID;
		$wpdb->query($query);
		$link = re_get_link( 'forgot_password', array('login' => $user->user_login, 'key' => $active_key) ); // HOME_URL.'/?action=forgot_password&login='.$user->user_login.'&key='.$active_key;
		$message[1] = str_replace("[customer]",$display_name, $message[1]);
		$message[1] = str_replace("[reset_password_url]",$link, $message[1]);
		$message[1] = str_replace("[website_name]",$sender_name, $message[1]);
		wp_mail($user_email, $message[0], $message[1], $header);
	}
} 
/**
 * new password mailing - tgt_ mailing_new_pw_content
 */
function tgt_mailing_new_password($user_email)
{
	$sender_name = get_bloginfo('name');
	$admin_email = get_bloginfo('admin_email');
	$header = "From: ".$sender_name." <".$admin_email.">";
	
	$message = get_option('tgt_mailing_new_pw_content');
	if(!empty($message))
	{
		global $wpdb;
		$user = get_user_by_email($user_email);
		$display_name = $user->display_name;
		$link = re_get_link( 'login' ); //HOME_URL.'/?action=login';
		$new_password = wp_generate_password(10);
		wp_update_user(array('ID' => $user->ID, 'user_pass' => $new_password));
		$message[1] = str_replace("[customer]",$display_name, $message[1]);
		$message[1] = str_replace("[new_password]",$new_password, $message[1]);
		$message[1] = str_replace("[login_url]",$link, $message[1]);
		$message[1] = str_replace("[website_name]",$sender_name, $message[1]);
		wp_mail($user_email, $message[0], $message[1], $header);
		$active_key = tgt_active_key();		
		$query = "UPDATE $wpdb->users SET user_activation_key='".$active_key."' WHERE id=".$user->ID;
		$wpdb->query($query);
	}
}
/*
 * Mail for auto create new account when login by facebook
 */
function tgt_mailing_facebook_login($user_email, $password)
{
	$sender_name = get_bloginfo('name');
	$admin_email = get_bloginfo('admin_email');
	$header = "From: ".$sender_name." <".$admin_email.">";
	
	$message = get_option('tgt_mailling_facebook_login_content');
	if(!empty($message))
	{
		global $wpdb;
		$user = get_user_by_email($user_email);
		$display_name = $user->display_name;
		$link = HOME_URL.'/?action=login';		
		
		$message[1] = str_replace("[website_url]",HOME_URL, $message[1]);
		$message[1] = str_replace("[customer]",$display_name, $message[1]);
		$message[1] = str_replace("[username]",$user->user_login, $message[1]);
		$message[1] = str_replace("[password]",$password, $message[1]);
		$message[1] = str_replace("[author_panel]",$link, $message[1]);
		$message[1] = str_replace("[website_name]",$sender_name, $message[1]);
		
		wp_mail($user_email, $message[0], $message[1], $header);		
	}
}
/*
 * Check valid email
 * input: email address
 * output: true if email valid or false if email invalid
 */
 function check_email($email) 
{
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		return false;
	}	
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) 
	{
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) 
		{
			return false;
		}
	}

	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) 
	{
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) 
		{
			return false;
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) 
		{
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) 
			{
				return false;
			}
		}
	}
	return true;
}
function tgt_active_key() 
{
    $length = 20;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $new_key = '';    

    for ($p = 0; $p < $length; $p++) 
    {
        $new_key .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $new_key;
}

/**
 * check if choosen user has reviewed current product or not
 * @author toannm
 */
function has_reviewed($user_ID, $post_ID){
	global $wpdb;
	$table_comment =  $wpdb->prefix . 'comments';
	$sql = "SELECT COUNT(comment_ID) as count  
			FROM $table_comment AS review 
			WHERE user_id = $user_ID AND comment_post_ID = $post_ID AND comment_type IN ('editor_review','review')";
	
	$result = $wpdb->get_row($sql, ARRAY_A );
	if ($result['count'] > 0 && $user_ID != 0){
		return true;
	}
	else return false;
}

/**
 *
 */
function the_review($meta_rating, $meta_review){
	
}

/**
 * display editor reviews in the product page
 * @author toannm
 * @name show_editor_reviews
 * @param 
 */
function show_editor_reviews($comment, $args, $depth){
	$GLOBALS['comment'] = $comment;
	global $helper, $user_ID, $current_user;
	$meta_review = get_comment_meta($comment->comment_ID, 'tgt_review_data', true);
	$meta_rating = get_comment_meta($comment->comment_ID, 'tgt_review_rating', true);
	$meta_review['bottomline'] = $comment->comment_content;	
	$ratings = get_option('tgt_rating');
	$author_avatar = get_user_meta($comment->user_id, 'avatar', true);
	?>
	
	<li>
	<div class="content_review2" >
		<?php if($comment->comment_approved == '0') {?>
			<p style="font: 12px/18px Arial, san-serif; padding-left: 20px;"><?php _e('Your comment is awaiting moderation.','re') ?></p>
		<?php } ?>
		<!--<div class="revieww">
			<h2 class="reviewer-role"> <?php _e("Editor's review:","re") ?> </h2>
		</div>-->
                        
		<div class="revieww" style="padding-bottom: 20px;">
				 <div class="review_left">
					<div class="overall">
						<div class="orange_rate">
								<p class="rate"> <?php _e("User's Rating:", "re") ?> </p>
								 <div class="vote_star" style="background:none; border:none; height:auto; margin:5px 0 5px 10px">
									  <div class="star">
											<?php
												tgt_display_rating( $meta_rating['sum'], 'editor_rating_'.$comment->comment_ID, true, 'star-disabled' );
											?>
									  </div> 
								 </div>
							</div>
							<?php foreach( $meta_rating['rates'] as $rate_ID => $rate ) {?> 
							<div class="orange_rate2">
								<p class="rate"><?php echo $ratings[$rate_ID] ?></p>
								<div class="vote_star" style="background:none; border:none; height:auto; margin:5px 0 5px 10px">
									<div class="star">
										<?php
											tgt_display_rating( $rate, 'editor_rating_'.$comment->comment_ID.'_'.$rate_ID, true, 'star-disabled' );
										?>
									</div> 
								 </div>
							</div>
							<?php } ?>							
					  </div>
				 </div>
				 
				 <div class="review_center">
					<div class="view">
						<h3 class="review-title">  <?php echo $meta_review['title'] ?>  </h3>
							
							<p class="sum"><strong><?php _e('THE GOOD:','re'); ?></strong></p>
							<div class="review-content"><?php echo $meta_review['pro'] ?></div>
							
							<p class="sum"><strong><?php _e('THE BAD:','re'); ?></strong></p>
							<div class="review-content"><?php echo $meta_review['con'] ?></div>
														
							<?php if (!empty($comment->comment_content)) {?>					
								<p class="sum"><strong><?php _e('THE BOTTOM LINE:','re'); ?></strong></p>
								<div class="review-content"><?php echo $comment->comment_content ?></div>
							<?php } ?>
							
							<?php if ( !empty($meta_review['review']) ){ ?>
							<p class="sum"><strong><?php _e('REVIEW:','re'); ?></strong></p>
							<div class="review-content">
								
								<div id="review_intro">
									<?php the_intro($meta_review['review'], "#review") ?>
                     	</div>
								<div id="review_desc" style="display: none">
									<p> <?php echo $meta_review['review'] ?> </p>
									<a class="hide-desc" href="#review"><strong> <?php _e('Hide','re') ?></strong> </a>
								</div>
								
								<?php //echo $meta_review['review'] ?>
							</div>
							<?php }
							
							// display like button
							//
							$enable_like = get_option(SETTING_ENABLE_LIKE);
							if ($enable_like){ ?>
							<!--- like/dislike --->							
							<div class="likediv" id="vote_review_<?php echo $comment->comment_ID ?>">
								<?php _e('Do you think this review is helpful?', 're') ?>
								<span class="like-count"><?php echo get_like_count( $comment->comment_ID, 1 ); ?></span>
								<div class="thumb-up" style="display: inline">
								<?php
									if ( !empty($user_ID ) && !is_voted( $comment->comment_ID , $user_ID ) ) { ?>
										<a class="vote-like" onclick="vote(<?php echo $comment->comment_ID ?>, <?php echo $user_ID ?>, 1, 'vote_review_<?php echo $comment->comment_ID ?>')">
											<?php echo $helper->image('thumb_up.png', 'like', array('title' => the_like_count( get_like_count( $comment->comment_ID, 1 ) ) ) ) ?>
										</a>
									<?php } else {
										echo $helper->image('thumb_up.png', 'like', array('title' => the_like_count( get_like_count( $comment->comment_ID, 1 ) ) ) );
									}
									?>
								</div>
								&nbsp;
								<span class="dislike-count"><?php echo get_like_count( $comment->comment_ID, 0 ); ?></span>
								<span class="thumb-down" style="display: inline">
								<?php
									if ( !empty($user_ID ) && !is_voted( $comment->comment_ID , $user_ID ) ) { ?>
										<a class="vote-dislike" onclick="vote(<?php echo $comment->comment_ID ?>, <?php echo $user_ID ?>, 0, 'vote_review_<?php echo $comment->comment_ID ?>')">
											<?php echo $helper->image('thumb_down.png', 'dislike', array('title' => the_dislike_count( get_like_count( $comment->comment_ID, 0 ) ) ) ) ?>
										</a>
									<?php } else {
										echo $helper->image('thumb_down.png', 'like', array('title' => the_dislike_count( get_like_count( $comment->comment_ID, 0 ) ) ) );
									}
								?>
								</span>
							</div>
							<?php } // end enable_like?>
							
					</div>
				 </div>
				 
				 <div class="review_left">
					<div class="overall2">
						<?php
						if (!empty($author_avatar)){
							echo $helper->link( $helper->image(URL_UPLOAD . '/' . $author_avatar, 'dailywp.com', array('style' => "height:80px")) , get_author_posts_url($comment->user_id) );
						}
						else{
							echo $helper->link( $helper->image(TEMPLATE_URL . '/images/no_avatar.gif', 'dailywp.com', array('style' => "height:80px")), get_author_posts_url($comment->user_id) );
						}
						?>
						<p> <?php _e('REVIEWED BY:','re') ?><br/>
						<?php echo $helper->link( $comment->comment_author, get_author_posts_url($comment->user_id)) ?> <br />
						<span> <?php comment_time('M j,Y');  ?> </span></p>
					</div>
				</div>
		</div>
   </div>

	<?php 
}
/**
 * display editor reviews in the product page
 * @author toannm
 * @name show_editor_reviews
 * @param 
 */
function show_user_reviews($comment, $args, $depth){
	$GLOBALS['comment'] = $comment;
	global $helper, $user_ID, $current_user;
	$meta_review = get_comment_meta($comment->comment_ID, 'tgt_review_data', true);
	$meta_rating = get_comment_meta($comment->comment_ID, 'tgt_review_rating', true);
	$meta_review['bottomline'] = $comment->comment_content;	
	$ratings = get_option('tgt_rating');
	$author_avatar = get_user_meta($comment->user_id, 'avatar', true);
	?>
	<li style="display:none">
	<div class="content_review" >                        
		<div class="revieww">
			<?php if($comment->comment_approved == '0') {?>
				<p style="font: 12px/18px Arial, san-serif; padding-left: 20px;"><?php _e('Your comment is awaiting moderation.','re') ?></p>
			<?php } ?>
			<div class="revieww" style="padding-bottom: 20px;">
				<div class="review_left">
				  <div class="overall">
					  <div class="orange_rate">
							<p class="rate"> <?php _e("User's Rating:", "re") ?> </p>
								<div class="vote_star" style="background:none; border:none; height:auto; margin:5px 0 5px 10px">
									<div class="star">
										<?php
											tgt_display_rating( $meta_rating['sum'], 'editor_rating_'.$comment->comment_ID, true, 'star-disabled' );
										?>
								</div> 
							 </div>
						</div>
							<?php foreach( $meta_rating['rates'] as $rate_ID => $rate ) {?> 
							<div class="orange_rate2">
								<p class="rate"><?php echo $ratings[$rate_ID] ?></p>
								<div class="vote_star" style="background:none; border:none; height:auto; margin:5px 0 5px 10px">
									<div class="star">
										<?php
											tgt_display_rating( $rate, 'editor_rating_'.$comment->comment_ID.'_'.$rate_ID, true, 'star-disabled' );
										?>
									</div> 
								</div>
							</div>
							<?php } ?>							
					  </div>
				 </div>
				 
				 <div class="review_center">
					<div class="view">
						<h3 class="review-title"> <?php echo $meta_review['title'] ?>  </h3>
							
							<p class="sum"><strong><?php _e('THE GOOD:','re'); ?></strong></p>
							<div class="review-content"><?php echo $meta_review['pro'] ?></div>
							
							<p class="sum"><strong><?php _e('THE BAD:','re'); ?></strong></p>
							<div class="review-content"><?php echo $meta_review['con'] ?></div>
									
							<?php if (!empty($comment->comment_content)) {?>					
								<p class="sum"><strong><?php _e('THE BOTTOM LINE:','re'); ?></strong></p>
								<div class="review-content"><?php echo $comment->comment_content ?></div>
							<?php } ?>
							
							<?php if ( !empty($meta_review['review']) ){ ?>
							<p class="sum"><strong><?php _e('REVIEW:','re'); ?></strong></p>
							<div class="review-content"><?php echo $meta_review['review'] ?></div>
							<?php } 
							
							// display like button
							//
							$enable_like = get_option(SETTING_ENABLE_LIKE);
							if ($enable_like){ ?>
							<!--- like/dislike --->					
							<div class="likediv" id="vote_review_<?php echo $comment->comment_ID ?>">
								Do you think this review is helpful?
								<span class="like-count"><?php echo get_like_count( $comment->comment_ID, 1 ); ?></span>
								<div class="thumb-up" style="display: inline">
								<?php
									if ( !empty($user_ID ) && !is_voted( $comment->comment_ID , $user_ID ) ) { ?>
										<a class="vote-like" onclick="vote(<?php echo $comment->comment_ID ?>, <?php echo $user_ID ?>, 1, 'vote_review_<?php echo $comment->comment_ID ?>')">
											<?php echo $helper->image('thumb_up.png', 'like', array('title' => the_like_count( get_like_count( $comment->comment_ID, 1 ) ) ) ) ?>
										</a>
									<?php } else {
										echo $helper->image('thumb_up.png', 'like', array('title' => the_like_count( get_like_count( $comment->comment_ID, 1 ) ) ) );
									}
									?>
								</div>
								<span class="dislike-count"><?php echo get_like_count( $comment->comment_ID, 0 ); ?></span>
								<div class="thumb-down" style="display: inline">
								<?php
								if ( !empty($user_ID ) && !is_voted( $comment->comment_ID , $user_ID ) ) { ?>
										<a class="vote-dislike" onclick="vote(<?php echo $comment->comment_ID ?>, <?php echo $user_ID ?>, 0, 'vote_review_<?php echo $comment->comment_ID ?>')">
											<?php echo $helper->image('thumb_down.png', 'dislike', array('title' =>  the_dislike_count( get_like_count( $comment->comment_ID, 0 ) ) ) ) ?>
										</a>
									<?php } else {
										echo $helper->image('thumb_down.png', 'like', array('title' => the_dislike_count( get_like_count( $comment->comment_ID, 0 ) ) ) );
									}
									?>
								</div>
							</div>
							<?php } // end enable_like?>
					</div>
				 </div>
				 
				 <div class="review_left">
					<div class="overall2">
						<?php
						if (!empty($author_avatar)){							
								echo $helper->link(  $helper->image(URL_UPLOAD . '/' . $author_avatar, 'dailywp.com', array('style' => "height:80px")) , get_author_posts_url($comment->user_id));							
						}
						else{
							if($comment->user_id > 1)
								echo $helper->link( $helper->image(TEMPLATE_URL . '/images/no_avatar.gif', 'dailywp.com', array('style' => "height:80px")), get_author_posts_url($comment->user_id) );
							else								
								echo $helper->image(TEMPLATE_URL . '/images/no_avatar.gif', 'dailywp.com', array('style' => "height:80px"));						
						}
						?>
						<p> <?php _e('REVIEWED BY:','re') ?><br/>
						<?php
						if($comment->user_id > 1)
							echo $helper->link( $comment->comment_author, get_author_posts_url($comment->user_id));
						else
							echo $comment->comment_author;
						?> <br />
						<span> <?php comment_time('M j,Y');  ?> </span></p>
					</div>
				 </div>
			</div>
		</div>
	</div>
	<?php 
}

/**
 * update review count in the post infomation
 * @author toannm
 */
function update_review_count($post_ID, $editor = false){
	global $wpdb;
	$count = 0;
	$meta_count = 'tgt_rating_count';
	if ($editor) $meta_count = 'tgt_edior_rating_count';
		
	$type = $editor == false ? 'review' : 'editor_review';

	$table_review = $wpdb->prefix	 . 'comments';
	$sql = "SELECT COUNT(*) AS count
			FROM $table_review AS comments
			WHERE comments.comment_type = '$type' AND comment_post_ID = $post_ID AND comment_approved = 1";
	$result = $wpdb->get_row( $sql, ARRAY_A ) ;
		
	$count = intval( $result['count'] );
	update_post_meta( $post_ID, $meta_count, $count );
	return $count;
}

/**
 * update post rating from the review
 * @author toannm
 */
function update_post_rating($post_ID ,$rating, $delete = false, $editor = false){
	$post = get_post($post_ID);
	
	if ($editor)
		$meta_rating = 'tgt_editor_rating';
	else
		$meta_rating = 'tgt_rating';
		
	$meta_count = 'tgt_rating_count';
	if ($editor) $meta_count = 'tgt_edior_rating_count';
	
	$review_count =  intval( get_post_meta( $post_ID, $meta_count, true ) );	
	
	$post_rating = get_post_meta($post_ID, $meta_rating, true );
	$post_rating = floatval($post_rating);
	if ($delete == false ){
		if ($review_count > 0)
			$new_rating = ( ( $post_rating * ($review_count - 1)) + $rating ) / ( $review_count );
		else $new_rating = 0;
	}
	else {
		if ($review_count >= 1)
			$new_rating = ( ( $post_rating * ($review_count + 1)) - $rating ) / ( $review_count);
		else
			$new_rating = 0;
	}
	//update_post_meta( $post_ID, 'tgt_editor_rating', $new_rating );
	update_post_meta( $post_ID, $meta_rating, $new_rating );
	
	return $new_rating;
}

function the_like_count($number){	
	if ($number == 0){
		return __('No one likes this review');
	}
	elseif ($number == 1){
		return __('One person likes this review');
	}
	else {
		return $number . __(' people like this review');
	}
}

function the_dislike_count($number){	
	if ($number == 0){
		return __('No one dislikes this review');
	}
	elseif ($number == 1){
		return __('One person dislikes this review');
	}
	else {
		return $number . __(' people dislike this review');
	}
}

/**
 * update product review:
 *  - calculate the review count
 *  - update rating
 *  @author toannm
 */
function update_product_review_rating($comment_ID, $delete = false){
	$comment = get_comment($comment_ID, ARRAY_A);
	$author = new WP_User ($comment['user_id']);
	
	if (isset( $author->roles[0] ))
		$role = $author->roles[0];
	else
		$role = ROLE_MEMBER;
		
	$rating = get_comment_meta($comment_ID, 'tgt_review_rating', true);
	
	if ($delete == false){
		// rating
		if ($role != ROLE_EDITOR){
			update_review_count($comment['comment_post_ID']);
			update_post_rating($comment['comment_post_ID'], $rating['sum']);
		}
		else {
			update_review_count($comment['comment_post_ID'], true);
			update_post_rating($comment['comment_post_ID'], $rating['sum'], false, true);			
		}
	}else {
		// rating
		if ($role != ROLE_EDITOR){
			update_review_count($comment['comment_post_ID']);
			update_post_rating($comment['comment_post_ID'], $rating['sum'], true);
		}
		else {
			update_review_count($comment['comment_post_ID'], true);
			update_post_rating($comment['comment_post_ID'], $rating['sum'], true, true);
		}
		
	}
	
}

/**
 * check if user have minimum
 * @author toannm
 */
function is_trusted_user($user_ID){
	global $wpdb;
	$auto_publish = get_option('tgt_auto_publish');
	$min_review = get_option('tgt_publish_min_posts');
	
	$user = new WP_User($user_ID);
	$role = '';
	if ( ! empty ( $user->roles[0] ) ){
		$role = $user->roles[0];
	}
	
	if ($role == ROLE_MEMBER)	{
		$table = $wpdb->prefix . 'comments';
		$sql = "SELECT COUNT(comment_ID) AS count
			FROM $table AS comments
			WHERE user_ID = $user_ID AND comment_approved = 1";
		$query = $wpdb->get_row($sql);
		
		if ($query->count >= $min_review){
			return true;
		}
		else return false;
	}
	else{
		return true;
	}
}

/**
 * get filter group by cat id
 * @author toannm
 * @param cat_id
 * @return array contain filter groups with their filter value * 
 */
function get_filter_groups($cat){
	global $wpdb;
	// if category null, return false
	if (empty ( $cat ) ) return false;
	
	// get filter groups
	$table_filter = $wpdb->prefix . 'tgt_filter';
	$table_filter_re = $wpdb->prefix . 'tgt_filter_relationship';
	$table_filter_val = $wpdb->prefix . 'tgt_filter_value';
	
	$sql = "SELECT val.ID AS ID, term_id, val.name AS filter_name, filter.name AS group_name, filter.ID AS group_id
			FROM $table_filter AS filter, $table_filter_val AS val
			WHERE filter.ID = val.group_id AND filter.term_id = $cat
			ORDER BY filter.ID ASC, val.ID ASC";
	$groups = $wpdb->get_results( $sql, ARRAY_A);
	$result = array();
	if (!empty ( $groups ) ){
		foreach ($groups as $filter){
			if ( !isset( $result[$filter['group_id']] )  ){
				$value = array(
					'ID' => $filter['group_id'],
					'name' => $filter['group_name'],
					'values' => array()
				);
				$result[$filter['group_id']] = $value;
			}
			$result[$filter['group_id']]['values'][$filter['ID']] = array(
				'ID' => $filter['ID'],
				'name' => $filter['filter_name']
			);
		}
	}
	return $result;
}

/**
 * get the filter name in group array created by function get_filter_groups
 * @author toannm
 * @param groups array generated by function get_filter_groups
 * @param $name_id
 * @return string filter value name
 */
function get_filter_name($groups, $name_id = 0){
	foreach( (array) $groups as $group){
		foreach ($group['value'] as $v) {
			if (isset ($v['filter_value_id']) && $v['filter_value_id'] == $name_id ){
				return $v['value_name'];
			}
		}
		
	}
	return false;
}


function get_facebook_cookie($app_id, $application_secret) {
  $args = array();
  
  if(isset($_COOKIE['fbs_' . $app_id]))
  	parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
	
  ksort($args);
  $payload = '';
  
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if(!isset($args['sig']))
  	return null;
  elseif (md5($payload . $application_secret) != $args['sig']) { 	  	
    return null;
  }
  return $args;
}
/*
 * Login via facebook
 *  
 */
function tgt_login_facebook($fb_user)
{
	
	if(!empty($fb_user))
	{	
		$user_id = 0;		
		$user_email = null;
		if(isset(json_decode($fb_user)->email))
			$user_email = json_decode($fb_user)->email;
		if(!empty($user_email))
		{
			global $wpdb;
			//$query = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key='tgt_facebook_email' AND meta_value='$user_email'";
			$query = "	SELECT $wpdb->users.id FROM $wpdb->users, $wpdb->usermeta 
						WHERE $wpdb->users.id = $wpdb->usermeta.user_id 
						AND $wpdb->usermeta.meta_key = 'tgt_facebook_email' 
						AND $wpdb->usermeta.meta_value='$user_email'";
			$user_id = 	$wpdb->get_var($query);		
			if($user_id > 0)
			{
				$user = get_userdata($user_id);			
				do_action('auto_login', $user->user_login);
			}
			else 
			{
				global $wp_version;
				if (version_compare($wp_version, '3.1', '<')) {
					require_once("wp-includes/registration.php");
				}
				$password   = wp_generate_password(10);
				$first_name = json_decode($fb_user)->first_name;
				$last_name  = json_decode($fb_user)->last_name;
				$nicename   = strtolower($first_name).strtolower($last_name);	
				$nicename   = str_replace(' ','',$nicename);
				$new_user = array(
					'user_login' => json_decode($fb_user)->email,
					'user_nicename' => $nicename,
					'user_pass' => $password,
					'user_email' => json_decode($fb_user)->email,
					'display_name' => json_decode($fb_user)->name,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'show_admin_bar_front' => 'false',
				    'show_admin_bar_admin' => 'false',
					'user_url' => stripslashes(json_decode($fb_user)->link)
				);
				$userid = wp_insert_user($new_user);
				if($userid > 0)
				{
					tgt_mailing_facebook_login($user_email, $password);
					update_user_meta($userid, 'tgt_facebook_email', json_decode($fb_user)->email);
					$user = get_userdata($userid);
					do_action('auto_login', $user->user_login );
				}
				var_dump( get_userdata($userid) );
				exit;
			}
			wp_redirect(HOME_URL);
			exit;
		}				
	}
}

/**
 * get like count
 * @author : toannm
 * @param: int $review
 * @param: bool $type : 1 mean like, 0 mean dislike
 * @return: number of like
 */
function get_like_count($review_ID, $type){
	if ($type == 1 ){
		$likes = get_comment_meta($review_ID, 'tgt_likes', true);
		if (is_array ( $likes) )
			return count( $likes );
		else
			return 0;
	}else {
		$dislikes = get_comment_meta($review_ID, 'tgt_dislikes', true);
		if (is_array ( $dislikes) )
			return count( $dislikes );
		else
			return 0;
	}
}

/**
 * check if user vote for review or not
 * @author: toannm
 * @param: int $review_ID id of review
 * @param: int $user_ID
 * @return: true or false
 */
function is_voted($review_ID, $user_ID) {
	$likes = get_comment_meta($review_ID, 'tgt_likes', true);
	
	if ( is_array($likes) && in_array( $user_ID, $likes ) ){
		return true;
	}
	else {
		$dislikes = get_comment_meta($review_ID, 'tgt_dislikes', true);
		if ( is_array($dislikes) &&  in_array ($user_ID, $dislikes) ){
			return true;
		}
	}
	return false;
}
/**
 * @author: James
 * @description: Show category box in sidebar left
 */
function get_cat_link($cat_ID){
	global $wp_rewrite;
	$link = '';
	if(isset($_GET['type']) && $_GET['type'] == 'article')
	{
		if($wp_rewrite->using_permalinks())
			$link = get_category_link($cat_ID).'?type=article';
		else
			$link = get_category_link($cat_ID).'&type=article';
	}else
		$link = get_category_link($cat_ID);
	return $link;
}

/**
 * Display product link (after hide)
 * @author toannm
 */
function tgt_get_the_product_link($product_ID){
	$enable_redirect = get_option(SETTING_ENABLE_REDIRECT_LINK);	
	$url = HOME_URL ;
	if ($enable_redirect){
		$url .= '?redirect=' . $product_ID ;
	}
	else {
		$url = get_post_meta($product_ID, 'tgt_product_url', true) ;
	}
	return $url;
}

/**
 * Display product thumb
 * @author toannm
 */
function tgt_the_product_thumb($url, $width = 330, $height = 247){
	$sizes = getimagesize($url);
	if ($sizes){
		if (($sizes[0] / $width ) > ( $sizes[1] / $height) ){			
			echo '<img src="'.$url.'" style="width: '. $width . 'px" alt="dailywp.com"/>';
		}
		else {							
			echo '<img src="'.$url.'" style="height: '. $height .'px" alt="dailywp.com"/>';	
		}
	}
}

/**
 * Get filter link (when use permalink or not)
 * @author toannm
 */
function tgt_get_filter_url($cat_ID, $filter_ID){
	global $wp_rewrite;
	if ($wp_rewrite->using_permalinks() ){
		return get_category_link($cat_ID) . '?filter=' . $filter_ID;
	}
	else{
		return get_category_link($cat_ID) . '&filter=' . $filter_ID;
	}
}

/**
 * get the introducing text of product
 * @author toannm
 */
function the_intro($text, $divId ){	
	//number of limit words
	$offset = 800;
	$intro = $text;
	//$intro = strip_tags($text, '<a><img>');
	if ( strlen( $intro ) >= $offset ){
		$index = strpos($intro, ' ', $offset);
		$intro = substr($intro, 0 , $index );
		$intro .= ' ...';
	}

	echo '<p> '. $intro . '</p>';
	if ( strlen( $intro ) > $offset ) {
		echo '<a class="show-desc" href="'.$divId.'"> <strong> '. __('More','re') .'</strong> </a>';
	}
}
/*
 * get the introduce test in description
 * 
 */
function the_intro_des ($text){	
	//number of limit words
	$offset = 150;
	$intro = $text;
	//$intro = strip_tags($text, '<a><img>');
	if ( strlen( $intro ) >= $offset ){
		$index = strpos($intro, ' ', $offset);
		$intro = substr($intro, 0 , $index );
	}
	echo $intro ;
}

function display_intro($content){
	
	//number of limit words
	$offset = 800;
	$intro = $content;
	//$intro = strip_tags($text, '<a><img>');
	if ( strlen( $intro ) >= $offset ){
		$index = strpos($intro, ' ', $offset);
		$intro = substr($intro, 0 , $index );
		$intro .= ' ...';
	}

	echo '<p> '. $intro . '</p>';
	if ( strlen( $intro ) > $offset ) {
		echo '<a class="show-desc" href="'.$divId.'"> <strong> '. __('More','re') .'</strong> </a>';
	}
}

/**
 * Convert for Unicode
 * @author James
 */
function ascii_to_entities($str)
{
   $count    = 1;
   $out    = '';
   $temp    = array();

   for ($i = 0, $s = strlen($str); $i < $s; $i++)
   {
	   $ordinal = ord($str[$i]);

	   if ($ordinal < 128)
	   {
			if (count($temp) == 1)
			{
				$out  .= '&#'.array_shift($temp).';';
				$count = 1;
			}
	   
			$out .= $str[$i];
	   }
	   else
	   {
		   if (count($temp) == 0)
		   {
			   $count = ($ordinal < 224) ? 2 : 3;
		   }
   
		   $temp[] = $ordinal;
   
		   if (count($temp) == $count)
		   {
			   $number = ($count == 3) ? (($temp['0'] % 16) * 4096) +
(($temp['1'] % 64) * 64) +
($temp['2'] % 64) : (($temp['0'] % 32) * 64) +
($temp['1'] % 64);

			   $out .= '&#'.$number.';';
			   $count = 1;
			   $temp = array();
		   }
	   }
   }

   return $out;
}
/*
 * Update post type from post to article
 * @param $post_ids IDs of posts
 * author: Phucch
 */
function update_post($post_ids = array())
{
    global $wpdb;
    $result = 0;
    if(!empty($post_ids) && is_array($post_ids))
    {
        $ids = implode(', ', $post_ids);
        $sql = "UPDATE " . $wpdb->prefix . "posts SET post_type='article' WHERE ID IN(" . $ids . ") AND post_type ='post'";
        $result = $wpdb->query($sql);
    }
    return $result;
}

/*
 * Add a product to Top product
 * @param $id is is of product
 * #param $order is order display in homepage
 */
function add_top_product($post_id, $order=-1)
{
    $result = 0; // fail
    $top_product = get_option(PRODUCT_TOP);
    if(empty ($top_product))
    {
        $top_product = array();
        if($order >= 0 )
        {
            $top_product[$order] = $post_id;
            $result = 1;
        }
        else
        {
            $top_product[] = $post_id;
            $result = 1;
        }
    }
    elseif($order >= 0)
    {
        if(isset ($top_product[$order]) && $top_product[$order] > 0 && $top_product[$order] == $post_id)
            $result = -1; // exist element at $order position
        else
        {
            $top_product[$order] = $post_id;
            $result = 1;
        }
    }
    elseif(find_product_in_top($post_id) == -1)
    {
        $top_product[] = $post_id;
        $result = 1;
    }
    else $result = -1;
    if($result == 1)
        update_option (PRODUCT_TOP, $top_product);
    return $result;
}
function find_product_in_top($post_id)
{
    $top_products = get_option(PRODUCT_TOP);
    if(empty($top_products))
        return -1;
    else
    {
        foreach ($top_products as $key=>$product)
        {
            if($product == $post_id)
                return $key;
        }
    }
    return -1;
}
function init_top_product()
{
    $top_ratings = array();    
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish'
    );
    $products = get_posts($args);
    if(!empty($products))
    {
        foreach ($products as $product)
        {
            $rating = get_rating_value($product->ID);
            //$rating = get_post_meta($product->ID, PRODUCT_RATING, true);
            if(!empty($rating) && $rating > 0)
            {
                $top_ratings[$product->ID] = $rating;
            }
        }
    }
    $max_top_product = get_option(SETTING_TOP_NUMBER_PRODUCT);
    $result = array();
    arsort($top_ratings);
    $count = 0;
    foreach ($top_ratings as $key=>$top)
    {
        if($count < $max_top_product)
        {
            $result[$key] = $key;
        }
        $count++;
    }
    return $result;
}

/**
 * Query all top rated products
 */
function query_top_products($paged){
	//add_filter('posts_join' , 'filter_join_top_product');
	//add_filter('posts_groupby' , 'filter_groupby_top_product');
	$list = (array)get_option( PRODUCT_TOP , array() );
	
	if ( !get_option( PRODUCT_SHOW_RATING , 0 ) )
		$show_rating = PRODUCT_RATING;
	else
		$show_rating = PRODUCT_EDITOR_RATING;
		
	$args = array( 'post_type' => 'product' ,
						'meta_key' => $show_rating,
						'orderby' => 'meta_value_num' ,
						'posts_per_page' => get_option(SETTING_TOP_NUMBER_PRODUCT , 5),
						'paged' => $paged );	
	
	if (get_option (PRODUCT_TOP_DISPLAY) == 1) {
		$args = array( 'post_type' => 'product' ,
						'meta_key' => $show_rating,
						'post__in' => $list,
						'orderby' => 'none',
						'posts_per_page' => get_option(SETTING_TOP_NUMBER_PRODUCT , 5),
						'paged' => $paged );	
	}
	$queries = query_posts( $args );
	
	if ( get_option (PRODUCT_TOP_DISPLAY) == 1 ){
		$result = array();
		foreach( $list as $item ){
			foreach( $queries as $product ){
				if ( $item == $product->ID ){
					$result[] = $product;
				}				
			}
		}
		$queries = $result;
	}
	
	//remove_filter('posts_join' , 'filter_join_top_product');
	//add_filter('posts_groupby' , 'filter_groupby_top_product');
	//echo '<pre>';
	//print_r($queries);
	//echo '</pre>';
	return $queries;
}

/**
 * filter posts_join
 */
function filter_join_top_product($join){
	global $wpdb;
	if ( !get_option( PRODUCT_SHOW_RATING , 0 ) )
		$show_rating = PRODUCT_RATING;
	else
		$show_rating = PRODUCT_EDITOR_RATING;
	
	$join = " LEFT JOIN {$wpdb->postmeta} ON {$wpdb->postmeta}.meta_key = '{$show_rating}' ";
	return $join;
}

/**
 * Add more two tables into database in the new version
 * @author James
 */
function tgt_add_more_tables()
{
	global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); //for dbDelta function
	
	/*
	* ADD the tab management table	
	*/	
	$table_name = $wpdb->prefix . 'tgt_tab';
	$sql = "CREATE TABLE IF NOT EXISTS ". $table_name ." (
				`ID` bigint(20) unsigned NOT NULL UNIQUE AUTO_INCREMENT,			
				`name` longtext,
				`tab_order` bigint(20),					
				PRIMARY KEY (`ID`)
	);";	
	dbDelta($sql);
	
	/*
	* The tables relate with specification	
	*/	
	$tgt_spec	= $wpdb->prefix.'tgt_spec';
	
	$table_name = $wpdb->prefix.'tgt_spec_category';
	$sql = "CREATE TABLE IF NOT EXISTS ". $table_name ." (		
					`spec_id` bigint(20) NOT NULL,
					`term_id` bigint(20) NOT NULL,
					`group_order` bigint(20) ,
					FOREIGN KEY (`spec_id`) REFERENCES $tgt_spec(`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
					FOREIGN KEY (`term_id`) REFERENCES ".$wpdb->prefix."terms (`term_id`) ON DELETE CASCADE ON UPDATE CASCADE
	);";	
	dbDelta($sql);
	$table_name = $wpdb->prefix . 'tgt_spec_value';
	$sql = "CREATE TABLE IF NOT EXISTS ". $table_name ." (
		`spec_value_id` bigint(20) unsigned NOT NULL UNIQUE AUTO_INCREMENT,
					`spec_id` bigint(20) NOT NULL,
					`name` longtext,
					`spec_order` bigint(20),					
					PRIMARY KEY (`spec_value_id`)
	);";	
	dbDelta($sql);
	
	//$sql = "ALTER TABLE $tgt_spec ADD group_order bigint(20) AFTER value;";	
	//$wpdb->query($sql); 
	
	/*
	* The tables relate with specification	
	*/
	$tgt_filter	= $wpdb->prefix.'tgt_filter';
	
	// Create new table
	$table_name = $wpdb->prefix.'tgt_filter_category';
	$sql = "CREATE TABLE IF NOT EXISTS ". $table_name ." (		
					`filter_id` bigint(20) NOT NULL,
					`term_id` bigint(20) NOT NULL,
					`group_order` bigint(20) ,
					FOREIGN KEY (`filter_id`) REFERENCES $tgt_filter(`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
					FOREIGN KEY (`term_id`) REFERENCES ".$wpdb->prefix."terms (`term_id`) ON DELETE CASCADE ON UPDATE CASCADE
	);";	
	dbDelta($sql);
	
	// Customize the tgt_filter_value table
	$table_name = $wpdb->prefix . 'tgt_filter_value';
	
	$sql = "ALTER TABLE $table_name ADD filter_order bigint(20) Default '0' AFTER name;";
	$wpdb->query($sql);
	
	$sql = "ALTER TABLE $table_name ADD filter_count bigint(20) AFTER filter_order;";	
	$wpdb->query($sql);
	
	//$sql = "ALTER TABLE $tgt_filter ADD group_order bigint(20) AFTER `name`;";	
	//$wpdb->query($sql);

	// Do the transfer data
	tgt_transfer_data();
}
/**
 * Transfer data from tgt_spec table to tgt_spec_category table and tgt_spec_value table
 * @author James
 */
function tgt_transfer_data()
{
	global $wpdb;
	$tgt_spec			= $wpdb->prefix . 'tgt_spec';
	$tgt_spec_category	= $wpdb->prefix . 'tgt_spec_category';
	$tgt_spec_value		= $wpdb->prefix . 'tgt_spec_value';
	
	$tgt_filter					= $wpdb->prefix.'tgt_filter';
	$tgt_filter_value 			= $wpdb->prefix.'tgt_filter_value';
	$tgt_filter_category		= $wpdb->prefix.'tgt_filter_category';
	$tgt_filter_relationship	= $wpdb->prefix.'tgt_filter_relationship';
	/*
	* The data relate with specification	
	*/	
	// Get all data from tgt_spec table
	$q_group=" SELECT * FROM $tgt_spec ORDER BY ID ASC";	
	$group_spec = $wpdb->get_results( $q_group );	
	if(!empty($group_spec))
	{		
		$sql_insert_value = "";
		$sql_insert_value_s = "";
		$sql_update_group_order = " CASE `ID` ";
		
		$count_group = 0;
		foreach($group_spec as $k => $v)
		{
			$count_group ++;
			$spec_value = '';
			// Insert data into tgt_spec_category table
			$sql_insert_value .= "('".$v->ID."','".$v->term_id."','".$count_group."'),";
			$sql_update_group_order .= " WHEN ".$v->ID." THEN '".$count_group."' ";
			
			$spec_value = json_decode($v->value);
			if(!empty($spec_value))
			{
				$count = 0;
				foreach ($spec_value as $k_s=>$v_s)
				{
					// Insert data into tgt_spec_value table
					$count++;	
					$sql_insert_value_s .= "('".$v->ID."','".$v_s."','".$count."'),";
				}
			}
		}
		//$sql_updade_spec_group = "UPDATE `".$tgt_spec."` SET `group_order` = ".$sql_update_group_order." END";
		//$wpdb->query($sql_updade_spec_group);
		
		$sql_insert = "INSERT INTO $tgt_spec_category(`spec_id`,`term_id`,`group_order`) VALUES ".trim($sql_insert_value,',').";";
		$wpdb->query($sql_insert);
		
		$sql_insert_s = "INSERT INTO $tgt_spec_value (`spec_id`,`name`,`spec_order`) VALUES ".trim($sql_insert_value_s,',').";";
		$wpdb->query($sql_insert_s);
	}
	
	/*
	* The data relate with filter	
	*/
	$q_filter = " SELECT * FROM $tgt_filter";	
	$group_filter = $wpdb->get_results( $q_filter );
	if(!empty($group_filter))
	{
		$sql_insert_value = "";
		$sql_insert_value_s = " CASE `ID` ";
		$sql_update_filter_order = " CASE `ID` ";
		$sql_update_filter_value_order = " CASE `ID` ";
		$group_id = '';
		$count_group = 0;
		foreach($group_filter as $k => $v)
		{
			$count_group ++;
			$filter_value = '';			
			
			// Insert data into tgt_filter_category table
			$sql_insert_value .= "('".$v->ID."','".$v->term_id."','".$count_group."'),";
			
			$q_filter_value = "SELECT * FROM $tgt_filter_value WHERE group_id = ".$v->ID;
			$filter_value = $wpdb->get_results( $q_filter_value );
			
			$sql_update_filter_order .= " WHEN ".$v->ID." THEN '".$count_group."' ";
			
			if(!empty($filter_value))
			{
				$count_filter_value = 0;
				$order_filter_value = 0;	
				foreach ($filter_value as $k_s=>$v_s)
				{
					$order_filter_value++;
					$sql_update_filter_value_order .= " WHEN ".$v_s->ID." THEN '".$order_filter_value."' ";
					$q_filter_count = "SELECT COUNT(post_id) count FROM $tgt_filter_relationship WHERE filter_value_id = ".$v_s->ID;
					$count_filter_value = $wpdb->get_results( $q_filter_count );
					$sql_insert_value_s .= " WHEN ".$v_s->ID." THEN '".$count_filter_value[0]->count."' ";
					$group_id .= $v_s->ID.',';					
				}
			}
		}
		
		//$sql_updade_filter_group = "UPDATE `".$tgt_filter."` SET `group_order` = ".$sql_update_filter_order." END";
		//$wpdb->query($sql_updade_filter_group);
		
		$sql_insert = "INSERT INTO $tgt_filter_category(filter_id,term_id,group_order) VALUES ".trim($sql_insert_value,',').";";
		$wpdb->query($sql_insert);
		
		$sql_insert_s = "UPDATE `".$tgt_filter_value."` SET `filter_count` = ".$sql_insert_value_s." END";
		$wpdb->query($sql_insert_s);
		
		$sql_insert_s = "UPDATE `".$tgt_filter_value."` SET `filter_order` = ".$sql_update_filter_value_order." END";
		$wpdb->query($sql_insert_s);
	}
}
function get_categories_name($post_id)
{
	$post_categories = wp_get_post_categories( $post_id );
	$cats = array();
	foreach($post_categories as $c){
		$cat = get_category( $c );
		$cats[] =  $cat->name;
	}
	return implode(', ',$cats);
}
/**
 * Check the tables in the new version
 * @author James
 */
function check_exists_tables_tgt()
{
	global $wpdb;
	$tgt_spec_category			= $wpdb->prefix . 'tgt_spec_category';
	$tgt_spec_value				= $wpdb->prefix . 'tgt_spec_value';
	$tgt_filter_category		= $wpdb->prefix . 'tgt_filter_category';
	$tgt_tab					= $wpdb->prefix . 'tgt_tab';

	$sql_check_spec_category = "SHOW TABLES LIKE '$tgt_spec_category'";
	$check_spec_category = $wpdb->query($sql_check_spec_category, ARRAY_A);
	
	$sql_check_spec_value = "SHOW TABLES LIKE '$tgt_spec_value'";
	$check_spec_value = $wpdb->query($sql_check_spec_value, ARRAY_A);
	
	$sql_check_fliter_category = "SHOW TABLES LIKE '$tgt_filter_category'";
	$check_filter_category = $wpdb->query($sql_check_fliter_category, ARRAY_A);
	
	$sql_check_tab = "SHOW TABLES LIKE '$tgt_tab'";
	$check_tab= $wpdb->query($sql_check_tab, ARRAY_A);	
	if($check_spec_category == 1 && $check_spec_value == 1 && $check_filter_category == 1 && $check_tab == 1)
		return true;
	else
		return false;
}
/**
 * Get data from table tgt_tab for tab management
 * @author James
 */
function get_tab_data_tgt($tab_id = '')
{
	global $wpdb;	
	$tgt_tab	= $wpdb->prefix . 'tgt_tab';
	$sql_get_tab = "SELECT DISTINCT * 
						FROM $tgt_tab ";
	if($tab_id > 0 && $tab_id != '')
	{
		$sql_get_tab .= " WHERE ID = $tab_id ";
	}
	$sql_get_tab .= " ORDER BY tab_order ASC";
	return $wpdb->get_results($sql_get_tab, ARRAY_A);
}
/**
 * Count the review of each user
 * @author James
 */
function count_review_tgt($user_id)
{
	global $wpdb;
	$result = 0;
	$tgt_comments	= $wpdb->prefix . 'comments';
	$sql_count = "SELECT COUNT( DISTINCT comment_ID ) count FROM $tgt_comments WHERE user_id = '$user_id' AND comment_approved = '1' AND comment_type IN ('review', 'editor_review') ";
	$result = $wpdb->get_results($sql_count, ARRAY_A);
	if(!empty($result))
		return $result[0]['count'];
	else
		return 0;
}
/**
 * Display category checkbox
 * @param $selected : selected categoris id
 * @param $name : name of the checkboxes
 * @param $depth : 2
 * @return print out the html code
 */
function categories_checkbox( $args = array() )
{
	// set param
	$df = array(
					'selected' 			=> array() ,
					'name' 				=> 'categories' ,
					'depth' 				=> 2,
					'root_class' 		=> 'category-checkbox-list',
					'children_class' 	=> 'category-checkbox-list'
					);	
	$args  = wp_parse_args( $args, $df );
	
	$categories = get_categories('exclude=1&hide_empty=0');
	
	echo '<ul class="'. $args['root_class'] .'">';
	foreach ( $categories as $root )
	{
		// if category has no parent, print it and its children
		if ( empty ( $root->parent ) )
		{
			$checked = in_array( $root->term_id, $args['selected'] ) ? 'checked="checked"' : '';
			echo '<li> <input type="checkbox" name="'. $args['name'] .'['.$root->term_id.']" value="1" '. $checked .' /> <label for="'. $args['name'] .'['.$root->term_id.']">'. $root->name .'</label>';
			echo '<ul  class="'. $args['children_class'] .'">';
			foreach ( $categories as $children )
			{				
				if ( $children->parent == $root->term_id )
				{
					$checked = in_array( $children->term_id, $args['selected'] )? 'checked="checked"' : '';
					echo '<li> <input type="checkbox" name="'. $args['name'] .'['.$children->term_id.']" value="1" '. $checked .'/> <label for="'. $args['name'] .'['.$children->term_id.']">'. $children->name .'</label> </li>';
				}
			}
			echo '</ul>';
			echo '</li>';
		}
	}
	echo '</ul>';
}

/**
 * Display category checkbox
 * @param $selected : selected categoris id
 * @param $name : name of the checkboxes
 * @param $depth : 2
 * @return print out the html code
 */
function categories_dropdown( $args = array() )
{
	// set param
	$df = array(
					'selected' 			=> '' ,
					'name' 				=> 'categories',
					'depth' 				=> 2,
					'id' 					=> 'categories_dropdown',
					'class'				=> 'categories-drop-down',
					'child_prefix'		=> '--'
					);
	$args  = wp_parse_args( $args, $df );
	
	$categories = get_categories('exclude=1&hide_empty=0');
	
	echo '<select name="'. $args['name'] .'" id="'. $args['id'] .'">';
	foreach ( $categories as $root )
	{
		// if category has no parent, print it and its children
		if ( empty ( $root->parent ) )
		{
			$selected = $args['selected'] == $root->term_id ? 'selected="selected"' : '';
			echo '<option value="'. $root->term_id .'" '. $selected .'> '. $root->name .' </option> ' ;
			foreach ( $categories as $children )
			{				
				if ( $children->parent == $root->term_id )
				{
					$selected = $args['selected'] == $children->term_id ? 'selected="selected"' : '';
					echo '<option value="'. $children->term_id .'" '. $selected .' > ' . $args['child_prefix'] . $children->name .' </option> ' ;
				}
			}
		}
	}
	echo '</select>';
}
/**
 * Get All data from tgt_spec, tgt_spec_category and tgt_spec_value tables
 */
function get_all_data_spec_tgt($group_id)
{
	global $wpdb;
	$tgt_spec			= $wpdb->prefix . 'tgt_spec';
	$tgt_spec_category	= $wpdb->prefix . 'tgt_spec_category';
	$tgt_spec_value		= $wpdb->prefix . 'tgt_spec_value';
	
	$args = '';
	$cate_id = '';
	$results = array(	'group_id' => '',
						'term_id' => '',
						'group_name' => '',
						'values_id' => array(),
						'values_name' => array() );
	$q_group	=	"SELECT $tgt_spec.name AS name
						FROM $tgt_spec													
						WHERE $tgt_spec.ID = $group_id";	
	$args = $wpdb->get_results( $q_group ,ARRAY_A);
	
	$q_value	=	"SELECT $tgt_spec_value.name AS value_name, $tgt_spec_value.spec_value_id AS value_id
						FROM $tgt_spec							
							JOIN $tgt_spec_value ON $tgt_spec.ID = $tgt_spec_value.spec_id
						WHERE $tgt_spec.ID = $group_id
						GROUP BY $tgt_spec_value.spec_value_id
						ORDER BY $tgt_spec_value.spec_order";	
	$args_value = $wpdb->get_results( $q_value ,ARRAY_A);
	
	if(!empty($args))
	{
		$q_cate	=	"SELECT $tgt_spec_category.term_id AS term_id
						FROM $tgt_spec
							JOIN $tgt_spec_category ON $tgt_spec.ID = $tgt_spec_category.spec_id						
						WHERE $tgt_spec.ID = $group_id";	
		$args_cate = $wpdb->get_results( $q_cate ,ARRAY_A);
		
		$results['group_id'] = $group_id;
		$results['group_name'] = $args[0]['name'];
		foreach($args_cate as $k => $v)
		{
			$results['term_id'] .= $v['term_id'].',';			
		}
		if(!empty($args_value))
		{
			foreach($args_value as $k => $v)
			{
				$results['values_id'][] = $v['value_id'];
				$results['values_name'][] = $v['value_name'];
			}
		}
		$results['term_id'] = trim($results['term_id'],',');
	}	
	return $results;
}
/**
 * Get All data from tgt_filter, tgt_filter_category and tgt_filter_value tables
 */
function get_all_data_filter_tgt($group_id)
{
	global $wpdb;
	$tgt_filter					= $wpdb->prefix.'tgt_filter';
	$tgt_filter_value 			= $wpdb->prefix.'tgt_filter_value';
	$tgt_filter_category		= $wpdb->prefix.'tgt_filter_category';
	
	$args = '';
	$cate_id = '';
	$results = array(	'group_id' => '',
						'term_id' => '',
						'group_name' => '',
						'values_id' => array(),
						'values_name' => array());
	$q_group	=	"SELECT $tgt_filter.name AS name
						FROM $tgt_filter							
						WHERE $tgt_filter.ID = $group_id";	
	$args = $wpdb->get_results( $q_group ,ARRAY_A);
	
	$q_value	=	"SELECT $tgt_filter_value.name AS value_name, $tgt_filter_value.ID AS value_id
						FROM $tgt_filter							
							JOIN $tgt_filter_value ON $tgt_filter.ID = $tgt_filter_value.group_id
						WHERE $tgt_filter.ID = $group_id
						GROUP BY $tgt_filter_value.ID 
						ORDER BY $tgt_filter_value.filter_order";	
	$args_value = $wpdb->get_results( $q_value ,ARRAY_A);

	if(!empty($args))
	{
		$q_cate	=	"SELECT $tgt_filter_category.term_id AS term_id
						FROM $tgt_filter
							JOIN $tgt_filter_category ON $tgt_filter.ID = $tgt_filter_category.filter_id						
						WHERE $tgt_filter.ID = $group_id";	
		$args_cate = $wpdb->get_results( $q_cate ,ARRAY_A);
		
		$results['group_id'] = $group_id;
		$results['group_name'] = $args[0]['name'];
		foreach($args_cate as $k => $v)
		{
			$results['term_id'] .= $v['term_id'].',';			
		}
		if(!empty($args_value))
		{
			foreach($args_value as $k => $v)
			{
				$results['values_id'][] = $v['value_id'];
				$results['values_name'][] = $v['value_name'];
			}
		}
		$results['term_id'] = trim($results['term_id'],',');
	}
	return $results;
}
/* =============== Duy =============================================================================== */

function resizeImage($source, $des, $type, $prefix, $width = 0, $height = 0){
	$url = tgt_resize( array(
		'source' => $source,
		'destination' => $des,
		'name_prefix' => $prefix,
		'width' => $width,
		'height' => $height,
		'type' => $type
	) );
	return $url;	
}

function cropImage($source, $des, $type, $prefix, $width = 0, $height = 0){
	$url = tgt_resize( array(
		'source' => $source,
		'destination' => $des,
		'name_prefix' => $prefix,
		'width' => $width,
		'height' => $height,
		'type' => $type,
		'crop' => true
	) );
	return $url;
	
}

function deleteRelatioship($post_id){
	global $wpdb;
	$table_relationship = $wpdb->prefix . 'tgt_filter_relationship';
	$sql = $wpdb->prepare( "DELETE FROM $table_relationship
			WHERE post_id = %d ", $post_id);
	
	return $wpdb->query( $sql );
}

function getRelationship($post_id){
	global $wpdb;
	$prefix = $wpdb->prefix;
	$table_filter = $prefix . 'tgt_filter';
	$table_filter_value = $prefix . 'tgt_filter_value';
	$table_filter_rel = $prefix . 'tgt_filter_relationship';
	
	$sql = "SELECT val.ID AS ID, val.name AS name, filter.ID AS group_id, filter.name AS group_name
		FROM $table_filter_rel AS relationship, $table_filter AS filter, $table_filter_value AS val
		WHERE (relationship.post_id = $post_id) AND (filter.ID = val.group_id) AND (val.ID = relationship.filter_value_id)";
			
	$filters = $wpdb->get_results($sql, ARRAY_A);
	$result = array();
	foreach ($filters as $filter){
		$result[$filter['ID']] = array(
			'ID' => $filter['ID'],
			'name' => $filter['name'],
			'group_id' => $filter['group_id'],
			'group_name' => $filter['group_name']
		);
	}
	return $result;
}

function getFilterGroup($cat_id){
	global $wpdb;
	$prefix = $wpdb->prefix;
	$table_filter = $prefix . 'tgt_filter';
	$table_filter_value = $prefix . 'tgt_filter_value';
	$sql = "SELECT val.ID AS ID, val.name AS NAME, filter.ID AS group_id, filter.name AS group_name
			FROM $table_filter AS filter ,$table_filter_value AS val
			WHERE filter.term_id = $cat_id AND val.group_id = filter.ID";
			
	$filters = $wpdb->get_results($sql, ARRAY_A);
	$result = array();
	foreach ($filters as $filter){
		$result[$filter['ID']] = array(
			'ID' => $filter['ID'],
			'name' => $filter['name'],
			'group_id' => $filter['group_id'],
			'group_name' => $filter['group_name']
		);
	}
	return $result;
}

function get_all_data_spec_by_cat_id_tgt($cat_id)
{
	global $wpdb;
	$tgt_spec			= $wpdb->prefix . 'tgt_spec';
	$tgt_spec_category	= $wpdb->prefix . 'tgt_spec_category';
	$tgt_spec_value		= $wpdb->prefix . 'tgt_spec_value';	
	
	
	$sql = "SELECT cat.spec_id AS spec_id, spec.name AS group_name, cat.group_order AS group_order, val.spec_value_id AS spec_value_id, val.name AS value_name, val.spec_order AS spec_order
			FROM $tgt_spec AS spec
				LEFT JOIN $tgt_spec_category AS cat ON cat.spec_id = spec.ID
				LEFT JOIN $tgt_spec_value AS val ON spec.ID = val.spec_id			
			WHERE cat.term_id = $cat_id ORDER BY cat.group_order, val.spec_order";
			
	$filters = $wpdb->get_results($sql, ARRAY_A);	
	$result = array();		
		$temp_spec_id = '';			
		$value = array();
		
		foreach ($filters as $filter){
			if ($temp_spec_id ==''){
				if ($filter['spec_value_id'] > 0){
					$value[] = array(
						'spec_value_id' => $filter['spec_value_id'],
						'value_name' => $filter['value_name'],
						'spec_order' => $filter['spec_order']				
					);	
				}		
				$result[$filter['spec_id']] = array(	
				'spec_id' => $filter['spec_id'],			
				'group_name' => $filter['group_name'],
				'value' => $value,
				'group_order' => $filter['group_order']								
			);
			}
				
			if ($temp_spec_id == $filter['spec_id']){	
				array_push($value,array(
				'spec_value_id' => $filter['spec_value_id'],
				'value_name' => $filter['value_name'],
				'spec_order' => $filter['spec_order']	
				));
				
				$result[$filter['spec_id']] = array(				
				'spec_id' => $filter['spec_id'],			
				'group_name' => $filter['group_name'],
				'value' => $value,
				'group_order' => $filter['group_order']									
				);
				
			}else {	
				$value = array();	
				if ($filter['spec_value_id'] > 0){		
					$value[] = array(
					'spec_value_id' => $filter['spec_value_id'],
					'value_name' => $filter['value_name'],
					'spec_order' => $filter['spec_order']	
					);	
				}		
				$result[$filter['spec_id']] = array(				
					'spec_id' => $filter['spec_id'],			
					'group_name' => $filter['group_name'],
					'value' => $value,
					'group_order' => $filter['group_order']		
				);
				
			}			
			$temp_spec_id = $filter['spec_id'];
		}
	
	return $result;
}
function get_all_data_filter_by_cat_id_tgt($cat_id)
{
	global $wpdb;
	$tgt_filter			= $wpdb->prefix . 'tgt_filter';
	$tgt_filter_category	= $wpdb->prefix . 'tgt_filter_category';
	$tgt_filter_value		= $wpdb->prefix . 'tgt_filter_value';	
	
	
	$sql = "SELECT cat.filter_id AS filter_id, filter.name AS group_name, cat.group_order AS group_order, val.ID AS filter_value_id, val.name AS value_name, val.filter_order AS filter_order, val.filter_count AS filter_count
			FROM $tgt_filter AS filter
				LEFT JOIN $tgt_filter_category AS cat ON cat.filter_id = filter.ID
				LEFT JOIN $tgt_filter_value AS val ON filter.ID = val.group_id
			WHERE cat.term_id = $cat_id order by cat.group_order, val.filter_order";

			
	$filters = $wpdb->get_results($sql, ARRAY_A);	
	$result = array();		
		$temp_filter_id = '';			
		$value = array();
		
		foreach ($filters as $filter){
			if ($temp_filter_id ==''){
			if ($filter['filter_value_id'] > 0) {
			$value[] = array(
				'filter_value_id' => $filter['filter_value_id'],
				'value_name' => $filter['value_name'],
				'filter_order' => $filter['filter_order'],
				'filter_count' => $filter['filter_count']
			);
			}			
			$result[$filter['filter_id']] = array(	
				'filter_id' => $filter['filter_id'],			
				'group_name' => $filter['group_name'],
				'value' => $value,
				'group_order' => $filter['group_order'],				
									
			);
			}
				
			if ($temp_filter_id == $filter['filter_id']){	
				array_push($value,array(
				'filter_value_id' => $filter['filter_value_id'],
				'value_name' => $filter['value_name'],
				'filter_order' => $filter['filter_order'],
				'filter_count' => $filter['filter_count']
				));
				
				$result[$filter['filter_id']] = array(				
				'filter_id' => $filter['filter_id'],			
				'group_name' => $filter['group_name'],
				'value' => $value,
				'group_order' => $filter['group_order']									
				);
				
			}else {	
				$value = array();
				if ($filter['filter_value_id'] > 0) {			
					$value[] = array(
					'filter_value_id' => $filter['filter_value_id'],
					'value_name' => $filter['value_name'],
					'filter_order' => $filter['filter_order'],
					'filter_count' => $filter['filter_count']
					);	
				}		
				$result[$filter['filter_id']] = array(				
					'filter_id' => $filter['filter_id'],			
					'group_name' => $filter['group_name'],
					'value' => $value,
					'group_order' => $filter['group_order']		
				);
				
			}			
			$temp_filter_id = $filter['filter_id'];
		}
	
	return $result;
}
 /* ================== End Tu Duy Nguyen ==================================================== */

function sort_product($sort='')
{
    if(!empty($sort))
    {
        switch ($sort)
        {
            case 'review':
                add_filter('posts_where', 'filter_where_latest');
                add_filter('posts_orderby', 'filter_recent_order_comment_count' );
                break;
            case 'price':
                add_filter('posts_where', 'filter_where_sort_price');
                add_filter('posts_orderby', 'filter_recent_order_price' );
                break;
            case 'rating':
                add_filter('posts_where', 'filter_where_sort_rating');
                add_filter('posts_orderby', 'filter_recent_order_price' );
                break;
            case 'viewing':
                add_filter('posts_where', 'filter_where_sort_viewing');
                add_filter('posts_orderby', 'filter_recent_order_price' );
                break;
        }
    }
    elseif($sort == '')
    {
        add_filter('posts_where', 'filter_where_latest');
        add_filter('posts_orderby', 'filter_order_latest' );
    }
}

/**
 * get permalink for custom pages
 * @param $page : page name
 * @author: toannm
 * 
 */
function tgt_get_permalink($page)
{
	global $custom_pages, $wp_rewrite;
	if ( !in_array( $page , $custom_pages ) )
		return '';
	
	if ( $wp_rewrite->using_permalinks() )
	{
		return get_bloginfo('wpurl') . '/' . $page;
	}
	else
	{
		return get_bloginfo('wpurl') . '/?action=' . $page;
	}
}

add_custom_background();

/**
 *
 */
function get_pagination_args()
{
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	
	$pagination = array(
		'base' 		=> @add_query_arg('page','%#%'),
		'format' 	=> '',
		'total' 		=> $wp_query->max_num_pages,
		'current' 	=> $current,
		'show_all' 	=> true,
		'type' 		=> 'list',
		'prev_next' => false,
		);
	
	if( $wp_rewrite->using_permalinks() )
		$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	
	if( !empty($wp_query->query_vars['s']) )
		$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
	
	return $pagination;
	//echo paginate_links( $pagination );
}
function get_rating_value($post_id)
{
    $rating_user = get_option(PRODUCT_SHOW_RATING);
    if($rating_user == 1) // editor
        return get_post_meta ($post_id, PRODUCT_EDITOR_RATING, true);
    elseif($rating_user == 0)
        return get_post_meta ($post_id, PRODUCT_RATING, true);
}
/**
 * author : Tu Duy
 */
function tgt_format_currency_symbol($number) {   
	$list = get_option(SETTING_CURRENCY_SYMBOL);  
	$number_begin = $number;
    $number = sprintf('%.2f', $number);
    while (true) { 
        $replaced = preg_replace('/(-?\d+)(\d{3})/', '$1,$2', $number);         
        if ($replaced != $number) { 
            $number = $replaced; 
        } else { 
            break; 
        }         
    } 
    if (is_array($list) && !empty($list)){  
			switch ($list['position']) {
				case 'before':
				$number = $list['symbol'] . $number;  
				break;
				case 'after':
				$number = $number . $list['symbol'];				
				break;
				case 'beforespace':
				$number = $list['symbol'] . ' ' . $number; 
				break;
				case 'afterspace':
				$number = $number . ' ' . $list['symbol'];;
				break;				
			}
       }
      if (empty($number_begin)){
      	 return _e('not available','re');
      }else {
   		 return $number; 
      }
}
function get_top_product_rating()
{
    $rating_option = get_option(SETTING_TOP_PRODUCT_RATING);
    if($rating_option)
        $rating_option = PRODUCT_EDITOR_RATING;
    else $rating_option = PRODUCT_RATING;
    global $custom_query, $wp_query;
    $custom_query = 'top-product';
    $max_top_product = get_option(SETTING_TOP_NUMBER_PRODUCT);
    $arg = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $max_top_product,
            'meta_key' => 'tgt_rating',
            'orderby' => 'meta_value',
            'order' => 'DESC'
        );
    $custom_query = '';
    $posts = query_posts($arg);
    return $posts;
}

/**
* Truncates text.
*
* Cuts a string to the length of $length and replaces the last characters
* with the ending if the text is longer than length.
*
* @param string  $text String to truncate.
* @param integer $length Length of returned string, including ellipsis.
* @param string  $ending Ending to be appended to the trimmed string.
* @param boolean $exact If false, $text will not be cut mid-word
* @param boolean $considerHtml If true, HTML tags would be handled correctly
* @return string Trimmed string.
*/
	function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
		 if ($considerHtml) {
			  // if the plain text is shorter than the maximum length, return the whole text
			  if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
					return $text;
			  }
			 
			  // splits all html-tags to scanable lines
			  preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
  
			  $total_length = strlen($ending);
			  $open_tags = array();
			  $truncate = '';
			 
			  foreach ($lines as $line_matchings) {
					// if there is any html-tag in this line, handle it and add it (uncounted) to the output
					if (!empty($line_matchings[1])) {
						 // if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
						 if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
							  // do nothing
						 // if tag is a closing tag (f.e. </b>)
						 } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
							  // delete tag from $open_tags list
							  $pos = array_search($tag_matchings[1], $open_tags);
							  if ($pos !== false) {
									unset($open_tags[$pos]);
							  }
						 // if tag is an opening tag (f.e. <b>)
						 } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
							  // add tag to the beginning of $open_tags list
							  array_unshift($open_tags, strtolower($tag_matchings[1]));
						 }
						 // add html-tag to $truncate'd text
						 $truncate .= $line_matchings[1];
					}
				  
					// calculate the length of the plain text part of the line; handle entities as one character
					$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
					if ($total_length+$content_length> $length) {
						 // the number of characters which are left
						 $left = $length - $total_length;
						 $entities_length = 0;
						 // search for html entities
						 if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
							  // calculate the real length of all entities in the legal range
							  foreach ($entities[0] as $entity) {
									if ($entity[1]+1-$entities_length <= $left) {
										 $left--;
										 $entities_length += strlen($entity[0]);
									} else {
										 // no more characters left
										 break;
									}
							  }
						 }
						 $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
						 // maximum lenght is reached, so get off the loop
						 break;
					} else {
						 $truncate .= $line_matchings[2];
						 $total_length += $content_length;
					}
				  
					// if the maximum length is reached, get off the loop
					if($total_length>= $length) {
						 break;
					}
			  }
		 } else {
			  if (strlen($text) <= $length) {
					return $text;
			  } else {
					$truncate = substr($text, 0, $length - strlen($ending));
			  }
		 }
		
		 // if the words shouldn't be cut in the middle...
		 if (!$exact) {
			  // ...search the last occurance of a space...
			  $spacepos = strrpos($truncate, ' ');
			  if (isset($spacepos)) {
					// ...and cut the text in this position
					$truncate = substr($truncate, 0, $spacepos);
			  }
		 }
		
		 // add the defined ending to the text
		 $truncate .= $ending;
		
		 if($considerHtml) {
			  // close all unclosed html-tags
			  foreach ($open_tags as $tag) {
					$truncate .= '</' . $tag . '>';
			  }
		 }
		
		 return $truncate;
		
	}

/***
 * Showing product rating in product list
 */
function get_showing_rating()
{
	return get_option( PRODUCT_SHOW_RATING ) ? 'tgt_editor_rating' : 'tgt_rating';
}

/**
 * 
 */
function tgt_comment_count( $zero, $single, $plural , $number)
{
	if ( $number == 0 )
		return sprintf( __($zero, 're'), $number) ;
	else
		return sprintf( _n( $single, $plural, $number , 're' ), $number ); 
}

/**
 * Explode string to array with escaping quote
 */
function csv_explode($delim=',', $str, $enclose='"', $preserve=false){
	$resArr = array();
	$n = 0;
	$expEncArr = explode($enclose, $str);
	foreach($expEncArr as $EncItem){
		if($n++%2){
		  array_push($resArr, array_pop($resArr) . ($preserve?$enclose:'') . $EncItem.($preserve?$enclose:''));
		}else{
		  $expDelArr = explode($delim, $EncItem);
		  array_push($resArr, array_pop($resArr) . array_shift($expDelArr));
		  $resArr = array_merge($resArr, $expDelArr);
		}
	}
	return $resArr;
}

?>
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
 * Number format
 */
function tgt_number_format($zero, $singular, $plural, $number){
	if ( $number == 0)
		return sprintf( $zero , $number );
	else if ( $number == 1)
		return sprintf( $singular , $number );
	else
		return sprintf( $plural , $number );
}
/**
 * get the post related
 * @author Thinking
 */
function tgt_query_post_related ($cat_id = '', $tag = '', $amountpost = '',$post_type = 'product'){
	global $post;
	wp_reset_query();
	
	$args = array(					
		'post_type'		=>	$post_type,	
		'post_status'  => 'public',
		'orderby'	=> 'rand()',
	);
	if ($amountpost !=''){
		$args['posts_per_page'] = $amountpost;
	}
	if ($cat_id != ''){
		$args['cat'] = $cat_id;		
	}	
	if ($tag != ''){
		$args['cat'] = $tag;		
	}
	
	query_posts( $args );
}

/**
 * get list product's comments
 * @author James
 */
function tgt_get_comment_product_list( $post_id = 0 ) {
	global $wpdb, $current_user, $wp_roles;
	wp_get_current_user();
	$parent_id = 0;
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
	
	if ( $post_id > 0 ) {
		$query_post_id = " AND c.comment_post_ID = '$post_id'";
	} else {
		$query_post_id = '';
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

	$query = "FROM $wpdb->comments c WHERE 1=1 $query_post_id $typesql
		$approved";
	
	// comment
	$comments = $wpdb->get_results( "SELECT * $query $orderby $limit" );	
	update_comment_cache( $comments );
	
	if( $parent_id ) {
		return $comments;
	}
	
	// all total
	$query_total = "FROM $wpdb->comments c WHERE 1=1 $query_post_id $typesql
		$approved";
	$total = $wpdb->get_var( "SELECT COUNT(c.comment_ID) $query_total" );

	// root total
	$root_total = $wpdb->get_var( "SELECT COUNT(c.comment_ID) $query" );

	return array( $comments, $total, $root_total );
}

/**
 * Template for comments and pingbacks.
 *
 */
function tgt_show_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	global $helper, $user_ID, $current_user;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment-box">
		<div class="avatar2 comment-col1">
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
				<br/>
				<?php echo date( 'M d, Y h:i A', strtotime( $comment->comment_date_gmt ) ); ?> </p>
		</div>
		<div class="comment-col2">
			<div class="comment-text" style="">
				<p>
					<?php if( $comment->comment_approved == 1 ) { ?>
						<?php echo htmlspecialchars( $comment->comment_content ); ?>
					<?php } elseif( $comment->comment_approved == 0 ) { ?>
						<strong><?php _e( 'This\'s awaiting moderation:', 're' );?> " </strong><i><?php echo htmlspecialchars( $comment->comment_content ); ?></i> <strong>"</strong>
					<?php } ?>
				</p>       	
			</div>			
			<form id="submit_comment_product" action="" method="post">
			<div class="reply-form child" id="child_reply_form_<?php echo $comment->comment_ID; ?>" style="display:none;" > 
				<h3 class="comment-title"><?php  _e('Write your comment','re') ?></h3>                                   
				<div id="comment_error" class="red"></div>
				<?php if($user_ID < 1) { ?>
				<div id="review-form">
					<p style="margin: 20px 0 0px 5px">
						<label for=""><strong> <?php _e('Your information','re') ?>  </strong><span class="red">*</span></label>
					</p>
					<div id="review_username" class="review-input">
						<label class="review-label" for="" <?php if (!empty($review['username']) ) echo 'style="display:none;"' ?>><strong> <?php _e('Your name','re')?> </strong></label>
						<input type="text" name="user_name" id="user_name" class="review-text"/>
						<span class="red">*</span>
						<div id="review_username_tooltip" class="review-tooltip" style="display: none;top: -10px">
							<div>
								<?php _e('Your name will be displayed on your comment.','re');?>
							</div>
						</div>
					</div>
					<div id="review_email" class="review-input">
						<label class="review-label" for="" <?php if (!empty($review['user_email']) ) echo 'style="display:none;"' ?>><strong> <?php _e('Your email','re')?> </strong></label>
						<input type="text" name="user_email" id="user_email" class="review-text"/>
						<span class="red">*</span>
						<div id="review_useremail_tooltip" class="review-tooltip" style="display: none;top: 0px">
							<div>
								<?php _e('Your email for display author email','re');?>
							</div>
						</div>
					</div>													
				</div>
				<?php } ?>												
				<div id="review-form">      							  
					<p style="margin: 20px 0 0px 5px">
						<label for=""><strong> <?php _e('Comment ','re') ?>  </strong><span class="red">*</span></label>									
					</p>
					<div id="review_pro" class="review-input">								  
						<textarea class="comment-text" name="comment_pro"  cols="30" rows="15" maxlength="<?php echo $limitation['pro']?>"></textarea>									  
					</div>		
					<div class="butt_search" style="margin-top:15px; float:left;">  
						<div class="butt_search_left"></div>        
							<div class="butt_search_center">
								<input type="hidden" name="parent_id" value="<?php echo $comment->comment_ID; ?>"/>
								<input type="submit" name="submit_comment" class="button" value="<?php _e('Submit','re'); ?>" />
							</div>
						<div class="butt_search_right"></div>
					</div>
				</div>
			</div>
			</form>
			<!-- Comment Reply -->
			<div id="comment-form-<?php echo $comment->comment_ID;?>" style="display:none; width: 552px; float:left; padding-left: 20px;" ></div>
			<!-- // Comment Reply -->
			<!-- Comment Button -->
			<div id="butt_<?php echo $comment->comment_ID;?>" class="butt" style="float:left;">
				<input type="button" value="<?php _e( 'Reply', 're' );?>" onclick="show_reply_form( '<?php echo $comment->comment_ID;?>' );" id="reply_button_<?php echo $comment->comment_ID;?>" class="reply button"/>
				<input type="button" value="<?php _e( 'Cancel', 're' );?>" style="display:none;" onclick="show_reply_form('0');" id="cancel_button_<?php echo $comment->comment_ID;?>" class="cancel button"/>
			</div>
					<div class="clear"></div>
			<!-- // Comment Button -->
		</div>
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
function tgt_comment_id_fields_comment($post) {
	global $post;
	//$result  = "<input type='hidden' name='comment_post_ID' value='" . $article_query[ 'id' ] . "' id='comment_post_ID' />\n";
	//$result .= "<input type='hidden' name='comment_parent' id='comment_parent' value='" . $article_query['replytoid'] . "' />\n";
	//$result .= "<input type='hidden' name='redirect_to' id='redirect_to' value='" . HOME_URL ."/?article=" . $article_query[ 'post_name' ] . "' />\n";
	return $post;
}
