<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
		<meta content="telephone=no" name="format-detection">

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
		<?php if (isset($thumbnailsrs) && $thumbnailsrs !=''){?>
			<meta property="og:image" content="<?php echo $thumbnailsrs; ?>" />
		<?php } ?>
		<?php } ?>
		<meta name="description" content="<?php echo page_description(); ?>">
		<meta name="keywords" content="<?php echo page_keywords(); ?>">
		<link rel="stylesheet" href="/assets/corecss.php" type="text/css">

		<link rel="stylesheet" href="/assets/css/style.css" type="text/css">

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="/assets/js/jquery.bxslider.js"></script>
		<script src="/assets/js/jquery.prettyPhoto.js"></script>
		<script src="/assets/js/jquery.filedrop.js"></script>
		<script src="/assets/js/upload.js"></script>
		<script src="/assets/js/swfobject.js"></script>
		<script src="/assets/js/core.js"></script>
		<script src="https://www.gstatic.com/swiffy/v5.4/runtime.js"></script>
		<script src="/assets/js/animationLogo.js"></script>
		<script src="/assets/js/animationOkno.js"></script>
		<script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
		<script src="https://yastatic.net/share2/share.js"></script>
		<!--<script>
			IS_IPAD = navigator.userAgent.match(/iPad/i) != null;
			IS_IPHONE = (navigator.userAgent.match(/iPhone/i) != null) || (navigator.userAgent.match(/iPod/i) != null);
			if(IS_IPHONE) {


				if (localStorage.getItem('view_site')!="pc") {

					$('head').prepend('<meta name="viewport" content="width=640,minimum-scale=0.25,user-scalable=yes">');

					$("head").append($("<link rel='stylesheet' href='/assets/less/iphone.css' type='text/css' media='screen' />"));
				}
			}else if (IS_IPAD) {

				if (localStorage.getItem('view_site')!="pc") {
					$('head meta[name=viewport]').remove();

					$('head').prepend('<meta name="viewport" content="width=device-width,minimum-scale=1,user-scalable=no">');

					$("head").append($("<link rel='stylesheet' href='/assets/less/ipad.css' type='text/css' media='screen' />"));
				}
			}
			else
				{

				$('head').prepend('<meta name="viewport" content="width=device-width,minimum-scale=0.25,user-scalable=no>');
			}

		</script>-->
		<?php //if(page('id_record') == settings('website_map_page')){?>
		<?php if(page('id_record') == settings('website_map_page')) $maplocation = page('template_map_center'); ?>
		<?php if (record('mapactive')=='Y') $maplocation = record('maplocation'); ?>
		<?php if (!empty($maplocation)) { ?>
			<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=ru"></script>-->
			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;language=ru"></script>
			<script type="text/javascript">
				//<![CDATA[
				var map;
				var geocoder;
				initialize();
				function initialize() {
					geocoder = new google.maps.Geocoder();
					geocoder.geocode({
						'address': '<?php echo $maplocation; ?>',
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
		<!--
			<script type="text/javascript">
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-12750421-25', 'indigo-yalta.com');
			ga('send', 'pageview');
			</script>
		-->
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-64369007-1', 'auto');
			ga('send', 'pageview');

		</script>

	</head>
	<body data-path="<?php echo APPPATH; ?>">
	<div itemscope itemtype="http://schema.org/Organization">
		<div class="clikalka"><div class="mobile"></div><div class="pc"></div></div>
		<section class="body-wrapper">
			<header class="body-part">
				<div class="units-container">

					<div class="units-row-end units-split">
						<div class="unit-20">
							<?php /*?>        	<div class="logo-holder" id="flash-logo"><a href="#"><img src="/assets/swf/logo.png" alt="<?php echo settings('website_name_ru'); ?>"></a></div>
							<?php */?>        	<div class="logo-holder" id="flash-logo"></div>
							<span style="font-size: 13pt; color: #7ccae0;"><?php echo settings('website_claim_ru'); ?></span><br>
							<div class="header-contacts"><?php echo settings('website_picture'); ?></div>
							<div class="header-order"><a title="Подать заявку" href="<?php echo fromsettingspage(settings('website_order_page')); ?>"><span>Подать заявку:</span></a></div>
						</div>
						<?php /*?>      	<div class="unit-60"><div id="flash-header"><img src="/assets/swf/okno.png" width="713" height="259" alt="<?php echo settings('website_claim_ru'); ?>"></div>
						<?php */?>      	<div class="unit-60"><div id="flash-header"><img src="/assets/images/okno.png" width="480" height="176" alt="" style="display: none;" /></div>

						<div class="top-menu"><ul class="menu">
							<!--<li><a href="<?php echo site_url(); ?>" title="Главная">Главная</a></li>-->

							<li class="exp" aria-haspopup="false"><a href="/sale" title="Продажа">ПРОДАЖА</a><?php
								$dropmenu = find('Menu')->where('dropdown_menu', 'T')->order_by('priority', 'ASC')->get();
								if(count($dropmenu)){ ?>
								<ul class="level second-top" style="display: none;">
									<div class="verh"></div>
									<div class="corner-tl"></div>
									<div class="corner-tr"></div>
									<div class="corner-bl"></div>
									<div class="corner-br"></div>
									<?php foreach ($dropmenu as $dropitem){ ?>
										<li><a href="<?php echo site_url($dropitem->get('uri')); ?>" title="<?php echo $dropitem->get('title'); ?>"><?php echo $dropitem->get('title'); ?></a></li>
									<?php } ?>


								</ul>
							<?php } ?>
							</li>
							<li class="exp" aria-haspopup="false"><a href="/rent" title="Аренда">АРЕНДА</a><?php
								$dropmenu_rent = find('Menu')->where('dropdown_menu_rent', 'T')->order_by('priority', 'ASC')->get();
								if(count($dropmenu_rent)){ ?>
								<ul class="level second-top" style="display: none;">
									<div class="verh"></div>
									<div class="corner-tl"></div>
									<div class="corner-tr"></div>
									<div class="corner-bl"></div>
									<div class="corner-br"></div>
									<?php foreach ($dropmenu_rent as $dropitem){ ?>
										<li><a href="<?php echo site_url($dropitem->get('uri')); ?>" title="<?php echo $dropitem->get('title'); ?>"><?php echo $dropitem->get('title'); ?></a></li>
									<?php } ?>


								</ul>
							<?php } ?>
							</li>
							<?php
								$topmenu = find('Menu')->where('header_menu', 'T')->order_by('priority', 'ASC')->get();
								if(count($topmenu)){
								foreach ($topmenu as $topitem){ ?><li><a href="<?php echo site_url($topitem->get('uri')); ?>" title="<?php echo $topitem->get('title'); ?>"><?php echo $topitem->get('title'); ?></a></li><?php } ?>
							<?php } ?>
						</ul></div>

						<div class="galary"><?php $realestates = find('realestate')->documents(TRUE)->where('frontstate', 'N')->where('carousel', 'Y')->order_by('date_insert DESC')->get(); ?>
							<div id="slider"><ul><?php
								foreach ($realestates as $realestate):
								$thumb = $realestate->get('thumbnail');
								if (!is_array($thumb) || !isset($thumb[0]) || !is_object($thumb[0]))
								continue;
								$realestateid = $realestate->get('id_record');
								$stateNew = $realestate->get('state_new') == 'Y';
								$realestatecats = recordCategoriesIds($realestateid);
							?>
							<li>
								<a href="<?php echo semantic_category_url($realestate, $realestatecats); ?>" class="tip_trigger">
									<img src="<?php echo preset_url(attach_url($thumb[0]->path), 'thumbnail');  ?>"  alt="<?php echo htmlspecialchars(strip_tags($realestate->get('title'))); ?>" >
									<span class='img_special'></span>
									<?php if($stateNew):?><span class="img_state_new"></span><?php endif;?>
									<?php /*?><span class='tip'><?php echo $realestate->get('title'); ?></span> <?php */?>
								</a></li>
								<?php endforeach; ?>
							</ul>
							</div>
						</div>

						</div>
						<div class="unit-20">
							<div class="header-books text-centered"><a href="<?php echo fromsettingspage(settings('website_auth_page')); ?>"><img src="/assets/images/knigi.png" alt="dfgdfg"></a></div>
							<div class="header-flowers text-centered"><img src="/assets/images/vazon.png" alt="flowers"></div>
						</div>
					</div>
					<div class="header-shell"></div>
				</div>
			</header><!-- end header -->
			<div class="header-fx"></div>
			<div class="body-part body-part-push">
				<div class="units-container">
					<div class="units-row-end units-split">
						<div class="unit-20 site-sidebar">
							<div class="sidebar-menu">
								<ul class="menu"><?php echo render_left_menu_by_category(get_menu_category(), $dropmenu, $dropmenu_rent); ?></ul>
								<div class="binder-fx-5"></div>
								<div class="corner-tl"></div>
								<div class="corner-tr"></div>
								<div class="corner-bl"></div>
								<div class="corner-br"></div>
							</div>
							<div class="clock"><a class="karta" title="Интерактивная карта Ялты" href="<?php echo fromsettingspage(settings('website_map_page')); ?>"><img src="/assets/images/karta.png" alt="d"></a></div>
						</div>
						<div class="unit-60">
							<div class="site-content">
								<div class="content-zindex">
									<?php echo template();?>
									<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
									<span itemprop="name">Агентство недвижимости в Ялте - Индиго,</span><br/>
									<div class="bot-cont"><span itemprop="addressLocality">Крым, г.Ялта</span>, <span itemprop="streetAddress">ул. Московская, д.43</span>, <span itemprop="postalCode">298600</span></div>
									<div class="adress-agent">
									<span itemprop="email"><a href="mailto:indigo-yalta@mail.ru">indigo-yalta@mail.ru</a></span><br/>
									<span itemprop="telephone">+7(978) 70-47-888<br/>
									+7(978) 70-75-888</span>
									</div>
									</span>
									<div class="bottom-menu">
										<ul class="menu">

											<li><a href="<?php echo site_url(); ?>" title="Главная">Главная</a> </li>

											<li aria-haspopup="true"> <a href="/sale" title="Продажа">ПРОДАЖА</a>
												<?php if(count($dropmenu)){ ?>
													<ul class="level second">
														<?php foreach ($dropmenu as $dropitem){ ?>
															<li><a href="<?php echo semantic_url($dropitem); ?>" title="<?php echo $dropitem->get('title'); ?>"><?php echo $dropitem->get('title'); ?></a></li>
														<?php } ?>
														<div class="niz"></div>
														<div class="corner-tl"></div>
														<div class="corner-tr"></div>
														<div class="corner-bl"></div>
														<div class="corner-br"></div>
													</ul>
												<?php } ?>
											</li>
											<li aria-haspopup="true"> <a href="/rent" title="Аренда">АРЕНДА</a>
												<?php if(count($dropmenu_rent)){ ?>
													<ul class="level second">
														<?php foreach ($dropmenu_rent as $dropitem){ ?>
															<li><a href="<?php echo semantic_url($dropitem); ?>" title="<?php echo $dropitem->get('title'); ?>"><?php echo $dropitem->get('title'); ?></a></li>
														<?php } ?>
														<div class="niz"></div>
														<div class="corner-tl"></div>
														<div class="corner-tr"></div>
														<div class="corner-bl"></div>
														<div class="corner-br"></div>
													</ul>
												<?php } ?>
											</li>
											<?php
												$bottommenu = find('Menu')->where('footer_menu', 'T')->order_by('priority', 'ASC')->get();
												if(count($bottommenu)){
												foreach ($bottommenu as $bottomitem){ ?><li><a href="<?php echo site_url($bottomitem->get('uri')); ?>" title="<?php echo $bottomitem->get('title'); ?>"><?php echo $bottomitem->get('title'); ?></a></li><?php } ?>
											<?php } ?>
										</ul>
									</div>
									<div class="copyright" style="margin-top:20px; margin-bottom:20px;"><a style="text-decoration: none;" href="http://mkvadrat.com/creat-site-estate">Продвижение сайта агентства недвижимости</a></div>
								</div>

								<div class="corner-tl"></div>
								<div class="corner-tr"></div>
								<div class="corner-bl"></div>
								<div class="corner-br"></div>

							</div>
						</div>
						<div class="unit-20">
							<div class="add-estate">
								<div class="corner-tl"></div>
								<div class="corner-tr"></div>
								<div class="corner-bl"></div>
								<div class="corner-br"></div>
								<a title="<?php echo settings('website_addestate'); ?>" href="<?php echo fromsettingspage(settings('website_buy_page')); ?>">срочный выкуп<span class="big">квартир</span></a>
							</div>
							<div class="clock"><img src="/assets/images/clock.png" alt="d"></div>
						</div>


					</div>




				</div>
			</div><!-- end content -->
			<div class="send-but"></div>
			<div class="send-mess">

				<div class="left">
					<a href="../onlajn-zayavka">Сделать<br/>online-заявку</a>
					<span class="s-t">Отдел аренды:</span>
					<p>+7978 071-55-35</p>
				</div>

				<div class="right">
					<span class="s-t">Отдел продаж:</span>
					<p>+7(978) 70-47-888</p>
					<p>+7(978) 70-75-888</p>
					<p>+7(978) 73-888-69</p>
				</div>
			</div>


			<footer class="body-part">
				<div class="footer-wrapper">
					<div class="footer-fx"><div class="cat"></div><div class="phone"></div><div class="boots"></div></div>
				</div>
			</footer><!-- end footer -->
		</section>

		<script>
			var stage1 = new swiffy.Stage(document.getElementById('flash-header'),
			indigoOkno);

			stage1.setBackground(null);
			stage1.start();

			var stage2 = new swiffy.Stage(document.getElementById('flash-logo'),
			indigoLogo);

			stage2.setBackground(null);
			stage2.start();
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('ul.level.second').each(function(){
					$(this).css('top', $(this).height()*-1-32);
				});
				$('.sidebar-menu.hovered').each(function(){
					$(this).css('top', $(this).height()*-1-70).css('left', '-5px');
				});
			});
		</script>

		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
			(function (d, w, c) {
				(w[c] = w[c] || []).push(function() {
					try {
						w.yaCounter30988071 = new Ya.Metrika({id:30988071,
							webvisor:true,
							clickmap:true,
							trackLinks:true,
						accurateTrackBounce:true});
					} catch(e) { }
				});

				var n = d.getElementsByTagName("script")[0],
				s = d.createElement("script"),
				f = function () { n.parentNode.insertBefore(s, n); };
				s.type = "text/javascript";
				s.async = true;
				s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

				if (w.opera == "[object Opera]") {
					d.addEventListener("DOMContentLoaded", f, false);
				} else { f(); }
			})(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="//mc.yandex.ru/watch/30988071" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
	</div>
	</body>
</html>
