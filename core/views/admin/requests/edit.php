<?php $this->load->helper('form'); $this->load->frlibrary('form_renderer'); $CI = & get_instance();?>
<div class="core-container">

	<?php echo form_open_multipart($action, array('id' => 'record_form', 'name' => 'record_form', 'class'=>'forms'));
	
	
	$headblock = array(
		'header' => $tipo['description'],
		'subheader' => (!$record->id ? _($tipo['label_new']) : 'Редактирование' ),
		'headicon' => 'sitemap fa-2x color-mint',
	'linkback'	=> array(
		'text' => 'Отмена',
		'link' => admin_url($_section),
	),
	'btngroup'	=> array(
		'save' => array(
			'name' => '_bt_save',
			'text' => 'Сохранить',
		),
	),
		'lgactive'	=> false,
		'linkgroup' => false,
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
		admin_url('requests') => $tipo['description'],
		'last' => (!$record->id ? _($tipo['label_new']) : ('редактирование запроса от клиента &quot;' . $record->get($tipo['edit_link']) . '&quot;')),
	);
	
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">

	<?php echo $this->view->get_messages(); ?>

		<div class="units-container">
			<div class="units-row">
	<?php
	/******************************/
	/* Recurring variables */
	$js_onload = '';
	$first_lap = TRUE;
	$has_full_textarea = FALSE;
	$p_start = '<div class="units-row-end">';
	$p_end = '</div></div>';
	$validator_rules = array();
	/* End of recurring variables */
	/******************************/
	?>
	<div class="edit-form-navigation units-row-end">
		<nav class="nav-tabs zero" data-toggle="tabs">
			<ul>
				<?php echo $CI->form_renderer->get_sidebar($tipo); ?>
			</ul>
  	</nav>
	</div>
<div class="units-container tabbed-items">
	<?php foreach ($tipo['fieldsets'] as $fieldset) { ?>
	<div class="form-tab" id="sb-<?php echo $CI->form_renderer->translitName($fieldset['name']); ?>">
	<?php 

	foreach ($fieldset['fields'] as $field_name)
	{
		$field = $tipo['fields'][$field_name];
		$attributes = array();
		
		$additionaldesc = '';
		if (isset($field['additionaldesc'])){
			$additionaldesc = '<div class="forms-desc">' . $field['additionaldesc'] . '</div>';
		}

		$tooltip = '';
		if (isset($field['tooltip'])){
			$tooltip = '<div class="forms-tooltip">' . $field['tooltip'] . '</div>';
		}

		//Validation rules
		if (isset($field['rules']) && strlen($field['rules'])){
			$validator_rules[]= array(
				'name'		=> $field_name,
				'display'	=> '['._($field['description']).']',
				'rules'		=> $field['rules']
			);
		}
		$hiddenclass = '';
		if (isset($field['visible']))
		{
			if ($field['visible'] === false) {
				$hiddenclass = ' hidden';
			}
		}



		//We evaluates the evals
		if ($field['default'] && substr($field['default'], 0, 5) == 'eval:')
		{
			eval('$value = '.substr($field['default'], 5).';');
			$field['default'] = $value;
		}
		//The default value will be set when no stored value is found
		$field_value = $record->get($field_name, $field['default']);

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
		
		echo '<div class="fields-container field-'.$field_name.$hiddenclass.'">';
		$label = '<div class="unit-20"><span class="color-gray">'.$field['description'].'</span>'.$reqpin.'</div><div class="unit-80">';
		
		switch ($field['type'])
		{

			case 'hidden':
				echo form_hidden($field_name, $field_value); 
				break;

			case 'separator':
					include(PARTSPATH.'fields/separator.php');
				break;

			case 'text':
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

			case 'radio':
					include(PARTSPATH.'fields/radio.php');
				break;

			case 'menuitemseditor': ?>
			<div class="units-row">
      	
      </div>
				<?php break;

		} ?>

		</div>

<?php	} ?>

	</div>

<?php	} //end fieldset foreach	?>

    </div>
 
 
  </div>
</form>
</div>
