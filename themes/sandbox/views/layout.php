<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="robots" content="index, follow">
<title><?php echo title($sep = ''); ?></title>
<?php if (record('action') == 'single' && record('id_type') == 11){
	$record->set_documents();
	$thumbnail = record('thumbnail');
	if (is_array($thumbnail) && count($thumbnail)) {
		$thumbnailsrs = attach_url($thumbnail[0]->path);
	}
?>
<link rel="canonical" href="<?php echo current_url(); ?>"/>
<meta property="og:site_name" content="<?php echo settings('website_name_ru'); ?>" />
<meta property="og:title" content="<?php echo record('title'); ?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:description" content="<?php echo strip_tags(html_entity_decode(record('content'), ENT_QUOTES, 'UTF-8')); ?>" />
<?php if ($thumbnailsrs !=''){?>
<meta property="og:image" content="<?php echo $thumbnailsrs; ?>" />
<?php } ?>
<?php } ?>
<meta name="description" content="<?php echo page_description(); ?>">
<meta name="keywords" content="<?php echo page_keywords(); ?>">
	<?php  page_feed(); ?>
<link rel="stylesheet" href="/assets/css/template.css" type="text/css"><link rel="stylesheet" href="/assets/css/additional.css" type="text/css"><link rel="stylesheet" href="/assets/css/jquery.formstyler.css" type="text/css"><link rel="stylesheet" href="/assets/css/form.css" type="text/css"><link href="/assets/css/jquery.bxslider.css" rel="stylesheet"><link href="/assets/css/prettyPhoto.css" rel="stylesheet"><link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" /><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script><script type="text/javascript" src="/assets/js/jquery.bxslider.js"></script><script type="text/javascript" src="/assets/js/jquery.prettyPhoto.js"></script><script type="text/javascript" src="/assets/js/jquery.fastinputs.js"></script><script type="text/javascript" src="/assets/js/core.js"></script><script type="text/javascript" src="/assets/js/swfobject.js"></script>
<?php /*?><?php if (record('action') == 'single' && record('id_type') == 11){?>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?96"></script>
<script type="text/javascript">VK.init({apiId: 3720867, onlyWidgets: true});</script>
<?php } ?>
<?php */?>
<?php if(page('id_record') == settings('website_map_page')){?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=ru"></script>
<script type="text/javascript">
	//<![CDATA[
	var map;
	var geocoder;
	initialize();
	function initialize() {
		geocoder = new google.maps.Geocoder();
		geocoder.geocode({
			'address': '<?php echo page('template_map_center'); ?>',
			'partialmatch': true}, geocodeResult);   
	}
									
	function geocodeResult(results, status) {
		if (status == 'OK' && results.length > 0) {         
			var latlng = new google.maps.LatLng(results[0].geometry.location.b,results[0].geometry.location.c);
			var myOptions = {
				zoom: 14,
				center: results[0].geometry.location,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.getElementById("simple-map"), myOptions);
			var marker = new google.maps.Marker({
				position: results[0].geometry.location,
				map: map,
				title:"<?php echo page('template_map_center'); ?>"
			});
			google.maps.event.trigger(marker, "click");
		} else {
			alert("Искомый адрес не найден на карте:" + status);
		}
	}
	//]]>
</script>
<?php }?>
<script type="text/javascript">
var flashvars = {},
params = {wmode:"transparent"},
attributes = {};
swfobject.embedSWF("/assets/swf/indigo_logo_240x125.swf", "flash-logo", "240", "125", "9.0.0", "/swf/expressInstall.swf", flashvars, params, attributes);
swfobject.embedSWF("/assets/swf/indigo_okno.swf", "flash-header", "713", "260", "9.0.0", "/swf/expressInstall.swf", flashvars, params, attributes);
</script>
</head>
<body>
<?php /*?><?php if (record('action') == 'single' && record('id_type') == 11){?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1&appId=547221248668608";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php } ?>
<?php */?><div class="header">
	<div class="headerWidth">
		<div class="leftHeader">
			<div class="logo">
				<div id="flash-logo"><img src="/assets/swf/logo.png" width="240" height="125" alt="<?php echo settings('website_name_ru'); ?>"></div>
				<span style="font-size: 13pt; color: #7ccae0;"><?php echo settings('website_claim_ru'); ?></span> </div>
			<div class="kartina">
				<div class="kartina-text"> <?php echo settings('website_picture'); ?> </div>
			</div>
			<div class="pismo">
				<p><a title="Подать заявку" href="<?php echo fromsettingspage(settings('website_order_page')); ?>">Подать заявку:</a></p>
				<a title="Онлайн заявка" href="<?php echo fromsettingspage(settings('website_order_page')); ?>"><img alt="pismo" src="/assets/images/pismo.png" height="75" width="93"></a></div>
		</div>
		<div class="centerHeader">
			<div id="flash-header"><img src="/assets/swf/okno.png" width="713" height="259" alt="<?php echo settings('website_claim_ru'); ?>"></div>
			<div class="top-menu"><ul class="menu"><li><a href="<?php echo site_url(); ?>" title="Главная">Главная</a></li><li><a href="#" title="Недвижимость">Недвижимость</a><?php						
						$dropmenu = find('Menu')->where('dropdown_menu', 'T')->order_by('priority', 'ASC')->get();
						if(count($dropmenu)){
						?><ul class="level"><?php foreach ($dropmenu as $dropitem){ ?><li><a href="<?php echo site_url($dropitem->get('uri')); ?>" title="<?php echo $dropitem->get('title'); ?>"><?php echo $dropitem->get('title'); ?></a></li><?php } ?></ul><?php } ?></li><?php						
					$topmenu = find('Menu')->where('header_menu', 'T')->order_by('priority', 'ASC')->get();
					if(count($topmenu)){
					foreach ($topmenu as $topitem){ ?><li><a href="<?php echo site_url($topitem->get('uri')); ?>" title="<?php echo $topitem->get('title'); ?>"><?php echo $topitem->get('title'); ?></a></li><?php } ?><?php } ?></ul></div><div class="galary"><?php $realestates = find('realestate')->documents(TRUE)->where('carousel', 'Y')->where('frontstate', 'N')->get(); ?>
