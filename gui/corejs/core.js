$(function () {


	

	$('.has-fasteditor').fasteditor({
//		imageUpload: admin_url+'repository',
//		fileUpload: '/core/file_upload.php',
//		imageGetJson: '/uploaded/data.json',
		wym: false,
		minHeight: 150,
		maxHeight: 800,
		observeLinks: true,
		cleanup: false,
		plugins: ['fontfamily','fontsize','fontcolor','fullscreen','cleanformatting']
	});

	$('.message').hide().fadeIn('slow');
	$('.message .close').hover(
		function() { $(this).addClass('hover'); },
		function() { $(this).removeClass('hover'); }
	);

	$('.message .close').click(function() {
		$(this).parent().fadeOut('slow', function() { $(this).remove(); });
	});
					setTimeout(function() {
					$('.message').fadeOut('slow');
				}, 2000);

	
  setTranslit('title', 'uri', false);
	if($('[name=uri]').length){
		fastcms.check.uri('input[name="uri"]')
	}

	$('.has-datepicker').datepicker();
	$('.has-timepicker').timepicker();

	$('#check_all').on('click', function () {
		$(this).parents('table').find('[name*=record]').attr('checked', $(this).is(':checked'));
	});
	
	$('body').delegate('.delete-link', 'click', function () {
		var txt = 'Удаление необратимо. Продолжить?',
		type = $(this).data("type"),
		entry = $(this).data("id");
					
		fastnotify.confirm("Подвердите удаление", function (e) {
			if (e) {
				$.post(admin_url+'contents/delete_record/'+type+'/'+entry+'/true', function(data){
					if(data == 'true'){
						$('#entry-'+entry).slideUp(300, function(){ $(this).remove(); });
						var resort = true,
							callback = function(table){
								fastnotify.success("Таблица записей обновлена");
							};
							$(".tablesorter").trigger("update", [resort, callback]);
					}else{
						fastnotify.error("Ошибка. Попробуйте позже");
					}							
				});
			} else {
			}
		});
	return false;
	});

	$('body').delegate('.menu-delete', 'click', function () {
		var txt = 'Удаление необратимо. Продолжить?',
		entry = $(this).data("id");
					
		fastnotify.confirm("Подвердите удаление", function (e) {
			if (e) {
				$.post(admin_url+'navigation/delete/'+entry, function(data){
					if(data == 'true'){
						$('#menu-'+entry).slideUp(300, function(){ $(this).remove(); });
						fastnotify.success("Список групп меню обновлен");
					}else{
						fastnotify.error("Ошибка. Попробуйте позже");
					}							
				});
			} else {
			}
		});
	return false;
	});
	
	if($('table.sortable').length){
		$('table.sortable tbody').sortable({
			forcePlaceholderSize: true,
			handle: ".handle",
			placeholder: "table-sortable-placeholder",
			stop: function(event, ui){
				fastcms.sort_priority(event, ui);
			}
		});
	}
	
	if($('.table-multihead').length){
		$('.table-multihead').tablesorter();
	}
	
	if($('.tablesorter').length){

		var $sortedTable = $(".tablesorter"), $sortedSix = $("#catalogs-table, #common-table"), $sortedFive = $("#news-table"), $sortedNine = $("#realestate-table"), $sortedEight = $("#Menu-table"),

		tablesorterColumnSelectorConfig = { widgets: ['zebra'], headers:{ 0:{sorter:false} } };
		
		$sortedTable.tablesorter({
			widgets: ["filter", "resizable", "zebra"],
			widgetOptions : {
				filter_anyMatch : true,
				filter_columnFilters: false,
				filter_reset: '.reset'
			}
		});
		$sortedFive.tablesorterColumnSelector({
			columns: {
				0: ['disable'],
				5: ['disable'],
			}
		});
		$sortedSix.tablesorterColumnSelector({
			columns: {
				0: ['disable'],
				6: ['disable'],
			}
		});
		$sortedNine.tablesorterColumnSelector({
			columns: {
				0: ['disable'],
				8: ['disable'],
			}
		});
		$sortedEight.tablesorterColumnSelector({
			columns: {
				0: ['disable'],
				7: ['disable'],
			}
		});
		$.tablesorter.filter.bindSearch($sortedTable, $('.search') );
		$(".search").bind('search keyup', function (e) {
			$sortedTable.trigger('search', [ [this.value] ]);
		});
				
	}
	
	$('[name=uri]').on('keyup', function () {
		fastcms.check.uri(this)
	});
	$('.repository-list select').change(function() {
		getPresetPath($(this));
	});


//	$('.main-navigation .parent > a').click(function() {
//		
//		$levelparent = $(this).parent('li');
//		$levelchild = $(this).next('ul');
//		
//		if($($levelchild).is(":visible")){
//			$($levelchild).slideUp("fast");
//			$($levelparent).removeClass("open");
//		}
//		else{
//			$($levelchild).slideDown("fast");
//			$($levelparent).addClass("open");
//		}
//		return false;
//	});



});


