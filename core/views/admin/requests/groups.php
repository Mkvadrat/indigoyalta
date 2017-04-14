<?php
$this->load->helper('text');

$acl_groups = $this->auth->has_permission('users', 'groups');
$acl_edit = $this->auth->has_permission('users', 'add');
$my_iduser = $this->auth->user('id');

?>
<div class="core-container">

	<?php
	
	$adduserbtn = array(
		'link' => admin_url('navigation/edit/'),
		'icon' => 'plus-circle',
		'text' => 'добавить меню',
	);

	
	$headblock = array(
		'header' => 'Запросы в СП',
		'subheader' => 'общение с клиентами',
		'headicon' => 'envelope-o fa-2x color-grapefruit',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> false,
		'linkgroup' => array(
			'1' => $adduserbtn,
		),
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
		'last' => 'Запросы в СП',
	);
	
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">

	<?php echo $this->view->get_messages(); ?>


		<div class="table-container well-container">
		<table class="width-100 table-striped table-stroked">

			<thead>
				<tr>
					<th class="text-centered td-identifier">ID</th>
					<th>Дата</th>
					<th>Данные клиента</th>
					<th>Тематика и раздел</th>
					<th>Менеджер</th>
					<th>Статус</th>
					<td>&nbsp;</td>
				</tr>
			</thead>

			<tbody>
      
<?php /*?>	<?php foreach ($users as $user) { ?>
		<tr>

			<td class="text-centered td-identifier"><?php echo $user->id_user; ?></td>
      
			<td><?php echo ($acl_edit || $user->id_user == $my_iduser ? '<a href="'.admin_url('users/edit/'.$user->id_user).'">'.$user->username.'</a>' : $user->username); ?></td>
			<td><?php echo $user->name; ?></td>
			<td><?php echo $user->surname; ?></td>
			<td><?php echo $user->email; ?></td>
			<td><?php echo ($acl_groups ? ($user->id_group ? '<a href="'.admin_url('users/groups/edit/'.$user->id_group).'">'._($user->group_name).'</a>' : '') : ($user->id_group ? _($user->group_name) : '')); ?></td>

			<td class="delete"><?php echo ($acl_edit && $user->id_user != $this->auth->user('id') ? '<a href="'.admin_url('users/delete/'.$user->id_user).'" onclick="return confirm(\''._('Do you want to delete this user?').'\');">'._('Delete').'</a>' : ''); ?>
			</td>
		</tr>
	<?php } ?>
<?php */?>
			</tbody>
      <tfoot>
      	<tr>
        	<td colspan="7"></td>
        </tr>
      </tfoot>
		</table>
		</div>
    


	</div>
	</div>
