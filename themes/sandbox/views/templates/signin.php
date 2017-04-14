<div class="page-outer">
<?php
$page_h1 = page('meta_h1');
$page_title = page('title');
$page_id = page('id_record');
$page_body = page('content');
?>
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>
	<?php if($page_body){ ?>
	<div class="page-inner">
		<?php echo $page_body; ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="signin-wrapper">
		<form action="<?php echo site_url('/admin/auth/login');?>" method="post">
			<div class="fieldset clearfix">
				<label>Логин:</label>
				<div class="right">
					<input name="username" type="text" class="text" value="<?php echo $this->input->post('username'); ?>" />
				</div>
			</div>
			<div class="fieldset clearfix">
				<label>Пароль:</label>
				<div class="right">
					<input name="password" type="password" class="text" value="" />
				</div>
			</div>
			<div class="fieldset noborder clearfix">
				<label></label>
				<div class="right">
					<input type="submit" class="submit" value="войти" />
					&nbsp;
					<input type="checkbox" class="checkbox" checked="checked" id="rememberme" />
					<label for="rememberme">запомнить</label>
				</div>
			</div>
		</form>
	</div>
	<div class="clear"></div>
</div>

