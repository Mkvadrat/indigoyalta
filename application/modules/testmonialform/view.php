<?php load_helper('form');?>

	<?php echo form_open(NULL, array('id' => 'testmonialform', 'class'=>'forms forms-columnar')); echo form_hidden('_testmonialform', 'true');?>
	<div class="forms-desc">
    <p>
      <span class="required">*</span> - поля обязательные для заполнения
    </p>
	</div>
	
	<p>
		<label>Имя<span class="required">*</span>:</label>
    <input type="text" name="author" class="width-100 <?php echo(form_error('author')?' input-error':'')?>" /> 
    <?php echo(form_error('author')? form_error('author') :'')?>
	</p>
	<p>
		<label>Email<span class="required">*</span>:</label>
    <input type="text" name="email" class="width-100" />
	</p>
	
	<p>
		<label>Ваш город:</label>
    <input type="text" name="comefrom" class="width-100" />
	</p>
	
	<p>
		<label>Род занятий:</label>
    <input type="text" name="jobposition" class="width-100" />
	</p>
<?php /*?>	<p>
		<label>Ваш сайт:</label>
    <input type="text" name="link" class="width-100" />
	</p>
<?php */?>	
	<p>
		<label>Сообщение<span class="required">*</span>:</label>
    <textarea name="message" rows="5" class="width-100 <?php echo(form_error('message')?' input-error':'')?>"></textarea>
    <?php echo(form_error('message')? form_error('message') :'')?>
	</p>
	
	
	<p>
		<input type="submit" class="btn btn-blue" name="submit" value="Отправить">
	</p>	
	
	<?php echo form_close(); ?>
