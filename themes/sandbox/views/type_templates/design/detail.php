<div class="estate-wrapper">
	<?php
	$record->set_documents();
	$type_def = $record->_tipo;	
	$recordid = $record->id;	
	$page_h1 = record('meta_h1');
	$page_title = record('title');
	$page_id = record('id_record');
	$page_body = record('content');
	$title = record('title');
	$cleantitle = strip_tags(record('title'));

	$thumbnail = record('thumbnail');
	if (is_array($thumbnail) && count($thumbnail)) {
		$thumbnaillink = true;
		$thumbnailsrs = preset_url(attach_url($thumbnail[0]->path), 'thumbnail');
		$thumbnailfull = attach_url($thumbnail[0]->path);
	}
	?>
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>

	<?php if($page_body){ ?>
	<div class="page-inner">
		<?php echo $page_body; ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="clear"></div>
	<?php $photos = record('images'); ?>
	<?php if (is_array($photos) && count($photos)) { ?>
	<div class="estate-photos">
		<div class="section-title">Фотографии</div>
		<ul class="estate-photos-list">
		<?php foreach ($photos as $photo) { ?>
		<?php
			$photosrs = preset_url(attach_url($photo->path), 'photo');
			$photofull = attach_url($photo->path);
		?>
			<li><a href="<?php echo $photofull; ?>" data-rel="prettyPhoto[<?php echo $recordid; ?>]"><img src="<?php echo $photosrs;  ?>"  alt="<?php echo $cleantitle; ?>" ></a></li>
		<?php } ?>
		</ul>
	<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<?php } ?>
</div>