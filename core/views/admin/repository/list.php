<div class="core-container">
<?php $this->load->helper('form');?>

	<?php
	$lgactive = false;

	$headblock = array(
		'header' => _('Images repository'),
		'subheader' => _('Here you can find the last uploaded images.'),
		'headicon' => 'picture-o fa-2x color-sunflower',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> $lgactive,
		'linkgroup' => false,
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
		'last' => _('Images repository'),
	);
	$presets_select = form_dropdown('preset', $presets);
	
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">

	<?php // echo form_open_multipart(null, array('id'=>'upload'));?>
    <div class="dropbox">
      <span class="info-message">Перетащите сюда необходимые изображения<br /><i>(превью изображений будет доступно только для просмотра)</i></span>
    </div>
  
    <ul>
    </ul>
  <?php // echo form_close();?>

		<div class="table-container well-container">
      <table class="width-100 table-striped table-stroked repository-list">
          <thead>
            <tr>
              <th class="td-repothumb"><?php echo _('Thumbnail'); ?></th>
              <th><?php echo _('Filename'); ?></th>
              <th>Системные размеры</th>
              <th>Путь к файлу</th>
              <th class="td-actions"></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($repository_files as $file) { if (in_array($file->mime, array('png', 'jpg', 'gif', 'jpeg'))) { ?>
            <tr data-path="<?php echo $file->path; ?>">
              <td class="text-centered"><img src="<?php echo attach_url($file->thumb_path); ?>" alt="ghtdm" class="zero"></td>
              <td><?php echo $file->name; ?><br> <a class="label label-orange" target="_blank" href="<?php echo attach_url($file->path); ?>">просмотр</a></td>
              <td><?php echo $presets_select; ?></td>
              <td><a href="#" class="choose">Скопировать путь</a></td>
              <td class="td-actions text-centered"><a href="#" class="btn btn-red btn-small removefromrepo" onclick="return fastcms.remove.document(this, '<?php echo $file->id_document; ?>');"><i class="fa fa-times"></i></a></td>
            </tr>
          <?php } } ?>
          </tbody>
          <tfoot><tr><td colspan="5"></td></tr>
            
          </tfoot>
      </table>
		</div>
	</div>
	</div>
  <script src="/gui/corejs/repo/jquery.filedrop.js"></script>
  <script src="/gui/corejs/repo/script.js"></script>
