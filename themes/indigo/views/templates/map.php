<div class="breadcrumbs"><?php load_helper('breadcrumbs'); echo breadcrumbs(tree('breadcrumbs'));?></div>
<div class="page-outer">
<?php
$page_h1 = page('meta_h1');
$page_title = page('title');
$page_id = page('id_record');
$page_body = page('content');


?> 

<?php 

 
 ?> 
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>
	<?php if($page_body){ ?>
	<div class="page-inner">
		<?php echo $page_body; ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<!--<div class="simple-map-wrapper" id="simple-map"></div>-->
	<div class="simple-map-wrapper">
		<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=Vzg_xHhLz7730aC1b3g-6AHmKVtQFSJi&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
	</div>
	<div class="clear"></div>
</div>