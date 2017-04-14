<div class="estate-wrapper">
<?php

	/* process type */
	$type_def = $record->_tipo;	
	$recordid = $record->get('id_record');	
	
	/* process standart data */
	$title = record('title');
	$cleantitle = strip_tags(record('title'));

	/* process thumbnail */
	$record->set_documents();
	$thumbnail = record('thumbnail');
	if (is_array($thumbnail) && count($thumbnail)) {
		$thumbnaillink = true;
		$thumbnailsrs = preset_url(attach_url($thumbnail[0]->path), 'thumbnail');
		$thumbnailfull = attach_url($thumbnail[0]->path);
	} else {
		$thumbnaillink = false;
		$thumbnailsrs = '/assets/images/nophoto.jpg';
	}
	
	/* process price */
	$obj_price = new Price($record, page('uri') == 'novostrojki');
	$price_html = '';
	if ($obj_price->hasPrice()) {
		$price_html = $obj_price->getPrimaryPrice();
		if ($obj_price->hasSecondPrice())
			$price_html .= ' / <span>' . $obj_price->getSecondaryPrice() . '</span>';
		if ($obj_price->hasUnit())
			$price_html .= ' / ' . $obj_price->getUnit();
	}
	else
		echo $price_html = settings('website_priceempty');
	
	
	/* process special row */
	$specialrow = record('carousel') == 'Y';
	
	# State is new
	$stateNew = record('state_new') == 'Y';
	
	/* process is estate hidden */
	$frontstate = record('frontstate');
	if($frontstate == 'Y'){
		$soldclass = ' sold';
	}else{
		$soldclass = '';
	}
	/* process description */
	$description = record('content');

	/* process specifications */
	$total_area = record('total_area');
	$usefull_area = record('usefull_area');
	$kitchen_area = record('kitchen_area');
	$lodgia_area = record('lodgia_area');
	$total_floors = record('total_floors');
	$app_floor = record('app_floor');

	/* process sharing */
	$sharerblock_links = settings('website_sharerblock_links');
