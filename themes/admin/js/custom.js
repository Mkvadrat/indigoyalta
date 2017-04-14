$(function () {

	// Preload images
	$.preloadCssImages();



	// CSS tweaks
	$('#nav').find('li:last').addClass('nobg');
	$('.block_head ul').each(function() { $('li:first', this).addClass('nobg'); });


	// Sort table
	$("table.sortable").tablesorter({
		headers: { 0: { sorter: false}, 5: {sorter: false} },		// Disabled on the 1st and 6th columns
		widgets: ['zebra']
	});

	
	$('.block').find('th.header').css('cursor', 'pointer');



	// Check / uncheck all checkboxes
	
	$('body').delegate('.check_all', 'click', function () {
		$(this).parents('form').find('input:checkbox').attr('checked', $(this).is(':checked'));
	});

	// Set WYSIWYG editor
	$('.wysiwyg').wysiwyg({css: site_url+"themes/admin/css/wysiwyg.css", brIE: false });

	$('.wysiwyg').wysiwyg("addControl",
		    "controlName",
		    {
		        icon: "/themes/admin/widgets/cal.jpg",
		        exec:  function() { alert('Hello World'); }
		    }
		);

	// Messages
	$('.block .message').hide().append('<span class="close" title="Dismiss"></span>').fadeIn('slow');
	$('.block .message .close').hover(
		function() { $(this).addClass('hover'); },
		function() { $(this).removeClass('hover'); }
	);

	$('.block .message .close').click(function() {
		$(this).parent().fadeOut('slow', function() { $(this).remove(); });
	});

	// Form select styling
//	$("form select.styled").select_skin();
	$('form select.styled, input[type=file]').fastinputs();

	// Tabs
	$(".tab_content").hide();
	$("ul.tabs li:first-child").addClass("active").show();
	$(".block").find(".tab_content:first").show();

	$("ul.tabs li").click(function() {
		var activeTab = $(this).find("a").attr("href");
		$(this).parent().find('li').removeClass("active");
		$(this).addClass("active");
		$(this).parents('.block').find(".tab_content").hide();
		
		$(activeTab).show();

		// refresh visualize for IE
		$(activeTab).find('.visualize').trigger('visualizeRefresh');

		return false;
	});

	// Sidebar Tabs
	$(".sidebar_content").hide();

	if(window.location.hash && window.location.hash.match('sb')) {

		$("ul.sidemenu li a[href="+window.location.hash+"]").parent().addClass("active").show();
		$(".block .sidebar_content#"+window.location.hash).show();
	} else {

		$("ul.sidemenu li:first-child").addClass("active").show();
		$(".block .sidebar_content:first").show();
	}

	$("ul.sidemenu li").click(function() {

		var activeTab = $(this).find("a").attr("href");
		window.location.hash = activeTab;

		$(this).parent().find('li').removeClass("active");
		$(this).addClass("active");
		$(this).parents('.block').find(".sidebar_content").hide();
		$(activeTab).show();
		return false;
	});

	// Block search
	$('.block .block_head form .text').bind('click', function() { $(this).attr('value', ''); });



	// Image actions menu
	$('ul.imglist li').hover(
		function() { $(this).find('ul').css('display', 'none').fadeIn('fast').css('display', 'block'); },
		function() { $(this).find('ul').fadeOut(100); }
	);

	// Date picker
	$('input.date_picker').date_input();

});

function strpos (haystack, needle, offset) {
	var i = (haystack+'').indexOf(needle, (offset || 0));
	return i === -1 ? false : i;
}

