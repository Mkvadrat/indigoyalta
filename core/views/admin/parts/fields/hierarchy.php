<?php 

				$dyna_name = '_dyna_'.$field_name;
				echo $p_start.$label.'<div id="'.$dyna_name.'"></div>';

				$data = array(
						'tree_input'	=> $field_name,
						'tree_id'		=> $dyna_name,
						'tree_form'		=> '#record_form',
						'tree_mode'		=> 2,
						'tree'			=> $field['options']
				);
				$this->view->render('admin/hierarchies/dynatree', $data);

				echo $additionaldesc.$p_end;

