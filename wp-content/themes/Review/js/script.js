jQuery(document).ready(function(){
	jQuery('.widget-user-thumb').each(function(){ 
		var current 	= jQuery(this),
			target 		= current.find('input[name=popup_id]'),
			target_id	= target.val(),
			thumbnail 	= current.find('img.user-thumbnail');
			
		if ( target.length > 0 )
		{
			current.tooltip({effect: 'slide', tip: target_id, delay: 100, offset: [15, 0]});
		}
	});
	
	jQuery('#cat_sort_type').change(function(){
		var current 	= jQuery(this),
			value 		= current.val();
			form 			= jQuery('#category_sort_form');
			sort_type 	= form.find('input[name=sort_type]');
			filter 		= form.find('input[name=filter]');
		
		sort_type.val( value );
		form.submit();
	})
	
	// show children category
	jQuery('.sidebar-widget ul li').each(function(){
		var element = jQuery(this);
		var children = element.find('ul.children');
		var container = element.parent();
		
		element.hover(function(){
			children.slideDown();
		});
		
		container.hover(function(){}, function(){
			children.slideUp();
		});
	});
	
	// when click on review tab
	jQuery('.tab_link ul li a, .go_review').click(function(){
		var target = jQuery( jQuery(this).attr('href') );
		
		jQuery('.review_tab_content').hide();
		jQuery('.tab-item').removeClass('select');
		if ( jQuery(this).hasClass('go_review') )
			jQuery('#tab_write').addClass('select');
		else
			jQuery(this).parent().addClass('select');
		
		target.show();
		jQuery('html, body').animate({ 'scrollTop' : jQuery('.tab').offset().top  }, 'slow');
		return false;
	});
});

function validateEmail(str) {
    var at="@";
    var dot=".";
    var lat=str.indexOf(at);
    var lstr=str.length;
    var ldot=str.indexOf(dot);
    if (str.indexOf(at)==-1){
       return false;
    }

    if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
       return false;
    }

    if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
        return false;
    }

     if (str.indexOf(at,(lat+1))!=-1){
        return false;
     }

     if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
        return false;
     }

     if (str.indexOf(dot,(lat+2))==-1){
        return false;
     }

     if (str.indexOf(" ")!=-1){
        return false;
     }

     return true;
}

/**
 * cookie
 */
jQuery.setCookie = function(name, value, hours ){
	if (hours) {
		var date = new Date();
		date.setTime(date.getTime()+(hours*60*60*1000));
		var expires = ";expires="+date.toUTCString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+";path=/";
	return value;
}
jQuery.getCookie = function( name ){
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
jQuery.deleteCookie =  function(name){
	jQuery.setCookie(name,"",-1);
}

var $elem = jQuery('html');
$elem.attr('style', 'margin-top: 0px !important');
