/**
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/
jQuery(document).ready(function() {
	jQuery('#attach_btn').click(function(){
		jQuery.post("attachment.php",{ op: "select_plugin"},
			function(data){
				jQuery('body').append('<div id="imfaq_addattachments_container" title="'+_AM_IMFAQ_FAQ_ATTACH+'">'+data+'</div>');
				jQuery("#imfaq_addattachments_container").dialog({ 
					width: 800,
					height: 700,
					draggable: true,
					buttons: { Cancel: function() { jQuery(this).dialog("close"); } },
					beforeclose: function(event, ui) { jQuery('#imfaq_addattachments_container').remove(); }	 
				});
			}
		);
	});
	
	var url = window.location.href;
	if (url.match(/auto_attach/gi) != null){
		jQuery('#attach_btn').click();
	}
	
	jQuery('#cancel_button').attr('onclick','');
	
	jQuery('#cancel_button').click(function(){
		var new_attachments = jQuery("input[name='faq_attachments']").val().split("|");
		var faq_id = jQuery("input[name='faq_id']").val() != ''?jQuery("input[name='faq_id']").val():0;

		if (faq_id == 0 && new_attachments.length > 1){
			
			jQuery('body').append('<div id="dialog_msg" title="'+_AM_IMFAQ_ATTACH_WARNING+'">'+_AM_IMFAQ_ATTACH_WARNING_HAS_ATTACH+'</div>');
			jQuery("#dialog_msg").dialog({ 
				modal: true,
				buttons: { 
					Delete: function() { 
						for ( key in new_attachments ) {
							var item = new_attachments[key];
							jQuery.post("attachment.php",{ attach_id: item, op: "remove"},
								function(data){
									if (data == '1'){
										jQuery("#attachment_"+item).remove();
									}
								}
							);
						}
						jQuery(this).dialog("close");
						history.go(-1);
					},
					Cancel: function() { jQuery(this).dialog("close"); return false; }
				},
				beforeclose: function(event, ui) { jQuery('#dialog_msg').remove(); }	 
			});
		}else{
			history.go(-1);
		}
	});
	
	jQuery(".delete_attachment").css('cursor','pointer');
	jQuery(".delete_attachment").click(function(){
		var attachment_id = jQuery(this).attr('id');
		delete_attachment(attachment_id);
	});
	
	jQuery(".show_hide_attachment").css('cursor','pointer');
	jQuery(".show_hide_attachment").click(function(){
		var id = jQuery(this).attr('id');
		id = id.substr(3);
		var attach_fid = jQuery("#attach_fid").val();
		show_hide_attachment(attach_fid, id);
	});
	
	jQuery(".sort_attachment").css('cursor','move');
	jQuery("#uplist").sortable({ 
	    handle : '.sort_attachment', 
	    update : function () {
			var attach_fid = jQuery("#attach_fid").val();
			var order = $('#uplist').sortable('serialize');
			sort_attachments (attach_fid, order);
	    }
	});
	
});

function sort_attachments (attach_fid, order) {
	jQuery.post("attachment.php?"+order,{ attach_fid: attach_fid, op: "sort_attachments" },
		function(data, textStatus, XMLHttpRequest){
			data = jQuery.evalJSON(data);
			var ids = data['ids'];
			jQuery("input[name='faq_attachments']").val(ids);
			jQuery('#uplist').html('');
			jQuery.each(data['attach_ids'],function(i, val) {
				var html  = '<li id="attachment_' +i+ '">';
					html += ' <a href="'+data[val]['attach_url']+'" target="_blank">'+data[val]['attach_title']+'</a>';
					html += ' <img class="sort_attachment" src="'+ICMS_URL+'/modules/imfaq/images/arrow.png" width="10" alt="'+_AM_IMFAQ_ATTACHMENT_SORT+'" title="'+_AM_IMFAQ_ATTACHMENT_SORT+'" />';
					html += ' <img class="show_hide_attachment" id="sh_' +data[val]['attach_id']+ '" src="'+ICMS_URL+'/modules/imfaq/images/'+(data[val]['attach_status'] == 1?'hide':'show')+'.gif" width="12" alt="'+(data[val]['attach_status'] == 1?_AM_IMFAQ_ATTACHMENT_HIDE:_AM_IMFAQ_ATTACHMENT_SHOW)+'" title="'+(data[val]['attach_status'] == 1?_AM_IMFAQ_ATTACHMENT_HIDE:_AM_IMFAQ_ATTACHMENT_SHOW)+'" />';
					html += ' <img class="delete_attachment" id="' +data[val]['attach_id']+ '" src="'+ICMS_IMAGES_SET_URL+'/actions/button_cancel.png" width="10" alt="'+_AM_IMFAQ_ATTACHMENT_DELETE+'" title="'+_AM_IMFAQ_ATTACHMENT_DELETE+'" />';
					html += '</li>';
				jQuery('#uplist').append(html);
		    });
			jQuery(".sort_attachment").css('cursor','move');
			jQuery(".show_hide_attachment").css('cursor','pointer');
			jQuery(".delete_attachment").css('cursor','pointer');
			jQuery(".delete_attachment").click(function(){
				var attachment_id = jQuery(this).attr('id');
				delete_attachment(attachment_id);
			});
			jQuery(".show_hide_attachment").click(function(){
				var id = jQuery(this).attr('id');
				id = id.substr(3);
				var attach_fid = jQuery("#attach_fid").val();
				show_hide_attachment(attach_fid, id);
			});
	 	}
	);
}

function show_hide_attachment (attach_fid, attach_id) {
	jQuery.post("attachment.php",{ attach_fid: attach_fid, attach_id: attach_id, op: "show_hide_attachments" },
		function(data, textStatus, XMLHttpRequest){
			data = jQuery.evalJSON(data);
			var ids = data['ids'];
			jQuery("input[name='faq_attachments']").val(ids);
			jQuery('#uplist').html('');
			jQuery.each(data['attach_ids'],function(i, val) {
				var html  = '<li id="attachment_' +i+ '">';
					html += ' <a href="'+data[val]['attach_url']+'" target="_blank">'+data[val]['attach_title']+'</a>';
					html += ' <img class="sort_attachment" src="'+ICMS_URL+'/modules/imfaq/images/arrow.png" width="10" alt="'+_AM_IMFAQ_ATTACHMENT_SORT+'" title="'+_AM_IMFAQ_ATTACHMENT_SORT+'" />';
					html += ' <img class="show_hide_attachment" id="sh_' +data[val]['attach_id']+ '" src="'+ICMS_URL+'/modules/imfaq/images/'+(data[val]['attach_status'] == 1?'hide':'show')+'.gif" width="12" alt="'+(data[val]['attach_status'] == 1?_AM_IMFAQ_ATTACHMENT_HIDE:_AM_IMFAQ_ATTACHMENT_SHOW)+'" title="'+(data[val]['attach_status'] == 1?_AM_IMFAQ_ATTACHMENT_HIDE:_AM_IMFAQ_ATTACHMENT_SHOW)+'" />';
					html += ' <img class="delete_attachment" id="' +data[val]['attach_id']+ '" src="'+ICMS_IMAGES_SET_URL+'/actions/button_cancel.png" width="10" alt="'+_AM_IMFAQ_ATTACHMENT_DELETE+'" title="'+_AM_IMFAQ_ATTACHMENT_DELETE+'" />';
					html += '</li>';
				jQuery('#uplist').append(html);
		    });
			jQuery(".sort_attachment").css('cursor','move');
			jQuery(".show_hide_attachment").css('cursor','pointer');
			jQuery(".delete_attachment").css('cursor','pointer');
			jQuery(".delete_attachment").click(function(){
				var attachment_id = jQuery(this).attr('id');
				delete_attachment(attachment_id);
			});
			jQuery(".show_hide_attachment").click(function(){
				var id = jQuery(this).attr('id');
				id = id.substr(3);
				var attach_fid = jQuery("#attach_fid").val();
				show_hide_attachment(attach_fid, id);
			});
	 	}
	);
}

function add_module_list(value,start,query){
	jQuery.post("attachment.php",{ op: "list_module_items", module: value, start: start, query: query},
		function(data){
			jQuery('#imfaq_addattachments_module_list').remove();
			jQuery("#imfaq_addattachments_container").append('<div id="imfaq_addattachments_module_list">'+data+'</div>');
		}
	);
}

function getPagenavClick(obj,module,query) {
	var href = jQuery(obj).attr('href');
	
	href = href.split('?');
	
	href = href[1].split('=');
		
	add_module_list(module,href[1],query);
	
	return false;
}

function attach_items(module){
	
	var attach_fid = jQuery("#attach_fid").val();
	
	if (jQuery('#imfaq_addattachments_module_list form input:checkbox:checked').length == 0){
		jQuery('body').append('<div id="dialog_msg" title="'+_AM_IMFAQ_ATTACH_WARNING+'">'+_AM_IMFAQ_ATTACH_WARNING_MSG+'</div>');
		jQuery("#dialog_msg").dialog({ 
			modal: true,
			buttons: { Ok: function() { jQuery(this).dialog("close"); } },
			beforeclose: function(event, ui) { jQuery('#dialog_msg').remove(); }	 
		});
		return false;
	}
	
	var Status = '';
	
	jQuery('#imfaq_addattachments_module_list form input:checkbox:checked').each(function (){
		var attach_itemid = jQuery(this).val();
		jQuery.post("attachment.php",{ attach_fid: attach_fid, op: "addattachments", attach_module: module, attach_itemid: attach_itemid },
			function(data, textStatus, XMLHttpRequest){
				data = jQuery.evalJSON(data);
				var ids = data['ids'];
				jQuery("input[name='faq_attachments']").val(ids);
				var html  = '<li id="attachment_' +data[attach_itemid]['attach_id']+ '">';
					html += ' <a href="'+data[attach_itemid]['attach_url']+'" target="_blank">'+data[attach_itemid]['attach_title']+'</a>';
					html += ' <img class="sort_attachment" src="'+ICMS_URL+'/modules/imfaq/images/arrow.png" width="10" alt="'+_AM_IMFAQ_ATTACHMENT_SORT+'" title="'+_AM_IMFAQ_ATTACHMENT_SORT+'" />';
					html += ' <img class="show_hide_attachment" id="sh_' +data[attach_itemid]['attach_id']+ '" src="'+ICMS_URL+'/modules/imfaq/images/'+(data[attach_itemid]['attach_status'] == 1?'hide':'show')+'.gif" width="12" alt="'+(data[attach_itemid]['attach_status'] == 1?_AM_IMFAQ_ATTACHMENT_HIDE:_AM_IMFAQ_ATTACHMENT_SHOW)+'" title="'+(data[attach_itemid]['attach_status'] == 1?_AM_IMFAQ_ATTACHMENT_HIDE:_AM_IMFAQ_ATTACHMENT_SHOW)+'" />';
					html += ' <img class="delete_attachment" id="' +data[attach_itemid]['attach_id']+ '" src="'+ICMS_IMAGES_SET_URL+'/actions/button_cancel.png" width="10" alt="'+_AM_IMFAQ_ATTACHMENT_DELETE+'" title="'+_AM_IMFAQ_ATTACHMENT_DELETE+'" />';
					html += '</li>';
				jQuery('#uplist').append(html);
				jQuery(".sort_attachment").css('cursor','move');
				jQuery(".show_hide_attachment").css('cursor','pointer');
				jQuery(".delete_attachment").css('cursor','pointer');
				jQuery(".delete_attachment").click(function(){
					var attachment_id = jQuery(this).attr('id');
					delete_attachment(attachment_id);
				});
				jQuery(".show_hide_attachment").click(function(){
					var id = jQuery(this).attr('id');
					id = id.substr(3);
					var attach_fid = jQuery("#attach_fid").val();
					show_hide_attachment(attach_fid, id);
				});
			 }
		);
	});
	jQuery("#imfaq_addattachments_container").dialog("close");
}

function delete_attachment(attach_id){
	jQuery('body').append('<div id="dialog_msg" title="'+_CO_ICMS_DELETE+'">'+printf(_CO_ICMS_DELETE_CONFIRM,jQuery("#attachment_"+attach_id+" a").text())+'</div>');
	jQuery("#dialog_msg").dialog({ 
		modal: true,
		buttons: { 
			Delete: function() {
				jQuery.post("attachment.php",{ attach_id: attach_id, op: "remove"},
					function(data){
						if (data == '1'){
							var ids = jQuery("input[name='faq_attachments']").val();
							ids = ids.split("|");
							for ( key in ids ) {
								if (ids[key] == attach_id){
									ids.splice(key, 1);
								}
							}
							jQuery("input[name='faq_attachments']").val(ids.join("|"));
							jQuery("#attachment_"+attach_id).remove();
						}
					}
				);
				jQuery(this).dialog("close"); 
			},
			Cancel: function() { jQuery(this).dialog("close"); return false; }
		},
		beforeclose: function(event, ui) { jQuery('#dialog_msg').remove(); }	 
	});
}

printf = function() {
	var num = arguments.length;
	var oStr = arguments[0];
	for ( var i = 1; i < num; i++) {
		var pattern = "%s";
		var re = new RegExp(pattern, "g");
		oStr = oStr.replace(re, arguments[i]);
	}
	return oStr;
}


/**
 * Function : dump()
 * Arguments: The data - array,hash(associative array),object
 *    The level - OPTIONAL
 * Returns  : The textual representation of the array.
 * This function was inspired by the print_r function of PHP.
 * This will accept some data as the argument and return a
 * text that will be a more readable version of the
 * array/hash/object that is given.
 * Docs: http://www.openjs.com/scripts/others/dump_function_php_print_r.php
 */
function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}