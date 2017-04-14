<?php
$this->load->helper('text');

$acl_groups = $this->auth->has_permission('users', 'groups');
$acl_edit = $this->auth->has_permission('users', 'add');
$my_iduser = $this->auth->user('id');

?>
<div class="core-container">

	<?php
	
	
	$headblock = array(
		'header' => 'Редактор меню',
		'subheader' => 'управление группами меню',
		'headicon' => 'sitemap fa-2x',
	'linkback'	=> array(
		'text' => 'Отмена',
		'link' => admin_url('navigation'),
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
		'last' => 'Редактирование группы меню',
	);
	
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">

	<?php echo $this->view->get_messages(); ?>

		<div class="units-container">
    	<code style="height:300px; width:95%; overflow:scroll">
      	<pre><?php print_r($records); ?></pre>
      </code>
    </div>

		<div class="units-container well-container">
			<div class="units-row">
      	<div class="unit-50">
           <div class="dd" id="nestable">
              <ol class="dd-list">
                  <li class="dd-item" data-id="1">
                      <div class="dd-handle">Item 1</div>
                  </li>
                  <li class="dd-item" data-id="2">
                      <div class="dd-handle">Item 2</div>
                      <ol class="dd-list">
                          <li class="dd-item" data-id="3"><div class="dd-handle">Item 3</div></li>
                          <li class="dd-item" data-id="4"><div class="dd-handle">Item 4</div></li>
                          <li class="dd-item" data-id="5">
                              <div class="dd-handle">Item 5</div>
                              <ol class="dd-list">
                                  <li class="dd-item" data-id="6"><div class="dd-handle">Item 6</div></li>
                                  <li class="dd-item" data-id="7"><div class="dd-handle">Item 7</div></li>
                                  <li class="dd-item" data-id="8"><div class="dd-handle">Item 8</div></li>
                              </ol>
                          </li>
                          <li class="dd-item" data-id="9"><div class="dd-handle">Item 9</div></li>
                          <li class="dd-item" data-id="10"><div class="dd-handle">Item 10</div></li>
                      </ol>
                  </li>
                  <li class="dd-item" data-id="11">
                      <div class="dd-handle">Item 11</div>
                  </li>
                  <li class="dd-item" data-id="12">
                      <div class="dd-handle">Item 12</div>
                  </li>
              </ol>
          </div>
        </div>
        <div class="unit-50">
          <div class="dd" id="nestable2">
              <ol class="dd-list">
              	<?php
                foreach ($records as $record)	{
									$rid = $record->id;
									$rtitle = $record->get('title');
									$rtipo = $record->tipo;
								?>
                 <li class="dd-item" data-id="<?php echo $rid; ?>" data-type="<?php echo $rtipo; ?>" data-name="<?php echo $rtitle; ?>">
                 	<div class="dd-handle"><?php echo $rid; ?> - <?php echo $rtitle; ?> - <?php echo $rtipo; ?></div>
                 </li>
                <?php } ?>
              </ol>
          </div>
        </div>
      </div>

			<div class="units-row">
      	<div class="unit-100">
        
        	<textarea id="nestable-output" class="width-100">
          
          </textarea>
        
        </div>
      </div>
		</div>

	</div>
</div>
<script src="/gui/corejs/navigation/jquery.nestable.js"></script>
<script>

$(document).ready(function(){

	var updateOutput = function(e){
		var list   = e.length ? e : $(e.target),
		output = list.data('output');
		if (window.JSON) {
			output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
		} else {
			output.val('JSON browser support required for this demo.');
		}
	};

	$('#nestable').nestable({
		group: 1
	}).on('change', updateOutput);
    
	$('#nestable2').nestable({
		group:1,
		maxDepth: 1,
	});

	updateOutput($('#nestable').data('output', $('#nestable-output')));

	$('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

});
</script>

