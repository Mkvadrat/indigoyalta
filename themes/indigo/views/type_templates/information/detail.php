<div class="page-outer">
	<?php
	$page_h1 = record('meta_h1');
	$page_title = record('title');
	$page_id = record('id_record');
	$page_body = record('content');
	?>
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>
	<?php if($page_body){ ?>
	<div class="page-inner">
		<?php echo auto_typography($page_body);?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="clear"></div>
</div>