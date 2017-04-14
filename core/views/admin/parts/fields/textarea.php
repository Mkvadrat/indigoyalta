<?php
				$attributes['name'] = $field_name;
				$attributes['value'] = $field_value;
				$attributes['class'] = 'width-100 wysiwyg'.($field['mandatory']?' mandatory':'');
				$attributes['id'] = 'textarea_'.$field_name;
				echo $p_start.$label.form_textarea($attributes).$additionaldesc.$p_end;
