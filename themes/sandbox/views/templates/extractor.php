<?php $realestates = find('realestate')->get(); ?>

		<?php $counter = 1;
					foreach ($realestates as $realestate){

					$realestateid = $realestate->get('id_record');
					$realestatetypo = $realestate->get('id_type');
					$realestateturi = $realestate->get('uri');
					$realestatecats = recordCategoriesIds($realestate->get('id_record'));
					//print_r($realestatecats);
					?>
		<?php echo semantic_category_url($realestate, $realestatecats, $realestatetypo,$realestateturi)."\n"; ?>
		<?php $counter++;} ?>
		
		
<?php $this->block->load('sometesting')?>