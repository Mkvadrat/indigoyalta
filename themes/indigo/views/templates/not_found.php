<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="breadcrumbs"><?php load_helper('breadcrumbs'); echo breadcrumbs(tree('breadcrumbs'));?></div>
<div class="page-outer">
	<div class="page-title"><h1><h1><?php echo settings('website_404_title'); ?></h1></h1></div>
	<?php if(settings('website_404')){ ?>
	<div class="page-inner">
		
		<?php echo settings('website_404'); ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="clear"></div>
</div>

