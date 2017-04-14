<h1><?php echo page('title'); ?></h1>
<p><?php echo page('content'); ?></p>

<?php if (have_records()) { ?>
	<ul>
	<?php foreach (records() as $record) { ?>
			<li>
				<a href="<?php echo semantic_url($record); ?>">
					<?php echo $record->get('title'); ?>
				</a>
			</li>
	<?php } ?>
	</ul>
	

	<?php echo pagination(); ?>


<?php }

/* End of file list.php */
/* Location: /type_templates/Default-Content/list.php */