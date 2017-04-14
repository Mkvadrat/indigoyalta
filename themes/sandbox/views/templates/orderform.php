<div class="breadcrumbs"><?php load_helper('breadcrumbs'); echo breadcrumbs(tree('breadcrumbs'));?></div>
<div class="page-outer">
<?php
$website_name = settings('website_name_ru');


$page_h1 = page('meta_h1');
$page_title = page('title');
$page_id = page('id_record');
$page_body = page('content');

$template_feedback_email = page('template_feedback_email');

?>
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>
	<?php if($page_body){ ?>
	<div class="page-inner">
		<?php echo $page_body; ?>
		<div class="clear"></div>
	</div>
	<?php } ?>

	<div class="request-form">
		<?php
		
		
		
		$config = array(
			'action' => 'email',
			'from' => 'website@indigo-yalta.com',
			'from_name' => settings('website_claim_ru'),
			'to' => settings('website_adminmail'),
//			'to' => 'fastimus@fastimus.ru',
			'subject' => 'Новая заявка с сайта' );
		
//		print_r($config);
		echo module('requestform', $config)->render();
		?>
	<div class="clear"></div>
	</div>

	<div class="clear"></div>
</div>




