<div class="units-container login-container">
<div class="text-centered"><img src="/gui/coreimages/logo-big.png" alt="FastCMS"></div>
<div class="units-row">
  <div class="unit-centered unit-80">
  
<?php if (isset($message)) { ?>
<div class="message message-error">
    <span class="close"></span>
    <?php echo $message; ?>
</div>
<?php } ?>
<form method="post" action="" class="forms login-form width-100">
<fieldset>
		<label class="unit-100 color-gray-light">
			Логин:
			<input name="username" type="text" class="width-100<?php echo(isset($message))? ' input-error': ''; ?>"  />
		</label>
		<label class="unit-100 color-gray-light">
			Пароль:
			<input name="password" type="password" class="width-100<?php echo(isset($message))? ' input-error': ''; ?>" />
		</label>
</fieldset>
   <p class="text-centered"><input type="submit" class="btn width-80 btn-login-wide" value="войти"></p>

</form>
  
  </div>
</div>
</div>

