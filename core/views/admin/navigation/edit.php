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
		admin_url('navigation') => 'Навигация',
		'last' => (!$record->id ? _($tipo['label_new']) : ('редактирование &quot;' . $record->get($tipo['edit_link']) . '&quot;')),
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
      	<div class="unit-50">
          <h4 class="forms-section">Список пунктов</h4>
          <div class="naviitems-listing">
          
          <?php
					$data = json_decode($field_value, TRUE);
					
					?>
          <ol id="templateHolder"></ol>
          <ol class="sortable">
              <li id="menuItem_0" class="template"><div><span class="disclose"><span></span></span><span class="miLabel">шаблон для клонирования</span><span class="menu-icon-panel edit_panel"><i class="fa fa-pencil-square"></i></span> <span class="menu-icon-panel remove_panel"><i class="fa fa-times-circle"></i></span></div></li>
              <?php if(isset($data)){ foreach($data as $menuItem){ ?>
              <li id="menuItem_<?php echo $menuItem['id'];?>" data-properties='{"label":"<?php echo $menuItem['data']['label'];?>","page":"<?php echo $menuItem['data']['page'];?>","link":"<?php echo $menuItem['data']['link'];?>","target":"<?php echo $menuItem['data']['target'];?>"}'>
              	<div>
                	<span class="disclose"><span></span></span><span class="miLabel"><?php echo $menuItem['data']['label'];?></span><span class="menu-icon-panel edit_panel"><i class="fa fa-pencil-square"></i></span> <span class="menu-icon-panel remove_panel"><i class="fa fa-times-circle"></i></span>
                </div>
                <?php if(isset($menuItem['children'])){?>
									<ol>
                  	<?php foreach($menuItem['children'] as $menuChildItem){ ?>
                      <li id="menuItem_<?php echo $menuChildItem['id'];?>" data-properties='{"label":"<?php echo $menuChildItem['data']['label'];?>","page":"<?php echo $menuChildItem['data']['page'];?>","link":"<?php echo $menuChildItem['data']['link'];?>","target":"<?php echo $menuChildItem['data']['target'];?>"}'>
                        <div>
                          <span class="disclose"><span></span></span><span class="miLabel"><?php echo $menuChildItem['data']['label'];?></span><span class="menu-icon-panel edit_panel"><i class="fa fa-pencil-square"></i></span> <span class="menu-icon-panel remove_panel"><i class="fa fa-times-circle"></i></span>
                        </div>
												<?php if(isset($menuChildItem['children'])){?>
                          <ol>
                            <?php foreach($menuChildItem['children'] as $menuChildChildItem){ ?>
                              <li id="menuItem_<?php echo $menuChildChildItem['id'];?>" data-properties='{"label":"<?php echo $menuChildChildItem['data']['label'];?>","page":"<?php echo $menuChildChildItem['data']['page'];?>","link":"<?php echo $menuChildChildItem['data']['link'];?>","target":"<?php echo $menuChildChildItem['data']['target'];?>"}'>
                                <div>
                                  <span class="disclose"><span></span></span><span class="miLabel"><?php echo $menuChildChildItem['data']['label'];?></span><span class="menu-icon-panel edit_panel"><i class="fa fa-pencil-square"></i></span> <span class="menu-icon-panel remove_panel"><i class="fa fa-times-circle"></i></span>
                                </div>
                              </li>
                            <?php } ?>
                          </ol>
                        <?php }?>
                      </li>
                    <?php } ?>
                  </ol>
								<?php }?>
              </li>
							<?php } ?>
          </ol>
          
         <?php } ?>
          </div>

        </div>

        <div class="unit-50">
        	<div class="units-row">
          	<div class="unit-90">
            
              <div id="controls">
                  <h4 id="menuform_title" class="forms-section">Добавить новый пункт меню</h4>
                <div class="forms forms text-left">
                  <fieldset>
                  <legend>Настройки ссылки
                  <input type="hidden" id="myAction" value="add" />
                  </legend>
                  <p>
                    <label for="thisLabel">Текст ссылки
                    <input type="text" name="thisLabel" id="thisLabel" class="width-100" />
                    </label>
                  </p>
                  <p>
                    <label for="existing_page">Целевая страница
                    <select id="existing_page" class="width-100">
                      <option value="nill" selected="selected">указать вручную</option>
                      <?php
                      foreach ($naviitems as $naviitem)	{
                        $rid = $naviitem->id;
                        $rtitle = $naviitem->get('title');
                        $rtipo = $naviitem->tipo;
                      ?>
                      <option value="<?php echo $rid; ?>"><?php echo $rtitle; ?></option>
                      <?php } ?>
                    </select>
                    </label>
                  </p>
                  <p>
                    <label for="thisLink">Адрес
                    <input type="text" name="thisLink" id="thisLink" class="width-100" />
                    <span class="forms-desc">для внешних страниц - с протоколом</span>
                    </label>
                  </p>
                  <p>
                    <label for="link_target">Открывать в
                    <select id="link_target" class="width-100">
                      <option value="self" selected="selected">том же окне</option>
                      <option value="blank">новом окне</option>
                    </select>
                    </label>
                  </p>
                  <p>
                    <span class="btn-group">
                      <button id="save_newOptions" class="btn btn-green">Добавить</button>
                      <button id="close_propBox" class="btn btn-red">Отменить</button>
                    </span>
                  </p>
                  </fieldset>         	
                </div>
      
      
              </div><!-- End #controls -->
            
            </div>
          </div>
        

          
        </div>
        <?php echo form_hidden($field_name, $field_value); ?>
        
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
<script src="/gui/corejs/navigation/jquery.fastmenu.nestedSortable.js"></script>
<script>

	var template = $('.template'),
	sortable = $('.sortable'),
	addLabel = $('#thisLabel'),
	existingPage = $('#existing_page'),
	linkTarget = $('#link_target'),
	addLink = $('#thisLink');

	sortable.nestedSortable({
		forcePlaceholderSize: true,
		handle: 'div',
		items: 'li',
		maxLevels: 3,
		toleranceElement: '> div'
	});
	if(sortable.hasClass('ui-sortable')){
		template.appendTo('#templateHolder');
	}
	$('.disclose').on('click', function() {
				$(this).closest('li').toggleClass('fastmenu-nestedSortable-collapsed').toggleClass('fastmenu-nestedSortable-expanded');
	})
	// -- Remove Clicked Panels
	$('.remove_panel').click(function(){
		var parentLI = $(this).parent().parent(),
				kid_cnt = parentLI.children().length;
		
		if(kid_cnt > 1){
			fastnotify.confirm("Содержит вложенные подпункты. Все равно удалить?", function (e) {
				if (e) {
					parentLI.remove();
					buidSerializedTree();
				} else {
				}
			});
		}
		else
			parentLI.remove();
			buidSerializedTree();
	}); // remove panel
	
	$('.edit_panel').click(function(){
		var parentLI = $(this).closest('li'),
				inx = parentLI.index(),
				properties = parentLI.data('properties');
		
		$('#myAction').val('edit').data('toEdit',parentLI.attr('id'));
		
		$('#thisLabel').val(properties.label);
		$('#existing_page').val(properties.page);
		$('#thisLink').val(properties.link);
		$('#link_target').val(properties.target);
		
		if($('#save_newOptions').text() == 'Добавить')
			$('#save_newOptions').text('Сохранить');
		
		$('#menuform_title').html('Изменение пункта меню');
	}); // edit panel
	
	// -- Save Added/Edited Properties
	$('#save_newOptions').click(function(){
		if(addLabel.val() === ''){
			addLabel.addClass('input-error');
			fastnotify.alert("Не указан текст ссылки");
		}else {
			addLabel.removeClass('input-error');
			var action = $('#myAction').val(),
					toEdit = $('#myAction').data('toEdit'),
					newIdNum = 0,
					newId = '',
					templateId = template.attr('id').split('_'),
					idTemplate = templateId[0],
					properties = { 
						'label' : addLabel.val(), 
						'page' : existingPage.val(), 
						'link' : addLink.val(),
						'target': linkTarget.val(),
					};
			
			if(action === 'add'){
				$('.sortable li').each(function(){
					var thisId = $(this).attr('id').split('_');
				
					if(thisId[1] > newIdNum)
						newIdNum = thisId[1];
				}); // end each() loop
			
				newId = idTemplate + '_' + (parseInt(newIdNum)+1);
			
				template.clone(true)
						.children('div')
						.children('.miLabel')
						.text(properties.label)
						.end().end()
						.removeClass('template')
						.attr('id',newId)
						.data('properties', properties)
						.appendTo('.sortable');
				flashThisPanel($('#'+newId));
	
			} else if(action === 'edit'){
				if(toEdit !== 'template'){
					var targetElem = $('#'+toEdit);
					targetElem.data('properties',properties)
						.children('div').children('.miLabel')
						.text(properties.label);
					flashThisPanel($('#'+toEdit));
				}
			}
			clearOptionFields();  
			
		}
		buidSerializedTree();
		return false;
	});
	
	
	function flashThisPanel(object){
		if($.type(object) === 'object'){
			$('.colorFlash').removeClass('colorFlash');
			object.addClass('colorFlash');
			setTimeout(function() {
				object.removeClass('colorFlash');
			}, 2200);
		}
	} // flashThisPanel
	
	function clearOptionFields(){
		addLabel.val('');
		existingPage.val('nill');
		addLink.val('');
		linkTarget.val('self');
		$('#myAction').val('add');
		$('#menuform_title').html('Добавить новый пункт меню');
	}
	
	$('#close_propBox').click(function(){
		clearOptionFields();
		buidSerializedTree();
		return false;
	});
	
	sortable.on( "sortupdate sortremove create sortout", function( event, ui ) {
		buidSerializedTree();
	});	

function buidMenuTree(){
		var arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0}),
		dataPkg = {};
		$.each(arraied, function(){
			if(this.item_id !== null){
				var myData = $('#menuItem_'+this.item_id).data('properties');
				this['properties'] = myData;
				console.log();
			}
		});
		$('[name=menutree]').val(window.JSON.stringify(arraied));
}	

function buidSerializedTree(){
		var arraied = $('ol.sortable').nestedSortable('toHierarchy');
		$('[name=menutree]').val(window.JSON.stringify(arraied));
}	

  </script>

