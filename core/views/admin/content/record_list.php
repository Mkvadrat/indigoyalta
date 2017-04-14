<?php
$this->load->helper('form');
$fields = array_keys($tipo['fields']);

?>

<div class="core-container">

	<?php
	$lgactive = true;
	$addcatbtn = false;

	if($tipo['has_categories']){
		$addcatbtn = array(
			'link' => admin_url($_section.'/type_categories/'.$tipo['name']),
			'icon' => 'list-ul',
			'text' => 'Категории',
		);
	}
		$addenrybtn = array(
			'link' => admin_url($_section.'/edit_record/'.$tipo['name']),
			'icon' => 'plus-circle',
			'text' => _($tipo['label_new']),
		);
	
	$headblock = array(
		'header' => ($tipo['tree']? 'Страницы: ' : 'Раздел: ' ).$tipo['description'],
		'subheader' => 'управление записями раздела',
		'headicon' => ($tipo['name'] == 'custom' ?'puzzle-piece ':'file-text-o ').'fa-2x color-'.($tipo['tree'] ?'blue':'aqua'),
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> $lgactive,
		'linkgroup' => array(
			'1' => $addcatbtn,
			'2' => $addenrybtn,
		),
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
		'last' => ($tipo['tree']? 'Страницы: ' : 'Раздел: ' ).$tipo['description'],
	);
	
	include(PARTSPATH.'layout/headblock.php'); ?>


