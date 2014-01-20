/*!
 * Review Engine Script v1.0.0
 */

jQuery(document).ready(function($){
	//enable toolip
	tooltip_initialize();
	group_initialize();
	
	//
	jQuery('.sortable-list').sortable();
	jQuery('.sortable-list').disableSelection();
});

function tooltip_initialize()
{
	jQuery(".tooltip").simpletooltip({click: true});
}

function group_initialize()
{
	var form_group = jQuery('#form_group'),
		button_open_group = jQuery('#open_group'),
		button_close_group = form_group.find('.close_group');
		
	form_group.hide();
	jQuery('#open_group').click(function(){
		form_group.slideDown();
		return false;
	});
	
	button_close_group.click(function(){
		form_group.slideUp();
		return false;
	});
	
	jQuery('.list-item').each(function(){
		var current = jQuery(this),
			trigger = current.find('.list-toggle'),
			content = current.find('.list-content');
			del_button = current.find('.control-delete');
		
		// first, hide all the content
		content.hide();
		
		// trigger the group content
		trigger.toggle(function(){
				content.slideDown();
			}, function(){
				content.slideUp();
			} );
		
//		del_button.click(function(){
//			if ( confirm('Are you really want to remove this item?') )
//				current.fadeOut('1000' , function(){ $(this).remove() });
//			return false;
//		});
	});
	
	jQuery('.group-item').each(function(){
		var current 		= jQuery(this),
			control 			= current.find('.item-controls'),
			title 			= current.find('.item-title'),
			field 			= current.find('.item-field'),
			control_edit 	= current.find('.item-controls-edit'),
			button_edit 	= control.find('.item-control-edit'),
			button_delete 	= control.find('.item-control-delete'),
			button_ok 		= control_edit.find('.item-control-edit'),
			button_cancel 	= control_edit.find('.item-control-cancel');
		
		current.hover(function(){
			if ( !current.hasClass('editting') )
				control.show();
		}, function(){
			if ( !current.hasClass('editting') )
				control.hide();
		})
		
		control.hide();
		control_edit.hide();
		field.hide();
		
		button_edit.click(function(){
			control.hide();
			control_edit.show();
			title.hide();
			field.show();
			current.addClass('editting');
			return false;
		})
		button_cancel.click(function(){
			control.show();
			control_edit.hide();
			title.show();
			field.hide();
			current.removeClass('editting');
			return false;
		})
		
	});
	
	jQuery('.new-group-value').each(function(){
		var current 		= jQuery(this),
			group_control 	= current.find('.group-value-control'),
			button_open 	= current.find('.group-value-open'),
			button_delete 	= current.find('.item-control-delete'),
			button_edit		= current.find('.item-control-edit'),
			button_close 	= current.find('.group-value-close'),
			form 				= current.find('.form-group-value');
		
		form.hide();
		button_open.click(function(){
			form.slideDown();
			group_control.hide();
			button_open.hide();
			button_delete.hide();
			button_edit.hide();
			return false;
		});
		button_close.click(function(){
			form.slideUp('normal', function(){button_open.show(); button_delete.show(); button_edit.show(); group_control.show(); } );			
			return false;
		});
	})
}