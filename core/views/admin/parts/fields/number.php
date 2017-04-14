<?php
				$attributes['name'] = $field_name;
				$attributes['type'] = 'number';
				$attributes['value'] = $field_value;
				$attributes['class'] = 'number width-50'.($field['mandatory']?' mandatory':'');
				echo $p_start.$label.form_input($attributes).$additionaldesc.$p_end;
