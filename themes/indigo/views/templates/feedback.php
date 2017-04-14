<div class="breadcrumbs"><?php load_helper('breadcrumbs'); echo breadcrumbs(tree('breadcrumbs'));?></div>
<div class="page-outer">
<?php
$page_h1 = page('meta_h1');
$page_title = page('title');
$page_id = page('id_record');
$page_body = page('content');

$template_feedback_email = page('template_feedback_email');
$template_feedback_adress = page('template_feedback_adress');
$template_feedback_city = page('template_feedback_city');
$template_feedback_region = page('template_feedback_region');
$template_feedback_postcode = page('template_feedback_postcode');
$template_feedback_country = page('template_feedback_country');
$template_feedback_mobile = page('template_feedback_mobile');
$template_feedback_fixed = page('template_feedback_fixed');
$template_feedback_fax = page('template_feedback_fax');
$template_feedback_website = page('template_feedback_website');
$template_feedback_content = page('template_feedback_content');
?>
	<div class="page-title"><h1><!--<?php echo ($page_h1)? $page_h1:$page_title; ?>-->Контакты:</h1></div>
	<?php if($page_body){ ?>
	<div class="page-inner">
		<?php echo $page_body; ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="feedback-data">
			<div class="map-content">    	   
               <!--<figure>
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2845.315176948433!2d34.16704781578737!3d44.50869730470691!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4094c90a66d202bf%3A0x5418510a6d7b7add!2z0JDQs9C10L3RgtGB0YLQstC-INC90LXQtNCy0LjQttC40LzQvtGB0YLQuCAi0JDQsdGD0LTQsNCx0Lgi!5e0!3m2!1sru!2sua!4v1449737431847" width="450" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
               </figure>-->
			        <div class="adress-agency-full">
					    <strong>Адрес офиса: </strong>
			            <adress><?php echo($template_feedback_adress)? $template_feedback_adress.', ' :''; ?>
				                <?php echo($template_feedback_city)? $template_feedback_city.', ' :''; ?>
				                <?php echo($template_feedback_region)? $template_feedback_region.', ' :''; ?>
				                <?php echo($template_feedback_postcode)? $template_feedback_postcode.', ' :''; ?>
				                <?php echo($template_feedback_country)? $template_feedback_country :''; ?>
								<?php echo safe_mailto($template_feedback_email); ?> 
								<!--<?php if($template_feedback_website){ ?>
								<a href="<?php echo $template_feedback_website; ?>"><?php echo $template_feedback_website; ?></a>
								<?php } ?></adress><br/>-->
						<br/>
						<br/>
						<strong>Время работы: </strong>Мы работаем с 09:00 до 18:00
	                </div>

			    <div class="simple-map-wrapper" id="simple-map"></div>
			
			    <?php if (!empty($template_feedback_adress)) { ?>
			    <script src="http://api-maps.yandex.ru/2.0/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
                    <script type="text/javascript">
                        var myMap;
                        ymaps.ready(init);
                        function init()
                        {
                            ymaps.geocode('<?php echo $template_feedback_city . $template_feedback_adress; ?>', {
                                results: 1
                            }).then
                            (
                                function (res)
                                {
                                    var firstGeoObject = res.geoObjects.get(0),
                                        myMap = new ymaps.Map
                                        (document.getElementById("simple-map"),
                                            {
                                                center: firstGeoObject.geometry.getCoordinates(),
                                                zoom: 15
                                            }
                                        );
                                    var myPlacemark = new ymaps.Placemark
                                    (
                                        firstGeoObject.geometry.getCoordinates(),
                                        {
                                            iconContent: ''
                                        },
                                        {
                                            preset: 'twirl#blueStretchyIcon'
                                        }
                                    );
                                    myMap.geoObjects.add(myPlacemark);
                                    myMap.controls.add(new ymaps.control.ZoomControl()).add(new ymaps.control.ScaleLine()).add('typeSelector');
                                },
                                function (err)
                                {
                                    alert(err.message);
                                }
                            );
                        }
                    </script>
		        <?php }?>
	        </div>
		<!--<ul class="left-part">
			<li class="location">
				<?php echo($template_feedback_adress)? $template_feedback_adress.', ' :''; ?>
				<?php echo($template_feedback_city)? $template_feedback_city.', ' :''; ?>
				<?php echo($template_feedback_region)? $template_feedback_region.', ' :''; ?>
				<?php echo($template_feedback_postcode)? $template_feedback_postcode.', ' :''; ?>
				<?php echo($template_feedback_country)? $template_feedback_country :''; ?>
			</li>
			<?php if($template_feedback_email){ ?>
			<li class="email">
				<?php echo safe_mailto($template_feedback_email); ?>
			</li>
			<?php } ?>
			<?php if($template_feedback_website){ ?>
			<li class="website">
				<?php echo $template_feedback_website; ?>
			</li>
			<?php } ?>
		</ul>-->
		
		<ul class="right-part">
			<?php
			if($template_feedback_mobile){ 
			$phones = explode(',',$template_feedback_mobile);
			foreach ($phones as $phone){
			?>
			<li class="mobile">
				<?php echo $phone; ?>
			</li>
			<?php } } ?>
			<?php if($template_feedback_fixed){ ?>
			<li class="fixed">
				<?php echo $template_feedback_fixed; ?>
			</li>
			<?php } ?>
			<?php if($template_feedback_fax){ ?>
			<li class="fax">
				<?php echo $template_feedback_website; ?>
			</li>
			<?php } ?>
		</ul>
		<!--<div class="clear"></div>-->
		<?php if($template_feedback_content){ ?>
		<div class="feedback-data-additional">
			<?php echo $template_feedback_content; ?>
		</div>
		<?php } ?>
	</div>
	
	<div class="feedback-form">
		<?php
		$config = array(
			'action' => 'email',
			'from' => 'website@indigo-yalta.com',
			'from_name' => settings('website_claim_ru'),
			'to' => settings('website_adminmail'),
//			'to' => 'fastimus@fastimus.ru',
			'subject' => 'Новый запрос с сайта' );
		echo module('contact_form', $config)->render();
		?>
	<div class="clear"></div>
	</div>

	<div class="clear"></div>
</div>




