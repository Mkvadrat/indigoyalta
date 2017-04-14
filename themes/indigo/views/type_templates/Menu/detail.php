<div class="page-outer">
	<?php
	$page_h1 = page('meta_h1');
	$page_title = page('title');
	$page_id = page('id_record');
	$page_body = page('content');
	?>
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>
	<?php if($page_body){ ?>
	<div class="page-inner">
		<?php $this->load->helper('typography'); $page_body = auto_typography($page_body);?>
		<?php echo $page_body; ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="clear"></div>
</div>

