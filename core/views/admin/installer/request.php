<?php
$this->load->helper('form');
?><div class="block small center login">
        <div class="block_head">
          <div class="bheadl"></div>
          <div class="bheadr"></div>
          <h2>Установка FastCMS</h2>
        </div>
		<div class="block_content">

<?php if ($already_installed === 'T') { ?>
		<div class="warning message">Указанная БД уже используется</div>
		<form><div class="fieldset clearfix"><label class="full">Для обновления предидущей установки удалите запись "is_installed" в таблице "settings"</label></div></form>
<?php } else { ?>

          <?php if (isset($message)) { ?><div class="message success"><p><?php echo $message; ?></p></div><?php } ?>

		  	<form action="<?php echo admin_url('install'); ?>" method="POST">

		  		<div class="fieldset noborder clearfix">
			  		<label class="full">Опции установки FastCMS:</label>
			  </div>

		  		<div class="fieldset clearfix">
				  	<div class="right">
				  		<input type="checkbox" checked="checked" name="create_directories" value="T" /> Создать необходимые папки<br />
				  		<input type="checkbox" checked="checked" name="create_tables" value="T" /> Сбросить таблицы в БД<br />
				  		<input type="checkbox" checked="checked" name="create_types" value="T" /> Сбросить схемы содержимого<br />
				  		<input type="checkbox" checked="checked" name="populate_settings" value="T" /> Установить настройки по умолчанию<br />
				  		<input type="checkbox" checked="checked" name="clear_cache" value="T" /> Очистить кеш<br />
				  		<input type="checkbox" checked="checked" name="log_events" value="T" /> Включить ведение логов<br />
					</div>
				</div>

				<div class="fieldset clearfix">
		  			<label>Локализация</label>
				  	<div class="right">
						<?php echo form_dropdown('language', $this->config->item('languages_select'), $this->lang->current_language, 'class="styled"'); ?>
					</div>
				</div>

				<div class="fieldset clearfix">
		  			<label>Тип установки</label>
				  	<div class="right">
						<select class="styled" name="premade">
							<option value="full">Полный</option>
							<option value="default">Минимальный</option>
						</select>
					</div>
				</div>

				<div class="fieldset clearfix">
		  			<label>Шаблон</label>
				  	<div class="right">
						<?php echo form_dropdown('theme', $this->view->get_available_themes(), 'sandbox', 'class="styled"'); ?>
						после установки можно изменить
					</div>
				</div>

				<div class="fieldset clearfix">
		  			<label>Формат хранения структуры данных</label>
				  	<div class="right">
						<select class="styled" name="scheme_format">
							<option value="yaml">YAML (Рекомендуется)</option>
						</select>
					</div>
				</div>

				<div class="fieldset clearfix noborder">
					<div class="right">
				  		<input name="install" onclick="$(this).fadeOut(200, function() {$('img.hidden').fadeIn();});" type="submit" class="submit" value="Установить" />
				  		<img class="hidden" src="<?php echo site_url() . THEMESPATH . 'admin/widgets/loading.gif'; ?>" />
			  		</div>
			  	</div>
		  	</form>
<?php } ?>
        </div>
      </div>