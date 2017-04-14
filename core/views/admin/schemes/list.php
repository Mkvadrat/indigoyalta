<?php
$tipi = $this->content->types();
?>
<div class="core-container restricted-access">

	<?php
	$lgactive = true;

	$rebuiltbtn = array(
		'link' => admin_url('schemes/rebuild_cache/'),
		'icon' => 'refresh',
		'text' => 'перестроить кеш',
	);
	if ($this->auth->has_permission('types', 'add')) {
	$addstbtn = array(
		'link' => admin_url('contents/add_type/'),
		'icon' => 'plus-circle',
		'text' => 'добавить',
	);
	}
	$headblock = array(
		'header' => 'Структура базы данных',
		'subheader' => 'управление работой БД сайта',
		'headicon' => 'power-off fa-2x',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> $lgactive,
		'linkgroup' => array(
			'1' => $rebuiltbtn,
			'2' => $addstbtn,
		),
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
		'last' => 'Структура базы данных',
	);
	
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">
		
    <div class="message-error-static text-centered">
    	<header>Системный раздел. Подумайте дважды</header>
      Данный раздел сайта предназначен для управления структурным скелетом базы данных <strong>ВСЕГО</strong> сайта.<br>Самостоятельное внесение изменений чревато выходом сайта из строя,<br>а также <strong>частичной либо полной потерей данных</strong>.<br>Восстановление платное. Дорого. <strong>ОЧЕНЬ</strong>.
    </div>
    
	<?php echo $this->view->get_messages(); ?>

		<?php if (count($tipi)) { ?>
		<div class="table-container well-container">
		<table class="width-100 table-striped table-stroked">

			<thead>
				<tr>
					<th class="text-centered td-identifier">ID</th>
					<th class="width-20">Имя файла</th>
					<th class="width-20">Название</th>
					<th class="width-10">Тип данных</th>
					<th class="width-20">Таблица со структурой</th>
					<th class="width-20">Таблица с данными</th>
					<th class="td-actions">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
					<?php foreach ($tipi as $tipo_id => $content) {
	
						if ($this->auth->has_permission('types', 'manage')) {
						?>
					<tr>
						<td><code><?php echo $content['id']; ?></code></td>
						<td><a href="<?php echo admin_url(($content['tree'] ? 'pages' : 'contents') . '/type_edit_xml/'.$content['name']); ?>"><?php echo $content['name'].'.'.(isset($content['source']) ? $content['source'] : 'xml'); ?></a></td>
						<td><?php echo $content['description']; ?></td>
						<td><?php echo $content['tree'] ? 'Страницы' : 'Записи'; ?></td>
						<td><?php echo $content['table']; ?></td>
						<td><?php echo $content['table_stage']; ?></td>
						<td class="td-actions">
							<a class="btn btn-small" href="<?php echo admin_url('schemes/rebuild/'.$content['name']); ?>"><i class="fa fa-cog"></i></a> 
							<?php if ($this->auth->has_permission('types', 'delete')) { ?>
							<a class="btn btn-red btn-small" onclick="return confirm('Точно? Отменить невозможно');" href="<?php echo admin_url(($content['tree'] ? 'pages' : 'contents').'/type_delete/'.$content['name']); ?>"><i class="fa fa-times"></i></a>
							<?php } ?>

						</td>
					</tr>
					<?php }
					}	?>
			</tbody>
      <tfoot>
      	<tr>
        	<td colspan="7"></td>
        </tr>
      </tfoot>
		</table>
		<?php } else {

			if ($_section == 'contents')
			{
				echo '<p>'.$this->lang->_trans('No type of contents found. To start, %link.', array(
					'link'	=> '<a href="'.admin_url('contents/add_type').'">'._('add a new one').'</a>'
				)).'</p>';
			}
			?>
			<?php } ?>

	</div>
	</div>
	</div>