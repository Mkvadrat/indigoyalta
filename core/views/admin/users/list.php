<?php
$this->load->helper('text');

$acl_groups = $this->auth->has_permission('users', 'groups');
$acl_edit = $this->auth->has_permission('users', 'add');
$my_iduser = $this->auth->user('id');

?>
<div class="core-container">

	<?php
	$lgactive = false;
	$adduserbtn = false;
	$addgroupbtn = false;
	if($acl_edit){
		$lgactive = true;
		$adduserbtn = array(
			'link' => admin_url('users/edit/'),
			'icon' => 'plus-circle',
			'text' => _('Add new user'),
		);
	}
	if($acl_groups){
		$addgroupbtn = array(
			'link' => admin_url('users/groups/'),
			'icon' => 'group',
			'text' => _('Groups and permissions'),
		);
	}
	
	$headblock = array(
		'header' => 'Пользователи',
		'subheader' => 'управление пользователями',
		'headicon' => 'user fa-2x color-green',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> $lgactive,
		'linkgroup' => array(
			'1' => $adduserbtn,
			'2' => $addgroupbtn,
		),
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
		'last' => 'Пользователи',
	);
	
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">

	<?php echo $this->view->get_messages(); ?>

	<form action="" method="post">

	<?php if (is_array($users)) { ?>

		<div class="table-container well-container">
		<table class="width-100 table-striped table-stroked">

			<thead>
				<tr>
					<th class="text-centered td-identifier"><code>ID</code></th>
					<th><?php echo _('Username'); ?></th>
					<th><?php echo _('Name'); ?></th>
					<th><?php echo _('Surname'); ?></th>
					<th><?php echo _('Email address'); ?></th>
					<th><?php echo _('Group'); ?></th>
					<th class="td-actions">&nbsp;</th>
				</tr>
			</thead>

			<tbody>
      
	<?php foreach ($users as $user) { ?>
		<tr>
			<td class="text-centered td-identifier"><?php echo $user->id_user; ?></td>
      
			<td><?php echo ($acl_edit || $user->id_user == $my_iduser ? '<a href="'.admin_url('users/edit/'.$user->id_user).'">'.$user->username.'</a>' : $user->username); ?></td>
			<td><?php echo $user->name; ?></td>
			<td><?php echo $user->surname; ?></td>
			<td><?php echo $user->email; ?></td>
			<td><?php echo ($acl_groups ? ($user->id_group ? '<a href="'.admin_url('users/groups/edit/'.$user->id_group).'">'._($user->group_name).'</a>' : '') : ($user->id_group ? _($user->group_name) : '')); ?></td>

			<td class="delete text-centered"><?php echo ($acl_edit && $user->id_user != $this->auth->user('id') ? '<a class="btn btn-red btn-small" href="'.admin_url('users/delete/'.$user->id_user).'" onclick="return confirm(\''._('Do you want to delete this user?').'\');"><i class="fa fa-times"></i></a>' : ''); ?>
			</td>
		</tr>
	<?php } ?>

			</tbody>
      <tfoot>
      	<tr>
        	<td colspan="7"></td>
        </tr>
      </tfoot>
		</table>
		</div>
    
    <div class="units-row units-split">
    	<div class="unit-10">
      </div>
    	<div class="unit-20">
      </div>
    	<div class="unit-20 text-right">
        <?php // echo $this->lang->_trans('There are %n users.', array('n'=>'<strong>'.$total_records.'</strong>')); ?>
      </div>
    	<div class="unit-50 text-right">
      	<?php echo $this->pagination->create_links(); ?>
      </div>


		</div>

	</form>

	</div>


<?php
}else{
}