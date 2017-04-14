<?php
				$attributes['name'] = $field_name.'['.$module.']';
				$attributes['value'] = $field_value;
				$attributes['class'] = 'has-fasteditor width-100 '.($field['mandatory']?' mandatory':'');
				$attributes['id'] = 'fasteditor_'.$field_name;
				$has_full_textarea = TRUE;
				echo $p_start.$label.form_textarea($attributes).$p_end;
