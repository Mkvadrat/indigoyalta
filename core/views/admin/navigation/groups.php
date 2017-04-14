<?php
$this->load->helper('text');

$acl_groups = $this->auth->has_permission('users', 'groups');
$acl_edit = $this->auth->has_permission('users', 'add');
$my_iduser = $this->auth->user('id');

?>
<div class="core-container">

	<?php
	
	$adduserbtn = array(
		'link' => admin_url('navigation/editgroup'),
		'icon' => 'plus-circle',
		'text' => 'добавить меню',
	);

	
	$headblock = array(
		'header' => 'Навигация',
		'subheader' => 'управление группами меню',
		'headicon' => 'sitemap fa-2x color-mint',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> true,
		'linkgroup' => array(
			'1' => $adduserbtn,
		),
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
		'last' => 'Навигация',
	);
	
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">

	<?php echo $this->view->get_messages(); ?>


		<div class="table-container well-container">
		<table class="width-100 table-striped table-stroked">

			<thead>
				<tr>
					<th class="text-centered td-identifier">ID</th>
					<th>Название</th>
					<th>Дата добавления</th>
					<th>CSS ID</th>
					<th>CSS Class</th>
					<th class="td-actions text-centered">Подпункты</th>
					<th>Расположение</th>
					<th>Язык</th>
					<th>Описание</th>
					<th class="td-actions text-centered">&nbsp;</th>
				</tr>
			</thead>

			<tbody>
      
	<?php foreach ($navigations as $navigation) { ?>
		<tr id="menu-<?php echo $navigation->id_navigation ?>">

			<td class="text-centered td-identifier"><code><?php echo $navigation->id_navigation; ?></code></td>
			<td><a class="color-green" href="<?php echo admin_url('navigation/editgroup/'.$navigation->id_navigation) ?>"><i class="fa fa-check-square"></i> <?php echo $navigation->menuname ?></a></td>
			<td><i class="fa fa-clock-o"></i> <kbd><?php echo date(LOCAL_DATE_FORMAT, $navigation->date_update); ?></kbd></td>
			<td><span class="label">#<?php echo $navigation->cssid; ?></span></td>
			<td><span class="label">.<?php echo $navigation->cssclass; ?></span></td>
			<td class="td-actions text-centered"><?php echo($navigation->nested? '<span class="color-green">да</span>':'<span class="color-red">нет</span>'); ?></td>
			<td><?php echo $navigation->location; ?></td>
			<td><?php echo $navigation->menu_lang; ?></td>
			<td><?php echo $navigation->description; ?></td>

			<td class="td-actions text-centered"><a class="btn btn-red btn-small menu-delete" data-id="<?php echo $navigation->id_navigation ?>" href="#"><i class="fa fa-times"></i></a></td>
		</tr>
	<?php } ?>

			</tbody>
      <tfoot>
      	<tr>
        	<td colspan="10"></td>
        </tr>
      </tfoot>
		</table>
		</div>
    


	</div>
