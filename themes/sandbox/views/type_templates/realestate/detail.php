<div class="estate-wrapper">
<?php
	/* process type */
	$type_def = $record->_tipo;	
	$recordid = $record->id;	

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
	}else{
		$thumbnaillink = false;
		$thumbnailsrs = '/assets/images/nophoto.jpg';
	}
	/* process price */
	$currency = settings('website_pricecurrency'); 
	$currencyempty = settings('website_priceempty'); 
	if($currency == 'usd'){
		$s_left = '$';
		$s_right = '';
	}elseif($currency == 'uah'){
		$s_left = '';
		$s_right = ' грн';
	}elseif($currency == 'euro'){
		$s_left = '&euro;';
		$s_right = '';
	}
	$operationtype = $record->get('deal_type');
	if($operationtype == 'S'){
		$price = $record->get($currency.'_total');
	}else{
		if($record->get($currency.'_month') !=''){
			$price = $record->get($currency.'_month');
			$renttext = '/ месяц';
		}else{
			$price = $record->get($currency.'_day');
			$renttext = '/ сутки';
		}
	}
	/* process special row */
	$specialrow = record('carousel');
	/* process is estate hidden */
	$frontstate = record('frontstate');
	if($frontstate == 'Y'){
		$soldclass = ' sold';
	}else{
		$soldclass = '';
	}
	/* process description */
//	if($this->auth->is_logged()){
		$description = record('content');
//	}else{
//		$phones = array();
//		preg_match_all("/\b((8|\+38)[\w'-]?)?(\(?\d{2,5}?\)?)?[\w'-]?\d{3}[\w'-]?\d{2}[\w'-]?\d{2}\b(?s).*/x", record('content'), $phones);
//		preg_match_all("/\+\b((8|\+38)[\w'-]?)?(\(?\d{2,5}?\)?)?[\w'-]?\d{3}[\w'-]?\d{2}[\w'-]?\d{2}\b(?s)/x", record('content'), $phones);
//		$phones = $phones[0];
		
//		$description = str_replace($phones, "".$phones."", record('content'));
//	}

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
		<?php if($specialrow == 'Y'){ ?><span class='img_special'></span><?php } ?>
		<a href="<?php echo $thumbnailfull; ?>" data-rel="prettyPhoto[<?php echo $recordid; ?>]">
			<img src="<?php echo $thumbnailsrs;  ?>"  alt="<?php echo $cleantitle; ?>" >
		</a>
		<?php }else{?>
			<?php if($specialrow == 'Y'){ ?><span class='img_special'></span><?php } ?>
			<img src="<?php echo $thumbnailsrs;  ?>"  alt="<?php echo $cleantitle; ?>" >
		<?php } ?>
	</div>
	<div class="estate-title">
		<div class="estate-id">№<?php echo $recordid; ?></div>
		
		<div class="sharer">
		<? if (in_array("tw", $sharerblock_links)) { ?>
        	<a class="tw-share"  href="http://twitter.com/home?status=<?php echo urlencode($cleantitle); ?>-<?php echo current_url(); ?>" onclick="return sharer('twitter', this.href, 600, 400);" title="Сохранить в Twitter&#39;е"></a>
		<?php } ?>
		<? if (in_array("vk", $sharerblock_links)) { ?>
        	<a class="vk-share"  href="http://vkontakte.ru/share.php?url=<?php echo current_url(); ?>&amp;title=<?php echo urlencode($cleantitle); ?>&amp;noparse=true"  onclick="return sharer('vkontakte', this.href, 600, 280);" title="Сохранить ВКонтакте"></a>
		<?php } ?>
		<? if (in_array("fb", $sharerblock_links)) { ?>
			<a class="fb-share" href="https://www.facebook.com/sharer.php?u=<?php echo current_url(); ?>&amp;t=<?php echo urlencode($cleantitle); ?>" onclick="return sharer('facebook', this.href, 1000, 640);" title="Сохранить в Facebook"></a>
		<?php } ?>
			<div class="clear"></div>
		</div>
		
		<div class="clear"></div>
		<h1><?php echo $title; ?></h1>
	</div>
	<div class="estate-price"><?php echo ($price) ? $s_left.$price.$s_right: $currencyempty;?></div>
	<div class="clear"></div>
	


	<?php if($description){?>
	<div class="estate-description">
		<div class="section-title">Описание</div>
		<?php echo $description; ?>
		<div class="clear"></div>
	</div>
	<?php } ?>


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
	
	<?php $relatedestates = recordsimilar($recordid);?>
	<?php if (is_array($relatedestates) && count($relatedestates)) { ?>
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
		$currency = settings('website_pricecurrency'); 
		$currencyempty = settings('website_priceempty'); 
		
		if($currency == 'usd'){
			$s_left = '$';
			$s_right = '';
		}elseif($currency == 'uah'){
			$s_left = '';
			$s_right = ' грн';
		}elseif($currency == 'euro'){
			$s_left = '&euro;';
			$s_right = '';
		}
		$reloperationtype = $relatedestate->get('deal_type');
		if($reloperationtype == 'S'){
			$relprice = $relatedestate->get($currency.'_total');
		}else{
			if($relatedestate->get($currency.'_month') !=''){
				$relprice = $relatedestate->get($currency.'_month');
				$relrenttext = '/ месяц';
			}else{
				$relprice = $relatedestate->get($currency.'_day');
				$relrenttext = '/ сутки';
			}
			
		}
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
				<div class="price"><div class="price-wrapper"><?php echo ($relprice) ? $s_left.$relprice.$s_right: $currencyempty;?></div></div>
				<div class="clear"></div>
				</li>
		<?php } ?>
		</ul>
	</div>
	<?php } ?>
	
	<?php /*?><div class="section social-comments">
		<div class="section-title">Комментарии</div>
		<ul class="tabs">
			<li class="current">ВКонтакте</li>
			<li>Facebook</li>
		</ul>
		<div class="clear"></div>
		<div class="box visible">
			<div id="vk_comments"></div>
	<script type="text/javascript">
	VK.Widgets.Comments("vk_comments", {limit: 5, width: "660", attach: false}, 660);
	</script>
		</div>
	
		<div class="box">
			<div class="fb-comments" data-href="<?php echo current_url(); ?>" data-width="660" data-num-posts="5"></div>
		</div>
	
	</div><?php */?>
	
</div>
