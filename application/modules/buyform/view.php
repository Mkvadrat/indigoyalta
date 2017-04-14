<?php load_helper('form'); ?>
<div class="units-row">
<div class="requestform-outer">
	<?php echo form_open_multipart(NULL, array('id' => 'requestform', 'class'=>'forms forms-columnar'));?>
	<? // echo form_open(NULL, array('id' => 'requestform'));
	echo form_hidden('_requestform', 'true'); ?>
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
		<label>Ваш телефон<span class="required">*</span>:</label>
    <input type="text" name="phone" class="width-100 <?php echo(form_error('phone')?' input-error':'')?>" />
    <?php echo(form_error('phone')? form_error('phone') :'')?>
	</p>
		
	<p>
		<label>Ваш город<span class="required">*</span>:</label>
    <input type="text" name="city" class="width-100 <?php echo(form_error('city')?' input-error':'')?>" />
    <?php echo(form_error('city')? form_error('city') :'')?>
	</p>
	
	<p>
		<label>Что желаете<span class="required">*</span>:</label>
		<ul class="forms-inline-list">
    	<li><input name="dealtype" id="dealtype-1" class="fast-radio " type="radio" value="b"> <label for="dealtype-1" class="fast-label<?php echo(form_error('dealtype')?' label-error':'')?>">Купить</label></li>
    	<li><input name="dealtype" id="dealtype-2" class="fast-radio" type="radio" value="s"> <label for="dealtype-2" class="fast-label<?php echo(form_error('dealtype')?' label-error':'')?>">Продать</label></li>
    </ul>
	</p>

	<p>
		<label>Тип недвижимости:</label>
    <select name="type" class="width-100">
       <option value="-">Выберите тип</option>
       <option value="flat">Квартира</option>
       <option value="land">Земельный участок</option>
       <option value="comestate">Коммерческую недвижимость</option>
       <option value="other">Другую недвижимость</option>
    </select>	
	</p>
	
	
	<p>
		<label>Описание:</label>
    <textarea name="message" rows="5" class="width-100"></textarea>
	</p>

	<p>
		<label>Фотографии:</label>
    <div class="upload-wrapper">
    <div class="dropbox" id="dropbox">
      <div class="upload-message"><span class="big">Перетащите сюда необходимые изображения</span><br><small>или</small><br><br><span class="btn btn-blue">кликните для выбора</span></div>
    </div>
      <input type="file" id="upload_button" multiple>
    
    </div>
	<p>
	
		
	<p>
		<input type="submit" class="btn btn-blue" name="submit" value="Отправить">
	</p>	
	
	
	<?php echo form_close(); ?>
	<div class="clear"></div>
</div>

</div>
