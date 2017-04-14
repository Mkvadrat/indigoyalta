<?php
				$attributes['name'] = $field_name;
				$attributes['value'] = $field_value;
				$attributes['class'] = 'text'.($field['mandatory']?' mandatory':'');
				echo $p_start.$label.form_input($attributes).$p_end;
