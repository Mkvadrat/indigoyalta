<?php

				echo $p_start.$label;
				$count = $field_value != '' ? count($field_value) : 0;

				//Multi upload on webkit+ff browsers
				$attributes['name'] = $field_name.'[]';
				$attributes['multiple'] = ' ';

				if ($count < $field['max']) {
/*					echo '<script type="text/javascript">
		$(function() {
           $("div#dropzone-'.$field_name.'").dropzone({ url: "'.$actionupload.'" });
 });
</script>';
*/					echo '<div id="dropzone-'.$field_name.'" class="dropzone-wrapper"></div>';
					echo form_upload($attributes).br(1).$this->lang->_trans('Максимальное количество для загрузки - %n', array('n' => $field['max']));
					echo ' - загружено - '.$count;
				} else {
					echo '<span class="limit">Загружено максимальное количество изображений</span>';
					echo '<div class="hidden limit">'.br(1).form_upload($attributes).br(1).'('.$this->lang->_trans('You can attach up to %n images', array('n' => $field['max'])).')</div>';
				}
				if ($count && is_array($field_value)) {
					echo '<ul class="uploaded-images-list">';
					;
					
					
					function getFn($sort) {
						return function($a, $b) use($sort) {
							if($a->$sort > $b->$sort) return 1;
							if($a->$sort < $b->$sort) return -1;
							return 0;
						};
					}

					usort($field_value, getFn('id_document'));
					
	//				aasort($field_value,"priority");
//					echo '<pre>';
//					print_r($field_value);
//					echo '</pre>';
					foreach ($field_value as $image) {
						if (array_key_exists('thumbnail', $field['presets']))
						{
							$src = 'cache/' . $tipo['name'] . '/' . $field_name . '/' . $record->id . '/' . $field['presets']['thumbnail'] . '/' . $image->name;
						} else {
							$src = $image->thumb_path ? $image->thumb_path : $image->path;
						}
						echo '<li class="uploaded-image-item"><div class="uii-inner"><div class="i-item"><img src="'. attach_url($src) . '" alt="" border="0" /></div>'
							.'<div class="i-info"><a target="_blank" href="'. attach_url($image->path) . '">просмотр</a><br />'.$image->width.' x '.$image->height.' px<br />'.$image->size.' Kb</div>'
							.'<div class="i-alt"><input name="_alt_text['.$image->id_document.']" type="text" class="text small" value="' . $image->alt_text . '" /></div>'
							.'<div class="i-order"><input class="tbl-priority text small" name="_priority['.$image->id_document.']" type="text" value="' . $image->priority . '" /></div>'
							.'<div class="delete"><img align="absmiddle" src="'.site_url(THEMESPATH.'admin/widgets/icns/delete.png').'" /> <a href="#" onclick="return fastcms.remove.document(this, '.$image->id_document.');">удалить</a></div>'
							."</div></li>";
					}
					echo '</ul><div class="clear"></div>';
				}
				echo $p_end;