function getUrlParam(paramName) {
  var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
  var match = window.location.search.match(reParam) ;
  return (match && match.length > 1) ? match[1] : '' ;
}
function getPresetPath(el) {
	var preset = el.val();
	var _tr = el.parent('td').parent('tr');
	var urlpath = 'attach/' + _tr.attr('data-path');

	_tr.find('.choose').unbind('click').click(function() {
		var url = fastcms.preset_url(urlpath, preset, true);
			fastnotify.prompt("Путь к файлу", function (e, str) {
				if (e) {
				} else {
				}
			}, url);
			return false;
	});
}

var ru2en = {
  fromChars : 'абвгдезиклмнопрстуфыэйхё',
  toChars : 'abvgdeziklmnoprstufyejhe',
  biChars : {'ж':'zh','ц':'c','ч':'ch','ш':'sh','щ':'sch','ю':'u','я':'ya','&':'-and-'},
  vowelChars : 'аеёиоуыэюя',
  translit : function(str) {
    str = str.replace(/[_\s\.,?!\[\](){}\\\/"':;]+/g, '-')
             .toLowerCase()
             .replace(new RegExp('(ь|ъ)(['+this.vowelChars+'])', 'g'), 'j$2')
             .replace(/(ь|ъ)/g, '');

    var _str = '';
    for (var x=0; x<str.length; x++)
      if ((index = this.fromChars.indexOf(str.charAt(x))) > -1)
        _str += this.toChars.charAt(index);
      else
        _str += str.charAt(x);
    str = _str;

    var _str = '';
    for (var x=0; x<str.length; x++)
      if (this.biChars[str.charAt(x)])
        _str += this.biChars[str.charAt(x)];
      else
        _str += str.charAt(x);
    str = _str;

    str = str.replace(/j{2,}/g, 'j')
             .replace(/[^-0-9a-z]+/g, '')
             .replace(/-{2,}/g, '-')
             .replace(/^-+|-+$/g, '');

    return str;
  }
}

function setTranslit(src, dst, force){
  if ($('input[name="'+src+'"]').val() != undefined){
    $('input[name="'+src+'"]').change(function(){
      var srcVal = $('input[name="'+src+'"]').val();
      var dstVal = $('input[name="'+dst+'"]').val();
      if (force || (dstVal == ''))
        $('input[name="'+dst+'"]').val(ru2en.translit(srcVal));
				fastcms.check.uri('input[name="'+dst+'"]')
    });
  }
}

function strpos (haystack, needle, offset) {
	var i = (haystack+'').indexOf(needle, (offset || 0));
	return i === -1 ? false : i;
}


var fastcms = {
	_priority : 0,
	load : function(url) {
		$.get(admin_url + url, function(data) {
			$('#content_wrapper').html(data);
		});
	},
	checkAll: function(){
		if ($("#check_all").is(':checked')) {
			$("[name*=record]").each(function () {
				$(this).prop("checked", true);
			});
		} else {
			$("[name*=record]").each(function () {
				$(this).prop("checked", false);
			});
    }
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
	trashphoto : {
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
	sort_schedule : function (event, ui) {
		var rows = $('#schedule-repeatable li', $(ui.item[0]).closest('.sortable'));
		fastcms._priority = rows.length;
		rows.each(function() {
			$('.event-priority', this).val(fastcms._priority);
			fastcms._priority--;
		});
	},
	sort_priority : function (event, ui) {
		var rows = $('tbody tr', $(ui.item[0]).closest('.sortable'));
		fastcms._priority = rows.length;
		rows.each(function() {
			$('.tbl-priority', this).val(fastcms._priority);
			fastcms._priority--;
		});
	},
	check : {
		uri: function(e) {
			clearInterval(document._to);
			document._to=setTimeout(function(){fastcms.check._triggers.uri(e);},1000);
		},
		_triggers : {
			uri : function(e) {
				if($(e).val().length > 3){
				$.post(admin_url+'ajax/can_use_uri', {uri : $(e).val(), id_record : $("input[name=id_record]").val(), id_type : $("input[name=id_type]").val()}, function(data) {
					if (data) {
						$('span.error').remove();
						$(e).removeClass('input-success').addClass('input-error');
						$(e).after('<span class="error">'+data+'</span>');
					} else {
						$('span.error').remove();
						$(e).addClass('input-success');
					}
				});
				}else if($(e).val().length == 0){
					$('span.error').remove();
					$(e).removeClass('input-success').removeClass('input-error');
				}
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

				speed = 0;

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
				currency_fields = '.field-realestate_currency_selector';
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

				speed = 0;

			switch (val) {
				case 'default':
					$(default_fields).show(speed);
					if($('select[name=action]').val() == 'list'){
						$(list_fields).show(speed);
					}
					if($('select[name=action]').val() == 'text'){
						$(list_fields).hide(speed);
					}
					$(currency_fields).hide(speed);
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
					$(currency_fields).hide(speed);
					$(orderform_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(map_fields).hide(speed);
					$(dinamap_fields).hide(speed);
					$(fixedmap_fields).hide(speed);
					break;

				case 'realestate':
					$(default_fields).show(speed);
						$(currency_fields).show(speed);
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
					$(currency_fields).hide(speed);
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
					$(currency_fields).hide(speed);
					$(orderform_fields).hide(speed);
					$(default_fields).hide(speed);
					$(list_fields).hide(speed);
					break;

				case 'feedback':
					$(feedback_fields).show(speed);
					$(map_fields).hide(speed);
					$(dinamap_fields).hide(speed);
					$(currency_fields).hide(speed);
					$(fixedmap_fields).hide(speed);
					$(orderform_fields).hide(speed);
					$(list_fields).hide(speed);
					$(default_fields).hide(speed);
					break;

				case 'orderform':
					$(orderform_fields).show(speed);
					$(map_fields).hide(speed);
					$(dinamap_fields).hide(speed);
					$(currency_fields).hide(speed);
					$(fixedmap_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(default_fields).hide(speed);
					$(list_fields).hide(speed);
					break;

				case 'buyform':
					$(orderform_fields).show(speed);
					$(map_fields).hide(speed);
					$(dinamap_fields).hide(speed);
					$(currency_fields).hide(speed);
					$(fixedmap_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(default_fields).hide(speed);
					$(list_fields).hide(speed);
					break;

				case 'addform':
					$(orderform_fields).show(speed);
					$(map_fields).hide(speed);
					$(dinamap_fields).hide(speed);
					$(currency_fields).hide(speed);
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

				speed = 0;

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
//		}
	},
//		},
		
		section_name: function(){
			$('[name=action_list_name]').val($('select[name=action_list_type] option:selected').text());
		},
		ticket_links_act: function(){},
		subscription_act: function(){},
		
		
		cleansmartresponder: function(){
			var originalCode = $('textarea[name="smartresponder_code"]').val();
			var regexp = /<script\b[^>]*>([\s\S]*?)<\/script>/gm;
			
			if (originalCode.match(regexp) ){      
        text = originalCode.replace(/<script\b[^>]*>([\s\S]*?)<\/script>/gm,"");
        return $('textarea[name="smartresponder_code"]').val(text);
    }
    return false;
			
		},
		
	},
	blocks : {
		_last_section : false,
		set_section : function(which) {
			fastcms.blocks._last_section = which;
		},
		save_section : function(el) {
			var this_block = fastcms.blocks._last_section,
				values = $(el + ' form').serialize();
			$(el + ' form').append('<input type="hidden" name="block" value ="'+this_block+'" />');
			
			values = values + '&theme=' + $('#add_section').attr('data-theme') + '&template='
				   + $('#add_section').attr('data-template');
			$('#cboxClose').click();
			$.post(admin_url + 'themes/add_section', values, function(data) {

				$(data).insertBefore($('.theme_block[data-name="'+this_block+'"]').children().last());

				$('#add_section input[type=text], #add_section select, #add_section textarea').val('');
				$('form input[name=block]').remove();
				fastcms.blocks.load_sortable();
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
					fastcms.blocks.sorted(event, ui);
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
};

// Ion.CheckRadio
// version 1.0.2 Build: 19
// © 2013 Denis Ineshin | IonDen.com
//
// Project page:    http://ionden.com/a/plugins/ion.CheckRadio/en.html
// GitHub page:     https://github.com/IonDen/ion.CheckRadio
//
// Released under MIT licence:
// http://ionden.com/a/plugins/licence-en.html
// =====================================================================================================================

(function($){
    var pluginCount = 0;
    var methods = {
        init: function(){
            return this.each(function(){
                var $input = $(this),
                    $label,
                    $elem,

                    disabled,
                    checked,
                    type,
                    id,
                    name,
                    html,
                    text,
                    tempText,

                    self = this;



                //prevent overwrite
                if($input.data("isActive")) {
                    return;
                }
                $input.data("isActive", true);

                pluginCount++;
                this.pluginCount = pluginCount;



                // private methods
                var getInfo = function(){
                    type = $input.prop("type");
                    disabled = $input.prop("disabled");
                    checked = $input.prop("checked");
                    name = $input.prop("name");

                    getText();
                };

                var getText = function(){
                    $label = $input.parent("label");

                    if($label.length > 0) {
                        text = $label.html();
                        tempText = text.replace(/<input["-=a-zA-Z\u0400-\u04FF\s\d]+>{1}/,"");
                        text = tempText.trim();
                    } else {
                        id = $input.prop("id");
                        $label = $("label[for='"+id+"']");
                        if($label.length > 0) {
                            text = $label.html().trim();
                        } else {
                            throw new Error("Label not found!");
                        }
                    }

                    hideOld();
                };

                var hideOld = function(){
                    $input[0].style.display = "none";
                    $label[0].style.display = "none";

                    placeNew();
                };

                var placeNew = function(){
                    if(disabled) {
                        if(checked) {
                            html = '<span class="icr disabled checked" id="icr-'+self.pluginCount+'">';
                        } else {
                            html = '<span class="icr disabled" id="icr-'+self.pluginCount+'">';
                        }
                    } else {
                        if(checked) {
                            html = '<span class="icr enabled checked" id="icr-'+self.pluginCount+'">';
                        } else {
                            html = '<span class="icr enabled" id="icr-'+self.pluginCount+'">';
                        }
                    }

                    html += '<span class="icr__'+type+'"></span>';
                    html += '<span class="icr__text">'+text+'</span>';
                    html += '</span>';

                    $label.after(html);
                    $elem = $("#icr-" + self.pluginCount);

                    bindEvents();
                };

                var bindEvents = function(){
                    $elem.on("click", function(){
                        if(!disabled) {
                            if(checked) {
                                checkOff();
                            } else {
                                checkOn();
                            }
                        }
                    });

                    $elem.on("mousedown", function(e){
                        e.preventDefault();
                        return false;
                    });

                    $input.on("stateChanged", function(){
                        checkListen();
                    });
                };

                var checkOn = function(){
                    $input.prop("checked", true).trigger("change");
                    $("input[name='"+name+"']").trigger("stateChanged");
                };

                var checkOff = function(){
                    $input.prop("checked", false).trigger("change");
                    $("input[name='"+name+"']").trigger("stateChanged");
                };

                var checkListen = function(){
                    checked = $input.prop("checked");
                    if(checked) {
                        $elem.addClass("checked");
                    } else {
                        $elem.removeClass("checked");
                    }
                };



                // yarrr!
                getInfo();
            });
        }
    };

    $.fn.ionCheckRadio = function(method){
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist for jQuery.ionCheckRadio');
            return false;
        }
    };
})(jQuery);