<div class="units-container control-wrapper">

	<?php echo $this->view->get_messages(); ?>

		<form action="" method="post">

	<?php if (count($records)) { ?>
  	<div class="units-row records-table-filter">
    	<div class="unit-80 unit-push-10">
        <span class="btn-group width-100">
            <input type="search" class="search width-100 wide-terminator" placeholder="поиск по таблице" />
            <span class="reset"><i class="color-red fa fa-times"></i></span>
        </span>
      </div>
    </div>
    
    <div class="" id="columnSelector"></div>
    
		<div class="table-container well-container">
		<table class="width-100 table-hovered tablesorter" id="<?php echo $tipo['name']; ?>-table">

			<thead>
				<tr>
					<th class="text-centered td-checker resizable-false" data-sorter="false"><input type="checkbox" class="check_all fast-checkbox" id="check_all" name="check_all" onChange="fastcms.checkAll()" /><label for="check_all" class="fast-label"></label></th>
					<th class="text-centered td-identifier resizable-false">ID</th>
<?php /*?>					<?php if ($tipo['stage']) { ?>
					<th>Статус</th>
					<?php } ?>
<?php */?>					
					<?php foreach ($admin_fields as $field) {
				//		print_r($field);
						//
							if ($field != $tipo['primary_key'])
							{
								$_descr = $tipo['fields'][$field]['description'];
								echo '<th class="text-left '.$field.'-column">'.($_descr ? _($_descr) : $field).'</th>';
							}
						}
						?>
					<?php if ($tipo['has_categories'] && count($recordcats)) { ?>
					<th class="text-left">Категория</th>
					<?php } ?>

					<th class="td-actions resizable-false" data-sorter="false">Опции</th>
				</tr>
			</thead>

			<tbody>
		<?php foreach ($records as $record)	{ ?>

			<?php
			$is_published = $record->get('published'); 
			$track_str = $tipo['name'].'/'.$record->id;
			$primary_key = $tipo['primary_key'];
			$current_url = admin_url($_section.'/type/'.$tipo['name']);
			$action_url = admin_url($_section.'/delete_record/'.$tipo['name']);
			$rid = $record->id;
			?>		
		
			<?php 
			$rowclass = '';
			$rowicon = '';
			
			if ($tipo['stage']){
				if ($is_published == '0' || !$is_published) {
					$rowclass = ' draft-entry';
				} else if ($is_published == '2') {
					$rowclass = ' draft-entry';
	//				$rowclass = ' hidden-entry';
				} else if (isset($tipo['fields']['date_publish']) && ((int)$record->get('_date_publish')) > time()) {
					$rowclass = ' future-entry';
				} else {
					$rowclass = ' published-entry';
				}
			}
			?>
		
		<tr<?php echo ' class="entry-row'.$rowclass.'"'; ?> id="entry-<?php echo $rid;?>">

			<td class="text-centered td-checker"><input type="checkbox" name="record[]" value="<?php echo $rid ?>" class="fast-checkbox" id="record-<?php echo $rid ?>"/><label class="fast-label" for="record-<?php echo $rid ?>"></label> </td>

			<td class="text-centered td-identifier"><code><?php echo $rid ?></code></td>
			<?php

			
		//	echo '<pre>'; print_r($fields); echo '</pre>';
			
			foreach ($fields as $field)
			{
				$eye ='';
//				$isvisible = $record->get('show_in_menu');
//				if($isvisible == 'T'){
//					$eye = '<i class="fa fa-eye color-gray-dark" title="Видят все"></i> ';
//				}elseif($isvisible == 'S' || $isvisible == 'F'){
//					$eye = '<i class="fa fa-eye-slash color-gray-light" title="Видит только администратор"></i> ';
//				}
				
				
				if ($tipo['fields'][$field]['admin'] === true && $field != $primary_key) {
					$value = $record->get($field);

					if (isset($tipo['fields'][$field]))
					{
						switch ($tipo['fields'][$field]['type'])
						{
							case 'select':
							case 'radio':
								if (isset($tipo['fields'][$field]['options']))
								{
									$tmp = (string)$value;
									if (isset($tipo['fields'][$field]['options'][$tmp])) {
										$value = $tipo['fields'][$field]['options'][$tmp];
									}
								}
								break;

							case 'text':
							case 'textarea':
							case 'textarea_code':
							case 'textarea_full':
							case 'hidden':
								$value = character_limiter(strip_tags($value), 30);
								break;

							case 'checkbox':
							case 'multiselect':
							case 'hierarchy':
								if (is_array($value)) {
									$values = array();
									if (isset($tipo['fields'][$field]['options'])) {
										foreach ($value as $val) {
											$tmp_val = (string)$val;
											if (isset($tipo['fields'][$field]['options'][$tmp_val])) {
												$tmp_val = $tipo['fields'][$field]['options'][$tmp_val];
											}
											$values[] = $tmp_val;
										}
									}
									$value = implode(', ', $values);
								}
								break;


						}
					}
					if ($tipo['edit_link'] == $field){
						echo '<td>'.$eye.'<i class="fa fa-pencil-square fa-fw status"></i> <a class="entry-edit-link" href="'.admin_url($_section.'/edit_record/'.$track_str).'">'.$value.'</a></td>';
					}elseif ('date_publish' == $field){
						echo '<td><i class="fa fa-clock-o"></i> <kbd>'.date(LOCAL_DATE_FORMAT . ' H:i', $value).'</kbd></td>';
					}elseif ('uri' == $field){
						echo '<td><span class="small">'.$value.'</span></td>';
					} else {
						echo '<td>'.$value.'</td>';
					}
				}

			}
			if ($tipo['has_categories'] && count($recordcats)) {
				$categoryarray = $record->categories();
				$cat_names = $this->categories->get_categories_names($categoryarray,$tipo['id']);
				$catstring ='';
				foreach($cat_names as $cat_name){$catstring .='<span class="label">'.character_limiter(strip_tags($cat_name), 15).'</span> ';}
			echo '<td>'.$catstring.'</td>';
			}
			?>
			<td class="delete text-centered"><a title="Удалить" class="btn btn-red btn-small delete-link" href="#" data-id="<?php echo $rid; ?>" data-type="<?php echo $tipo['name']; ?>" data-href="<?php echo admin_url($_section.'/delete_record/'.$track_str) ?>"><i class="fa fa-times"></i></a></td>
    </tr>
    <?php	} ?>

			</tbody>
      <tfoot>
				<tr class="canhide">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<?php foreach ($admin_fields as $field) {
							if ($field != $tipo['primary_key'])
							{
								echo '<td>&nbsp;</td>';
							}
						}
						?>
					<?php if ($tipo['has_categories'] && count($recordcats)) { ?>
					<td></td>
					<?php } ?>

					<td class="td-actions">&nbsp;</td>
				</tr>
      
      </tfoot>
		</table>
		</div>
    
    <div class="units-row units-split records-list-bottom">
    	<div class="unit-10">
        <select name="action" class="width-100">
          <option value="">Действия</option>
          <option value="publish">Опубликовать</option>
          <option value="depublish">Скрыть</option>
          <option value="delete">Удалить</option>
        </select>
      </div>
    	<div class="unit-20">
        <input type="submit" class="btn" value="поехали" />
      </div>
    	<div class="unit-20 text-right">
        <?php echo $total_records; ?> записей
      </div>
    	<div class="unit-50 text-right">
      	<?php echo $this->pagination->create_links(); ?>
      </div>


		</div>

		<?php }else{ ?>
            <div class="message-static">
			<header>Нет записей</header>
		<?php echo $this->lang->_trans('There are no contents/pages for this type. To start, %a.', array('a'	=> '<a href="'.admin_url($_section.'/edit_record/'.$tipo['name']).'">'._('add a new one').'</a>')); ?>
            </div>
    
		<?php } ?>


	</form>
  
  
  
</div>
  
</div>
