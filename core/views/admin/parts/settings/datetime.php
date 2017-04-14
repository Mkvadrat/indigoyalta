<?php
				if (is_numeric($field_value))
				{
					$field_value = date(LOCAL_DATE_FORMAT . ' H:i', $field_value);
				}
				$tmp = explode(' ', $field_value);
				$attributes['name'] = $field_name;
				$attributes['value'] = $tmp[0] ? $tmp[0] : date(LOCAL_DATE_FORMAT);
				$attributes['class'] = 'has-datepicker has-datepicker width-100'.($field['mandatory']?' mandatory':'');
				echo $p_start.$label.'<div class="units-row-end units-split"><div class="unit-10 component-date-group"><input class="'.$attributes['class'].'" type="text" value="'.$attributes['value'].'" name="'.$attributes['name'].'"></div>';

				$attributes['name'] = '_time_'.$field_name;
				$attributes['value'] = isset($tmp[1]) ? $tmp[1] : date('H:i');
				$attributes['class'] = 'has-timepicker width-100';
				echo '<div class="unit-10 component-time-group">'.form_input($attributes).'</div></div>'.$p_end;
