<div class="box_search" style="position: relative">
	<form action="<?php echo HOME_URL; ?>" method="get">
	<input type="hidden" name="s" id="s" value="search"/>
	<input style="position:absolute; left:0px;" type="text" size="29px" name="key" id="key" autocomplete="off" <?php if( isset( $_GET['key'] ) ) echo 'value="' . $_GET['key'] . '"' ?> />
	<input type="hidden" id="ready_status" value="1"/>
	<?php
	if(isset($_GET['type']) && $_GET['type'] == 'article')
		echo '<input type="hidden" name="type" value="article"/>';
	?>
		<div id="combo" class="combo">
			<div id="all_hover" class="all choose_topic">
				<p>
					<?php echo $helper->link( '<label style="cursor:pointer;" id="topic_title">'.__('All Topics', 're').'</label> '. $helper->image('li_arrow31.png', 'All Topic', array('style'=> 'padding-top:10px;')) , null , array('style'=>'cursor:pointer;') ) ?>
				</p>
			</div>
			<div class="topic_hover">
				<div class="all_hover">
					<p>
						<?php echo $helper->link( '<label style="cursor:pointer;" id="topic_title">'.__('All Topics', 're').'</label> '. $helper->image('li_arrow31.png', 'All Topic', array('style'=> 'padding-top:10px;')) , null, array('style'=>'cursor:pointer;') ) ?>											
					</p>
				</div>
				<div class="combo_box">
					<div id="combobox_desc">
						<strong style="cursor:pointer;"><?php _e('All Topics','re'); ?></strong>
					</div>
					<ul class="topics-list">					
					<?php
					if($main_category != '')
					{
						foreach ($main_category as $main)
						{
							$key_word_main = str_replace('','+',$main->name);
							$main_id = $main->term_id;
							echo '<li class="category_item"><input type="checkbox" class="category_checkbox" id="category[]" name="category[]" value="'.$main_id.'" />';
							echo '<a href="javascript:void(0)">'.$main->name.'</a>';
							echo '</li>';
							$args = array(
									'type'                     => 'post',
									'child_of'                 => $main->term_id,
									'orderby'                  => 'slug',
									'order'                    => 'ASC',
									'hide_empty'               => 0,
									'hierarchical'             => 1,
									'pad_counts'               => false );
							$sub_cate = get_categories($args);
							if($sub_cate != '')
							{
								echo '<ul>';
								foreach ($sub_cate as $sub)
								{
									$key_word_sub = str_replace('','+',$sub->name);
									$sub_id = $sub->term_id;
									echo '<li class="category_item"><input type="checkbox" class="category_checkbox" id="category[]" name="category[]" value="'.$sub_id.'" />';
									echo '<a href="javascript:void(0)">'.$sub->name.'</a>';
									echo '</li>';
								}
								echo '</ul>';
							}
						}
					}
					?>				
					 </ul>
				</div>
			</div>
		</div>
	    
		<input style="position:absolute; right: 17px;" type="submit" class="butt" value=""/>
	</form>
	<div id="suggest" class="suggest-product" style="display: none">
		<div id="suggest-content">
			<input type="hidden" id="current-suggest" value="-1" />
			<ul class="suggest-list"><li></li></ul>
			<script type="text/javascript">
				//jQuery('.star-disabled').rating();
			</script>
		</div>
	</div>
</div>

<div class="ava_search">
	<?php if (get_option(SETTING_TIPS_SEARCH) != ' ' ){ 
		echo '<p>'.get_option(SETTING_TIPS_SEARCH).'</p>';		
	}else { ?>
	<p><?php _e('e.g. ','re'); ?>  "<label style="color:#7C8C8C;font:10px verdana;"><?php _e('Apple Macbook Pro','re'); ?>", "</label><label style="color:#7C8C8C;font:10px verdana;"><?php _e('Canon EOS 60D','re'); ?></label>", <?php _e(' etc.','re'); ?></p>
	<?php } ?>
</div>
<script type="text/javascript">

