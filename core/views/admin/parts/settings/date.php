<?php
				$attributes['name'] = $field_name;
				$attributes['value'] = $field_value;
				$attributes['class'] = 'has-datepicker width-20'.($field['mandatory']?' mandatory':'');
				echo $p_start.$label.form_input($attributes).$additionaldesc.$p_end;
