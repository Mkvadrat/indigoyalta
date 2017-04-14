<?php

$this->load->helper('form');
$this->load->frlibrary('form_renderer');
$CI = & get_instance();
?>
<div class="core-container">

<?php

$headblock = array(
	'header' => 'Настройки',
	'subheader' => 'управление настройками сайта',
		'headicon' => 'cogs fa-2x color-orange',
	'linkback'	=> false,
	'btngroup'	=> false,
	'lgactive'	=> false,
	'linkgroup'	=> false,
);
$breadcrumbs = array(
	admin_url() => 'Главная',
	'last' => 'Настройки',
);

include(PARTSPATH.'layout/headblock.php');



?>


<div class="units-container control-wrapper">

	<?php echo $this->view->get_messages(); ?>

	<div class="edit-form-navigation units-row-end">
		<nav class="nav-tabs zero" data-toggle="tabs">
			<ul>
				<?php echo $CI->form_renderer->get_sidebar($tipo); ?>
			</ul>
  	</nav>
	</div>


<?php echo form_open(null, array('id' => 'record_form', 'name' => 'record_form')); ?>

<div class="units-container tabbed-items">

	<?php
	/******************************/
	/* Recurring variables */
	$js_onload = '';
	$first_lap = TRUE;
	$has_full_textarea = FALSE;
	$p_start = '<div class="units-row-end">';
	$p_end = '</div></div>';
	/* End of recurring variables */
	/******************************/
	?>



<?php foreach ($tipo['fieldsets'] as $fieldset) { ?>


<?php ?>
  
  <div class="form-tab" id="sb-<?php echo $CI->form_renderer->translitName($fieldset['name']); ?>">

	<?php foreach ($fieldset['fields'] as $field_name) {
		$field = $tipo['fields'][$field_name];

		$attributes = array();
//		$module = 'General';
		$field_value = $this->settings->get($field_name);



		$field_note = '';
		if (isset($field['tooltip'])){
			$field_note = '<div class="forms-desc">' . $field['tooltip'] . '</div>';
		}
		
		$additionaldesc = '';
		if (isset($field['additionaldesc'])){
			$additionaldesc = '<div class="forms-desc">' . $field['additionaldesc'] . '</div>';
		}

		$tooltip = '';
		if (isset($field['tooltip'])){
			$tooltip = '<div class="forms-desc">' . $field['tooltip'] . '</div>';
		}
		//We evaluates the evals
		if ($field['default'] && substr($field['default'], 0, 5) == 'eval:')
		{
			eval('$value = '.substr($field['default'], 5).';');
			$field['default'] = $value;
		}

		//The default value will be set when no stored value is found
//		$module = $fieldset['name'];
		if (!$field_value)
		{
			$field_value = $field['default'];
		}

		$hiddenclass = '';
		if (isset($field['visible']))
		{
			if ($field['visible'] === false) {
				$hiddenclass = ' hidden';
			}
		}
		echo '<div class="fields-container field-'.$field_name.$hiddenclass.'">';

		if (isset($field['onkeyup']))
		{
			$attributes['onkeyup'] = $field['onkeyup'];
			$js_onload .= trim($field['onkeyup'], ';').'; ';
		}
		$reqpin = '';
		if ($field['mandatory'] && in_array($field['type'], array('text', 'number', 'date', 'datetime')))
		{
			$reqpin = '<span class="req big">*</span>';
			$attributes['required'] = 'required';
		}

		//Localized options
		if (isset($field['options']) && is_array($field['options']) && $field['type'] != 'hierarchy')
		{
			$tmp = array();
			foreach ($field['options'] as $opt_key => $opt_val)
			{
				$tmp[$opt_key] = _($opt_val);
			}
			$field['options'] = $tmp;
		}

		$label = '<div class="unit-20"><span class="color-gray">'.$field['description'].'</span>'.$reqpin.'</div><div class="unit-80">';
		switch ($field['type'])
		{
			case 'hidden':
				echo form_hidden($field_name, $field_value);
				break;
			case 'infoblock':
					include(PARTSPATH.'fields/infoblock.php');
				break;

			case 'separator':
					include(PARTSPATH.'fields/separator.php');
				break;

			case 'text':
					
					include(PARTSPATH.'fields/textinput.php');
				break;

			case 'password':
					include(PARTSPATH.'fields/textinput.php');
				break;

			case 'textarea':
					include(PARTSPATH.'fields/textarea.php');
				break;

			case 'textarea_code':
					include(PARTSPATH.'fields/textarea_code.php');
				break;

			case 'textarea_full':
					include(PARTSPATH.'fields/textarea_full.php');
				break;

			case 'date':
					include(PARTSPATH.'fields/date.php');
				break;

			case 'datetime':
					include(PARTSPATH.'fields/datetime.php');
				break;

			case 'number':
					include(PARTSPATH.'fields/number.php');
				break;

			case 'select':
					include(PARTSPATH.'fields/select.php');
				break;

			case 'checkbox':
					include(PARTSPATH.'fields/checkbox.php');
				break;

			case 'multiselect':
					include(PARTSPATH.'fields/multiselect.php');
				break;

			case 'radio':
					include(PARTSPATH.'fields/radio.php');
				break;


		}

		

//		if (isset($field['visible']))
//		{
//			if ($field['visible'] === false)
//			{
				echo '</div>';
//			}
//		}
	}

	echo '</div>';

} //end fieldset foreach

//echo '<div class="fieldset noborder clearfix"><label></label><div class="right">'.form_submit('_bt_save', 'Сохранить', 'class="submit long" onclick="fastcms.add_form_hash(\'#record_form\');"') . '</div></div>';


?>




</div>
    <div class="units-row-end foot-bgroup">
      <div class="unit-push-40 unit-60 more-space text-right">
      	<div class="btn-single">
          <input type="submit" class="btn btn-save" value="Сохранить">
				</div>
      </div>
    </div>
  
</form>
</div>
  
</div>

<?php /*?><?php if ($has_full_textarea) { ?>
<script type="text/javascript" src="<?php echo site_url() . THEMESPATH; ?>admin/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo site_url() . THEMESPATH; ?>admin/js/ckeditor/adapters/jquery.js"></script>
<?php } ?>
<?php */?>
<script type="text/javascript">
$(document).ready(function() {
	<?php echo $js_onload; ?>
});
</script>