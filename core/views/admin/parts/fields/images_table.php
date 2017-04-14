<?php
				echo $p_start.$label;
				$count = $field_value != '' ? count($field_value) : 0;

				//Multi upload on webkit+ff browsers
				$attributes['name'] = $field_name.'[]';
				$attributes['multiple'] = 'multiple';


if($field_name == 'thumbnail'){

				if ($count < $field['max']) {
					echo '<div class="upload-group" data-title="Выберите файл">'.form_upload($attributes).'</div>';
//					echo $this->lang->_trans('Максимальное количество для загрузки - %n', array('n' => $field['max']));
//					echo ' - загружено - '.$count;
				} else {
//					echo '<span class="limit">Загружено максимальное количество изображений</span>';
//					echo '<div class="hidden limit">'.br(1).form_upload($attributes).br(1).'('.$this->lang->_trans('You can attach up to %n images', array('n' => $field['max'])).')</div>';
				}
				if ($count && is_array($field_value)) {
					echo '<div class="thumbnail-container"><table class="width-100 table-flat zero">'
						.'<thead><tr><th class="width-20">Миниатюра</th><th class="width-10">Оригинал</th><th class="width-10">В каталог</th><th class="width-20">Тэг alt</th><th class="width-10"></th></tr></thead><tbody>';
					;
					$tdnum = 1;
					foreach ($field_value as $image) {
						if (array_key_exists('thumbnail', $field['presets']))
						{
							$src = 'cache/' . $tipo['name'] . '/' . $field_name . '/' . $record->id . '/' . $field['presets']['thumbnail'] . '/' . $image->name;
						} else {
							$src = $image->thumb_path ? $image->thumb_path : $image->path;
						}
						echo '<tr><td><img src="'. attach_url($src) . '" alt="' . $image->alt_text . '" /></td>'
							.'<td class="width-10"><a target="_blank" href="'. attach_url($image->path) . '">просмотр</a><br />'.$image->width.' x '.$image->height.' px<br />'.$image->size.' Kb</td>'
							.'<td class="width-10">'.($image->resized_path ? '<a target="_blank" href="'. attach_url($image->resized_path) . '">просмотр</a>':'').'</td>'
							.'<td class="width-50"><input name="_alt_text['.$image->id_document.']" type="text" class="width-100" value="' . $image->alt_text . '" />
							                       <input class="tbl-priority width-100" name="_priority['.$image->id_document.']" type="hidden" value="' . $image->priority . '" /></td>'
							.'<td class="width-10 text-centered"><a class="btn btn-red btn-small delete-link" href="#" onclick="return fastcms.remove.document(this, '.$image->id_document.');"><i class="fa fa-times"></i></a></td>'
							."</tr>\n";
					$tdnum++;}
					echo '</tbody></table></div>';
				}


}else{
				if ($count < $field['max']) {
					echo '<div class="upload-group" data-title="Выберите файл">'.form_upload($attributes).'</div>';
//					echo form_upload($attributes).br(1).$this->lang->_trans('Максимальное количество для загрузки - %n', array('n' => $field['max']));
//					echo ' - загружено - '.$count;
				} else {
//					echo '<span class="limit">Загружено максимальное количество изображений</span>';
//					echo '<div class="hidden limit">'.br(1).form_upload($attributes).br(1).'('.$this->lang->_trans('You can attach up to %n images', array('n' => $field['max'])).')</div>';
				}
				if ($count && is_array($field_value)) {
					echo '<div class="thumbnail-container"><table class="width-100  table-flat zero sortable">'
						.'<thead><tr><th></th><th>Миниатюра</th><th>Оригинал</th><th>Ресайз</th><th>Тэг alt</th><th>Порядок сортировки</th><th></th></tr></thead><tbody>';
					;
					$tdnum = 1;
					foreach ($field_value as $image) {
						if (array_key_exists('thumbnail', $field['presets']))
						{
							$src = 'cache/' . $tipo['name'] . '/' . $field_name . '/' . $record->id . '/' . $field['presets']['thumbnail'] . '/' . $image->name;
						} else {
							$src = $image->thumb_path ? $image->thumb_path : $image->path;
						}
						echo '<tr><td class="handle-td"><span class="handle"><i class="fa fa-bars"></i></span></td><td><img src="'. attach_url($src) . '" alt="' . $image->alt_text . '" /></td>'
							.'<td class="width-20"><a target="_blank" href="'. attach_url($image->path) . '">просмотр</a><br />'.$image->width.' x '.$image->height.' px<br />'.$image->size.' Kb</td>'
							.'<td class="width-10">'.($image->resized_path ? '<a target="_blank" href="'. attach_url($image->resized_path) . '">просмотр</a>':'').'</td>'
							.'<td class="width-30"><input name="_alt_text['.$image->id_document.']" type="text" class="width-100" value="' . $image->alt_text . '" /></td>'
							.'<td class="width-10"><input class="tbl-priority width-100" name="_priority['.$image->id_document.']" type="text" value="' . $image->priority . '" /></td>'
							.'<td class="width-10 text-centered"><a class="btn btn-red btn-small delete-link" href="#" onclick="return fastcms.remove.document(this, '.$image->id_document.');"><i class="fa fa-times"></i></a></td>'
							."</tr>\n";
					$tdnum++;}
					echo '</tbody></table></div>';
				}


}
				echo $p_end;

