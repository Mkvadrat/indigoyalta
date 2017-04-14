$(document).ready(function(){
    $(".sidebar-menu .title").hover(function(){
        $(".hovered").css('display','block');
	});
	IS_IPAD = navigator.userAgent.match(/iPad/i) != null;
	IS_IPHONE = (navigator.userAgent.match(/iPhone/i) != null) || (navigator.userAgent.match(/iPod/i) != null);
	
	
	//подключение mobile.css
	if ((document.body.clientWidth <= '1170')&&(localStorage.getItem('view_site')!="pc")){
		var view_site = "mobile";
		localStorage.setItem('view_site', view_site);
		if ((!IS_IPAD) && (!IS_IPHONE)) {
			$("head").append($("<link rel='stylesheet' href='/assets/less/indigo-media.css' type='text/css' media='screen' />"));
		};
		
		}else{
		var view_site = "pc";
		localStorage.setItem('view_site', view_site);
		$('head').prepend('<meta name="viewport" content="width=device-width,minimum-scale=0.25,user-scalable=yes">');
	};
	
	widht_container();
	function widht_container() {
		// показывать переключатель
		if ((document.body.clientWidth >= '1170')){
			$(".clikalka").css('display','none');
			}else{
			$(".clikalka").css('display','block');		
		}	
		// размер моб. версии
		if ((screen.width <= '620')&&(localStorage.getItem('view_site')!="pc")&&(!IS_IPHONE)&&(!IS_IPAD)){
			$('head meta[name=viewport]').remove();
			$('head').prepend('<meta name="viewport" content="width=640,minimum-scale=0.25,user-scalable=yes">');	
		}else if ((screen.width >= '620')&&(localStorage.getItem('view_site')!="pc")&&(!IS_IPHONE)&&(!IS_IPAD)){
		$('head meta[name=viewport]').remove();
			$('head').prepend('<meta name="viewport" content="width=980,minimum-scale=0.25,user-scalable=yes">');
		
		}
	}
	$(window).resize(function() {
		widht_container();
	});
	if ((document.body.clientWidth <= '1170' && document.body.clientWidth >='620')&&(localStorage.getItem('view_site')!="mobile")){
		$('head meta[name=viewport]').remove();
		$('head').prepend('<meta name="viewport" content="width=device-width,minimum-scale=0.25,user-scalable=yes">');	
	}
	
	
	
	
	$('.top-menu ul.menu li.exp').children('a').click(function(){
		
		//if ((document.body.clientWidth <= '1170')&&(localStorage.getItem('view_site')!="pc")){
		
		if (localStorage.getItem('view_site')!="pc"){
			if ($(this).hasClass("act")){
				$('.top-menu ul.menu li.exp a.act').next('ul').animate({
					"height": "toggle", "opacity": "toggle"
				}, 500);				
				$('.top-menu ul.menu li.exp a.act').removeClass();	
				return false;	
				}else{
				$('.top-menu ul.menu li.exp a.act').next('ul').animate({	
					"height": "toggle", "opacity": "toggle"
				}, 500);
				$('.top-menu ul.menu li.exp a.act').removeClass();
				$(this).addClass('act');
				$(this).next('ul').animate({
					"height": "toggle", "opacity": "toggle"
				}, 500);	
				return false;	
			}
		}
	});		
	$('li.exp').hover(function(){
		if (localStorage.getItem('view_site')!="mobile"){
			$(this).children('ul').toggle();
		}
	});
	
	
	$('.send-but').click(function(){
		if ($(this).hasClass("open")){
			
			$(this).removeClass("open");
			$(this).stop().animate({bottom:"0"}, 1400);
			$('.send-mess').stop().animate({height:"0"}, 1400);
			
			}else{
			$(this).addClass("open");
			$(this).stop().animate({bottom:"225"}, 1400);
			$('.send-mess').stop().animate({height:"228"}, 1400);
		}
	});	
	
	$('#flash-logo').click(function(){
		location.href = '../';
	});
	
	$('.pc').click(function(){
		var view_site = "pc";
		localStorage.setItem('view_site', view_site);	
		location.reload();
	});
	$('.mobile').click(function(){
		var view_site = "mobile";
		localStorage.setItem('view_site', view_site);
		location.reload();
	});
	
	
	
	$(".sidebar-menu .title").click(function(){
		$(".hovered").toggleClass("stop");
		$(".sidebar-menu .title").toggleClass("stop-color");
	});
	
	$(".site-sidebar").hover(function(){
		$(".hovered").css('display','none');
	});
	
	$("a[data-rel^='prettyPhoto']").prettyPhoto({
		deeplinking: false,
	});
	
	$('#slider ul').bxSlider({
		minSlides: 5,
		maxSlides: 5,
		slideMargin: 5,
		slideWidth: 130,
		pager: false,
		infiniteLoop: false,
		moveSlides: 3,
	});
	
	$(function() {
		
		$('ul.tabs').on('click', 'li:not(.current)', function() {
			$(this).addClass('current').siblings().removeClass('current')
			.parents('div.section').find('div.box').eq($(this).index()).fadeIn(150).siblings('div.box').hide();
		})
	});
});

function sharer(name, url, width, height){
	window.open(url, name, 'width=' + width + ',height=' + height + ',top=100,left=100,toolbar=no,menubar=no');
	return false;
}

var flashvars = {},
params = {wmode:"transparent"}, 
attributes = {};
//  swfobject.embedSWF("/assets/swf/indigo_logo_240x125.swf", "flash-logo", "240", "125", "9.0.0", "/swf/expressInstall.swf", flashvars, params, attributes);
//  swfobject.embedSWF("/assets/swf/indigo_okno.swf", "flash-header", "713", "260", "9.0.0", "/swf/expressInstall.swf", flashvars, params, attributes);

