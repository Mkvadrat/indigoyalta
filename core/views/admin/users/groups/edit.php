<?php $this->load->helper('form'); ?>
<div class="core-container">

<?php

	$headblock = array(
		'subheader' => $group ? _('Manage group').': '._($group->group_name) : _('Add group'),
		'header' => _('Groups and permissions'),
		'headicon' => 'group fa-2x color-green',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> false,
		'linkgroup'	=> false,
	);
	$breadcrumbs = array(
		admin_url() => 'Главная',
		admin_url('users') => 'Пользователи',
		admin_url('users/groups/') => _('Groups and permissions'),
		'last' => $group ? _('Manage group').': '._($group->group_name) : _('Add group'),
	);

include(PARTSPATH.'layout/headblock.php');



?>


<div class="units-container control-wrapper">
	<?php echo $this->view->get_messages(); ?>
  
<?php echo form_open(); ?>

  <div class="units-container tabbed-items form-tab">
  
    <?php if ($group){	echo form_hidden('id_group', $group->id_group);} ?>
    <div class="fields-container">
      <div class="units-row-end">
        <div class="unit-20"><span class="color-gray"><?php echo _('Group name'); ?></span></div>
        <div class="unit-80"><?php echo form_input(array('name' => 'name', 'class' => 'width-100'), $group ? $group->group_name : ''); ?></div>
      </div>

      <div class="units-row-end">
        <div class="unit-20"><span class="color-gray"><?php echo _('Permissions'); ?></span></div>
        <div class="unit-80">
          <ul class="forms-list">
          <?php 
          $data = array(
                    'name'        => 'acl[]',
                    'class'       => 'fast-checkbox',
          );
          foreach ($acls as $acl) {
            $data['checked'] = in_array($acl->id, $user_acls);
            $data['value'] = $acl->id;
            $data['id'] = 'acl-'.$acl->id;
          
            echo '<li>'.form_checkbox($data).form_label(' ' . $acl->name, 'acl-'.$acl->id).'</li>';
          }
          ?>
          </ul>
        </div>
      </div>
    
    </div>
    
  
  </div>
          


    <div class="units-row-end foot-bgroup">
      <div class="unit-push-40 unit-60 more-space text-right">
      	<div class="btn-single">
          <input type="submit" name="submit" class="btn btn-save" value="<?php echo $group ? _('Save changes') : _('Add group') ?>">
				</div>
      </div>
    </div>
  
</form>
</div>
  
</div>