jQuery(document).ready(function(){	
	
	jQuery('.topics-list li').each(function(){
		var element = jQuery(this);
		var link = element.find('a');
		var checkbox = element.find('input[type=checkbox]');
		
		link.click(function(){
			if ( !checkbox.is(':checked') )
				checkbox.attr('checked', 'checked');
			else
				checkbox.removeAttr('checked', 'checked');
		});
	});
	
	jQuery('.combo').each(function(){
		var container = jQuery(this);
		var normal = container.find('.choose_topic');
		var hover = container.find('.topic_hover');
		
		container.find('.all a, .all_hover a').click(function(){return false})
		
		normal.hover(function(){
			hover.show();
		});
		hover.hover(function(){}, function(){
			jQuery(this).hide();
		});
	});
	
	jQuery('#combo').mouseleave(function(){
		if(jQuery('#all_hover').hasClass('all_hover'))
		{
			jQuery('#all_hover').removeClass("all_hover");
			jQuery('#all_hover').addClass("all");		
			jQuery('.combo_box').hide();
		}
    });
	
	jQuery('.combo').blur(function(){
		if( jQuery('#all_hover').hasClass('all_hover') ){
			jQuery('#all_hover').removeClass("all_hover");
			jQuery('#all_hover').addClass("all");		
			jQuery('.combo_box').hide();
		}
		return false;
	});

	jQuery('body').click(function() {
		jQuery('#suggest').fadeOut( 500 );
    	jQuery( '#current-suggest' ).val( '-1' );
    	jQuery('.suggest-list').html( '' );
	});
<?php 
$enable = (int) get_option( SETTING_ENABLE_AUTOCOMPLETE );
if( $enable ) {
?>
	// ajax get products here
	if (jQuery.browser.mozilla) {
	    jQuery('input[name=key]').keypress( checkKey );
	} else {
	    jQuery('input[name=key]').keydown( checkKey );
	}

	jQuery('input[name=key]').keyup(function(){
		var readyStatus = jQuery( '#ready_status' ).val( );
		if ( readyStatus == 1 ) {
			processRequest();
		}
	});

	jQuery('input[name=key]').focus();
});

function processRequest() {
	// create static variable
	if ( typeof processRequest.data == 'undefined' ) {
		processRequest.data = [];
	} 

	// create request function
	var request = function() {
		var ajaxListProductsUrl = '<?php echo HOME_URL . '/?do=ajax&to=1' ?>';
		var matchingText = jQuery('input[id=key]').val();
		var catText = jQuery('input[id="category[]"]:checked');
		var cat = new Array();
		
		for ( var i = 0, j = catText.length; i < j ; i++ ) {
			cat.push( jQuery(catText[i]).val() );
		}
		
		if ( matchingText == '' || matchingText == null ) {
			jQuery('#suggest').fadeOut( 500 );
			jQuery('.suggest-list').html( '' );	
		} else {
			// send ajax request
			jQuery.ajax({
				type: 'post',
				url : reviewAjax.ajaxurl,
				data: {
					action: 'auto_complete',
					s: matchingText,
					cat: cat
				},
				beforeSend: function() {
				},
				success: function(data){
					if ( data.success ){
						var products = data.para;

						if ( products.length == 0 ) {
							jQuery('#suggest').fadeOut( 500 );
							jQuery('.suggest-list').html( '' );
							return;
						}
						var elements = '';
						// create list product
						for( var i = 0; i < products.length; i++ ) {
							var rating_message = display_rating( products[i].rating, 'suggest-rating-' + i );
							elements += ''
							+ '<li id="suggest-item-' + i + '" class="suggest-item" onmouseover="changeStatus(' + i + ')" onclick="redirectToProduct(' + i + ')">'
								+ '<img class="si-image" src="' + products[i].thumb +  '" alt="' + products[i].post_title + '"/>'
								+ '<p class="si-title"><span ">' + products[i].post_highlight + '</span></p>'
								+ '<div class="si-rating">'
								+ rating_message
								+ '</div>'
								+ '<div class="si-tags">' 
									+ '<span class="tags-list">';
									var tags = products[i].tags;
									for( var j =0; j < tags.length; j++ ) {
										if ( j != 0 ) {
											elements += ', ' + tags[j];
										} else {
											elements += tags[j];
										}
									}
								elements += '</span></div>'
								+ '<input type="hidden" id="guid-' + i + '" value="' + products[i].permalink + '" />'
								+ '<div class="clear"></div>'
							+ '</li>';
						}
						jQuery('.suggest-list').html( elements );
						
						jQuery('#suggest').fadeIn( 200 );

						jQuery('.star-disabled').rating();
					}
				}
			});
		}		
	}

	// hook request to functions
	processRequest.data.push( request );

	// call hook request
	setTimeout( function(){
		if ( processRequest.data.length == 0 ) {
			return;
		}
		// call function
		(processRequest.data.shift())();
		// reset functions
		processRequest.data = [];
	}, 1000 );
}

function display_rating( rating, name ){
	var disable = true;
	var rclass = "star-disabled";
	var title = "";
	var message = "";
	
	var round = parseInt( Math.round( rating ) );
	var width = round * 10;
	
	message = '<div class="rating_star" title="' + ratingTitles[round] + '">\
		<div class="amount" style="width:'+ width +'%"></div>\
	</div>';
	
	for( var i = 1; i <= 10; i++ ) {
		var check = "";
		if ( i == round ) {
			check = "checked='checked'";
		}

		var readonly = '';
		if ( disable ) {
			readonly = "disabled='disabled'";
		}
		
		if ( title == "" ) {
			switch ( round ){
				case 1: 
					title = "<?php _e( 'Abysmal' , 're' ); ?>";
					break;
				case 2:
					title = "<?php _e( 'Terrible' , 're' ); ?>";
					break;
				case 3: 
					title = "<?php _e( 'Poor' , 're' ); ?>";
					break;
				case 4: 
					title = "<?php _e( 'Mediocre' , 're' ); ?>";
					break;
				case 5: 
					title = "<?php _e( 'OK' , 're' ); ?>";
					break;
				case 6: 
					title = "<?php _e( 'Good' , 're' ); ?>";
					break;
				case 7: 
					title = "<?php _e( 'Very Good' , 're' ); ?>";
					break;
				case 8: 
					title = "<?php _e( 'Excellent' , 're' ); ?>";
					break;
				case 9: 
					title = "<?php _e( 'Outstanding' , 're' ); ?>";
					break;
				case 10: 
					title = "<?php _e( 'Spectacular' , 're' ); ?>";
					break;
				default:
					title = "<?php _e( 'Not rating yet' , 're' );?>";
					break;
			}
		}
		//message += "<input title='" + title + "' type='radio' name='" + name + "' class='" + rclass + " {split:2}' value='" + i + "' " + readonly + "  " + check + "/>";
	}
	return message;
}

function changeStatus( id ) {
	jQuery( '#ready_status' ).val( -1 );
	jQuery( '#current-suggest' ).val( id );
	jQuery( '.suggest-item' ).attr( 'class', 'suggest-item' );
	jQuery( '#suggest-item-' + ( id ) ).attr( 'class', 'suggest-item selected' );
}

function redirectToProduct( id ) {
	var url = jQuery( '#guid-' + id ).val();   
	jQuery( location ).attr( 'href', url );
}

function checkKey( e ){
	var currentSuggest = jQuery( '#current-suggest' ).val( );
	
	switch ( e.keyCode ) {
		// key down
	    case 40:
	    	jQuery( '#ready_status' ).val( -1 );
	    	if ( currentSuggest == 4 ) {
	    		jQuery( '#current-suggest' ).val( -1 );
	    		jQuery( '.suggest-item' ).attr( 'class', 'suggest-item' );
		    	break;
	    	}
	    	jQuery( '#current-suggest' ).val( parseInt( currentSuggest ) + 1 );
	    	jQuery( '.suggest-item' ).attr( 'class', 'suggest-item' );
	    	jQuery( '#suggest-item-' + ( parseInt( currentSuggest ) + 1 ) ).attr( 'class', 'suggest-item selected' );
	        break;
	        
		// key right
	    case 37:
	    	jQuery( '#ready_status' ).val( -1 );
		    break;
		    
	    // key up
	    case 38:
	    	jQuery( '#ready_status' ).val( -1 );
	    	if ( currentSuggest == -1 ) {
	    		jQuery( '#current-suggest' ).val( 5 );
	    		jQuery( '.suggest-item' ).attr( 'class', 'suggest-item' );
	    		break;
	    	}
	    	jQuery( '#current-suggest' ).val( parseInt( currentSuggest ) - 1 );
	    	jQuery( '.suggest-item' ).attr( 'class', 'suggest-item' );
	    	jQuery( '#suggest-item-' + ( parseInt( currentSuggest ) - 1 ) ).attr( 'class', 'suggest-item selected' );
	        break;
	        
		// key left
	    case 37:
	    	jQuery( '#ready_status' ).val( -1 );
		    break;
		// enter key
	    case 13:
	    	jQuery( '#ready_status' ).val( -1 );
	    	var url = jQuery( '#guid-' + currentSuggest ).val();   
	    	jQuery( location ).attr( 'href', url );
	    	if ( currentSuggest != -1 ) {
	    		return false;
	    	}
		    break;
		    
	    default:
	    	jQuery( '#ready_status' ).val( 1 );
		    break;
	}    
}
<?php } else {
?>
	jQuery('input[name=key]').focus();
});
<?php }?>
</script>