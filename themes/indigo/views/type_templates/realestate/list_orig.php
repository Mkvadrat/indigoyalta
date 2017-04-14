<?php
	
	# Define all the input variables
	$currency = page('realestate_currency_selector'); 
	$currencyempty = settings('website_priceempty'); 
	$page_h1 = page('meta_h1');
	$page_title = page('title');
	$page_body = page('content');
	
	# Objects per page
	$onpageValues = array(
	'20' => '20',
	'50' => '50',
	'all' => 'Все'
	);
	$onpage = $this->input->get('onpage');
	if ($onpage == '' || !isset($onpageValues[$onpage]))
	$onpage = '20';
	
	
	
?>
<div class="estate-list-wrapper">
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>
	
	
	<?php if (have_records()) { ?>
		<div class="units-row-end visitor-settings-row">
			<div class="unit-70" style="width: 65%;">
				<div class="visitor-settings">
					<?php
						
						$orderdirection = $this->input->get('orderby'); 
						$default = array(current_url(), 'orderby', 'onpage', 'page');
					$array = $this->uri->uri_to_assoc(3, $default);	?>
					
					<form action="<?php echo current_url(); ?>" class="zero" method="get" name="vsettings">
						<ul>
							<li class="show-order"><span>Сортировка: </span>
								<select name="orderby" onchange="vsettings.submit()">
									<option value="" >Выбрать</option>
									<option value="price_asc"<?php echo($orderdirection == 'price_asc')? ' selected':''; ?>>Цена по возрастанию</option>
									<option value="price_desc"<?php echo($orderdirection == 'price_desc')? ' selected':''; ?>>Цена по убыванию</option>
									<option value="sku_asc" class="option-asc"<?php echo($orderdirection == 'sku_asc')? ' selected':''; ?>>Номер объекта</option>
									<option value="latest"<?php echo($orderdirection == 'latest')? ' selected':''; ?>>Последние поступления</option>
								</select>
							</li>
							<li class="show-num"><span>На странице: </span>
								<select name="onpage" onchange="vsettings.submit()">
									<?php
										foreach ($onpageValues as $value => $title) {
											$isSelected = $onpage == $value ? ' selected="selected"' : '';
											echo '<option value="' . $value . '"' . $isSelected . '>' . $title . '</option>';
										}
									?>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
					</form>
				</div>
			</div>
			<div class="unit-30 text-right" style="width: 35%;">
				<a class="btn btn-blue" href="<?php echo fromsettingspage(settings('website_add_page')); ?>">Добавить объявление <i class="fa fa-plus-circle"></i></a>
			</div>
		</div>	
		
		<ul class="estate-list">
			
			<?php
				
				foreach (records() as $record) {
					/* process thumbnail */
					$record->set_documents();
					$thumbnail = $record->get('thumbnail');
					if (is_array($thumbnail) && count($thumbnail)) {
						$thumbnailsrs = preset_url(attach_url($thumbnail[0]->path), 'thumbnail');
						}else{
						$thumbnailsrs = '/assets/images/nophoto.jpg';
					}
					
					
					/* process description */
					$description_symbols = 150;
					$descr_plaintext = strip_tags(html_entity_decode($record->get('content'), ENT_QUOTES, 'UTF-8'));
					if( mb_strlen($descr_plaintext, 'UTF-8') > $description_symbols ) {
						$descr_plaintext = mb_substr($descr_plaintext, 0, $description_symbols, 'UTF-8') . '&hellip;&nbsp;';
					}
					
					
					
					$obj_price = new Price($record, page('uri') == 'novostrojki');
					$price_html = '';
					if ($obj_price->hasPrice()) {
						if ($obj_price->hasSecondPrice())
						$price_html .= '<span class="second-price">' . $obj_price->getSecondaryPrice() . '</span>';
						if ($obj_price->getDialType() == Price::DEAL_RENT && $obj_price->hasUnit())
						$price_html = '<span class="unit">За '.$obj_price->getUnit().'</span>';
						$price_html .= $obj_price->getPrimaryPrice();
						if ($obj_price->getDialType() == Price::DEAL_SALE && $obj_price->hasUnit())
						$price_html .= '<span class="unit">за 1 м²</span>';
					}
					else
					$price_html = $currencyempty;
					
					/* process special row */
					$specialrow = $record->get('carousel') == 'Y';
					$stateNew = $record->get('state_new') == 'Y';
                    /*Вывод площади*/
					$total_area = $record->get('total_area');
					/*Вывод площади*/
					
					/*Вывод адреса*/
					$adress = $record->get('adress_object');
					/*Вывод адреса*/
					
					?><li class="estate-item<?php echo $specialrow ? ' highlight' : ''; ?>">
					<div class="name">
						<h3><span>№</span><span class="item-id"><?php echo $record->get('id_record'); ?></span><a href="<?php echo semantic_url($record); ?>"><?php echo $record->get('title'); ?></a></h3>
					</div>
					<div class="thumbnail"><a href="<?php echo semantic_url($record); ?>"><?php if($specialrow){ ?><span class='img_special'></span><?php } ?><?php if($stateNew){ ?><span class="img_state_new"></span><?php } ?><img src="/assets/images/fotik.png" width="35" height="26" alt="Подробнее" class="fotik"><img src="<?php echo $thumbnailsrs;  ?>"  alt="<?php echo htmlspecialchars(strip_tags($record->get('title'))); ?>" ></a></div>
					<div class="information">
					    <div class="description-estate"><?php echo $descr_plaintext; ?><a href="<?php echo semantic_url($record); ?>">Подробнее</a></div>
					    <div class="adress-estate"><?php if($adress){ ?>Адрес: <?php echo $adress;?><?php } ?></div>
					</div>
					
					<div class="price">
						<div class="price-wrapper">Цена: <?php echo $price_html; ?></div>
					</div>
					<div class="other-options">
					    <div class="total_area"><?php if($total_area){ ?>Площадь: <?php echo $total_area . 'м²'; ?><?php } ?></div>
					</div>
					<div class="clear"></div>
					</li>
					<?php } ?>
		</ul>
		<div class="clear"></div>
		
		<div class="units-row">
			<div class="unit-30"> <a class="btn btn-blue btn-add-estate" href="<?php echo fromsettingspage(settings('website_add_page')); ?>">Добавить объявление <i class="fa fa-plus-circle"></i></a> </div>
			<div class="unit-70 text-right">
				<?php if (isset($this->pagination))	{ ?>
					<div class="pagination zero middle-vertical text-centered">
						<?php echo $this->pagination->create_links(); ?>
					</div>
				<?php } ?>
				
			</div>
		</div>
		
	<?php } ?>
	<?php if(page('content') && $this->input->get('page') == 0) { ?>
<div class="description-wrapper">
	<?php echo page('content'); ?>
</div>
<?php } ?>
</div>
