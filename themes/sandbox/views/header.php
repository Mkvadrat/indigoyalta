<div id="wrapper">
	<header id="header">
		<div class="container">
			<div class="logo">
				<a href="<?php echo site_url(); ?>" title="<?php echo settings('website_name_ru'); ?>"><?php echo settings('website_name_ru'); ?></a>
				<div class="site-slogan"><?php echo settings('website_claim_ru'); ?></div>
			</div>

			<div class="clear"></div>
			<div class="main-navigation">
				<ul>
					<?php echo mainmenu(tree(), 1); ?>
				</ul>
			</div>
		</div>
	</header>
