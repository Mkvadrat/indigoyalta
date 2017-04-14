<?php

				echo $p_start.$label;
				$count = $field_value != '' ? count($field_value) : 0;

				//Multi upload on webkit+ff browsers
				$attributes['name'] = $field_name.'[]';
				$attributes['multiple'] = ' ';

				if ($count < $field['max']) {
					echo form_upload($attributes).br(1).'('.$this->lang->_trans('You can attach up to %n files', array('n' => $field['max'])).')';
				} else {
					echo '<span class="limit">'._('File limit exceeded.').'</span>';
					echo '<div class="hidden limit">'.br(1).form_upload($attributes).br(1).'('.$this->lang->_trans('You can attach up to %n files', array('n' => $field['max'])).')</div>';
				}
				if ($count && is_array($field_value)) {
					echo '<table cellpadding="0" cellspacing="0" width="100%" class="sortable cursor">'
						.'<thead><tr><th>'._('File name').'</th><th>'._('File type').'</th><th>'._('Alternative text').'</th><th></th></tr></thead><tbody>';
					;
					foreach ($field_value as $file) {
						echo '<tr><td><a target="_blank" href="'. attach_url($file->path) . '">'.$file->name.'</a></td>'
							.'<td>'.$file->mime.'</td>'
							.'<td><input name="_alt_text['.$file->id_document.']" type="text" class="text small" value="' . $file->alt_text . '" /></td>'
							.'<td class="delete"><img align="absmiddle" src="'.site_url(THEMESPATH.'admin/widgets/icns/delete.png').'" /> <a href="#" onclick="return fastcms.remove.document(this, '.$file->id_document.');">'._('Delete file').'</a></td>'
							."</tr>\n";
					}
					echo '</tbody></table>';
				}
				echo $p_end;
