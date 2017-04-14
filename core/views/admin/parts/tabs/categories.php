		<div class="form-tab" id="sb_category">
    	<div class="fields-container">
			<div class="units-row-end">
				<div class="unit-20"><span>Категории</span></div>
				<div class="unit-80">
					<?php	if (count($categories)) { ?>
          <ul class="forms-list">
					<?php
						$data = array(
								'name'        => 'categories[]',
								'class'       => 'fast-checkbox',
						);
						foreach ($categories as $category) {
							$data['checked'] = is_array($record->get('categories')) ? in_array($category->id, $record->get('categories')) : FALSE;
							$data['value'] = $category->id;
							$data['id'] = 'cat-'.$category->id;
							echo '<li>'.form_checkbox($data).form_label(' '.$category->name, 'cat-'.$category->id).'</li>';
						}
					?>
          </ul>
					<?php } else { ?>
            <div class="message-static">
	            <header>Список категорий пуст</header>
              <p>Для текущего раздела не создано ни одной категории</p>
            </div>
					<?php }	?>
				</div>
			</div>
    </div>
  </div>
