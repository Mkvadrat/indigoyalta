<?php

				$add = '';
				if (isset($field['onchange'])) {
					$add .= 'onchange="'.$field['onchange'].'" '; 
					$js_onload .= trim($field['onchange'], ';').'; ';
				}
				$add .= 'class="width-100 '.($field['mandatory']?' mandatory':'');
				$add .='" ';
				echo $p_start.$label.form_dropdown($field_name.'['.$module.']', $field['options'], $field_value, $add).$additionaldesc.$p_end;
