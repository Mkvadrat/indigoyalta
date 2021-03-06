<div class="page-outer">
	<?php
	$page_h1 = page('meta_h1');
	$page_title = page('title');
	$page_body = page('content');
	?>
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>
	<?php if($page_body  && $this->input->get('page') == 0){ ?>
	<div class="page-inner">
		<?php echo $page_body; ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="clear"></div>

	<div class="articles-list-wrapper">
		<?php if (have_records()) { ?>
		<ul class="articles-list">
			<?php foreach (records() as $record) {?>
			<?php
			$record_h1 = $record->get('meta_h1');
			$record_title = $record->get('title');
			/* process thumbnail */
			$record->set_documents();
			$thumbnail = $record->get('thumbnail');
			if (is_array($thumbnail) && count($thumbnail)) {
				$thumbnailsrs = preset_url(attach_url($thumbnail[0]->path), 'thumbnail');
			}
			?>
			<li class="article-item-wrapper">
				<div class="title"><h2><a href="<?php echo semantic_url($record); ?>"><?php echo ($record_h1)? $record_h1:$record_title; ?></a></h2></div>
				<?php if($thumbnailsrs){ ?>
				<div class="thumbnail">
					<a href="<?php echo semantic_url($record); ?>">
					<img src="<?php echo $thumbnailsrs;  ?>"  alt="<?php echo strip_tags($record->get('title')); ?>" >
					</a>
				</div>
				<?php } ?>
				<div class="excerpt">
					<?php echo auto_typography($record->get('content'));?>
				<div class="clear"></div>
				</div>
				<a href="<?php echo semantic_url($record); ?>">подробнее</a>
			</li>
			<?php } ?>
		</ul>
		<div class="clear"></div>
		<?php if (isset($this->pagination))	{ ?>
		<div class="pagination">
		<?php echo $this->pagination->create_links(); ?>
		</div>
		<?php } ?>
		<?php } ?>
	</div>
	
	<div class="clear"></div>
</div>



