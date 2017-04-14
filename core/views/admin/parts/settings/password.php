<?php
				$attributes['name'] = $field_name;
				$attributes['value'] = $field_value;
				$attributes['class'] = 'width-100 text'.($field['mandatory']?' mandatory':'');
				echo $p_start.$label.form_password($attributes).$additionaldesc.$p_end;