var bancha = {
	_priority : 0,
	load : function(url) {
		$.get(admin_url + url, function(data) {
			$('#content_wrapper').html(data);
		});
	},
	preset_url : function(path, preset, append) {
		//Prototype: attach/cache/type/field/id/preset/name.ext
		if (!append || append === 'undefined') {
			append = false;
		}
		var tmp = path.split('/'),
			i = tmp.length-1,
			path = 'attach/cache/' + tmp[i-3] + '/' + tmp[i-2] + '/' + tmp[i-1] + '/' + preset + '/' + tmp[i];
		return (append ? site_url : '') + path;
	},
	remove : {
		document : function(self, e) {
			var pr = $(self).closest('table').prev('div.limit.hidden');
			$.post(admin_url+'ajax/delete_document', {document_id : e});
			$(self).closest('tr').fadeOut(200);
			pr.removeClass('hidden');
			pr.prev('span.limit').fadeOut(200);
			return false;
		}
	},
	add_form_hash : function(el) {
		var obj = $(el),
			action = obj.attr('action'),
			attr;

		if (!action)return;

		if (strpos(action, '#')) {
			attr = action.split('#');
			attr = attr[0];
		} else {
			attr = action;
		}

		obj.attr('action', action + window.location.hash);
		return true;
	},
	sort_priority : function (event, ui) {
		var rows = $('tbody tr', $(ui.item[0]).closest('.sortable'));
		bancha._priority = rows.length;
		rows.each(function() {
			$('.tbl-priority', this).val(bancha._priority);
			bancha._priority--;
		});
	},
	check : {
		uri: function(e) {
			clearInterval(document._to);
			document._to=setTimeout(function(){bancha.check._triggers.uri(e);},1000);
		},
		_triggers : {
			uri : function(e) {
				$.post(admin_url+'ajax/can_use_uri', {uri : $(e).val(), id_record : $("input[name=id]").val()}, function(data) {
					if (data) {
						$(e).after('<div class="message errormsg">'+data+'</div>');
					} else {
						$('div.errormsg').remove();
					}
				});
			}
		}
	},
	tab_textarea : function(selector) {
		$(selector).keypress(function (e) {
		    if (e.keyCode == 9) {
		        var myValue = "\t",
		        	startPos = this.selectionStart,
		        	endPos = this.selectionEnd,
		        	scrollTop = this.scrollTop;
		        this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos,this.value.length);
		        this.focus();
		        this.selectionStart = startPos + myValue.length;
		        this.selectionEnd = startPos + myValue.length;
		        this.scrollTop = scrollTop;

		        e.preventDefault();
		    }
		});
	},
	actions : {
		record_act : function() {
			var val = $('select[name=action]').val(),
				list_fields = '.field-action_list_type, .field-action_list_categories, .field-action_list_limit, '
							+ '.field-action_list_order_by, .field-action_list_where, .field-action_list_has_feed, .field-action_list_hierarchies ',
				action_fields = '.field-action_custom_name, .field-action_custom_mode';
				link_fields = '.field-action_link_url',

				speed = 200;

			switch (val) {
				case 'text':
					$(list_fields).hide(speed);
					$(action_fields).hide(speed);
					$(link_fields).hide(speed);
					break;

				case 'list':
					$(list_fields).show(speed);
					$(action_fields).hide(speed);
					$(link_fields).hide(speed);
					$(link_fields).hide(speed, function(){
						//Temporary fix
						$('.cmf-skinned-text').css('height', '20px');
					});
					break;

				case 'action':
					$(action_fields).show(speed);
					$(list_fields).hide(speed);
					$(link_fields).hide(speed);
					break;

				case 'link':
					$(link_fields).show(speed);
					$(list_fields).hide(speed);
					$(action_fields).hide(speed);
					break;
			}
		},
		template_act : function() {
			var val = $('select[name=view_template]').val(),
				default_fields = '.field-separator_action, .field-action';
				list_fields = '.field-action_list_type, .field-action_list_categories, .field-action_list_limit, '
							+ '.field-action_list_order_by, .field-action_list_where, .field-action_list_has_feed, .field-action_list_hierarchies ';
				feedback_fields = '.field-template_feedback_email, .field-template_feedback_adress, .field-template_feedback_city, '
							+ '.field-template_feedback_region, .field-template_feedback_postcode, .field-template_feedback_country, .field-template_feedback_mobile, '
							+'.field-template_feedback_fixed, .field-template_feedback_fax, .field-template_feedback_website, .field-template_feedback_content';
				map_fields = '.field-template_map_content';
				fixedmap_fields = '.field-template_map_center, .field-template_map_marker';
				dinamap_fields = '.field-template_map_filter';
				orderform_fields = '.field-template_orderform_email',

				speed = 200;

			switch (val) {
				case 'default':
					$(default_fields).show(speed);
					if($('select[name=action]').val() == 'list'){
						$(list_fields).show(speed);
					}
					if($('select[name=action]').val() == 'text'){
						$(list_fields).hide(speed);
					}
					$(orderform_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(map_fields).hide(speed);
					$(dinamap_fields).hide(speed);
					$(fixedmap_fields).hide(speed);
					break;

				case 'homepage':
					$(default_fields).show(speed);
					if($('select[name=action]').val() == 'list'){
						$(list_fields).show(speed);
					}
					if($('select[name=action]').val() == 'text'){
						$(list_fields).hide(speed);
					}
					$(orderform_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(map_fields).hide(speed);
					$(dinamap_fields).hide(speed);
					$(fixedmap_fields).hide(speed);
					break;

				case 'realestate':
					$(default_fields).show(speed);
					if($('select[name=action]').val() == 'list'){
						$(list_fields).show(speed);
					}
					if($('select[name=action]').val() == 'text'){
						$(list_fields).hide(speed);
					}
					$(orderform_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(map_fields).hide(speed);
					$(dinamap_fields).hide(speed);
					$(fixedmap_fields).hide(speed);
					break;

				case 'signin':
					$(default_fields).hide(speed);
					$(list_fields).hide(speed);
					$(orderform_fields).hide(speed);
					$(map_fields).hide(speed);
					$(dinamap_fields).hide(speed);
					$(fixedmap_fields).hide(speed);
					$(feedback_fields).hide(speed);
					break;

				case 'map':
					$(map_fields).show(speed);
					if($('select[name=template_map_content]').val() == 'showfixedlocation'){
						$(fixedmap_fields).show(speed);
						$(dinamap_fields).hide(speed);
					}
					if($('select[name=template_map_content]').val() == 'listmapdata'){
						$(dinamap_fields).show(speed);
						$(fixedmap_fields).hide(speed);
					}
					$(feedback_fields).hide(speed);
					$(orderform_fields).hide(speed);
					$(default_fields).hide(speed);
					$(list_fields).hide(speed);
					break;

				case 'feedback':
					$(feedback_fields).show(speed);
					$(map_fields).hide(speed);
					$(dinamap_fields).hide(speed);
					$(fixedmap_fields).hide(speed);
					$(orderform_fields).hide(speed);
					$(list_fields).hide(speed);
					$(default_fields).hide(speed);
					break;

				case 'orderform':
					$(orderform_fields).show(speed);
					$(map_fields).hide(speed);
					$(dinamap_fields).hide(speed);
					$(fixedmap_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(default_fields).hide(speed);
					$(list_fields).hide(speed);
					break;

			}
		},
		mapfields_act : function() {
			var val = $('select[name=template_map_content]').val(),
				fixedmap_fields = '.field-template_map_center, .field-template_map_marker';
				dinamap_fields = '.field-template_map_filter';
				map_selector = '.field-template_map_content';

				speed = 200;

			switch (val) {

				case 'showfixedlocation':
					if($(map_selector).is(":visible")){
						$(fixedmap_fields).show(speed);
						$(dinamap_fields).hide(speed);
					}
					break;
				case 'listmapdata':
					if($(map_selector).is(":visible")){
					$(dinamap_fields).show(speed);
					$(fixedmap_fields).hide(speed);
					}
					break;

			}
		}
	},
	blocks : {
		_last_section : false,
		set_section : function(which) {
			bancha.blocks._last_section = which;
		},
		save_section : function(el) {
			var this_block = bancha.blocks._last_section,
				values = $(el + ' form').serialize();
			$(el + ' form').append('<input type="hidden" name="block" value ="'+this_block+'" />');
			
			values = values + '&theme=' + $('#add_section').attr('data-theme') + '&template='
				   + $('#add_section').attr('data-template');
			$('#cboxClose').click();
			$.post(admin_url + 'themes/add_section', values, function(data) {

				$(data).insertBefore($('.theme_block[data-name="'+this_block+'"]').children().last());

				$('#add_section input[type=text], #add_section select, #add_section textarea').val('');
				$('form input[name=block]').remove();
				bancha.blocks.load_sortable();
			});
		},
		delete_section : function(which) {
			var pos = $(which).parent('.section').attr('data-pos'),
				block = $(which).parent('.section').parent('.theme_block').attr('data-name');
			window.location.href = current_url + '?delete_section=' + pos + '&block=' + block;
		},
		load_sortable : function() {
			$('.theme_block').sortable({
				stop: function(event, ui) {
					bancha.blocks.sorted(event, ui);
				}
			});
		},
		sorted : function(event, ui) {
			var block = ui.item.parent('.theme_block'),
				block_name = block.attr('data-name'),
				str = '&theme=' + $('#add_section').attr('data-theme') + '&template='
					+ $('#add_section').attr('data-template'); + '&block=' + block,

				str = '&theme=' + $('#add_section').attr('data-theme') + '&template='
				   + $('#add_section').attr('data-template') + '&block=' + block_name;

			$('.section', block).each(function(index) {
				str = str + '&' + index + '=' + $(this).attr('data-pos');
			});
			$.post(admin_url + 'themes/reorder_block', str, function(data) {
				
			});
		}
	},
	relations : {
		load : function(relation_name, id_record, content_type) {
			$.post(admin_url + 'ajax/get_relation',
				{ name : relation_name, id : id_record, type : content_type },
				function(data) {
					$('.relation-'+relation_name).html(data);
			});
		}
	}
}

jQuery.extend(DateInput.DEFAULT_OPTS, { 
  	stringToDate: function(string) {
	    var matches;
	    if (local_date_format == 'd/m/Y') {
		    if (matches = string.match(/^(\d{2,2})\/(\d{2,2})\/(\d{4,4})$/)) { 
		      return new Date(matches[3], matches[2] - 1, matches[1]);
		    } else {
		      return null;
		    };
		} else {
			 if (matches = string.match(/^(\d{4,4})\/(\d{2,2})\/(\d{2,2})$/)) {
		      return new Date(matches[1], matches[2] - 1, matches[3]);
		    } else {
		      return null;
		    };
		}
	},

	  dateToString: function(date) {
	    var month = (date.getMonth() + 1).toString();
	    var dom = date.getDate().toString();
	    if (month.length == 1) month = "0" + month;
	    if (dom.length == 1) dom = "0" + dom;
	    if (local_date_format == 'd/m/Y') {
	    	return dom + "/" + month + "/" + date.getFullYear();
		} else {
			return date.getFullYear() + "-" + month + "-" + dom;
		}
	}
});