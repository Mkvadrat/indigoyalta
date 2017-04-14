<?php
				echo $p_start.$label; ?>
        <ul class="forms-list">
				<?php foreach ($field['options'] as $opt_key => $opt_val) {
					$checked = is_array($field_value) ? (in_array($opt_key, $field_value) ? 'checked' : '') : '';
					$data = array(
					    'name'        => $field_name.'[]',
					    'value'       => $opt_key,
					    'id'       => 'check-'.$opt_key,
					    'checked'     => $checked,
					    'class'       => 'fast-checkbox',
					);

					echo '<li>'.form_checkbox($data).form_label(' '.$opt_val, 'check-'.$opt_key).'</li>';
				} ?>
				</ul>
				<?php echo $p_end;
