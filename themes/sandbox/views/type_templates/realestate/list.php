<div class="estate-list-wrapper">
	<?php
	$page_h1 = page('meta_h1');
	$page_title = page('title');
	$page_body = page('content');
	?>
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>
<?php if(page('content') && $this->input->get('page') == 0){ ?>
<div class="description-wrapper">
	<?php echo page('content'); ?>
</div>
<?php } ?>

<?php if (have_records()) { ?>
	
	<div class="visitor-settings">
	<?php $orderdirection = $this->input->get('orderby'); $onpage = $this->input->get('onpage'); 
	
$default = array(current_url(), 'orderby', 'onpage', 'page');

$array = $this->uri->uri_to_assoc(3, $default);	?>
<form action="<?php echo current_url(); ?>" method="get" name="vsettings">
		<ul>
			<li class="show-num"><span>Показать на странице: </span>
<select name="onpage" onchange="vsettings.submit()">
	<option value="10">10</option>
	<option value="20"<?php echo($onpage == '20')? ' selected':''; ?>>20</option>
	<option value="50"<?php echo($onpage == '50')? ' selected':''; ?>>50</option>
	<option value="all"<?php echo($onpage == 'all')? ' selected':''; ?>>Все</option>
</select>
			
			</li>
			<li class="show-order"><span>Сортировать по: </span>
<select name="orderby" onchange="vsettings.submit()">
	<option value="" >Выбрать</option>
    <option value="price_asc"<?php echo($orderdirection == 'price_asc')? ' selected':''; ?>>Цена по возрастанию</option>
	<option value="price_desc"<?php echo($orderdirection == 'price_desc')? ' selected':''; ?>>Цена по убыванию</option>
    <option value="sku_asc" class="option-asc"<?php echo($orderdirection == 'sku_asc')? ' selected':''; ?>>Номер объекта</option>
    <option value="latest"<?php echo($orderdirection == 'latest')? ' selected':''; ?>>Последние поступления</option>
</select>
			</li>
		</ul>
		<div class="clear"></div>
		</form>
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
		/* process price */
		$currency = settings('website_pricecurrency'); 
		$currencyempty = settings('website_priceempty'); 
		$separator = ' ';

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
		$specialrow = $record->get('carousel');
		if($specialrow == 'Y'){
			$rowclass = ' highlight';
		}else{
			$rowclass = '';
		}
	?><li class="estate-item<?php echo $rowclass; ?>"><div class="name"><h3><span>№</span><span class="item-id"><?php echo $record->get('id_record'); ?></span><a href="<?php echo semantic_url($record); ?>"><?php echo $record->get('title'); ?></a></h3></div><div class="thumbnail"><a href="<?php echo semantic_url($record); ?>"><?php if($specialrow == 'Y'){ ?><span class='img_special'></span><?php } ?><img src="/assets/images/fotik.png" width="35" height="26" alt="Подробнее" class="fotik"><img src="<?php echo $thumbnailsrs;  ?>"  alt="<?php echo htmlspecialchars(strip_tags($record->get('title'))); ?>" ></a></div><div class="information"><?php echo $descr_plaintext; ?><a href="<?php echo semantic_url($record); ?>">Подробнее</a></div><div class="price"><div class="price-wrapper"><?php echo ($price) ? $s_left.preg_replace('/(?<=\d)\x' . bin2hex($separator[0]) . '(?=\d)/',$separator,number_format($price, 0, '.', $separator)).$s_right: $currencyempty;?></div></div><div class="clear"></div></li><?php } ?>
	</ul>
	<div class="clear"></div>
	<?php if (isset($this->pagination))	{ ?>
	<div class="pagination">
	<?php echo $this->pagination->create_links(); ?>
	</div>
	<?php } ?>




<?php } ?>

</div>
