<?php $this->load->helper('form'); ?>
<div class="core-container">

	<?php
	$lgactive = false;

	$headblock = array(
		'header' => 'Связки разделов',
		'subheader' => 'управление перелинковкой разделов',
		'headicon' => 'random fa-2x color-lavender',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> $lgactive,
		'linkgroup' => false,
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
		'last' => _('Hierarchies list'),
	);
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">

	<?php echo $this->view->get_messages(); ?>

	
      <div class="units-row">
          <div class="unit-50">

    <div class="table-container well-container nodes-form">
          
            <?php if (count($hierarchies)) { ?>
			<form action="" method="POST" class="tree forms">
				<h4 class="forms-section">Доступные варианты</h4> 
				<div id="tree" name="selNodes"></div>
              <p class="text-right">
                <input type="submit" name="submit" value="Удалить выбранные" class="btn btn-red" />
              </p>
			</form>
			<?php } else { ?>
      <div class="message-static">
          <header>Нет ни одной связки</header>
          <p>Связки обеспечивают взаимоотношения между разными разделами сайта. Наиболее близкий пример - коментарии записей блога либо отзывы об объектах недвижимости</p>
      </div>
			<?php }	?>
          
          </div>
      </div>
          <div class="unit-40">
						<?php echo form_open(); ?>
						<h4 class="forms-section"><?php echo _('Add hierarchy'); ?></h4>
						<?php echo form_hidden('new', '1'); ?>
              <div class="units-row">
                <label class="unit-50">
                  Название
                  <input type="text" name="name" class="width-100"  />
                </label>
                <label class="unit-50">
                  Родительская
                  <?php echo form_dropdown('id_parent', $dropdown, null, 'class="width-100"') ?>
                </label>
              </div>
              <p class="text-right">
                <input type="submit" name="submit" value="добавить" class="btn btn-save" />
              </p>
            <?php echo form_close();?>          
          </div>
    </div>
	</div>
  
</div>


<?php
$data = array(
	'tree_input'	=> 'hierarchies',
	'tree_id'		=> 'tree',
	'tree_form'		=> '.tree',
	'tree_mode'		=> 2,
	'tree'			=> $tree
);
$this->view->render('admin/hierarchies/dynatree', $data);
?>