?>
	<?php if($this->auth->is_logged() && record('hiddenannotation') !=''){?>
	<div class="hidden-description">
		<div class="section-title">Информация для сотрудников агентства</div>
		<?php echo record('hiddenannotation'); ?>
		<div class="clear"></div>
	</div>
	<?php } ?>

	<div class="estate-thumb">
		<?php if($thumbnaillink){?>
		<a href="<?php echo $thumbnailfull; ?>" data-rel="prettyPhoto[<?php echo $recordid; ?>]">
			<?php if($specialrow){ ?><span class="img_special"></span><?php } ?>
			<?php if($stateNew){ ?><span class="img_state_new"></span><?php } ?>
			<img src="<?php echo $thumbnailsrs;  ?>"  alt="<?php echo $cleantitle; ?>" >
		</a>
		<?php }else{?>
			<?php if($specialrow){ ?><span class="img_special"></span><?php } ?>
			<?php if($stateNew){ ?><span class="img_state_new"></span><?php } ?>
			<img src="<?php echo $thumbnailsrs;  ?>"  alt="<?php echo $cleantitle; ?>" >
		<?php } ?>
	</div>
	<div class="estate-title">
		<div class="estate-id">№<?php echo $recordid; ?></div>
		
		<div class="sharer">
		<?php if (in_array("tw", $sharerblock_links)): ?>
        	<a class="tw-share"  href="http://twitter.com/home?status=<?php echo urlencode($cleantitle); ?>-<?php echo current_url(); ?>" onclick="return sharer('twitter', this.href, 600, 400);" title="Сохранить в Twitter&#39;е"></a>
		<?php endif; ?>
		<?php if (in_array("vk", $sharerblock_links)) { ?>
        	<a class="vk-share"  href="http://vkontakte.ru/share.php?url=<?php echo current_url(); ?>&amp;title=<?php echo urlencode($cleantitle); ?>&amp;noparse=true"  onclick="return sharer('vkontakte', this.href, 600, 280);" title="Сохранить ВКонтакте"></a>
		<?php } ?>
		<?php if (in_array("fb", $sharerblock_links)) { ?>
			<a class="fb-share" href="https://www.facebook.com/sharer.php?u=<?php echo current_url(); ?>&amp;t=<?php echo urlencode($cleantitle); ?>" onclick="return sharer('facebook', this.href, 1000, 640);" title="Сохранить в Facebook"></a>
		<?php } ?>
			<div class="clear"></div>
		</div>
		
		<div class="clear"></div>
		<h1><?php echo $title; ?></h1>
	</div>
	<div class="estate-price"><?php echo $price_html; ?></div>
	<div class="clear"></div>
	


	<?php if($description): ?>
	<div class="estate-description">
		<div class="section-title">Описание</div>
		<?php echo $description; ?>
		<div class="clear"></div>
	</div>
	<?php endif; ?>


	<?php if($total_area || $usefull_area || $kitchen_area || $lodgia_area || $app_floor || $total_floors){?>
	<div class="estate-detailed">
		<div class="section-title">Дополнительная информация</div>
		<ul class="specifications-list">
		<?php if($total_area){?>
			<li class="specification-item">
			<span class="title">Общая площадь</span>
			<span class="value"><?php echo $total_area; ?>m&sup2;</span>
			</li>
		<?php } ?>
		<?php if($usefull_area){?>
			<li class="specification-item">
			<span class="title">Жилая площадь</span>
			<span class="value"><?php echo $usefull_area; ?>m&sup2;</span>
			</li>
		<?php } ?>
		<?php if($kitchen_area){?>
			<li class="specification-item">
			<span class="title">Кухня</span>
			<span class="value"><?php echo $kitchen_area; ?>m&sup2;</span>
			</li>
		<?php } ?>
		<?php if($lodgia_area){?>
			<li class="specification-item">
			<span class="title">Балкон</span>
			<span class="value"><?php echo $lodgia_area; ?>m&sup2;</span>
			</li>
		<?php } ?>
		<?php if($app_floor){?>
			<li class="specification-item">
			<span class="title">Этаж</span>
			<span class="value"><?php echo $app_floor; ?></span>
			</li>
		<?php } ?>
		<?php if($total_floors){?>
			<li class="specification-item">
			<span class="title">Этажность</span>
			<span class="value"><?php echo $total_floors; ?></span>
			</li>
		<?php } ?>
		</ul>
	<div class="clear"></div></div>
	<?php } ?>

	<?php $photos = record('images'); ?>
	<?php if (is_array($photos) && count($photos)) { ?>
	<div class="estate-photos">
		<div class="section-title">Фотографии</div>
		<ul class="estate-photos-list">
		<?php foreach ($photos as $photo) { ?>
		<?php
			$photosrs = preset_url(attach_url($photo->path), 'photo');
			$photofull = attach_url($photo->path);
		?>
			<li><a href="<?php echo $photofull; ?>" data-rel="prettyPhoto[<?php echo $recordid; ?>]"><img src="<?php echo $photosrs;  ?>"  alt="<?php echo $cleantitle; ?>" ></a></li>
		<?php } ?>
		</ul>
	<div class="clear"></div>
	</div>
	<?php } ?>
	
	<?php $relatedestates = recordsimilar($record, 5); // print_r($relatedestates);?>
	<?php if (is_array($relatedestates) && count($relatedestates)): ?>
	<div class="related-estate">
		<div class="section-title">Другие объекты</div>
		<ul class="related-estate-list">
		<?php foreach($relatedestates as $relatedestate){
			
		$relthumbnail = $relatedestate->get('thumbnail');
		if (is_array($relthumbnail) && count($relthumbnail)) {
			$relthumbnailsrs = preset_url(attach_url($relthumbnail[0]->path), 'similar');
		}else{
			$relthumbnailsrs = '/assets/images/nophoto_small.jpg';
		}

		/* process price */
		$r_price = new Price($relatedestate, page('uri') == 'novostrojki');
		$price_html = '';
		if ($r_price->hasPrice()) {
			$price_html = $r_price->getPrimaryPrice();
			if ($r_price->hasSecondPrice())
				$price_html .= ' / <span>' . $r_price->getSecondaryPrice() . '</span>';
			if ($r_price->hasUnit())
				$price_html .= ' / ' . $r_price->getUnit();
		}
		else
			echo $r_price = settings('website_priceempty');
		
		


		/* process special row */
		$relspecialrow = $relatedestate->get('carousel');
		if($relspecialrow == 'Y'){
			$relrowclass = ' highlight';
		}else{
			$relrowclass = '';
		}
	?>
			<li class="related-item<?php echo $relrowclass; ?>">
				<div class="thumb">
					<a href="<?php echo semantic_url($relatedestate); ?>">
					<?php if($relspecialrow == 'Y'){ ?><span class='img_special'></span><?php } ?>
					<img src="<?php echo $relthumbnailsrs;  ?>"  alt="<?php echo strip_tags($relatedestate->get('title')); ?>" >
					</a>
				</div>
				<div class="title">
					<h3><span class="item-id">№<?php echo $relatedestate->get('id_record'); ?></span> - <a href="<?php echo semantic_url($relatedestate); ?>"><?php echo $relatedestate->get('title'); ?></a></h3>
				</div>
				<div class="price"><div class="price-wrapper"><?php echo $price_html; ?></div></div>
				<div class="clear"></div>
				</li>
		<?php } ?>
		</ul>
	</div>
	<?php endif; ?>

    <?php if (record('mapactive')=='Y'): ?>
    <div class="simple-map-wrapper" id="simple-map"></div>
    <?php endif; ?>
</div>
