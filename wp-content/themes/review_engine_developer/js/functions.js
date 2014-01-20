/**
 *
 *
 */
function NumbersPrice(e)
{
	var keynum;
	var keychar;
	var numcheck = new RegExp("^[^a-z^A-Z]");
	
	if(window.event) // IE
		{
		keynum = e.keyCode;
		}
	else if(e.which) // Netscape/Firefox/Opera
		{
		keynum = e.which;
		}
	keychar = String.fromCharCode(keynum);	
	return numcheck.test(keychar);
}

/**
 * tooltip for the form. When focus in the input, tooltip appear
 * @author: toannm
 */
	function applyTooltip(parentClass, labelClass, targetClass){
		jQuery('.' + parentClass ).focusin(function(){
			jQuery(this).parent().find('.' + labelClass).hide();
			jQuery('.' + targetClass).hide();
			jQuery(this).parent().find('.' + targetClass).show();
		});
		
		jQuery('.' + parentClass).focusout(function(){
			jQuery(this).parent().find('.' + targetClass).hide();
			if (jQuery(this).val() == '')
				jQuery(this).parent().find('.' + labelClass).show();
		});
	}	
	
function ismaxlength(obj){
	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
	if (obj.getAttribute && obj.value.length>mlength)
	obj.value=obj.value.substring(0,mlength)
}