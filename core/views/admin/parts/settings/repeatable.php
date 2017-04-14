<?php

				echo '<div class="repeatable-wrapper">';
				$count = $field_value != '' ? count($field_value) : 0;
				$speakers = $this->records->type('speakers')->get();
				$topics = $this->records->type('topics')->get();

				//Multi upload on webkit+ff browsers
				$attributes['name'] = $field_name.'';
				$attributes['multiple'] = '';
				$schedule_row = 1;
//				echo count($field_value[0]);
//					echo '<div class="schedule-list-title">Список запланированных выступлений</div>';
					echo '<div class="schedule-list-actions top">';
						echo '<a href="#" onclick="addScheduleEvent();return false;" class="add-schedule-item"><i class="icon-plus-sign"></i> выступление</a>';
						echo '<a href="#" onclick="addScheduleSeparator();return false;" class="add-schedule-separator"><i class="icon-plus-sign"></i> перерыв</a>';
					echo '</div>';
					echo '<ul id="schedule-repeatable" class="repeatable-fields-list schedule-fields-list sortable clearfix">';
				if ($count && is_array($field_value)) {

//					$field_values = unserialize($field_value);
//					echo '<pre>';
//					print_r($field_value);
//					echo '<pre>';
					foreach ($field_value as $field_array) {
//						echo $field_array['type'];
						if($field_array['type'] =='event'){
						echo '<li id="schedule-item-'.$schedule_row.'">'
							.'<div class="sort-handle"><i class="icon-reorder"></i></div>'
							.'<div class="speaker"><label>Спикер: </label>'
							.'<select name="'.$field_name.'['.$schedule_row.'][speaker]" class="customStyled">';
							foreach ($speakers as $speaker) {
								$selected = ($field_array['speaker'] == $speaker->get('id_record'))? ' selected':'';
								echo '<option value="'.$speaker->get('id_record').'"'.$selected.'>'.$speaker->get('title').'</option>';
							};
							echo '</select>'
							.'</div>'
							.'<div class="meta clearfix"><label>Время начала:<br><input name="'.$field_name.'['.$schedule_row.'][time]" type="text" class="text small" value="'.$field_array['time'].'" /></label>'
							.'<label>Место:<br><input name="'.$field_name.'['.$schedule_row.'][location]" type="text" class="text" value="'.$field_array['location'].'" /></label></div>'
							.'<div class="topic"><label>Тема: </label>'
							.'<select name="'.$field_name.'['.$schedule_row.'][topic]" class="customStyled">';
							foreach ($topics as $topic) {
								$selected = ($field_array['topic'] == $topic->get('id_record'))? ' selected':'';
								echo '<option value="'.$topic->get('id_record').'"'.$selected.'>'.$topic->get('title').'</option>';
							};
							echo '</select>'
							.'</div>'
							.'<div class="remove-handle"><a href="#" onclick="$(\'#schedule-item-'.$schedule_row.'\').remove();" title="удалить выступление"><i class="icon-remove"></i></a></div>'
							.'<input class="event-priority" name="'.$field_name.'['.$schedule_row.'][priority]" type="hidden" value="'.$field_array['priority'].'" />'
							.'<input name="'.$field_name.'['.$schedule_row.'][type]" type="hidden" value="event" />'
							."</li>\n";
						}elseif($field_array['type'] =='break'){
							echo '<li id="schedule-separator-'.$schedule_row.'">'
								.'<div class="sort-handle"><i class="icon-reorder"></i></div>'
								.'<div class="meta clearfix"><label>Назначение:<br><input type="text" name="'.$field_name.'['.$schedule_row.'][title]" class="text" value="'.$field_array['title'].'" /></label>'
								.'<label>Длительность:<br><input type="text" name="'.$field_name.'['.$schedule_row.'][time]" class="text" value="'.$field_array['time'].'" /></label></div>'
								.'<div class="remove-handle"><a href="#" onclick="$(\'#schedule-separator-'.$schedule_row.'\').remove();" title="удалить перерыв"><i class="icon-remove"></i></a></div>'
								.'<input class="event-priority" name="'.$field_name.'['.$schedule_row.'][priority]" type="hidden" value="'.$field_array['priority'].'" />'
								.'<input name="'.$field_name.'['.$schedule_row.'][type]" type="hidden" value="break" />'
								.'</li>';
						}
					$schedule_row++;
					}
				}else{
//					echo '<div class="schedule-list-empty">Выходной?</div>';
	
				}
					echo '</ul>';
					echo '<div class="schedule-list-actions bottom">';
						echo '<a href="#" onclick="addScheduleEvent();return false;" class="add-schedule-item"><i class="icon-plus-sign"></i> выступление</a>';
						echo '<a href="#" onclick="addScheduleSeparator();return false;" class="add-schedule-separator"><i class="icon-plus-sign"></i> перерыв</a>';
					echo '</div>';

					?>
					<script type="text/javascript"><!--
					var schedule_row = <?php echo $schedule_row; ?>;

					function addScheduleEvent() {	
						html  = '<li id="schedule-item-' + schedule_row + '">';
						html += '  <div class="sort-handle"><i class="icon-reorder"></i></div>';
						html += '  <div class="speaker"><label>Спикер: </label><select name="<?php echo $field_name;?>[' + schedule_row + '][speaker]" class="customStyled">';
						<?php foreach ($speakers as $speaker) { ?>
						html += '      <option value="<?php echo $speaker->get('id_record'); ?>"><?php echo $speaker->get('title'); ?></option>';
						<?php } ?>
						html += '    </select></div>';
						html += '    <div class="meta clearfix"><label>Время начала:<br><input type="text" name="<?php echo $field_name;?>[' + schedule_row + '][time]" class="text small" value="" /></label><label>Место:<br><input type="text" name="<?php echo $field_name.'['.$schedule_row.']';?>[location]" class="text" value="" /></label></div>';
						html += '  <div class="topic"><label>Тема:<br></label><select name="<?php echo $field_name;?>[' + schedule_row + '][topic]" class="customStyled">';
						<?php foreach ($topics as $topic) { ?>
						html += '      <option value="<?php echo $topic->get('id_record'); ?>"><?php echo $topic->get('title'); ?></option>';
						<?php } ?>
						html += '    </select></div>';
						html += '    <div class="remove-handle"><a href="#" onclick="$(\'#schedule-item-'+schedule_row+'\').remove();" title="удалить выступление"><i class="icon-remove"></i></a></div>';
						html += '  <input class="event-priority" name="<?php echo $field_name;?>[' + schedule_row + '][priority]" type="hidden" value="' + schedule_row + '" />';
						html += '  <input name="<?php echo $field_name;?>[' + schedule_row + '][type]" type="hidden" value="event" />';
						html += '</li>';
						
						$('#schedule-repeatable').append(html);
						
						schedule_row++;
					}
					function addScheduleSeparator() {	
						html  = '<li id="schedule-separator-' + schedule_row + '">';
						html += '  <div class="sort-handle"><i class="icon-reorder"></i></div>';
						html += '    <div class="meta clearfix"><label>Назначение:<br><input type="text" name="<?php echo $field_name;?>[' + schedule_row + '][title]" class="text" value="" /></label>';
						html += '    <label>Длительность:<br><input type="text" name="<?php echo $field_name;?>[' + schedule_row + '][time]" class="text" value="" /></label></div>';
						html += '    <div class="remove-handle"><a href="#" onclick="$(\'#schedule-separator-'+schedule_row+'\').remove();" title="удалить перерыв"><i class="icon-remove"></i></a></div>';
						html += '  <input class="event-priority" name="<?php echo $field_name;?>[' + schedule_row + '][priority]" type="hidden" value="' + schedule_row + '" />';
						html += '  <input name="<?php echo $field_name;?>[' + schedule_row + '][type]" type="hidden" value="break" />';
						html += '</li>';
						
						$('#schedule-repeatable').append(html);
						
						schedule_row++;
					}
					//--></script> 
					
					
					<?php

				echo '</div>';
