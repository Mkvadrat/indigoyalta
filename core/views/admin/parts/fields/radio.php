<?php

				echo $p_start.$label.'<ul class="forms-inline-list zero">';
				foreach ($field['options'] as $opt_key => $opt_val) {
					$data = array(
					    'name'        => $field_name,
					    'value'       => $opt_key,
					    'id'       => 'radio-'.$field_name.'-'.$opt_key,
					    'checked'     => $opt_key == $field_value ? 'checked' : '',
					    'class'       => 'fast-radio'.($field['mandatory']?' mandatory':''),
					);
					echo '<li>'.form_radio($data).form_label(' '.$opt_val, 'radio-'.$field_name.'-'.$opt_key).'</li>';
				}
				echo '</ul>'.$additionaldesc.$p_end;
