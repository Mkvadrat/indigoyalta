<?php
$this->load->helper('form');
?>
<div class="core-container">
	<?php
	
	$headblock = array(
		'header' => 'Редактирование структуры ',
		'subheader' => 'системный раздел для управления структурой БД',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> false,
		'linkgroup' => false,
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
		'last' => 'Системный раздел',
	);
	
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">

	<div class="message message-warning"><p>Внимание! Правки на свой страх и риск. Восстановление платное.</p></div>

  <div class="units-container tabbed-items form-tab">
	<div class="units-row-end">
  	<div class="unit-80 unit-push-10">
    
			<?php
      
      echo form_open();
      echo form_hidden('id_type', $tipo['id']);
      
      $attributes = array();
      $attributes['name'] = 'description';
      $attributes['value'] = $tipo['description'];
      $attributes['class'] = 'text';
      echo '<div class="fieldset clearfix">';
      echo form_label('Название', 'description') . '<div class="right">';
      echo form_input($attributes) . '</div></div>';
      
      $attributes = array();
      $attributes['name'] = 'xml';
      $attributes['class'] = 'scheme code width-100';
      $attributes['value'] = $xml;
      $attributes['style'] = 'height:400px;';
      echo '<div class="fieldset clearfix">';
      echo form_label('Содержимое', 'xml') . '<div class="right">';
      echo form_textarea($attributes) . '</div></div>';
      
      echo '<div class="fieldset clearfix noborder"><label></label><div class="right">';
      echo form_submit('save', 'Сохранить', 'class="submit long"') . '</div></div>';
      
      echo form_close();
      
      
      ?>
    
    
    </div>
  </div>
    


	</div>
	</div>
	</div>
<script type="text/javascript">
$(document).ready(function() {
	fastcms.tab_textarea('.scheme');
});
</script>