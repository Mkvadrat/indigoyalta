<h1><?php echo page('title'); ?></h1>
<p><?php echo page('content'); ?></p>

<?php if (have_records()) { ?>
	<ul class="testmonials-list">
	<?php foreach (records() as $record) {
		
		$tauthor = $record->get('author');
		$tlink = $record->get('link');
		
		$record->set_documents();
		$screenshot = $record->get('screenshot');
		if (is_array($screenshot) && count($screenshot)) {
			$screenshotsrs = preset_url(attach_url($screenshot[0]->path), 'testmonial');
			$screenshotfull = attach_url($screenshot[0]->path);
		}else{
			$screenshotsrs = false;
			$screenshotfull = false;
		}
		
		 ?>
			<li class="testmonial-item" id="twrapper-<?php echo $record->get('id_record'); ?>">
					<div class="testmonial-title">
						<?php echo $record->get('title'); ?> <span class="testmonial-date"><?php echo date(LOCAL_DATE_FORMAT . ' H:i', $record->get('date_publish')); ?></span>
						
					</div>
					<?php if($screenshotsrs){ ?><div class="testmonial-scan text-centered"><a data-rel="prettyPhoto[<?php echo $record->get('id_record'); ?>]" href="<?php echo attach_url($screenshot[0]->path); ?>"><img src="<?php echo $screenshotsrs;  ?>"  alt="<?php echo htmlspecialchars(strip_tags($record->get('title'))); ?>" ></a></div><?php } ?>
					<div class="testmonial-fulltext"><?php echo $record->get('content'); ?></div>
          <div class="testmonial-meta">
						<?php if($tlink){?><a href="<?php echo $tlink; ?>" target="_blank"><?php echo $tauthor?></a>,<?php } else {  echo $tauthor.','; }?><br> <span class="testmonial-position"><?php echo  $record->get('jobposition') ?></span>
            <span class="testmonial-comefrom"><?php echo  $record->get('comefrom') ?></span>
					</div>


			</li>
	<?php } ?>
	</ul>
	

	<?php echo pagination(); ?>


<?php }
