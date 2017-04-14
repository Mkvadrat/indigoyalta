$(function () {



	
	if($('.repeatable-fields-list').length){
	$(".repeatable-fields-list").sortable();
	}
	// Check / uncheck all checkboxes
	
	$('body').delegate('#check_all', 'click', function () {
		$(this).parents('form').find('[name*=record]').attr('checked', $(this).is(':checked'));
	});

	// Messages


    $('.repeatable-field-add').click(function() {
        var theField = $(this).closest('div.repeatable-wrap').find('.repeatable-fields-list li:last').clone(true);
        var theLocation = $(this).closest('div.repeatable-wrap').find('.repeatable-fields-list li:last');
        $('input', theField).val('').attr('name', function(index, name) {
            return name.replace(/(\d+)/, function(fullMatch, n) {
                return Number(n) + 1;
            });
        });
        theField.insertAfter(theLocation, $(this).closest('div.repeatable-wrap'));
        var fieldsCount = $('.repeatable-field-remove').length;
        if (fieldsCount > 1) {
            $('.repeatable-field-remove').css('display', 'inline');
        }
        return false;
    });
	
	
	
	
	
	
	
	
	
	// Image actions menu
	$('ul.imglist li').hover(
		function() { $(this).find('ul').css('display', 'none').fadeIn('fast').css('display', 'block'); },
		function() { $(this).find('ul').fadeOut(100); }
	);

});

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
		template_act : function() {
			var val = $('select[name=section_template]').val(),
				default_fields = '.field-separator_content, .field-content';
				flatcontent_fields = '.field-smartresponder_code, .field-votesystem_code';
//				schedule_fields = '.field-smartresponder_code';
				gallery_fields = '.field-separator_gallery, .field-photoreport';
				splashpage_fields = '.field-separator_splash_details, .field-wbs_video_id, .field-wbs_location_date_splash, .field-wbs_location_content_splash, .field-wbs_splash_features';

				feedback_fields = '.field-separator_feedback_details, .field-wbs_location, .field-wbs_location_date, '
							+ '.field-wbs_location_content, .field-separator_photo, .field-logoorg, .field-separator_gensponsor, '
							+'.field-gensponsors, .field-separator_supportsponsors, .field-supportsponsors, .field-separator_infosponsor, .field-infosponsors, .field-template_feedback_content';

				partpacks_fields = '.field-separator_vip, .field-vip_participation_title, .field-vip_participation_link, .field-participation_first_wave, .field-participation_second_wave, .field-participation_third_wave, '
							+ '.field-vip_participation_content, .field-vip_participation_prices, .field-stndrt_participation_prices, .field-separator_stndrt, .field-stndrt_participation_title, .field-stndrt_participation_link, .field-stndrt_participation_content, .field-separator_orderblock, .field-participation_dates ';

				speed = 200;

			switch (val) {
				case 'default':
					$(default_fields).show(speed);
					$(feedback_fields).hide(speed);
					$(splashpage_fields).hide(speed);
					$(gallery_fields).hide(speed);
					$(partpacks_fields).hide(speed);
					break;
				case 'flatcontent':
					$(default_fields).show(speed);
					$(flatcontent_fields).show(speed);
					$(feedback_fields).hide(speed);
					$(splashpage_fields).hide(speed);
					$(gallery_fields).hide(speed);
					$(partpacks_fields).hide(speed);
					break;
				case 'splashpage':
					$(splashpage_fields).show(speed);
					$(feedback_fields).hide(speed);
					$(partpacks_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(default_fields).hide(speed);
					$(flatcontent_fields).hide(speed);
					break;

				case 'feedback':
					$(feedback_fields).show(speed);
					$(splashpage_fields).hide(speed);
					$(partpacks_fields).hide(speed);
					$(gallery_fields).hide(speed);
					$(default_fields).hide(speed);
					$(flatcontent_fields).hide(speed);
					break;

				case 'gallery':
					$(gallery_fields).show(speed);
					$(default_fields).hide(speed);
					$(flatcontent_fields).hide(speed);
					$(splashpage_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(partpacks_fields).hide(speed);
					break;
				case 'gallerypaged':
					$(gallery_fields).show(speed);
					$(default_fields).hide(speed);
					$(flatcontent_fields).hide(speed);
					$(splashpage_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(partpacks_fields).hide(speed);
					break;

				case 'topicslist':
					$(splashpage_fields).hide(speed);
					$(gallery_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(partpacks_fields).hide(speed);
					$(gallery_fields).hide(speed);
					$(default_fields).hide(speed);
					$(flatcontent_fields).hide(speed);
					break;

				case 'testmonials':
					$(splashpage_fields).hide(speed);
					$(default_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(partpacks_fields).hide(speed);
					$(gallery_fields).hide(speed);
					$(default_fields).hide(speed);
					$(flatcontent_fields).hide(speed);
					break;

				case 'schedule':
					$(splashpage_fields).hide(speed);
					$(default_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(partpacks_fields).hide(speed);
					$(gallery_fields).hide(speed);
					$(default_fields).hide(speed);
					$(flatcontent_fields).hide(speed);
					break;

				case 'programslist':
					$(default_fields).show(speed);
					$(flatcontent_fields).show(speed);
					$(splashpage_fields).hide(speed);
					$(gallery_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(partpacks_fields).hide(speed);
					break;

				case 'speakerslist':
					$(default_fields).show(speed);
					$(flatcontent_fields).show(speed);
					$(splashpage_fields).hide(speed);
					$(gallery_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(partpacks_fields).hide(speed);
					break;

				case 'partpacks':
					$(partpacks_fields).show(speed);
					$(default_fields).hide(speed);
					$(gallery_fields).hide(speed);
					$(flatcontent_fields).hide(speed);
					$(feedback_fields).hide(speed);
					$(splashpage_fields).hide(speed);
					break;

			}
		},
		
		participation_act: function(){},
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
}

;



/**
 * StyleFix 1.0.3 & PrefixFree 1.0.7
 * @author Lea Verou
 * MIT license
 */(function(){function t(e,t){return[].slice.call((t||document).querySelectorAll(e))}if(!window.addEventListener)return;var e=window.StyleFix={link:function(t){try{if(t.rel!=="stylesheet"||t.hasAttribute("data-noprefix"))return}catch(n){return}var r=t.href||t.getAttribute("data-href"),i=r.replace(/[^\/]+$/,""),s=(/^[a-z]{3,10}:/.exec(i)||[""])[0],o=(/^[a-z]{3,10}:\/\/[^\/]+/.exec(i)||[""])[0],u=/^([^?]*)\??/.exec(r)[1],a=t.parentNode,f=new XMLHttpRequest,l;f.onreadystatechange=function(){f.readyState===4&&l()};l=function(){var n=f.responseText;if(n&&t.parentNode&&(!f.status||f.status<400||f.status>600)){n=e.fix(n,!0,t);if(i){n=n.replace(/url\(\s*?((?:"|')?)(.+?)\1\s*?\)/gi,function(e,t,n){return/^([a-z]{3,10}:|#)/i.test(n)?e:/^\/\//.test(n)?'url("'+s+n+'")':/^\//.test(n)?'url("'+o+n+'")':/^\?/.test(n)?'url("'+u+n+'")':'url("'+i+n+'")'});var r=i.replace(/([\\\^\$*+[\]?{}.=!:(|)])/g,"\\$1");n=n.replace(RegExp("\\b(behavior:\\s*?url\\('?\"?)"+r,"gi"),"$1")}var l=document.createElement("style");l.textContent=n;l.media=t.media;l.disabled=t.disabled;l.setAttribute("data-href",t.getAttribute("href"));a.insertBefore(l,t);a.removeChild(t);l.media=t.media}};try{f.open("GET",r);f.send(null)}catch(n){if(typeof XDomainRequest!="undefined"){f=new XDomainRequest;f.onerror=f.onprogress=function(){};f.onload=l;f.open("GET",r);f.send(null)}}t.setAttribute("data-inprogress","")},styleElement:function(t){if(t.hasAttribute("data-noprefix"))return;var n=t.disabled;t.textContent=e.fix(t.textContent,!0,t);t.disabled=n},styleAttribute:function(t){var n=t.getAttribute("style");n=e.fix(n,!1,t);t.setAttribute("style",n)},process:function(){t('link[rel="stylesheet"]:not([data-inprogress])').forEach(StyleFix.link);t("style").forEach(StyleFix.styleElement);t("[style]").forEach(StyleFix.styleAttribute)},register:function(t,n){(e.fixers=e.fixers||[]).splice(n===undefined?e.fixers.length:n,0,t)},fix:function(t,n,r){for(var i=0;i<e.fixers.length;i++)t=e.fixers[i](t,n,r)||t;return t},camelCase:function(e){return e.replace(/-([a-z])/g,function(e,t){return t.toUpperCase()}).replace("-","")},deCamelCase:function(e){return e.replace(/[A-Z]/g,function(e){return"-"+e.toLowerCase()})}};(function(){setTimeout(function(){t('link[rel="stylesheet"]').forEach(StyleFix.link)},10);document.addEventListener("DOMContentLoaded",StyleFix.process,!1)})()})();(function(e){function t(e,t,r,i,s){e=n[e];if(e.length){var o=RegExp(t+"("+e.join("|")+")"+r,"gi");s=s.replace(o,i)}return s}if(!window.StyleFix||!window.getComputedStyle)return;var n=window.PrefixFree={prefixCSS:function(e,r,i){var s=n.prefix;n.functions.indexOf("linear-gradient")>-1&&(e=e.replace(/(\s|:|,)(repeating-)?linear-gradient\(\s*(-?\d*\.?\d*)deg/ig,function(e,t,n,r){return t+(n||"")+"linear-gradient("+(90-r)+"deg"}));e=t("functions","(\\s|:|,)","\\s*\\(","$1"+s+"$2(",e);e=t("keywords","(\\s|:)","(\\s|;|\\}|$)","$1"+s+"$2$3",e);e=t("properties","(^|\\{|\\s|;)","\\s*:","$1"+s+"$2:",e);if(n.properties.length){var o=RegExp("\\b("+n.properties.join("|")+")(?!:)","gi");e=t("valueProperties","\\b",":(.+?);",function(e){return e.replace(o,s+"$1")},e)}if(r){e=t("selectors","","\\b",n.prefixSelector,e);e=t("atrules","@","\\b","@"+s+"$1",e)}e=e.replace(RegExp("-"+s,"g"),"-");e=e.replace(/-\*-(?=[a-z]+)/gi,n.prefix);return e},property:function(e){return(n.properties.indexOf(e)?n.prefix:"")+e},value:function(e,r){e=t("functions","(^|\\s|,)","\\s*\\(","$1"+n.prefix+"$2(",e);e=t("keywords","(^|\\s)","(\\s|$)","$1"+n.prefix+"$2$3",e);return e},prefixSelector:function(e){return e.replace(/^:{1,2}/,function(e){return e+n.prefix})},prefixProperty:function(e,t){var r=n.prefix+e;return t?StyleFix.camelCase(r):r}};(function(){var e={},t=[],r={},i=getComputedStyle(document.documentElement,null),s=document.createElement("div").style,o=function(n){if(n.charAt(0)==="-"){t.push(n);var r=n.split("-"),i=r[1];e[i]=++e[i]||1;while(r.length>3){r.pop();var s=r.join("-");u(s)&&t.indexOf(s)===-1&&t.push(s)}}},u=function(e){return StyleFix.camelCase(e)in s};if(i.length>0)for(var a=0;a<i.length;a++)o(i[a]);else for(var f in i)o(StyleFix.deCamelCase(f));var l={uses:0};for(var c in e){var h=e[c];l.uses<h&&(l={prefix:c,uses:h})}n.prefix="-"+l.prefix+"-";n.Prefix=StyleFix.camelCase(n.prefix);n.properties=[];for(var a=0;a<t.length;a++){var f=t[a];if(f.indexOf(n.prefix)===0){var p=f.slice(n.prefix.length);u(p)||n.properties.push(p)}}n.Prefix=="Ms"&&!("transform"in s)&&!("MsTransform"in s)&&"msTransform"in s&&n.properties.push("transform","transform-origin");n.properties.sort()})();(function(){function i(e,t){r[t]="";r[t]=e;return!!r[t]}var e={"linear-gradient":{property:"backgroundImage",params:"red, teal"},calc:{property:"width",params:"1px + 5%"},element:{property:"backgroundImage",params:"#foo"},"cross-fade":{property:"backgroundImage",params:"url(a.png), url(b.png), 50%"}};e["repeating-linear-gradient"]=e["repeating-radial-gradient"]=e["radial-gradient"]=e["linear-gradient"];var t={initial:"color","zoom-in":"cursor","zoom-out":"cursor",box:"display",flexbox:"display","inline-flexbox":"display",flex:"display","inline-flex":"display",grid:"display","inline-grid":"display","min-content":"width"};n.functions=[];n.keywords=[];var r=document.createElement("div").style;for(var s in e){var o=e[s],u=o.property,a=s+"("+o.params+")";!i(a,u)&&i(n.prefix+a,u)&&n.functions.push(s)}for(var f in t){var u=t[f];!i(f,u)&&i(n.prefix+f,u)&&n.keywords.push(f)}})();(function(){function s(e){i.textContent=e+"{}";return!!i.sheet.cssRules.length}var t={":read-only":null,":read-write":null,":any-link":null,"::selection":null},r={keyframes:"name",viewport:null,document:'regexp(".")'};n.selectors=[];n.atrules=[];var i=e.appendChild(document.createElement("style"));for(var o in t){var u=o+(t[o]?"("+t[o]+")":"");!s(u)&&s(n.prefixSelector(u))&&n.selectors.push(o)}for(var a in r){var u=a+" "+(r[a]||"");!s("@"+u)&&s("@"+n.prefix+u)&&n.atrules.push(a)}e.removeChild(i)})();n.valueProperties=["transition","transition-property"];e.className+=" "+n.prefix;StyleFix.register(n.prefixCSS)})(document.documentElement);