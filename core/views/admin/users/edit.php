<?php $this->load->helper('form'); $this->load->frlibrary('form_renderer'); $CI = & get_instance();?>

<div class="core-container">
<?php
$actionupload = isset($action) ? $action : ADMIN_PUB_PATH.$_section.'/edit_record/'.$tipo['name'].($record->id?'/'.$record->id:'');
echo form_open_multipart($actionupload, array('id' => 'record_form', 'name' => 'record_form', 'class'=>'forms dropzone'));


$headblock = array(
	'header' => $tipo['description'],
	'subheader' => (!$record->id ? _($tipo['label_new']) : 'Редактирование' ),
		'headicon' => 'user fa-2x color-green',
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
	'linkgroup'	=> false,
);
$breadcrumbs = array(
	admin_url() => 'Главная',
	admin_url($_section.'/allusers') => $tipo['description'],
	'last' => (!$record->id ? _($tipo['label_new']) : ('редактирование &quot;' . $record->get($tipo['edit_link']) . '&quot;')),
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
					include(PARTSPATH.'fields/password.php'); 
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

			case 'images':
					include(PARTSPATH.'fields/images.php');
				break;
				
			case 'imagesmultisortable':
					include(PARTSPATH.'fields/imagesmultisortable.php');
				break;

			case 'imagesgrid':
					include(PARTSPATH.'fields/imagesgrid.php');
				break;

			case 'files':
					include(PARTSPATH.'fields/files.php');
				break;

			case 'repeatable':
					include(PARTSPATH.'fields/repeatable.php');
				break;

		} ?>

		</div>

<?php	} ?>

	</div>

<?php	} //end fieldset foreach	?>


	</div>

	<div class="units-row-end foot-bgroup">
		<div class="unit-push-40 unit-60 more-space text-right"> 
		<?php if($tipo['stage']){ ?>
			<div class="btn-group">
				<input type="submit" class="btn btn-save" name="_bt_save" value="Сохранить">
				<input type="submit" class="btn btn-savelist" name="_bt_save_list" value="Сохранить и выйти">
				<input type="submit" class="btn btn-publish" name="_bt_publish" value="Опубликовать">
			</div>
		<?php } else { ?>
			<div class="btn-single">
				<input type="submit" class="btn btn-save" name="_bt_save" value="Сохранить">
			</div>
		<?php } ?>
		</div>
	</div>


</div>
</form>
  
</div>

<?php /*?>
<?php if ($has_full_textarea) { ?>
<script type="text/javascript" src="<?php echo site_url() . THEMESPATH; ?>admin/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo site_url() . THEMESPATH; ?>admin/js/ckeditor/adapters/jquery.js"></script>
<?php }
//
//if ($tipo['has_attachments']) {
//	$js_onload.= "$('table.sortable tbody').sortable({ stop: function(event, ui) {"
//				." fastcms.sort_priority(event, ui); } });"; 
//
	?>
<?php // } ?>
<?php */?>  
<?php // if ($tipo['has_attachments']) { ?>
<?php /*?><script type="text/javascript">
$(".uploaded-images-list").on('click', 'li', function (e) {
	$(this).toggleClass("selected");
	}).sortable({
    connectWith: ".uploaded-images-list",
		placeholder: 'placeholder',
helper: function(event , el){
                     return $('<div class="porlet">' + el.children('.portlet-header').text() + '</div>' ).width(100).height(30).addClass("ui-widget-header ui-corner-all");
                },
    delay: 150, //Needed to prevent accidental drag when trying to select
    helper: function (e, item) {
        var helper = $('<li/>');
        if (!item.hasClass('selected')) {
            item.addClass('selected').siblings().removeClass('selected');
        }
        var elements = item.parent().children('.selected').clone();
        item.data('multidrag', elements).siblings('.selected').remove();
        return helper.append(elements);
    },
    stop: function (e, info) {
        info.item.after(info.item.data('multidrag')).remove();
		var cnt = 1;
		$('.uploaded-images-list li').each(function(){
			var newposition = cnt;
			$(this).find('.i-order input').val(newposition);
			cnt++;
		});      
	 }
}).disableSelection();

</script> 

<?php } ?>

<script type="text/javascript" src="<?php echo site_url() . THEMESPATH; ?>admin/js/validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	<?php echo $js_onload; ?>
	
	$('ul.sortable').sortable({
		handle: '.sort-handle',
		cursor: 'move',
		stop: function(event, ui) { fastcms.sort_priority(event, ui); } });
	
	var validator = new FormValidator('record_form',
		<?php echo json_encode($validator_rules); ?>,
		function(errors, events) {

		    if (errors.length > 0) {
		        var el = $('#js_errors .block_content');
		        el.html('');
		        $.each(errors, function(er) {
		        	el.append('<div class="message error">' + this + '</div>');
		        });
		        $.colorbox({width:"65%", inline:true, href:"#js_errors"});

		    } else {
		    	fastcms.add_form_hash('#record_form');
		    }
		}
	);
});
</script>
<?php */?>
