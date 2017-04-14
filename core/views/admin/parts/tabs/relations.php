		<div class="form-tab" id="sb_relations">
    	<div class="fields-container">
			<?php foreach ($tipo['relations'] as $rel_name => $relation) { 
			$relhumannames = array(
				
				'childs' => 'Дочерние',
				'common' => 'Стандартные',
				'custom' => 'Конструктор',
				'catalogs' => 'Каталоги разделов',
			
			)
			
			?>
			<div class="units-row-end">
				<div class="unit-20"><span><?php echo $relhumannames[$rel_name]; ?></span></div>
				<div class="unit-80">
					<div class="relation-<?php echo $rel_name; ?>">
						<?php if ($record->id) {
							echo form_submit(
								array(
									'name' 		=> '_relation_' . $rel_name,
									'class'		=> 'submit btn btn-full btn-blue',
									'type'		=> 'button',
									'onclick'	=> "fastcms.relations.load('" . $rel_name . "', ".$record->id.", '".$tipo['name']."');"
								), 'Загрузить список');
						} ?>
					</div>
				</div>
			</div>
			<?php } ?>
	
		</div>
		</div>
