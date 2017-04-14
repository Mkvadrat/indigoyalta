		<div class="form-tab" id="sb_hierarchies">
    	<div class="fields-container">
			<div class="units-row-end">
				<div class="unit-20"><span>Список доступных связок</span></div>
				<div class="unit-80">
				<?php 
				if ($this->config->item('hierarchies')) {
					echo form_hidden('_hierarchies');
				?>
					<div id="hierarchies"></div>
					<?php	} else { ?>
      <div class="message-static">
          <header>Нет ни одной связки</header>
          <p>Связки обеспечивают взаимоотношения между разными разделами сайта. Наиболее близкий пример - коментарии записей блога либо отзывы об объектах недвижимости</p>
      </div>
					<?php } ?>
				</div>
			</div>
		</div>
		</div>