<?php /*?>					<div id="slider"><ul><?php
					foreach ($realestates as $realestate){
					$thumb = $realestate->get('thumbnail');
					$realestateid = $realestate->get('id_record');
					$realestatetypo = $realestate->get('id_type');
					$realestateturi = $realestate->get('uri');
					$realestatecats = recordCategoriesIds($realestate->get('id_record'));
					//print_r($realestatecats);
					?><li><a href="<?php echo semantic_category_url($realestate, $realestatecats, $realestatetypo,$realestateturi); ?>" class="tip_trigger"> <img src="<?php echo preset_url(attach_url($thumb[0]->path), 'thumbnail');  ?>"  alt="<?php echo htmlspecialchars(strip_tags($realestate->get('title'))); ?>" > <span class='img_special'></span><span class='tip'><?php echo $realestate->get('title'); ?></span> </a></li><?php } ?></ul></div>
<?php */?>					
					</div></div>
		<div class="rightHeader"> <a href="<?php echo fromsettingspage(settings('website_auth_page')); ?>"><img style="margin:30px 0 0 20px;" alt="knigi" src="/assets/images/knigi.png" height="170" width="168"></a><br>
			<br>
			<img style="display: block;" alt="vazon" src="/assets/images/vazon.png" height="228" width="222"> </div>
		<div class="polka"> </div>
	</div>
</div>
<!-- #header-->

<div class="plintus"></div>
<div class="container">
	<div class="leftbar">
		<div class="left">
			<div class="ugol11"></div>
			<div class="ugol21"></div>
			<div class="ugol31"></div>
			<div class="ugol41"></div>
			<div class="prugina"></div>
			<ul class="menu">
				<?php echo leftmenu(tree(), 1); ?>
			</ul>
		</div>
		<a class="karta" title="Интерактивная карта Ялты" href="<?php echo fromsettingspage(settings('website_map_page')); ?>"><img alt="karta" src="/assets/images/karta.png" height="214" width="256"></a>
	</div>
	<!-- .sidebar#leftbar -->
	
	<div class="content">
		<div class="ugol1"></div>
		<div class="ugol2"></div>
		<div class="ugol3"></div>
		<div class="ugol4"></div>
		<?php template(); ?>
		<div class="con-bottom">
			<div class="bottom-menu">
				<ul class="menu">
					<li><a href="<?php echo site_url(); ?>" title="Главная">Главная</a> </li><li> <a href="#" title="Недвижимость">Недвижимость</a><?php						
						if(count($dropmenu)){
						?><ul class="level"><?php foreach ($dropmenu as $dropitem){ ?><li><a href="<?php echo semantic_url($dropitem); ?>" title="<?php echo $dropitem->get('title'); ?>"><?php echo $dropitem->get('title'); ?></a></li><?php } ?></ul><?php } ?></li><?php						
					$bottommenu = find('Menu')->where('footer_menu', 'T')->order_by('priority', 'ASC')->get();
					if(count($bottommenu)){
					foreach ($bottommenu as $bottomitem){ ?><li><a href="<?php echo site_url($bottomitem->get('uri')); ?>" title="<?php echo $bottomitem->get('title'); ?>"><?php echo $bottomitem->get('title'); ?></a></li><?php } ?><?php } ?>
				</ul>
			</div>
		</div>
	</div>
	<!-- #content-->
	
	<div class="rightbar">
		<?php if (record('action') == 'single' && record('id_type') == 11){?>
		<?php if(settings('website_addestate') !=''){ ?>
		<div class="add-estate">
			<div class="ugol11"></div>
			<div class="ugol21"></div>
			<div class="ugol31"></div>
			<div class="ugol41"></div>
			<a title="<?php echo settings('website_addestate'); ?>" href="<?php echo fromsettingspage(settings('website_order_page')); ?>"><?php echo settings('website_addestate'); ?></a>
		</div>
		<?php } ?>
		<?php } ?>
		<div class="clock"></div>
	</div>
	<div class="clear"></div>
</div>
<!-- #container-->

<div class="footer">
	<div class="plintus"> </div>
	<div class="centerFooter">
		<div class="floor">
			<div class="tel"></div>
			<div class="cat"></div>
			<div class="tapki"></div>
		</div>
	</div>
</div>
<!-- #footer --> 
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12750421-25']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!-- Piwik -->
<script type="text/javascript"> 
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://indigo-yalta.com/piwik//";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();

</script>
<noscript><p><img src="http://indigo-yalta.com/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Code -->

</body>
</html>