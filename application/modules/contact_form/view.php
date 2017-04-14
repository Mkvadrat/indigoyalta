<?php load_helper('form'); ?>

<div class="requestform-outer">
	<?php echo form_open_multipart(NULL, array('id' => 'contactform', 'class'=>'forms forms-columnar'));?>
	<? // echo form_open(NULL, array('id' => 'contactform'));
	echo form_hidden('_contactform', 'true'); ?>
	<div class="forms-desc">
    <p>
      <span class="required">*</span> - поля обязательные для заполнения
    </p>
	</div>
	<p>
		<label>Имя<span class="required">*</span>:</label>
    <input type="text" name="firstname" class="width-100 <?php echo(form_error('firstname')?' input-error':'')?>" />
    <?php echo(form_error('firstname')? form_error('firstname') :'')?>
	</p>
	
	<p>
		<label>Email:</label>
    <input type="text" name="email" class="width-100" />
	</p>
	
	<p>
		<label>Ваш город:</label>
    <input type="text" name="city" class="width-100" />
	</p>

	<p>
		<label>Сообщение<span class="required">*</span>:</label>
    <textarea name="message" rows="5" class="width-100 <?php echo(form_error('message')?' input-error':'')?>"></textarea>
    <?php echo(form_error('message')? form_error('message') :'')?>
	</p>
	
	<p>
		<label> </label>
		<ul class="forms-inline-list">
    	<li><input name="selfcopy" id="selfcopy-1" class="fast-checkbox" type="checkbox" value="1"> <label for="selfcopy-1" class="fast-label">Отправить копию этого сообщения на ваш адрес</label></li>
    </ul>
	</p>
	
	
	<p>
		<input type="submit" class="btn btn-blue" name="submit" value="Отправить">
	</p>	
	
	<?php echo form_close(); ?>
	<div class="clear"></div>
</div>