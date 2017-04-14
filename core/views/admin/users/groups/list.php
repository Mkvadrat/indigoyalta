<?php
$this->load->helper('text');
?>
<div class="core-container">

	<?php
	$lgactive = true;

	$addgroupbtn = array(
		'link' => admin_url('users/groups/edit'),
		'icon' => 'plus-circle',
		'text' => _('Add new group'),
	);
	
	$headblock = array(
		'header' => _('Groups and permissions'),
		'subheader' => 'управление группами пользователей',
		'headicon' => 'group fa-2x color-green',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> $lgactive,
		'linkgroup' => array(
			'1' => $addgroupbtn,
		),
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
		admin_url('users') => 'Пользователи',
		'last' => _('Groups and permissions'),
	);
	
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">

	<?php echo $this->view->get_messages(); ?>

	<form action="" method="post">


		<div class="table-container well-container">
	<?php if (is_array($groups)) { ?>

		<table class="width-100 table-striped table-stroked">

			<thead>
				<tr>
					<th class="text-centered td-identifier">ID</th>
					<th><?php echo _('Group name'); ?></th>
					<th class="td-actions">&nbsp;</th>
				</tr>
			</thead>

			<tbody>
<?php foreach ($groups as $group) { ?>
		<tr>
			<td><code><?php echo $group->id_group; ?></code></td>
			<td><a href="<?php echo admin_url('users/groups/edit/'.$group->id_group); ?>"><?php echo _($group->group_name) ?></a></td>
			<td class="td-actions">
					<?php echo($this->auth->user('group_id') != $group->id_group ? '<a class="btn btn-red btn-small" href="'.admin_url('users/group_delete/'.$group->id_group).'" onclick="return confirm(\''._('Do you want to delete this group?').'\');"><i class="fa fa-times"></i></a>' : '') ?>
			</td>
		</tr>
<?php } ?>
			</tbody>
			<tfoot>
      	<tr>
        	<td colspan="3"></td>
        </tr>
      </tfoot>

		</table>

<?php } ?>
		
		</div>
    
	</form>

	</div>
