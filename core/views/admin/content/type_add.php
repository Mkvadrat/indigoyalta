<?php $this->load->helper('form');?>
<div class="core-container">
<?php
$headblock = array(
		'header' => 'Структура базы данных',
		'subheader' => 'управление работой БД сайта',
		'headicon' => 'power-off fa-2x',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> false,
		'linkgroup'	=> false,
);
$breadcrumbs = array(
	admin_url() => 'Главная',
//	admin_url($_section.'/allusers') => $tipo['description'],
//	'last' => (!$record->id ? _($tipo['label_new']) : ('редактирование &quot;' . $record->get($tipo['edit_link']) . '&quot;')),
);

include(PARTSPATH.'layout/headblock.php');

?>

  <div class="units-container control-wrapper">
  
    <?php echo $this->view->get_messages(); ?>
  
    <div class="units-container tabbed-items">
			<?php
      echo form_open();
      
      echo '<div class="fieldset clearfix">';
      echo form_label('Имя файла (только латиница) *', 'type_name') . '<div class="right">';
      echo form_input(array('name' => 'type_name', 'class' => 'text')) . '</div></div>';
      
      echo '<div class="fieldset clearfix">';
      echo form_label('Название *', 'type_description') . '<div class="right">';
      echo form_input(array('name' => 'type_description', 'class' => 'text'));
      echo '</div></div>';
      
      echo '<div class="fieldset clearfix">';
      echo form_label('Заголовок страницы добавления *', 'type_label_new') .'<div class="right">';
      echo form_input(array('name' => 'type_label_new', 'class' => 'text'), '');
      echo '</div></div>';
      
      echo '<div class="fieldset clearfix">';
      echo form_label('Тип данных', 'type_tree') . '<div class="right">';
      echo form_dropdown('type_tree', array('false' => _('Записи (без иерархии)'), 'true' => 'Страницы (с иерархией)'), $_section == 'pages' ? 'true' : 'false', 'class="styled"');
      echo '</div></div>';
      
      echo '<div class="fieldset clearfix">';
      echo form_label('Формат файла', 'scheme_format') . '<div class="right">';
      echo form_dropdown('scheme_format', array('yaml' => _('YAML (рекомендуется)'), 'xml' => 'XML'), 'yaml', 'class="styled"');
      echo '</div></div>';
      
      echo '<div class="fieldset clearfix noborder"><label></label><div class="right">';
      echo form_submit('submit', 'Добавить', 'class="submit mid"');
      echo '</div></div>';
      echo form_close();
      
      ?>
  
    </div>
  
  
  
	</div>



</div>

