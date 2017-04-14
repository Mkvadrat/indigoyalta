<?php

				$add = '';
				if (isset($field['onchange'])) {
					$add .= 'onchange="'.$field['onchange'].'" ';
					$js_onload .= trim($field['onchange'], ';').'; ';
				}
				$add .= 'multiple size="15" class="multi '.($field['mandatory']?' mandatory':'');
				$add .='" ';
				$field['options']['multiple'] = '';
				echo $p_start.$label;

				$left_options = array();
				$right_options = array();
				foreach ($field['options'] as $opt_key => $opt_val)
				{
					if (is_array($field_value) && in_array($opt_key, $field_value))
					{
						$right_options[$opt_key] = $opt_val;
					} else {
						$left_options[$opt_key] = $opt_val;
					}
				}
//				print_r($field_value);
				echo '<div class="multiselect multiselect_'.$field_name.'"><div class="multi_left">'.form_dropdown(null, $left_options, $field_value, $add);
				echo '<br /><input type="button" class="add button tiny" value="добавить" />'.'</div>';

				echo '<div class="multi_right">'.form_dropdown($field_name.'[]', $right_options, $field_value, $add);
				echo '<br /><input type="button" class="rem button tiny" value="удалить" />'.'</div><div class="clear"></div></div>';

				$nm = 'multiselect_'.$field_name;

				$js_onload.= "$('.".$nm." .add').click(function(){ ".
					 "return !$('.".$nm." .multi_left select option:selected').remove().appendTo('.".$nm." .multi_right select'); });";
				$js_onload.= "$('.".$nm." .rem').click(function(){ ".
					 "return !$('.".$nm." .multi_right select option:selected').remove().appendTo('.".$nm." .multi_left select'); });";

				echo $additionaldesc.$p_end;
