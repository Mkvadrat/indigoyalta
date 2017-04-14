<div class="core-container">

	<?php
	$lgactive = false;

	$headblock = array(
		'header' => $this->settings->get('website_name_ru'),
		'subheader' => $this->settings->get('website_claim_ru'),
		'headicon' => 'home fa-2x',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> $lgactive,
		'linkgroup' => false,
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
	);
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">

	<?php echo $this->view->get_messages(); ?>

	
  <div class="units-row">
  	<div class="unit-50"><?php // print_r($actions); ?></div>
  	<div class="unit-50"><?php // print_r($visitors); ?></div>
  </div>
  
	</div>
  
</div>
