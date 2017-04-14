<?php

				echo $p_start.$label.'<ul class="forms-inline-list">';
				foreach ($field['options'] as $opt_key => $opt_val) {
					$data = array(
					    'name'        => $field_name.'['.$module.']',
					    'value'       => $opt_key,
					    'id'       => 'radio-'.$opt_key,
					    'checked'     => $opt_key == $field_value ? 'checked' : '',
					    'class'       => 'radio',
					);
					echo '<li>'.form_radio($data).form_label(' '.$opt_val, 'radio-'.$opt_key).'</li>';
				}
				echo '</ul>'.$additionaldesc.$p_end;
